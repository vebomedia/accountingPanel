        
var product = function () {

    var tableID = 'table_product';
    var page_slug = 'product';
    var tableUrlExt = ''; //Datatabel Url Extension
    var form_sizes = {"product":"lg"};
    var DT1 = false; //datatable handle
    var selected = {}; //datatable selected

    var get_selectedIds = function () {
        return DT1.rows({selected: true}).ids().toArray();
    };

    var get_url = function (param) {
    
        if (typeof param === 'undefined') {
            param = '';
        }else{
            param = '/' + param;
        }
    
        return panel_url('product' + param);
        
    };

    var getTableUrl = function () {

        if(tableUrlExt !== ''){
            return $('#' + tableID).data('url') + '?' + tableUrlExt;
        }

        return $('#' + tableID).data('url');
    };
            
    // -- Relation  Lang Function 
    var c4_invoice_itemLang = function (param, paramsub) {
        return getLang('c4_invoice_item', param, paramsub);
    };

    var c4_invoice_itemUrl = function(param){

        if (typeof param === 'undefined'){
            param = '';
        }

        var panel_language = homeLang('panel_language');

        return document.location.origin + '/financepanel/' + panel_language + '/c4_invoice_item/' +  param;
    };

            

    //Module Lang
    var productLang = function (param, paramsub) {
        return getLang('product', param, paramsub);
    };  

    var init_datatable = function () {
        function subTable(d) {

            var rowID = d.DT_RowId;

            var div = $('<div class="slider pl-3 pr-3" id="slider_' + rowID + '"></div>');

        
            var childTableID = 'child_c4_invoice_item' + rowID;
            var cardHeader = c4_invoice_itemLang('_page_c4_invoice_item');

            var $cardHtml = `<div class="card border-info  mt-2 mb-1">
            
            <div class="card-header text-white bg-info">
            
                <div class="float-left text-center">
                    <h6><i class="fas fa-file-invoice"></i> `+ cardHeader +` <small><span class="date_title"></span></small></h6>
                </div>
                <ul class="nav nav-pills card-header-pills float-right">`;

            
                                    $cardHtml += `<button href="javascript:;"       
                                            href="` + c4_invoice_itemUrl('showForm/c4_invoice_item') + `" 
                                            data-modalsize="lg"
                                            data-datatable="child_c4_invoice_item` + rowID + `"
                                            data-table="child_c4_invoice_item` + rowID + `"
                                            data-modalurl="` + c4_invoice_itemUrl('showForm/c4_invoice_item') + `"
                                            data-modaldata='\{"product_id":"` + rowID + `"\}'
                                            data-action="openformmodal"                        
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-file-invoice"></i>
                                    </button>`;                             
            
            $cardHtml += `
                <button class="btn btn-sm btn-primary dropdown-toggle ml-1"
                    data-toggle="collapse" 
                    href="#body_`+ childTableID +`" 
                    role="button"
                    aria-expanded="true"
                    aria-controls="body_`+ childTableID +`" >
                </button>
            `;


            $cardHtml += `</ul>
            </div>
            <div class="card-body collapse show" id="body_`+ childTableID +`">

                <table id="` + childTableID + `" class="table responsive no-wrap" width="100%"><table/> 

            </div>
        </div>`;
        
            div.append($cardHtml);

            div.find('#' + childTableID).DataTable({
                "lengthMenu": [ 5, 10, 20, 50, 100 ],
                "processing": true,
                "serverSide": true,
                stateSave: true,
                "ajax": {
                    url: get_url('readC4_invoice_item/read_product_TO_c4_invoice_item'),
                    "type": 'POST',
                    "data": function (d) {

                        d.formFilter = 'product_id=' + rowID;

                        var $order_column = d.order[0]['column'];
                        var $order_name =  d.columns[$order_column]['name'];
                        d.order[0]['name'] = $order_name;

                    }
                },

                    
            order: [[1, 'desc']],

                columns: [
                                
                {   
                    sortable : true,
                    name: 'c4_invoice_RELATIONAL_description',
                    title: c4_invoice_itemLang('c4_invoice_id'),
                    data: function ( row, type, set, meta ) 
                    {
                        var txt = !isEmpty(row.c4_invoice_RELATIONAL_description)? escapeHtml(row.c4_invoice_RELATIONAL_description) : '';
                        return '<span title="ID : ' + escapeHtml(row.c4_invoice_id) + '">' + txt + '</span>';
                     }
                },
            {   
                sortable : true,
 
                name: 'name',
                title: c4_invoice_itemLang('name'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.name !== 'string'){
                        return '';
                    }
                                        
                    var text = escapeHtml(row.name);
                    
                                        
                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }

                    return text;

                    
                }
            },
            {   
                sortable : true,
                name: 'quantity',
                title: c4_invoice_itemLang('quantity'),
                data: function ( row, type, set, meta ) {
                
                    var formatter = new Intl.NumberFormat('tr-TR', {maximumSignificantDigits: '4', minimumSignificantDigits  : '2'} );
                    return formatter.format(row.quantity);
                     
                 }
            },

            {   
                sortable : true,
                name: 'unit_price',
                title: c4_invoice_itemLang('unit_price'),
                data: function ( row, type, set, meta ) {
                    
                    var currency = row.currency;
                    
                    if(typeof currency != 'string' || currency === ''){
                        currency = 'TRY';
                    }
                    
                    var formatter = new Intl.NumberFormat('tr-TR', {
                        style: 'currency',
                        currency: currency,
                    });
                    return formatter.format(row.unit_price);
                     
                 }
            },

            {   
                sortable : true,
 
                name: 'vat_rate',
                title: c4_invoice_itemLang('vat_rate'),
                data: function ( row, type, set, meta ) {
                
                     return '% ' + parseFloat(row.vat_rate);
                  }
            },

            {   
                sortable : true,
                name: 'net_total',
                title: c4_invoice_itemLang('net_total'),
                data: function ( row, type, set, meta ) {
                
                    var formatter = new Intl.NumberFormat('tr-TR', {maximumSignificantDigits: '4', minimumSignificantDigits  : '2'} );
                    return formatter.format(row.net_total);
                     
                 }
            },

            {   
 
                sortable : true,
 
                name: 'description',
                title: c4_invoice_itemLang('description'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.description !== 'string'){
                        return '';
                    }
             
                    var text = escapeHtml(row.description);

                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }
                    
                    return text; 
                }
            },
            {
                name: 'Actions',
                title: homeLang('action'),  
                sortable: false,
                textAlign: 'right',
                overflow: 'visible',
                className: 'text-right',
                width:50,
        
                data: function (row) {
                    var id = row.c4_invoice_item_id;
                    var child_id = d.product_id;
                    var $link = ``;
        
                                                    $link += `<div class="btn-group" role="group" aria-label="">`;

                                    
                                    //c4_invoice_item relation form button
                                    $link += `<button  
                                            href="` + c4_invoice_itemUrl('showForm/c4_invoice_item/' + id) + `" 
                                            data-modalsize="lg"
                                            data-datatable="child_c4_invoice_item` + rowID + `"
                                            data-modalurl="` + c4_invoice_itemUrl('showForm/c4_invoice_item/' + id) + `"
                                            data-modaldata='\{"product_id":"` + rowID + `"\}'
                                            data-action="openformmodal"  
                                            class="btn btn-sm btn-primary"
                                            title="` + c4_invoice_itemLang('_form_c4_invoice_item') + `">
                                            <i class="fas fa-file-invoice"></i>
                                    </button>`;

                                    

                                
                                $link += `<div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">`;                                    //Sub Delete Link
                                   $link += `<a 
                                            href="` + c4_invoice_itemUrl('delete/' + id) + `" 
                                            data-datatable="child_c4_invoice_item` + rowID + `"
                                            data-actionurl="` + c4_invoice_itemUrl('delete/' + id) + `"
                                            data-action="apirequest"
                                            data-question="areyousure"
                                            data-subtitle="will_be_deleted"
                                            data-usehomelang="true"
                                            data-ajaxmethod="DELETE"
                                            class="dropdown-item btn btn-sm btn-danger"  
                                            title="` + homeLang('delete') + `" 
                                            class="dropdown-item btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i> ` + homeLang('delete') + `
                                        </a>`;
                                      
                                $link += `</div>
                                  </div>`;
                            $link += `</div>`;
                            return $link;


                    
                    },
            } //End Action



        ],
        }).on('draw', function () {
        _callback_subdatatable_drawed();
        });
    
    
            return div;
        }

        if ($('#' + tableID).length === 0) {
            return;
        }

        if ($.fn.DataTable.isDataTable('#' + tableID)) {
            console.log('Datatable init has been already launched');
            return DT1;
        }

        DT1 = $('#' + tableID).DataTable({
            "retrieve": true,
            "dom": 'rt<"row"<"col-auto mr-auto"i><"col-auto pt-2"l><"col-auto"p>>',
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": getTableUrl(),
                "type": 'POST',
                "data": function (d) {
                    d.formFilter = $('#form_product').serialize();

                    var $order_column = d.order[0]['column'];
                    var $order_name = d.columns[$order_column]['name'];
                    d.order[0]['name'] = $order_name;

                },
                error: function (jqXHR, error, thrown) {
                    alertFail(_getApiErrorString(jqXHR));
                    checkResponse(jqXHR);
                }
            },
            columnDefs: [
                {
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    width: 30
                }
            ],

            select: {
                style: 'multi',
                selector: '.select-checkbox',
                width: 30
            },
            order: [[2, 'desc']],
            columns: [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": '',
                    "searchable": false,
                    "targets": 0,
                    width: 30,
                },
                {
                    "searchable": false,
                    "targets": 1,
                    title: '<label for="productselectAll" class="text-center" style="width: 100%"><div class="text-center"><input type="checkbox" class="selectAll" id="productselectAll"/></div></label>',
                    defaultContent: '',
                    "data": null,
                    orderable: false,
                    className: 'select-checkbox',
                    width: 30
                },

    
{   
                sortable : true,
                name: 'name',
                title: productLang('name'),
               
                data: function ( row, type, set, meta ) {
                
                    var title1 = escapeHtml(row.name);
                    var title2 = escapeHtml('');
                    var card_title = title1 + ' ' + title2;
                                        
                    var card_image = '';
                    
                                                                
                    if(!isEmpty(row.photo_c4_url_thumb))
                    {                        
                       card_image =  '<img src="' + (row.photo_c4_url_thumb) + '" onerror="this.src=\'https://resources.crud4.com/v1/images/notfound.png\'" class="img-thumbnail mr-1" width="50" height="50"></img> ';
                    }
                    else
                    {
                        var items = ['#007bff', '#6c757d', '#28a745', '#dc3545', '#ffc107', '#17a2b8', '#343a40'];
                        var color = items[Math.floor(Math.random()*items.length)];
                        var first =  card_title.charAt(0).toUpperCase();

                        card_image = `<svg class="bd-placeholder-img rounded-sm mr-3" width="50" height="50" xmlns="http://www.w3.org/2000/svg" 
                                           preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                            <title>` + card_title + `</title>
                            <rect width="100%" height="100%" fill="` + color + `"></rect>
                            <text x="40%" y="50%" fill="#dee2e6" dy=".4em">` + first + `</text>
                        </svg>`;
                    }
                    
                                        
                    var card_desc = escapeHtml('');
                    
                    var $return = `<div class="media">`;
                    $return += card_image;
                    $return += `<div class="media-body align-self-center">
                          <h6 class="mt-0 mb-1">` + card_title.substring(0, 36) + `</h6>
                         ` + card_desc.substring(0, 36) + `
                        </div>`;
                    $return += `</div>`;
                    
                    return $return;
                    
                }
            },
            {   
                sortable : true,
                name: 'list_price',
                title: productLang('list_price'),  
                data: function ( row, type, set, meta ) {
                
                                        var currency = row.currency;

                                        
                    if(typeof currency != 'string' || currency == ''){
                        currency = 'TRY';
                    }
                
                    var formatter = new Intl.NumberFormat('tr-TR', {
                        style: 'currency',
                        currency: currency,
                    });
                    return formatter.format(row.list_price);
                     
                 }
            },

                    {
                        name: 'Actions',
                        title: homeLang('action'),
                        sortable: false,
                        textAlign: 'right',
                        overflow: 'visible',
                        className: 'text-right',
                        width:100,

                        data: function (row) {
                            var id = row.product_id;
                            var $link = ``;

                                var $link =`<div class="btn-group" role="group" aria-label="">`;
        
                            //product form button
                            
                            $link += `<a
                               href="` + get_url('showForm/product/' + id) + `" 
                               data-modalsize="lg"
                               data-datatable="table_product"
                               data-modalurl="` + get_url('showForm/product/' + id) + `"
                               data-modaldata='{"product_id":"` + id + `"}'
                               data-action="openformmodal"
                               data-modalview="centermodal"
                               data-modalbackdrop="true"
                               class="btn btn-sm btn-primary"
                               title="` + productLang('_form_product') + `" 
                               > <i class="fas fa-tags"></i> 
                            </a>`;             
                                                        //Dropdown Menu
                            $link += `<div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">`
                                   //Delete Link
                                $link += `    
                                   <a
                                    href="` + get_url('delete/' + id) + `" 
                                    data-datatable="table_product"
                                    data-actionurl="` + get_url('delete/' + id) + `"
                                    data-action="apirequest"
                                    data-question="areyousure"
                                    data-subtitle="will_be_deleted"
                                    data-usehomelang="true"
                                    class="dropdown-item btn btn-sm btn-danger"  
                                    title="` + homeLang('delete') + `">
                                        <i class="fa fa-trash"></i> ` + homeLang('delete') + `</a>`;
                            $link += `
                                </div>
                            </div>`;        
                            $link += `</div>`;

                            return $link;


                        }
                } //And Action
            ],

            "rowCallback": function (row, data) {

                if (typeof selected[data.DT_RowId] !== 'undefined') {
                    DT1.row('#' + data.DT_RowId).select();
                }
            },
        })
                .on('select', function (e, dt, type, indexes) {

                    $('#batch_product').collapse('show');
                    if (type === 'row') {
                        var selectedIDs = DT1.rows({selected: true}).ids().toArray();
                        
                        //keep ids on memory 
                        for (var key in selectedIDs) {
                            selected[selectedIDs[key]] = selectedIDs[key];
                        }
                            
                        $('.selectedCount').html(selectedIDs.length);
                    }
                })
                .on('deselect', function (e, dt, type, indexes) {

                    if (type === 'row') {

                        var deletedIDs = DT1.rows(indexes).ids().toArray();
                       
                        //remove ids from memory
                        for (var key in deletedIDs) {

                            if (typeof selected[deletedIDs[key]] !== 'undefined') {
                                delete selected[deletedIDs[key]];
                            }
                        }

                        var selectedIDs = DT1.rows({selected: true}).ids().toArray();
                        var count = selectedIDs.length;
                    
                        if (count === 0) {
                            $('#batch_product').collapse('hide');
                        }

                        $('.selectedCount').html(count);
                    }
                })
                .on('draw', function () {

                    var $selectAll = $('#productselectAll');

                    if ($selectAll.is(":checked")) {
                        DT1.rows().select();
                    }

                    $selectAll.on('click', function () {
                        if ($(this).is(":checked")) {
                            DT1.rows().select();
                        } else {
                            DT1.rows().deselect();
                        }
                    });
                    
                    //Send call back to generaljs to init otherthings.
                    _callback_datatable_drawed();
        });
        // Add event listener for opening and closing details
        $('#' + tableID + ' tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = DT1.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                $('div.slider', row.child()).slideUp(function () {
                    row.child.hide();
                    tr.removeClass('shown');
                });
            } else {
                // Open this row
                row.child(subTable(row.data()), 'no-padding').show();
                tr.addClass('shown');

                $('div.slider', row.child()).slideDown();
            }
        });

        //Form
        $('#form_product').find('.generalSearch').bind("keyup search", function () {
            console.log('Searching..');
            DT1.ajax.reload();
        });

        $('#form_product').find('.formSearch').on('change', function (e) {

            //e.stopImmediatePropagation();

            if ($(this).attr('name') === 'deleted_at') {

                var column = DT1.column('deleted_at:name');

                if ($(this).val() === '1') {
                    column.visible(true);
                    $('.delete_link').hide();
                    $('.undelete_link').show();
                } else {
                    column.visible(false);

                    $('.delete_link').show();
                    $('.undelete_link').hide();
                }

            }

            reload_datatable();
        });
        
        return DT1;

    };
    var reload_datatable = function () {

        if (typeof DT1 === 'object') {
            
            if(tableUrlExt !== '')
            {
                DT1.ajax.url(getTableUrl()).load()
            }
            else{
                DT1.ajax.reload( null, false );
            }
            
        } else {
            init_datatable();
        }

        if (get_selectedIds().length === 0) {
            $('#batch_product').collapse('hide');
        }

    };

    var destroyDatatable = function () {
        if (typeof DT1 == 'object') {
            DT1.destroy();
        }
    };

    var getModalSize = function (form_slug) {
        return typeof form_sizes[form_slug] != 'undefined' ? form_sizes[form_slug] : 'lg';
    };

    return {

        init_datatable: function () {
            return init_datatable();
        },

        reload_datatable: function () {
            reload_datatable();
        },

        returnDataUrl: function (url) {
            return url;
        },

        returnLang: function (param, paramsub) {
            return productLang(param, paramsub);
        },

        destroyDatatable: function () {
            destroyDatatable();
        },

        setTableUrlExt: function (param) {
            tableUrlExt = param;
        },

        get_url: function (param) {

            return get_url(param);
        },

        get_selectedIds: function () {
            return get_selectedIds();
        },
            
        getDT1: function () {
            return DT1;
        },
    }
}();

document.addEventListener('DOMContentLoaded', function () {

    if ($('#table_product').length > 0) {
    
        general.loadPackage('dataTable', function () {
            loadDatatableLang(function () {
                product.init_datatable();
            });
        });

        if ($('.select2_js').length > 0) {
            general.loadPackage('select2_js', function () {
                init_select2_js();
            });
        }
    }
 
    if ($('.daterangefilter').length > 0) {
        general.loadPackage('daterangepicker', function () {
            $('.daterangefilter').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear'
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }).on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                $(this).trigger("change");
            }).on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
                $(this).trigger("change");
            });
        });
    }
});
