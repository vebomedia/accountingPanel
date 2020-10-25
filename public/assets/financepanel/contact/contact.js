        
var contact = function () {

    var tableID = 'table_contact';
    var page_slug = 'contact';
    var tableUrlExt = ''; //Datatabel Url Extension
    var form_sizes = {"contact":"lg"};
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
    
        return panel_url('contact' + param);
        
    };

    var getTableUrl = function () {

        if(tableUrlExt !== ''){
            return $('#' + tableID).data('url') + '?' + tableUrlExt;
        }

        return $('#' + tableID).data('url');
    };
            
    // -- Relation  Lang Function 
    var c4_invoiceLang = function (param, paramsub) {
        return getLang('c4_invoice', param, paramsub);
    };

    var c4_invoiceUrl = function(param){

        if (typeof param === 'undefined'){
            param = '';
        }

        var panel_language = homeLang('panel_language');

        return document.location.origin + '/financepanel/' + panel_language + '/c4_invoice/' +  param;
    };

                        
    // -- Relation  Lang Function 
    var c4_invoiceLang = function (param, paramsub) {
        return getLang('c4_invoice', param, paramsub);
    };

    var c4_invoiceUrl = function(param){

        if (typeof param === 'undefined'){
            param = '';
        }

        var panel_language = homeLang('panel_language');

        return document.location.origin + '/financepanel/' + panel_language + '/c4_invoice/' +  param;
    };

            

    //Module Lang
    var contactLang = function (param, paramsub) {
        return getLang('contact', param, paramsub);
    };  

    var init_datatable = function () {
        function subTable(d) {

            var rowID = d.DT_RowId;

            var div = $('<div class="slider pl-3 pr-3" id="slider_' + rowID + '"></div>');

        
            var childTableID = 'child_sales_invoice' + rowID;
            var cardHeader = c4_invoiceLang('_page_sales_invoice');

            var $cardHtml = `<div class="card border-info  mt-2 mb-1">
            
            <div class="card-header text-white bg-info">
            
                <div class="float-left text-center">
                    <h6><i class="fas fa-file-invoice"></i> `+ cardHeader +` <small><span class="date_title"></span></small></h6>
                </div>
                <ul class="nav nav-pills card-header-pills float-right">`;

            
                                    $cardHtml += `<button href="javascript:;"       
                                            href="` + c4_invoiceUrl('showForm/sales_invoice') + `" 
                                            data-modalsize="lg"
                                            data-datatable="child_sales_invoice` + rowID + `"
                                            data-table="child_sales_invoice` + rowID + `"
                                            data-modalurl="` + c4_invoiceUrl('showForm/sales_invoice') + `"
                                            data-modaldata='\{"contact_id":"` + rowID + `"\}'
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
                    url: get_url('readC4_invoice/read_contact_TO_sales_invoice'),
                    "type": 'POST',
                    "data": function (d) {

                        d.formFilter = 'contact_id=' + rowID;

                        var $order_column = d.order[0]['column'];
                        var $order_name =  d.columns[$order_column]['name'];
                        d.order[0]['name'] = $order_name;

                    }
                },

                    
            order: [[1, 'desc']],

                columns: [
            {   
                sortable : true,
         
                name: 'invoice_type',
                title: c4_invoiceLang('invoice_type'),
                data: function ( row, type, set, meta ) {
                
                    var data_list = c4_invoiceLang('list_invoice_type');
                
                    
                                    
                    return !isEmpty(row.invoice_type)? escapeHtml(data_list[row.invoice_type]) : '';
                    
                                        
                }
            },

            {   
                sortable : true,
         
                name: 'invoice_status',
                title: c4_invoiceLang('invoice_status'),
                data: function ( row, type, set, meta ) {
                
                    var data_list = c4_invoiceLang('list_invoice_status');
                
                    
                                    
                    return !isEmpty(row.invoice_status)? escapeHtml(data_list[row.invoice_status]) : '';
                    
                                        
                }
            },

            {   
                sortable : true,
 
                name: 'description',
                title: c4_invoiceLang('description'),
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
                name: 'issue_date',
                title: c4_invoiceLang('issue_date'),
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
                name: 'due_date',
                title: c4_invoiceLang('due_date'),
                data: function ( row, type, set, meta ) {

                    if(!isEmpty(row.due_date) && typeof row.due_date === 'string' && row.due_date != '0000-00-00' && row.due_date != '0000-00-00 00:00:00'){

                        var dateX = moment(row.due_date, "YYYY-MM-DD");
                        var datenow = moment();                        
                        var remaing = parseFloat(row.net_total) - parseFloat(row.total_paid);
                        var status = row.invoice_status;

                        var colorClass = '';
   
                        if (dateX > datenow) {
                            var colorClass = 'text-secondary'; 
                        } 
                        else {
                            var colorClass = 'text-danger'; 
                        }

                        if(remaing === 0 || status === 'PAID')
                        {
                            $return =  '<span class="" title="' + escapeHtml(row.due_date) +'">'  +  moment(row.due_date, 'YYYY-MM-DD').format('LL') + '</span>';
                        }
                        else{
                            $return = '<span class="' + colorClass + '" title="' + escapeHtml(row.due_date) +'">'  +  moment(row.due_date, 'YYYY-MM-DD').format('LL') + '</span>';
                            $return += '<br/><span class="' + colorClass + '" title="' + escapeHtml(row.due_date) +'">(' + dateX.fromNow() + ')</span>'
                        }

                        return $return;

                    }
                    return '';                   
                 }
            },
            {   
                sortable : true,
                name: 'gross_total',
                title: c4_invoiceLang('gross_total'),
                data: function ( row, type, set, meta ) {
                
                    var formatter = new Intl.NumberFormat('tr-TR', {maximumSignificantDigits: '4', minimumSignificantDigits  : '2'} );
                    return formatter.format(row.gross_total);
                     
                 }
            },

            {   
                sortable : true,
                name: 'net_total',
                title: c4_invoiceLang('net_total'),  
                data: function ( row, type, set, meta ) {
                
                                        var currency = row.currency;

                                        
                    if(typeof currency != 'string' || currency == ''){
                        currency = 'TRY';
                    }
                
                    var formatter = new Intl.NumberFormat('tr-TR', {
                        style: 'currency',
                        currency: currency,
                    });
                    return formatter.format(row.net_total);
                     
                 }
            },

            {   
                sortable : true,
                name: 'remaining',
                title: c4_invoiceLang('remaining'),  
                data: function ( row, type, set, meta ) {

                    var currency = row.currency;
  
                    if(typeof currency != 'string' || currency === ''){
                        currency = 'TRY';
                    }

                    var formatter = new Intl.NumberFormat('tr-TR', {
                           style: 'currency',
                           currency: currency,
                    });
                     
                    var dateX = moment(row.due_date, "YYYY-MM-DD");
                    var datenow = moment();                    

                    gross_totalView = formatter.format(row.gross_total);
                    net_totalView = formatter.format(row.net_total);

                    var remaing = parseFloat(row.net_total) - parseFloat(row.total_paid);
                                        
                    if (dateX > datenow) {
                        var className = 'text-secondary';
                    }
                    else {
                        var className = 'text-danger';
                    }

                    remaingView = `<b><span class="`+ className + `">` + formatter.format(remaing) + `</span></b>`;

                    if(remaing === 0 || row.invoice_status === 'PAID'){
                        remaingView = c4_invoiceLang('PAID');
                    }

                    return   remaingView + '<br/><span title="Gross Total">Total : ' +  gross_totalView  + '</span>';

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
                    var id = row.c4_invoice_id;
                    var child_id = d.contact_id;
                    var $link = ``;
        
                                                    $link += `<div class="btn-group" role="group" aria-label="">`;

                                    if(( (row.invoice_type === 'sales_invoice') ||  (d.invoice_type === 'sales_invoice') ) ){

                                    //sales_invoice relation form button
                                    $link += `<button  
                                            href="` + c4_invoiceUrl('showForm/sales_invoice/' + id) + `" 
                                            data-modalsize="lg"
                                            data-datatable="child_sales_invoice` + rowID + `"
                                            data-modalurl="` + c4_invoiceUrl('showForm/sales_invoice/' + id) + `"
                                            data-modaldata='\{"contact_id":"` + rowID + `"\}'
                                            data-action="openformmodal"  
                                            class="btn btn-sm btn-primary"
                                            title="` + c4_invoiceLang('_form_sales_invoice') + `">
                                            <i class="fas fa-file-invoice"></i>
                                    </button>`;

                                    }


                                
                                $link += `<div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">`;                                    //Sub Delete Link
                                   $link += `<a 
                                            href="` + c4_invoiceUrl('delete/' + id) + `" 
                                            data-datatable="child_sales_invoice` + rowID + `"
                                            data-actionurl="` + c4_invoiceUrl('delete/' + id) + `"
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
    
        
            var childTableID = 'child_purchase_invoice' + rowID;
            var cardHeader = c4_invoiceLang('_page_purchase_invoice');

            var $cardHtml = `<div class="card border-info  mt-2 mb-1">
            
            <div class="card-header text-white bg-info">
            
                <div class="float-left text-center">
                    <h6><i class="fas fa-file-invoice"></i> `+ cardHeader +` <small><span class="date_title"></span></small></h6>
                </div>
                <ul class="nav nav-pills card-header-pills float-right">`;

            
                                    $cardHtml += `<button href="javascript:;"       
                                            href="` + c4_invoiceUrl('showForm/fast_bill') + `" 
                                            data-modalsize="lg"
                                            data-datatable="child_purchase_invoice` + rowID + `"
                                            data-table="child_purchase_invoice` + rowID + `"
                                            data-modalurl="` + c4_invoiceUrl('showForm/fast_bill') + `"
                                            data-modaldata='\{"contact_id":"` + rowID + `"\}'
                                            data-action="openformmodal"                        
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-file-invoice"></i>
                                    </button>`;        
                                    $cardHtml += `<button href="javascript:;"       
                                            href="` + c4_invoiceUrl('showForm/detail_bill') + `" 
                                            data-modalsize="lg"
                                            data-datatable="child_purchase_invoice` + rowID + `"
                                            data-table="child_purchase_invoice` + rowID + `"
                                            data-modalurl="` + c4_invoiceUrl('showForm/detail_bill') + `"
                                            data-modaldata='\{"contact_id":"` + rowID + `"\}'
                                            data-action="openformmodal"                        
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-money-bill-wave"></i>
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
                    url: get_url('readC4_invoice/read_contact_TO_purchase_invoice'),
                    "type": 'POST',
                    "data": function (d) {

                        d.formFilter = 'contact_id=' + rowID;

                        var $order_column = d.order[0]['column'];
                        var $order_name =  d.columns[$order_column]['name'];
                        d.order[0]['name'] = $order_name;

                    }
                },

                    
            order: [[1, 'desc']],

                columns: [
            {   
                sortable : true,
         
                name: 'invoice_type',
                title: c4_invoiceLang('invoice_type'),
                data: function ( row, type, set, meta ) {
                
                    var data_list = c4_invoiceLang('list_invoice_type');
                
                    
                                    
                    return !isEmpty(row.invoice_type)? escapeHtml(data_list[row.invoice_type]) : '';
                    
                                        
                }
            },

            {   
                sortable : true,
         
                name: 'invoice_status',
                title: c4_invoiceLang('invoice_status'),
                data: function ( row, type, set, meta ) {
                
                    var data_list = c4_invoiceLang('list_invoice_status');
                
                    
                                    
                    return !isEmpty(row.invoice_status)? escapeHtml(data_list[row.invoice_status]) : '';
                    
                                        
                }
            },

            {   
                sortable : true,
 
                name: 'description',
                title: c4_invoiceLang('description'),
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
                name: 'issue_date',
                title: c4_invoiceLang('issue_date'),
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
                name: 'due_date',
                title: c4_invoiceLang('due_date'),
                data: function ( row, type, set, meta ) {

                    if(!isEmpty(row.due_date) && typeof row.due_date === 'string' && row.due_date != '0000-00-00' && row.due_date != '0000-00-00 00:00:00'){

                        var dateX = moment(row.due_date, "YYYY-MM-DD");
                        var datenow = moment();                        
                        var remaing = parseFloat(row.net_total) - parseFloat(row.total_paid);
                        var status = row.invoice_status;

                        var colorClass = '';
   
                        if (dateX > datenow) {
                            var colorClass = 'text-secondary'; 
                        } 
                        else {
                            var colorClass = 'text-danger'; 
                        }

                        if(remaing === 0 || status === 'PAID')
                        {
                            $return =  '<span class="" title="' + escapeHtml(row.due_date) +'">'  +  moment(row.due_date, 'YYYY-MM-DD').format('LL') + '</span>';
                        }
                        else{
                            $return = '<span class="' + colorClass + '" title="' + escapeHtml(row.due_date) +'">'  +  moment(row.due_date, 'YYYY-MM-DD').format('LL') + '</span>';
                            $return += '<br/><span class="' + colorClass + '" title="' + escapeHtml(row.due_date) +'">(' + dateX.fromNow() + ')</span>'
                        }

                        return $return;

                    }
                    return '';                   
                 }
            },
            {   
                sortable : true,
                name: 'gross_total',
                title: c4_invoiceLang('gross_total'),
                data: function ( row, type, set, meta ) {
                
                    var formatter = new Intl.NumberFormat('tr-TR', {maximumSignificantDigits: '4', minimumSignificantDigits  : '2'} );
                    return formatter.format(row.gross_total);
                     
                 }
            },

            {   
                sortable : true,
                name: 'net_total',
                title: c4_invoiceLang('net_total'),  
                data: function ( row, type, set, meta ) {
                
                                        var currency = row.currency;

                                        
                    if(typeof currency != 'string' || currency == ''){
                        currency = 'TRY';
                    }
                
                    var formatter = new Intl.NumberFormat('tr-TR', {
                        style: 'currency',
                        currency: currency,
                    });
                    return formatter.format(row.net_total);
                     
                 }
            },

            {   
                sortable : true,
                name: 'remaining',
                title: c4_invoiceLang('remaining'),  
                data: function ( row, type, set, meta ) {

                    var currency = row.currency;
  
                    if(typeof currency != 'string' || currency === ''){
                        currency = 'TRY';
                    }

                    var formatter = new Intl.NumberFormat('tr-TR', {
                           style: 'currency',
                           currency: currency,
                    });
                     
                    var dateX = moment(row.due_date, "YYYY-MM-DD");
                    var datenow = moment();                    

                    gross_totalView = formatter.format(row.gross_total);
                    net_totalView = formatter.format(row.net_total);

                    var remaing = parseFloat(row.net_total) - parseFloat(row.total_paid);
                                        
                    if (dateX > datenow) {
                        var className = 'text-secondary';
                    }
                    else {
                        var className = 'text-danger';
                    }

                    remaingView = `<b><span class="`+ className + `">` + formatter.format(remaing) + `</span></b>`;

                    if(remaing === 0 || row.invoice_status === 'PAID'){
                        remaingView = c4_invoiceLang('PAID');
                    }

                    return   remaingView + '<br/><span title="Gross Total">Total : ' +  gross_totalView  + '</span>';

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
                    var id = row.c4_invoice_id;
                    var child_id = d.contact_id;
                    var $link = ``;
        
                                                    $link += `<div class="btn-group" role="group" aria-label="">`;

                                    if(( (row.invoice_type === 'purchase_bill') ||  (d.invoice_type === 'purchase_bill') ) &&( (row.has_items === '0') ||  (d.has_items === '0') ) ){

                                    //purchase_invoice relation form button
                                    $link += `<button  
                                            href="` + c4_invoiceUrl('showForm/fast_bill/' + id) + `" 
                                            data-modalsize="lg"
                                            data-datatable="child_purchase_invoice` + rowID + `"
                                            data-modalurl="` + c4_invoiceUrl('showForm/fast_bill/' + id) + `"
                                            data-modaldata='\{"contact_id":"` + rowID + `"\}'
                                            data-action="openformmodal"  
                                            class="btn btn-sm btn-primary"
                                            title="` + c4_invoiceLang('_form_fast_bill') + `">
                                            <i class="fas fa-file-invoice"></i>
                                    </button>`;

                                    }


                                    if(( (row.invoice_type === 'purchase_bill') ||  (d.invoice_type === 'purchase_bill') ) &&( (row.has_items === '1') ||  (d.has_items === '1') ) ){

                                    //purchase_invoice relation form button
                                    $link += `<button  
                                            href="` + c4_invoiceUrl('showForm/detail_bill/' + id) + `" 
                                            data-modalsize="lg"
                                            data-datatable="child_purchase_invoice` + rowID + `"
                                            data-modalurl="` + c4_invoiceUrl('showForm/detail_bill/' + id) + `"
                                            data-modaldata='\{"contact_id":"` + rowID + `"\}'
                                            data-action="openformmodal"  
                                            class="btn btn-sm btn-primary"
                                            title="` + c4_invoiceLang('_form_detail_bill') + `">
                                            <i class="fas fa-money-bill-wave"></i>
                                    </button>`;

                                    }


                                
                                $link += `<div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">`;                                    //Sub Delete Link
                                   $link += `<a 
                                            href="` + c4_invoiceUrl('delete/' + id) + `" 
                                            data-datatable="child_purchase_invoice` + rowID + `"
                                            data-actionurl="` + c4_invoiceUrl('delete/' + id) + `"
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
                    d.formFilter = $('#form_contact').serialize();

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
                    title: '<label for="contactselectAll" class="text-center" style="width: 100%"><div class="text-center"><input type="checkbox" class="selectAll" id="contactselectAll"/></div></label>',
                    defaultContent: '',
                    "data": null,
                    orderable: false,
                    className: 'select-checkbox',
                    width: 30
                },
            {   
                sortable : true,
 
                name: 'name',
                title: contactLang('name'),
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
         
                name: 'contact_type',
                title: contactLang('contact_type'),
                data: function ( row, type, set, meta ) {
                
                    var data_list = contactLang('list_contact_type');
                
                    
                                    
                    return !isEmpty(row.contact_type)? escapeHtml(data_list[row.contact_type]) : '';
                    
                                        
                }
            },

            {   
 
                sortable : true,
                name: 'phone',
                title: contactLang('phone'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.phone !== 'string'){
                        return '';
                    }
                    
                    var phoneTxt = escapeHtml(row.phone);
                    
                                            
                         return phoneTxt; 
                         
                    
                                        
                   
                   
                }
            },
            {   
                sortable : true,
                name: 'email',
                title: contactLang('email'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.email !== 'string'){
                        return '';
                    }
                    
                                        
                        if(row.email.length > 0){
                            return `<a href="javascript:;" 
                                       data-modalsize="lg"
                                       data-datatable="table_contact"
                                       data-modalurl="` + panel_url('home/showForm/email') + `"
                                       data-modaldata='{"type":"single", "mailto":"` + escapeHtml(row.email) + `", "id":"` + row.DT_RowId + `", "email_field":"email", "table_name":"contact", "jsname":"contact"}'
                                       data-action="openformmodal"                               
                                       class="btn btn-sm btn-light" 
                                       title=""><i class="fas fa-envelope-open-text"></i>  ` + escapeHtml(row.email) + `
                                    </a>` 
                        }
                        else {
                            return '';
                        }
                    
                                        
                   
                   
                }
            },
            {   
                sortable : true,
 
                name: 'iban',
                title: contactLang('iban'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.iban !== 'string'){
                        return '';
                    }
                                        
                    var text = escapeHtml(row.iban);
                    
                                        
                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }

                    return text;

                    
                }
            },
            {   
                sortable : true,
 
                name: 'fax',
                title: contactLang('fax'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.fax !== 'string'){
                        return '';
                    }
                                        
                    var text = escapeHtml(row.fax);
                    
                                        
                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }

                    return text;

                    
                }
            },
            {   
                sortable : true,
 
                name: 'address',
                title: contactLang('address'),
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
                        name: 'Actions',
                        title: homeLang('action'),
                        sortable: false,
                        textAlign: 'right',
                        overflow: 'visible',
                        className: 'text-right',
                        width:100,

                        data: function (row) {
                            var id = row.contact_id;
                            var $link = ``;

                                var $link =`<div class="btn-group" role="group" aria-label="">`;
        
                            //contact form button
                            
                            $link += `<a
                               href="` + get_url('showForm/contact/' + id) + `" 
                               data-modalsize="lg"
                               data-datatable="table_contact"
                               data-modalurl="` + get_url('showForm/contact/' + id) + `"
                               data-modaldata='{"contact_id":"` + id + `"}'
                               data-action="openformmodal"
                               data-modalview="centermodal"
                               data-modalbackdrop="true"
                               class="btn btn-sm btn-primary"
                               title="` + contactLang('_form_contact') + `" 
                               > <i class="far fa-building"></i> 
                            </a>`;             
                                                        //Dropdown Menu
                            $link += `<div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">`
                                   //Delete Link
                                $link += `    
                                   <a
                                    href="` + get_url('delete/' + id) + `" 
                                    data-datatable="table_contact"
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

                    $('#batch_contact').collapse('show');
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
                            $('#batch_contact').collapse('hide');
                        }

                        $('.selectedCount').html(count);
                    }
                })
                .on('draw', function () {

                    var $selectAll = $('#contactselectAll');

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
        $('#form_contact').find('.generalSearch').bind("keyup search", function () {
            console.log('Searching..');
            DT1.ajax.reload();
        });

        $('#form_contact').find('.formSearch').on('change', function (e) {

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
            $('#batch_contact').collapse('hide');
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
            return contactLang(param, paramsub);
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

    if ($('#table_contact').length > 0) {
    
        general.loadPackage('dataTable', function () {
            loadDatatableLang(function () {
                contact.init_datatable();
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
