        
var inflow_shipment_document = function () {

    var tableID = 'table_inflow_shipment_document';
    var page_slug = 'inflow_shipment_document';
    var tableUrlExt = ''; //Datatabel Url Extension
    var form_sizes = {"inflow_shipment_document":"lg"};
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
    
        return panel_url('c4_shipment_document' + param);
        
    };

    var getTableUrl = function () {

        if(tableUrlExt !== ''){
            return $('#' + tableID).data('url') + '?' + tableUrlExt;
        }

        return $('#' + tableID).data('url');
    };


    //Module Lang
    var c4_shipment_documentLang = function (param, paramsub) {
        return getLang('c4_shipment_document', param, paramsub);
    };  

    var init_datatable = function () {

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
                    d.formFilter = $('#form_inflow_shipment_document').serialize();

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
            order: [[1, 'desc']],
            columns: [
                {
                    "searchable": false,
                    "targets": 0,
                    title: '<label for="inflow_shipment_documentselectAll" class="text-center" style="width: 100%"><div class="text-center"><input type="checkbox" class="selectAll" id="inflow_shipment_documentselectAll"/></div></label>',
                    defaultContent: '',
                    "data": null,
                    orderable: false,
                    className: 'select-checkbox',
                    width: 30
                },
            {   
                sortable : true,
 
                name: 'description',
                title: c4_shipment_documentLang('description'),
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
 
                sortable : true,
 
                name: 'address',
                title: c4_shipment_documentLang('address'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.address !== 'string'){
                        return '';
                    }
             
                    var text = escapeHtml(row.address);

                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }
                    
                    return text; 
                }
            },
            {   
                sortable : true,
                name: 'inflow',
                title: c4_shipment_documentLang('inflow'),
                className: "text-center",
                data: function ( row, type, set, meta ) {
                
                var data_list = c4_shipment_documentLang('list_inflow');
                
                                    
                
                if(row.inflow == '1'){
                      return '<span class="badge badge-success">' + data_list[row.inflow] + '</span>';
                }
                else if(row.inflow == '0' || row.inflow == '2'){
                      return '<span class="badge badge-danger">' + data_list[row.inflow] + '</span>';
                }

                return !isEmpty(row.inflow)? escapeHtml(data_list[row.inflow]) : '';
                
                                
                  
                 }
            },

            {   
                sortable : true,
                name: 'issue_date',
                title: c4_shipment_documentLang('issue_date'),
                data: function ( row, type, set, meta ) {

                    if(!isEmpty(row.issue_date) && typeof row.issue_date === 'string' && row.issue_date != '0000-00-00' && row.issue_date != '0000-00-00 00:00:00'){

                        var dateX = moment(row.issue_date, "YYYY-MM-DD");
                        var datenow = moment();

                        var colorClass = '';

                        
                         
                         
                            return '<span class="' + colorClass + '" title="' + escapeHtml(row.issue_date) +'">'  +  moment(row.issue_date, 'YYYY-MM-DD').format('LL') + '</span>';

                                                 
                    }
                    return '';                   
                 }
            },            {   
                sortable : true,
                name: 'shipment_date',
                title: c4_shipment_documentLang('shipment_date'),
                data: function ( row, type, set, meta ) {

                    if(!isEmpty(row.shipment_date) && typeof row.shipment_date === 'string' && row.shipment_date != '0000-00-00' && row.shipment_date != '0000-00-00 00:00:00'){

                        var dateX = moment(row.shipment_date, "YYYY-MM-DD HH:mm:ss");
                        var datenow = moment();

                        var colorClass = '';

                        
                         
                         
                            return '<span class="' + colorClass + '" title="' + escapeHtml(row.shipment_date) +'">'  +  moment(row.shipment_date, 'YYYY-MM-DD HH:mm:ss').format('LL') + '</span>';

                                                 
                    }
                    return '';                   
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
                            var id = row.c4_shipment_document_id;
                            var $link = ``;

                                var $link =`<div class="btn-group" role="group" aria-label="">`;
        
                            //inflow_shipment_document form button
                            if(row.inflow === '1' ){

                            $link += `<a
                               href="` + get_url('showForm/inflow_shipment_document/' + id) + `" 
                               data-modalsize="lg"
                               data-datatable="table_inflow_shipment_document"
                               data-modalurl="` + get_url('showForm/inflow_shipment_document/' + id) + `"
                               data-modaldata='{"c4_shipment_document_id":"` + id + `"}'
                               data-action="openformmodal"
                               data-modalview="centermodal"
                               data-modalbackdrop="true"
                               class="btn btn-sm btn-primary"
                               title="` + c4_shipment_documentLang('_form_inflow_shipment_document') + `" 
                               > <i class="fas fa-shipping-fast"></i> 
                            </a>`;             
                            }
                            //Dropdown Menu
                            $link += `<div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">`
                                   //Delete Link
                                $link += `    
                                   <a
                                    href="` + get_url('delete/' + id) + `" 
                                    data-datatable="table_inflow_shipment_document"
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

                    $('#batch_inflow_shipment_document').collapse('show');
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
                            $('#batch_inflow_shipment_document').collapse('hide');
                        }

                        $('.selectedCount').html(count);
                    }
                })
                .on('draw', function () {

                    var $selectAll = $('#inflow_shipment_documentselectAll');

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
        $('#form_inflow_shipment_document').find('.generalSearch').bind("keyup search", function () {
            console.log('Searching..');
            DT1.ajax.reload();
        });

        $('#form_inflow_shipment_document').find('.formSearch').on('change', function (e) {

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
            $('#batch_inflow_shipment_document').collapse('hide');
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
            return c4_shipment_documentLang(param, paramsub);
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

    if ($('#table_inflow_shipment_document').length > 0) {
    
        general.loadPackage('dataTable', function () {
            loadDatatableLang(function () {
                inflow_shipment_document.init_datatable();
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
