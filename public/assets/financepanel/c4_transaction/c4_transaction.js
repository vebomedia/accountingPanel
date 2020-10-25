        
var c4_transaction = function () {

    var tableID = 'table_c4_transaction';
    var page_slug = 'c4_transaction';
    var tableUrlExt = ''; //Datatabel Url Extension
    var form_sizes = {"money_in":"lg","money_out":"lg"};
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
    
        return panel_url('c4_transaction' + param);
        
    };

    var getTableUrl = function () {

        if(tableUrlExt !== ''){
            return $('#' + tableID).data('url') + '?' + tableUrlExt;
        }

        return $('#' + tableID).data('url');
    };


    //Module Lang
    var c4_transactionLang = function (param, paramsub) {
        return getLang('c4_transaction', param, paramsub);
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
                    d.formFilter = $('#form_c4_transaction').serialize();

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
                    title: '<label for="c4_transactionselectAll" class="text-center" style="width: 100%"><div class="text-center"><input type="checkbox" class="selectAll" id="c4_transactionselectAll"/></div></label>',
                    defaultContent: '',
                    "data": null,
                    orderable: false,
                    className: 'select-checkbox',
                    width: 30
                },

            {   
                sortable : true,
 
                name: 'c4_transaction_id',
                title: c4_transactionLang('c4_transaction_id'),
                data: function ( row, type, set, meta ) {
                    return escapeHtml(row.c4_transaction_id);            
                }
            },
                                
                {   
                    sortable : true,
                    name: 'c4_account_RELATIONAL_name',
                    title: c4_transactionLang('c4_account_id'),
                    data: function ( row, type, set, meta ) 
                    {
                        var txt = !isEmpty(row.c4_account_RELATIONAL_name)? escapeHtml(row.c4_account_RELATIONAL_name) : '';
                        return '<span title="ID : ' + escapeHtml(row.c4_account_id) + '">' + txt + '</span>';
                     }
                },
            {   
                sortable : true,
         
                name: 'transaction_type',
                title: c4_transactionLang('transaction_type'),
                data: function ( row, type, set, meta ) {
                
                    var data_list = c4_transactionLang('list_transaction_type');
                
                    
                                    
                    return !isEmpty(row.transaction_type)? escapeHtml(data_list[row.transaction_type]) : '';
                    
                                        
                }
            },

            {   
                sortable : true,
 
                name: 'description',
                title: c4_transactionLang('description'),
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
                name: 'debit_amount',
                title: c4_transactionLang('debit_amount'),  
                data: function ( row, type, set, meta ) {
                
                                        var currency = row.debit_currency;

                                        
                    if(typeof currency != 'string' || currency == ''){
                        currency = 'TRY';
                    }
                
                    var formatter = new Intl.NumberFormat('tr-TR', {
                        style: 'currency',
                        currency: currency,
                    });
                    return formatter.format(row.debit_amount);
                     
                 }
            },

            {   
                sortable : true,
                name: 'credit_amount',
                title: c4_transactionLang('credit_amount'),  
                data: function ( row, type, set, meta ) {
                
                                        var currency = row.credit_currency;

                                        
                    if(typeof currency != 'string' || currency == ''){
                        currency = 'TRY';
                    }
                
                    var formatter = new Intl.NumberFormat('tr-TR', {
                        style: 'currency',
                        currency: currency,
                    });
                    return formatter.format(row.credit_amount);
                     
                 }
            },

            {   
                sortable : true,
                name: 'date',
                title: c4_transactionLang('date'),
                data: function ( row, type, set, meta ) {

                    if(!isEmpty(row.date) && typeof row.date === 'string' && row.date != '0000-00-00' && row.date != '0000-00-00 00:00:00'){

                        var dateX = moment(row.date, "YYYY-MM-DD");
                        var datenow = moment();

                        var colorClass = '';

                        
                         
                         
                            return '<span class="' + colorClass + '" title="' + escapeHtml(row.date) +'">'  +  moment(row.date, 'YYYY-MM-DD').format('LL') + '</span>';

                                                 
                    }
                    return '';                   
                 }
            },            {   
                sortable : true,
                name: 'created_at',
                title: c4_transactionLang('created_at'),
                data: function ( row, type, set, meta ) {
                                
                    if(!isEmpty(row.created_at) && typeof row.created_at === 'string' && row.created_at != '0000-00-00 00:00:00'){
                    
                        var dateX = moment(row.created_at, "YYYY-MM-DD HH:mm:ss");
                        var datenow = moment();
                    
                         
                     
                        if (dateX > datenow) {
                            return '<span class="text-success" title="' + escapeHtml(row.created_at) +'">' + moment(row.created_at, 'YYYY-MM-DD HH:mm:ss').format('LL') + '</span>';
                        } else {
                            return '<span class="text-danger" title="' + escapeHtml(row.created_at) +'">'  +  moment(row.created_at, 'YYYY-MM-DD HH:mm:ss').format('LL') + '</span>';
                        }
                        
                                                 
                    }
                    return '';                   
                 }
            },                    {
                        name: 'Actions',
                        title: homeLang('action'),
                        sortable: false,
                        textAlign: 'right',
                        overflow: 'visible',
                        className: 'text-right',
                        width:100,

                        data: function (row) {
                            var id = row.c4_transaction_id;
                            var $link = ``;

                                var $link =`<div class="btn-group" role="group" aria-label="">`;
        
                            //money_in form button
                            if(row.transaction_type === 'account_debit' ){

                            $link += `<a
                               href="` + get_url('showForm/money_in/' + id) + `" 
                               data-modalsize="lg"
                               data-datatable="table_c4_transaction"
                               data-modalurl="` + get_url('showForm/money_in/' + id) + `"
                               data-modaldata='{"c4_transaction_id":"` + id + `"}'
                               data-action="openformmodal"
                               data-modalview="centermodal"
                               data-modalbackdrop="true"
                               class="btn btn-sm btn-primary"
                               title="` + c4_transactionLang('_form_money_in') + `" 
                               > <i class="fas fa-money-bill-wave-alt"></i> 
                            </a>`;             
                            }

                            //money_out form button
                            if(row.transaction_type === 'account_credit' ){

                            $link += `<a
                               href="` + get_url('showForm/money_out/' + id) + `" 
                               data-modalsize="lg"
                               data-datatable="table_c4_transaction"
                               data-modalurl="` + get_url('showForm/money_out/' + id) + `"
                               data-modaldata='{"c4_transaction_id":"` + id + `"}'
                               data-action="openformmodal"
                               data-modalview="centermodal"
                               data-modalbackdrop="true"
                               class="btn btn-sm btn-primary"
                               title="` + c4_transactionLang('_form_money_out') + `" 
                               > <i class="far fa-money-bill-alt"></i> 
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
                                    data-datatable="table_c4_transaction"
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

                    $('#batch_c4_transaction').collapse('show');
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
                            $('#batch_c4_transaction').collapse('hide');
                        }

                        $('.selectedCount').html(count);
                    }
                })
                .on('draw', function () {

                    var $selectAll = $('#c4_transactionselectAll');

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
        $('#form_c4_transaction').find('.generalSearch').bind("keyup search", function () {
            console.log('Searching..');
            DT1.ajax.reload();
        });

        $('#form_c4_transaction').find('.formSearch').on('change', function (e) {

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
            $('#batch_c4_transaction').collapse('hide');
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
            return c4_transactionLang(param, paramsub);
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

    if ($('#table_c4_transaction').length > 0) {
    
        general.loadPackage('dataTable', function () {
            loadDatatableLang(function () {
                c4_transaction.init_datatable();
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
