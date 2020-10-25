<?php

namespace Financepanel\Controllers;

use CodeIgniter\API\ResponseTrait;
use Financepanel\Models\C4_invoice_itemModel;
use Financepanel\Models\C4_invoiceModel;
use Financepanel\Models\ProductModel;
use Financepanel\Models\ContactModel;

class C4_invoice extends BaseController
{

    use ResponseTrait;

    //--------------------------------------------------------------------

    public function __construct()
    {
        helper(['Financepanel\c4_invoice_item', 'Financepanel\c4_invoice', 'Financepanel\product', 'Financepanel\contact']);
    }

    //--------------------------------------------------------------------
    /**
     * view default page = sales_invoice 
     * sales_invoice   
     */
    public function index()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '436a698']);

        $data                 = ['page_title' => lang('c4_invoice._page_sales_invoice')];
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('c4_invoice._page_sales_invoice'), 'class' => 'active'];

        $this->_render('sales_invoice', $data);
    }
    //--------------------------------------------------------------------
    /**
     * view page = sales_invoice
     * Sales Invoice  
     */
    public function sales_invoice()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '3a02e85']);

        $data                 = ['page_title' => lang('c4_invoice._page_sales_invoice')];
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('c4_invoice._page_sales_invoice'), 'class' => 'active'];

        $this->_render('sales_invoice', $data);
    }
    //--------------------------------------------------------------------
    /**
     * view page = purchase_invoice
     * Purchase Invoice  
     */
    public function purchase_invoice()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '7b986c1']);

        $data                 = ['page_title' => lang('c4_invoice._page_purchase_invoice')];
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('c4_invoice._page_purchase_invoice'), 'class' => 'active'];

        $this->_render('purchase_invoice', $data);
    }

    //--------------------------------------------------------------------
    /**
     * create or update
     * @return json
     */
    public function save($form_slug, $c4_invoice_id = '')
    {
        $data       = $this->request->getPost();
        $validation = \Config\Services::validation();

        //---------------------------------------------------------------------//
        //For form_slug=sales_invoice pageSlug=sales_invoice
        if($form_slug === 'sales_invoice')
        {

            //----------------------------------------------------------------//
            /**
            * gross_total FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['gross_total'] = filter_var($data['gross_total'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * total_vat FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['total_vat'] = filter_var($data['total_vat'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * net_total FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['net_total'] = filter_var($data['net_total'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            $c4_invoice_item_postArray = $data['c4_invoice_item'] ?? null;

            if (!empty($c4_invoice_item_postArray))
            {
                foreach ($c4_invoice_item_postArray as $key => $c4_invoice_item_data)
                {
                    //----------------------------------------------------------------//
                    /**
                    * unit_price FILTER_CALLBACK
                    */
                    //----------------------------------------------------------------//
                    $c4_invoice_item_data['unit_price'] = filter_var($c4_invoice_item_data['unit_price'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
                    //----------------------------------------------------------------//

                    //----------------------------------------------------------------//
                    /**
                    * quantity FILTER_CALLBACK
                    */
                    //----------------------------------------------------------------//
                    $c4_invoice_item_data['quantity'] = filter_var($c4_invoice_item_data['quantity'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
                    //----------------------------------------------------------------//

                    //----------------------------------------------------------------//
                    /**
                    * net_total FILTER_CALLBACK
                    */
                    //----------------------------------------------------------------//
                    $c4_invoice_item_data['net_total'] = filter_var($c4_invoice_item_data['net_total'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
                    //----------------------------------------------------------------//

   
                    // sales_invoice SubTable Validations and security
                    $validation->setRules([
                        'product_id'    => ['label' => lang('c4_invoice_item.product_id'), 'rules'=>"required|integer|max_length[11]"],
                        'name'          => ['label' => lang('c4_invoice_item.name'), 'rules'=>"required|alpha_numeric_space_turkish|max_length[256]"],
                        'unit_price'    => ['label' => lang('c4_invoice_item.unit_price'), 'rules'=>"required|decimal|max_length[15]"],
                        'quantity'      => ['label' => lang('c4_invoice_item.quantity'), 'rules'=>"required|decimal|max_length[15]"],
                        'vat_rate'      => ['label' => lang('c4_invoice_item.vat_rate'), 'rules'=>"required|decimal|max_length[15]|in_list[18.0000,8.0000,1.0000,0.0000]"],
                        'net_total'     => ['label' => lang('c4_invoice_item.net_total'), 'rules'=>"required|decimal|max_length[15]"],
                    ]);
                    if ($validation->run($c4_invoice_item_data) === false)
                    {
                        return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
                    }
                    
                    $c4_invoice_item_postArray[$key] = $c4_invoice_item_data;
                }
                    
                unset($c4_invoice_item_data);
            }

            // sales_invoice form Validations and security
            $validation->setRules([
                'description'   => ['label' => lang('c4_invoice.description'), 'rules'=>"required|max_length[255]|alpha_numeric_space_turkish"],
                'contact_id'    => ['label' => lang('c4_invoice.contact_id'), 'rules'=>"required|integer|max_length[11]"],
                'issue_date'    => ['label' => lang('c4_invoice.issue_date'), 'rules'=>"required|valid_date"],
                'due_date'      => ['label' => lang('c4_invoice.due_date'), 'rules'=>"required|valid_date"],
                'invoice_series' => ['label' => lang('c4_invoice.invoice_series'), 'rules'=>"permit_empty|max_length[50]|alpha_numeric_space_turkish"],
                'invoice_number' => ['label' => lang('c4_invoice.invoice_number'), 'rules'=>"permit_empty|max_length[256]|alpha_numeric_space_turkish"],
                'gross_total'   => ['label' => lang('c4_invoice.gross_total'), 'rules'=>"required|decimal|max_length[15]"],
                'total_vat'     => ['label' => lang('c4_invoice.total_vat'), 'rules'=>"required|decimal|max_length[15]"],
                'net_total'     => ['label' => lang('c4_invoice.net_total'), 'rules'=>"required|decimal|max_length[15]"],
            ]);
            if ($validation->run($data) === false)
            {
                return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
            }
            //----------------------------------------------------------------//
            // clear undefined post fields for security..
            //----------------------------------------------------------------//
            $filterFormFields = ['description', 'contact_id', 'issue_date', 'due_date', 'invoice_series', 'invoice_number', 'gross_total', 'total_vat', 'net_total', 'currency', 'c4_invoice_id'];
            $data             = array_intersect_key($data, array_flip($filterFormFields));
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * Check contact_id for security
            */        
            //----------------------------------------------------------------//
            if (empty($this->request->getPost('new_contact_id'))  && empty(getContact($data['contact_id'])))
            {
                log_message('error', 'SECURITY: Undefined contact_id value posted');
                return $this->fail(['contact_id'=>'You Can not set this value'], 400, lang('home.error_validation_form')); 
            }
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            //Form Condtions to Data
            //----------------------------------------------------------------//
            $data['invoice_type'] = 'sales_invoice';

        }
        //---------------------------------------------------------------------//
        //For form_slug=fast_bill pageSlug=purchase_invoice
        elseif($form_slug === 'fast_bill')
        {

            //----------------------------------------------------------------//
            /**
            * net_total FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['net_total'] = filter_var($data['net_total'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * total_vat FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['total_vat'] = filter_var($data['total_vat'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            // fast_bill form Validations and security
            $validation->setRules([
                'description'   => ['label' => lang('c4_invoice.description'), 'rules'=>"required|max_length[255]|alpha_numeric_space_turkish"],
                'contact_id'    => ['label' => lang('c4_invoice.contact_id'), 'rules'=>"required|integer|max_length[11]"],
                'issue_date'    => ['label' => lang('c4_invoice.issue_date'), 'rules'=>"required|valid_date"],
                'due_date'      => ['label' => lang('c4_invoice.due_date'), 'rules'=>"required|valid_date"],
                'net_total'     => ['label' => lang('c4_invoice.net_total'), 'rules'=>"required|decimal|max_length[15]"],
                'total_vat'     => ['label' => lang('c4_invoice.total_vat'), 'rules'=>"required|decimal|max_length[15]"],
            ]);
            if ($validation->run($data) === false)
            {
                return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
            }
            //----------------------------------------------------------------//
            // clear undefined post fields for security..
            //----------------------------------------------------------------//
            $filterFormFields = ['description', 'contact_id', 'issue_date', 'due_date', 'net_total', 'total_vat', 'currency', 'c4_invoice_id'];
            $data             = array_intersect_key($data, array_flip($filterFormFields));
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * Check contact_id for security
            */        
            //----------------------------------------------------------------//
            if (empty($this->request->getPost('new_contact_id'))  && empty(getContact($data['contact_id'])))
            {
                log_message('error', 'SECURITY: Undefined contact_id value posted');
                return $this->fail(['contact_id'=>'You Can not set this value'], 400, lang('home.error_validation_form')); 
            }
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            //Form Condtions to Data
            //----------------------------------------------------------------//
            $data['invoice_type'] = 'purchase_bill';
            $data['has_items'] = '0';

        }
        //---------------------------------------------------------------------//
        //For form_slug=detail_bill pageSlug=purchase_invoice
        elseif($form_slug === 'detail_bill')
        {

            //----------------------------------------------------------------//
            /**
            * gross_total FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['gross_total'] = filter_var($data['gross_total'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * total_vat FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['total_vat'] = filter_var($data['total_vat'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * net_total FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['net_total'] = filter_var($data['net_total'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            $c4_invoice_item_postArray = $data['c4_invoice_item'] ?? null;

            if (!empty($c4_invoice_item_postArray))
            {
                foreach ($c4_invoice_item_postArray as $key => $c4_invoice_item_data)
                {
                    //----------------------------------------------------------------//
                    /**
                    * quantity FILTER_CALLBACK
                    */
                    //----------------------------------------------------------------//
                    $c4_invoice_item_data['quantity'] = filter_var($c4_invoice_item_data['quantity'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
                    //----------------------------------------------------------------//

                    //----------------------------------------------------------------//
                    /**
                    * unit_price FILTER_CALLBACK
                    */
                    //----------------------------------------------------------------//
                    $c4_invoice_item_data['unit_price'] = filter_var($c4_invoice_item_data['unit_price'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
                    //----------------------------------------------------------------//

                    //----------------------------------------------------------------//
                    /**
                    * net_total FILTER_CALLBACK
                    */
                    //----------------------------------------------------------------//
                    $c4_invoice_item_data['net_total'] = filter_var($c4_invoice_item_data['net_total'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
                    //----------------------------------------------------------------//

   
                    // detail_bill SubTable Validations and security
                    $validation->setRules([
                        'product_id'    => ['label' => lang('c4_invoice_item.product_id'), 'rules'=>"required|integer|max_length[11]"],
                        'name'          => ['label' => lang('c4_invoice_item.name'), 'rules'=>"required|alpha_numeric_space_turkish|max_length[256]"],
                        'quantity'      => ['label' => lang('c4_invoice_item.quantity'), 'rules'=>"required|decimal|max_length[15]"],
                        'unit_price'    => ['label' => lang('c4_invoice_item.unit_price'), 'rules'=>"required|decimal|max_length[15]"],
                        'vat_rate'      => ['label' => lang('c4_invoice_item.vat_rate'), 'rules'=>"required|decimal|max_length[15]|in_list[18.0000,8.0000,1.0000,0.0000]"],
                        'net_total'     => ['label' => lang('c4_invoice_item.net_total'), 'rules'=>"required|decimal|max_length[15]"],
                    ]);
                    if ($validation->run($c4_invoice_item_data) === false)
                    {
                        return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
                    }
                    
                    $c4_invoice_item_postArray[$key] = $c4_invoice_item_data;
                }
                    
                unset($c4_invoice_item_data);
            }

            // detail_bill form Validations and security
            $validation->setRules([
                'description'   => ['label' => lang('c4_invoice.description'), 'rules'=>"required|max_length[255]|alpha_numeric_space_turkish"],
                'contact_id'    => ['label' => lang('c4_invoice.contact_id'), 'rules'=>"required|integer|max_length[11]"],
                'issue_date'    => ['label' => lang('c4_invoice.issue_date'), 'rules'=>"required|valid_date"],
                'due_date'      => ['label' => lang('c4_invoice.due_date'), 'rules'=>"required|valid_date"],
                'gross_total'   => ['label' => lang('c4_invoice.gross_total'), 'rules'=>"required|decimal|max_length[15]"],
                'total_vat'     => ['label' => lang('c4_invoice.total_vat'), 'rules'=>"required|decimal|max_length[15]"],
                'net_total'     => ['label' => lang('c4_invoice.net_total'), 'rules'=>"required|decimal|max_length[15]"],
            ]);
            if ($validation->run($data) === false)
            {
                return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
            }
            //----------------------------------------------------------------//
            // clear undefined post fields for security..
            //----------------------------------------------------------------//
            $filterFormFields = ['description', 'contact_id', 'issue_date', 'due_date', 'gross_total', 'total_vat', 'net_total', 'currency', 'c4_invoice_id'];
            $data             = array_intersect_key($data, array_flip($filterFormFields));
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * Check contact_id for security
            */        
            //----------------------------------------------------------------//
            if (empty($this->request->getPost('new_contact_id'))  && empty(getContact($data['contact_id'])))
            {
                log_message('error', 'SECURITY: Undefined contact_id value posted');
                return $this->fail(['contact_id'=>'You Can not set this value'], 400, lang('home.error_validation_form')); 
            }
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            //Form Condtions to Data
            //----------------------------------------------------------------//
            $data['invoice_type'] = 'purchase_bill';
            $data['has_items'] = '1';

        }
        //---------------------------------------------------------------------//
        else
        {
            //not matched
            log_message('error', "SECURITY: $form_slug form not founded");
            return $this->failNotFound("$form_slug form not found");
        }

        $C4_invoiceModel = new C4_invoiceModel();

        try
        {
            $C4_invoiceModel->save($data);
        }
        catch (\Exception $e)
        {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            return $this->fail($e->getMessage(), 400, lang('home.error_validation_form'));
        }
        
        if(empty($c4_invoice_id))
        {
            $c4_invoice_id = $C4_invoiceModel->getInsertID();
        }

        //---------------------------------------------------------------------//
        //For form_slug=sales_invoice pageSlug=sales_invoice
        if($form_slug === 'sales_invoice')
        {

            //------------------------------------------------------------------
            //Delete All relational c4_invoice_item_id if form is empty
            if (empty($c4_invoice_item_postArray))
            {
                deleteC4_invoice_item(['c4_invoice_id' => $c4_invoice_id]);
            }
            else
            {
                //Delete relational c4_invoice_item_id deleted on form...

                $getAllC4_invoice_item = getAllC4_invoice_item(['c4_invoice_id' => $c4_invoice_id]);

                if (!empty($getAllC4_invoice_item))
                {
                    foreach ($getAllC4_invoice_item as $temp_data)
                    {
                        $c4_invoice_item_id = $temp_data['c4_invoice_item_id'];

                        if (!isset($c4_invoice_item_postArray[$c4_invoice_item_id]))
                        {
                            deleteC4_invoice_item($c4_invoice_item_id);
                        }
                    }
  
                    unset($temp_data);
                    unset($getAllC4_invoice_item);
                }

                foreach ($c4_invoice_item_postArray as $c4_invoice_item_data)
                {

                    //----------------------------------------------------------------//
                    /**
                    * Check product_id for security
                    */        
                    //----------------------------------------------------------------//
                    if (empty($this->request->getPost('new_product_id'))  && empty(getProduct($c4_invoice_item_data['product_id'])))
                    {
                        log_message('error', 'SECURITY: Undefined product_id value posted');
                        return $this->fail(['product_id'=>'You Can not set this value'], 400, lang('home.error_validation_form')); 
                    }
                    //----------------------------------------------------------------//

                    //----------------------------------------------------------------//
                    // clear undefined post fields for security..
                    //----------------------------------------------------------------//
                    $filterFormFields = ['product_id', 'name', 'unit_price', 'quantity', 'vat_rate', 'net_total', 'c4_invoice_item_id'];
                    $c4_invoice_item_data  = array_intersect_key($c4_invoice_item_data, array_flip($filterFormFields));
                    //----------------------------------------------------------------//

                    //Set Relation Field
                    $c4_invoice_item_data['c4_invoice_id'] = $c4_invoice_id;

                    saveC4_invoice_item($c4_invoice_item_data);

                }
            }

        }

        //---------------------------------------------------------------------//
        //For form_slug=detail_bill pageSlug=purchase_invoice
        if($form_slug === 'detail_bill')
        {

            //------------------------------------------------------------------
            //Delete All relational c4_invoice_item_id if form is empty
            if (empty($c4_invoice_item_postArray))
            {
                deleteC4_invoice_item(['c4_invoice_id' => $c4_invoice_id]);
            }
            else
            {
                //Delete relational c4_invoice_item_id deleted on form...

                $getAllC4_invoice_item = getAllC4_invoice_item(['c4_invoice_id' => $c4_invoice_id]);

                if (!empty($getAllC4_invoice_item))
                {
                    foreach ($getAllC4_invoice_item as $temp_data)
                    {
                        $c4_invoice_item_id = $temp_data['c4_invoice_item_id'];

                        if (!isset($c4_invoice_item_postArray[$c4_invoice_item_id]))
                        {
                            deleteC4_invoice_item($c4_invoice_item_id);
                        }
                    }
  
                    unset($temp_data);
                    unset($getAllC4_invoice_item);
                }

                foreach ($c4_invoice_item_postArray as $c4_invoice_item_data)
                {

                    //----------------------------------------------------------------//
                    /**
                    * Check product_id for security
                    */        
                    //----------------------------------------------------------------//
                    if (empty($this->request->getPost('new_product_id'))  && empty(getProduct($c4_invoice_item_data['product_id'])))
                    {
                        log_message('error', 'SECURITY: Undefined product_id value posted');
                        return $this->fail(['product_id'=>'You Can not set this value'], 400, lang('home.error_validation_form')); 
                    }
                    //----------------------------------------------------------------//

                    //----------------------------------------------------------------//
                    // clear undefined post fields for security..
                    //----------------------------------------------------------------//
                    $filterFormFields = ['product_id', 'name', 'quantity', 'unit_price', 'vat_rate', 'net_total', 'c4_invoice_item_id'];
                    $c4_invoice_item_data  = array_intersect_key($c4_invoice_item_data, array_flip($filterFormFields));
                    //----------------------------------------------------------------//

                    //Set Relation Field
                    $c4_invoice_item_data['c4_invoice_id'] = $c4_invoice_id;

                    saveC4_invoice_item($c4_invoice_item_data);

                }
            }

        }
    
        $InvoiceSystem  = new \App\Libraries\InvoiceSystem\InvoiceSystem();
        $InvoiceSystem->read($c4_invoice_id);
        $InvoiceSystem->update($InvoiceSystem->getInvoiceData());

        return $this->respondCreated(['id' => $c4_invoice_id, 'message' => lang('home.saved')]);
    }
 
    //--------------------------------------------------------------------

    /**
     * Read c4_invoice data
     * Functions adds DT_RowId variable to each row for datatables.net
     * 
     * Search Contions may change according to $pageSlug
     * 
     * @param string $pageSlug
     * @return array
     * 
     */
    public function readC4_invoice($pageSlug)
    {

        $pageList = ['sales_invoice', 'purchase_invoice'];
        $pageSlug = trim($pageSlug);

        if (!in_array($pageSlug, $pageList))
        {
            return $this->response->setJSON(['error' => 'Invalid Page Name']);
        }
            
        session();

        $_SESSION['draw'] =  (int)($draw = $_SESSION['draw'] ?? 1) + 1;

        $start        = intval($_POST['start'] ?? $_GET['start'] ?? 0); 
        $length       = intval($_POST['length'] ?? $_GET['length'] ?? 200);
        $order        = $this->request->getPostGet('order'); //asc desc
        $order_dir    = (isset($order[0]['dir']) && in_array($order[0]['dir'], ['asc', 'desc'])) ? $order[0]['dir'] : 'desc';
        $order_column = filter_var($order[0]['name'] ?? NULL, FILTER_SANITIZE_STRING);

        $model      = new C4_invoiceModel();
        $primaryKey = $model->primaryKey;

        $table_colons = $model->getAllowedFields();
 
        // ---------------------------------------------------------------------
        // Form Search Filter
        $formFilter  = $this->request->getPostGet('formFilter');
        $filterArray = null;
        $search_text = null;
 
        if (!empty($formFilter) && is_string($formFilter))
        {
            parse_str($formFilter, $filterArray);
            
            //filterSearch is general input search used in pageview
            if (isset($filterArray['filterSearch']) && !empty($filterArray['filterSearch']))
            {
                $search_text = trim($filterArray['filterSearch']);
            }
        }
        else
        {
            //Standart datatable.net $search['value'] input. used in subtable.
            $search = $this->request->getPost("search");
            if (!empty($search) && !empty($search['value']))
            {
                $search_text = trim($search['value']);
            }
        }
        // ---------------------------------------------------------------------

        //--------------------------------------------------------------------//
        // Page sales_invoice
        //--------------------------------------------------------------------//

        if($pageSlug === 'sales_invoice')
        {
            $select_text       = "c4_invoice.*, contact.name as contact_RELATIONAL_name";
            $multipleFields    = [];

            //------------------------------------------------------------------//
            //merge relation fields names to make Sortable
            $table_colons = array_merge($table_colons, ['contact_RELATIONAL_name']);
            //------------------------------------------------------------------//
            //------------------------------------------------------------------//        
            // Left Join Text
            //------------------------------------------------------------------//
            $model->join("(SELECT contact_id, name FROM contact WHERE contact.deleted_at IS NULL AND contact.status = '1' GROUP BY contact_id ORDER BY contact_id DESC) contact", 'contact.contact_id = c4_invoice.contact_id', 'left');

            if (!empty($search_text))
            {
                $search_text = filter_var($search_text, FILTER_SANITIZE_STRING);
                $model->groupStart();
                $model->groupEnd();
            }

            $model->where("invoice_type='sales_invoice'");

        }
        //----------------------------oo----------------------------------//


        //--------------------------------------------------------------------//
        // Page purchase_invoice
        //--------------------------------------------------------------------//

        elseif($pageSlug === 'purchase_invoice')
        {
            $select_text       = "c4_invoice.*, contact.name as contact_RELATIONAL_name";
            $multipleFields    = [];

            //------------------------------------------------------------------//
            //merge relation fields names to make Sortable
            $table_colons = array_merge($table_colons, ['contact_RELATIONAL_name']);
            //------------------------------------------------------------------//
            //------------------------------------------------------------------//        
            // Left Join Text
            //------------------------------------------------------------------//
            $model->join("(SELECT contact_id, name FROM contact WHERE contact.deleted_at IS NULL AND contact.status = '1' GROUP BY contact_id ORDER BY contact_id DESC) contact", 'contact.contact_id = c4_invoice.contact_id', 'left');

            if (!empty($search_text))
            {
                $search_text = filter_var($search_text, FILTER_SANITIZE_STRING);
                $model->groupStart();
                $model->groupEnd();
            }

            $model->where("invoice_type='purchase_bill'");

        }
        //----------------------------oo----------------------------------//


        $model->select($select_text);

        //---------------------------------------------------------------------//
        //OTHER FORM SEARCH OPTIONS
        //---------------------------------------------------------------------//

        if (!empty($filterArray) && is_array($filterArray))
        {
            foreach ($filterArray as $filterField => $filterValue)
            {

                if (!is_array($filterValue))
                {
                    $filterValue = trim($filterValue);
                }

                if (empty($filterValue) && !is_numeric($filterValue))
                {
                    continue;
                }

                if ($filterField === 'daterangefilter' && !empty($filterValue))
                {
                    foreach ($filterValue as $dateField => $dateRange)
                    {
                        $exp = explode(' - ', $dateRange);
                        if (count($exp) === 2)
                        {        
                            $_GET['dateRangeStart'][$dateField] = $exp[0];
                            $_GET['dateRangeEnd'][$dateField]   = $exp[1];
                        }
                    }
                    continue;
                }

                if(!in_array($filterField, $table_colons) || in_array($filterField, ['filterSearch', 'deleted_at']))
                {
                    continue;
                }

                if (in_array($filterField, $multipleFields))
                {
                    if(is_array($filterValue))
                    {
                        $model->groupStart();
                        foreach ($filterValue as  $fvalue)
                        {
                           $model->like($filterField, filter_var($fvalue, FILTER_SANITIZE_STRING)); 
                        }
                        $model->groupEnd();
                    }
                    else
                    {
                        $model->groupStart();
                        $model->like($filterField, filter_var($filterValue, FILTER_SANITIZE_STRING)); 
                        $model->groupEnd();
                    }
                }
                elseif (!is_array($filterValue) || is_numeric($filterValue))
                {
                    $model->where("c4_invoice.$filterField", trim(filter_var($filterValue, FILTER_SANITIZE_STRING)));
                }
            }
        }
        if (isset($filterArray['deleted_at']) && $filterArray['deleted_at'] === '1')
        {
            $model->onlyDeleted();
        }
        else
        {
            $model->where('c4_invoice.deleted_at', NULL);
        }

        //---------------------------------------------------------------------//
        /**
         * dateRangeStart and dateRangeEnd used in statistic page. 
         * Also you can use for datatable filter.
         * Get Request E.g
         * dateRangeStart[created_at]=2020-01-01&dateRangeEnd[created_at]=2020-03-02
         */

        $dateRangeStart = $_GET['dateRangeStart'] ?? $_POST['dateRangeStart'] ?? NULL;

        if (!empty($dateRangeStart) && is_array($dateRangeStart))
        {
            foreach ($dateRangeStart as $key_field => $fieldValue)
            {
                if (in_array($key_field, $table_colons) && !empty($fieldValue))
                {
                    $fieldValue = date( "Y-m-d", strtotime(trim($fieldValue)));
                    $model->where("c4_invoice.$key_field >=", $fieldValue);
                }
            }
        }

        $dateRangeEnd = $_GET['dateRangeEnd'] ?? $_POST['dateRangeEnd'] ?? NULL;

        if (!empty($dateRangeEnd) && is_array($dateRangeEnd))
        {
            foreach ($dateRangeEnd as $key_field => $fieldValue)
            {
                if (in_array($key_field, $table_colons) && !empty($fieldValue))
                {
                    $fieldValue = date( "Y-m-d", strtotime(trim($fieldValue)));
                    $model->where("c4_invoice.$key_field <=", $fieldValue .' 23:59:59');
                }
            }
        }
        //---------------------------------------------------------------------//

        //==========SORT==========//
        if (!empty($order_column) && in_array($order_column, $table_colons))
        {
            $model->orderBy($order_column, $order_dir);
        }
        else
        {
            $model->orderBy($primaryKey, 'DESC');
        }

        //==========LIMIT==========//
        if($length > 0)
        {
            $model->limit($length, $start);
        }            

        //==========GET RESULT==========//
        $db_result = $model->get()->getResult();

        //==========RETURN DATA==========//
        $getLastQuery  = $model->showLastQuery();
        $unlimited     = explode('LIMIT', $getLastQuery)[0];
        $select_sql    = "SELECT COUNT($primaryKey) as count FROM ($unlimited) AS subquery";
        $iTotalRecords = $model->query($select_sql)->getRow()->count;

        if (!empty($db_result))
        {
            foreach ($db_result as $key => $value)
            {
                $db_result[$key]->DT_RowId = $value->$primaryKey;

                //--------------------------------------------------------------------//
                // Page sales_invoice
                //--------------------------------------------------------------------//

                if($pageSlug === 'sales_invoice')
                { 

                } //endif

                //--------------------------------------------------------------------//
                // Page purchase_invoice
                //--------------------------------------------------------------------//

                elseif($pageSlug === 'purchase_invoice')
                { 

                } //endif

            }
        }

        $result = [
            'draw'            => $draw,
            'recordsTotal'    => intval($iTotalRecords),
            'recordsFiltered' => intval($iTotalRecords),
            //'sql' => $getLastQuery,
            'data'            => $db_result
        ];
        return $this->response->setJSON($result);

    }

    //--------------------------------------------------------------------
 
    //--------------------------------------------------------------------

    /**
     * Read c4_invoice_item data
     * Functions adds DT_RowId variable to each row for datatables.net
     * 
     * Search Contions may change according to $pageSlug
     * 
     * @param string $pageSlug
     * @return array
     * 
     */
    public function readC4_invoice_item($pageSlug)
    {

        $pageList = ['read_sales_invoice_TO_c4_invoice_item'];
        $pageSlug = trim($pageSlug);

        if (!in_array($pageSlug, $pageList))
        {
            return $this->response->setJSON(['error' => 'Invalid Page Name']);
        }
            
        session();

        $_SESSION['draw'] =  (int)($draw = $_SESSION['draw'] ?? 1) + 1;

        $start        = intval($_POST['start'] ?? $_GET['start'] ?? 0); 
        $length       = intval($_POST['length'] ?? $_GET['length'] ?? 200);
        $order        = $this->request->getPostGet('order'); //asc desc
        $order_dir    = (isset($order[0]['dir']) && in_array($order[0]['dir'], ['asc', 'desc'])) ? $order[0]['dir'] : 'desc';
        $order_column = filter_var($order[0]['name'] ?? NULL, FILTER_SANITIZE_STRING);

        $model      = new C4_invoice_itemModel();
        $primaryKey = $model->primaryKey;

        $table_colons = $model->getAllowedFields();
 
        // ---------------------------------------------------------------------
        // Form Search Filter
        $formFilter  = $this->request->getPostGet('formFilter');
        $filterArray = null;
        $search_text = null;
 
        if (!empty($formFilter) && is_string($formFilter))
        {
            parse_str($formFilter, $filterArray);
            
            //filterSearch is general input search used in pageview
            if (isset($filterArray['filterSearch']) && !empty($filterArray['filterSearch']))
            {
                $search_text = trim($filterArray['filterSearch']);
            }
        }
        else
        {
            //Standart datatable.net $search['value'] input. used in subtable.
            $search = $this->request->getPost("search");
            if (!empty($search) && !empty($search['value']))
            {
                $search_text = trim($search['value']);
            }
        }
        // ---------------------------------------------------------------------

        //--------------------------------------------------------------------//
        // Page read_sales_invoice_TO_c4_invoice_item
        //--------------------------------------------------------------------//

        if($pageSlug === 'read_sales_invoice_TO_c4_invoice_item')
        {
            $select_text       = "c4_invoice_item.*";
            $multipleFields    = [];

            if (!empty($search_text))
            {
                $search_text = filter_var($search_text, FILTER_SANITIZE_STRING);
                $model->groupStart();
                $model->orLike('c4_invoice_item.name', $search_text);
                $model->groupEnd();
            }

        }
        //----------------------------oo----------------------------------//


        $model->select($select_text);

        //---------------------------------------------------------------------//
        //OTHER FORM SEARCH OPTIONS
        //---------------------------------------------------------------------//

        if (!empty($filterArray) && is_array($filterArray))
        {
            foreach ($filterArray as $filterField => $filterValue)
            {

                if (!is_array($filterValue))
                {
                    $filterValue = trim($filterValue);
                }

                if (empty($filterValue) && !is_numeric($filterValue))
                {
                    continue;
                }

                if ($filterField === 'daterangefilter' && !empty($filterValue))
                {
                    foreach ($filterValue as $dateField => $dateRange)
                    {
                        $exp = explode(' - ', $dateRange);
                        if (count($exp) === 2)
                        {        
                            $_GET['dateRangeStart'][$dateField] = $exp[0];
                            $_GET['dateRangeEnd'][$dateField]   = $exp[1];
                        }
                    }
                    continue;
                }

                if(!in_array($filterField, $table_colons) || in_array($filterField, ['filterSearch', 'status', 'deleted_at']))
                {
                    continue;
                }

                if (in_array($filterField, $multipleFields))
                {
                    if(is_array($filterValue))
                    {
                        $model->groupStart();
                        foreach ($filterValue as  $fvalue)
                        {
                           $model->like($filterField, filter_var($fvalue, FILTER_SANITIZE_STRING)); 
                        }
                        $model->groupEnd();
                    }
                    else
                    {
                        $model->groupStart();
                        $model->like($filterField, filter_var($filterValue, FILTER_SANITIZE_STRING)); 
                        $model->groupEnd();
                    }
                }
                elseif (!is_array($filterValue) || is_numeric($filterValue))
                {
                    $model->where("c4_invoice_item.$filterField", trim(filter_var($filterValue, FILTER_SANITIZE_STRING)));
                }
            }
        }
        //Show Allways active status if not filtered
        if (!isset($filterArray['status']))
        {
            $model->where('c4_invoice_item.status', '1');
        }
        else
        {
            $model->where('c4_invoice_item.status', $filterArray['status']);
        }
        if (isset($filterArray['deleted_at']) && $filterArray['deleted_at'] === '1')
        {
            $model->onlyDeleted();
        }
        else
        {
            $model->where('c4_invoice_item.deleted_at', NULL);
        }

        //---------------------------------------------------------------------//
        /**
         * dateRangeStart and dateRangeEnd used in statistic page. 
         * Also you can use for datatable filter.
         * Get Request E.g
         * dateRangeStart[created_at]=2020-01-01&dateRangeEnd[created_at]=2020-03-02
         */

        $dateRangeStart = $_GET['dateRangeStart'] ?? $_POST['dateRangeStart'] ?? NULL;

        if (!empty($dateRangeStart) && is_array($dateRangeStart))
        {
            foreach ($dateRangeStart as $key_field => $fieldValue)
            {
                if (in_array($key_field, $table_colons) && !empty($fieldValue))
                {
                    $fieldValue = date( "Y-m-d", strtotime(trim($fieldValue)));
                    $model->where("c4_invoice_item.$key_field >=", $fieldValue);
                }
            }
        }

        $dateRangeEnd = $_GET['dateRangeEnd'] ?? $_POST['dateRangeEnd'] ?? NULL;

        if (!empty($dateRangeEnd) && is_array($dateRangeEnd))
        {
            foreach ($dateRangeEnd as $key_field => $fieldValue)
            {
                if (in_array($key_field, $table_colons) && !empty($fieldValue))
                {
                    $fieldValue = date( "Y-m-d", strtotime(trim($fieldValue)));
                    $model->where("c4_invoice_item.$key_field <=", $fieldValue .' 23:59:59');
                }
            }
        }
        //---------------------------------------------------------------------//

        //==========SORT==========//
        if (!empty($order_column) && in_array($order_column, $table_colons))
        {
            $model->orderBy($order_column, $order_dir);
        }
        else
        {
            $model->orderBy($primaryKey, 'DESC');
        }

        //==========LIMIT==========//
        if($length > 0)
        {
            $model->limit($length, $start);
        }            

        //==========GET RESULT==========//
        $db_result = $model->get()->getResult();

        //==========RETURN DATA==========//
        $getLastQuery  = $model->showLastQuery();
        $unlimited     = explode('LIMIT', $getLastQuery)[0];
        $select_sql    = "SELECT COUNT($primaryKey) as count FROM ($unlimited) AS subquery";
        $iTotalRecords = $model->query($select_sql)->getRow()->count;

        if (!empty($db_result))
        {
            foreach ($db_result as $key => $value)
            {
                $db_result[$key]->DT_RowId = $value->$primaryKey;

                //--------------------------------------------------------------------//
                // Page read_sales_invoice_TO_c4_invoice_item
                //--------------------------------------------------------------------//

                if($pageSlug === 'read_sales_invoice_TO_c4_invoice_item')
                { 

                } //endif

            }
        }

        $result = [
            'draw'            => $draw,
            'recordsTotal'    => intval($iTotalRecords),
            'recordsFiltered' => intval($iTotalRecords),
            //'sql' => $getLastQuery,
            'data'            => $db_result
        ];
        return $this->response->setJSON($result);

    }

    //--------------------------------------------------------------------
    /**
     * Delete c4_invoice by id
     * @param mix $id
     * @return mixed
     */
    public function delete($id)
    {
        if (empty($id))
        {
            return $this->fail('ID can not be empty');
        }
        if (!is_numeric($id))
        {
            log_message('critical', "SECURITY: Delete ID is not numeric ID: " . esc($id) );
            return $this->fail('ID must be numeric');
        }

        $C4_invoiceModel = new C4_invoiceModel();
        if ($C4_invoiceModel->delete($id, true) === false)
        {
            log_message('error', "Error: $id ID C4_invoiceModel Delete Error");
            return $this->fail($C4_invoiceModel->errors());
        }

        return $this->respondDeleted(['id' => $id]);
    }

    //--------------------------------------------------------------------

    /**
     * Show form by formSlug
     * @param string $formSlug
     * @return html
     */
    public function showForm($formSlug, $id = null)
    {
        $formSlug = trim($formSlug);

        $data['page_title'] = lang('c4_invoice._form_' .$formSlug);
        $data['formData'] = $_POST;
        
        // -----------------------------------
        //breadcrumb if form is showed in Page
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];

        if($formSlug === 'sales_invoice')
        {
            $data['breadcrumb'][] = ['url' => financepanel_url('c4_invoice/sales_invoice'), 'title' => lang('c4_invoice._page_sales_invoice')];
            $data['breadcrumb'][] = ['title' => lang('c4_invoice._form_sales_invoice'), 'class' => 'active'];
        }
        elseif($formSlug === 'fast_bill')
        {
            $data['breadcrumb'][] = ['url' => financepanel_url('c4_invoice/purchase_invoice'), 'title' => lang('c4_invoice._page_purchase_invoice')];
            $data['breadcrumb'][] = ['title' => lang('c4_invoice._form_fast_bill'), 'class' => 'active'];
        }
        elseif($formSlug === 'detail_bill')
        {
            $data['breadcrumb'][] = ['url' => financepanel_url('c4_invoice/purchase_invoice'), 'title' => lang('c4_invoice._page_purchase_invoice')];
            $data['breadcrumb'][] = ['title' => lang('c4_invoice._form_detail_bill'), 'class' => 'active'];
        }
        else
        {
            log_message('error', "SECURITY: $formSlug form not founded");
            return $this->failNotFound("$formSlug not founded");
        }

        if (!empty($id))
        {
            $C4_invoiceModel = new C4_invoiceModel();
            
            $data['formData'] += $C4_invoiceModel->find($id) ?? [];
        }

        $copy      = (int) $this->request->getGet('copy');

        if (!empty($copy))
        {
            $C4_invoiceModel = new C4_invoiceModel();
            
            $data['formData'] += $C4_invoiceModel->find($copy);
            
            if(isset($data['formData']['c4_invoice_id']))
            {
                unset($data['formData']['c4_invoice_id']);
            }
        }

        

        $this->_render('form/' . $formSlug, $data);
    }

    //--------------------------------------------------------------------

    public function showFormPart($subformSlug)
    {
        $subformList = ['sales_invoice_relation_c4_invoice_item', 'detail_bill_relation_perchase_invoice_items'];

        if (!in_array($subformSlug, $subformList))
        {
            return $this->failNotFound("$subformSlug not founded");
        }

        helper('form');

        if($subformSlug === 'sales_invoice_relation_c4_invoice_item')
        {
            $key = rand(10000000, 90000000); 
            echo financepanel_view('c4_invoice/form/sales_invoice_relation_c4_invoice_item', ['key' => $key, 'formData' => []]);
        }

        if($subformSlug === 'detail_bill_relation_perchase_invoice_items')
        {
            $key = rand(10000000, 90000000); 
            echo financepanel_view('c4_invoice/form/detail_bill_relation_perchase_invoice_items', ['key' => $key, 'formData' => []]);
        }

    }
    //--------------------------------------------------------------------

    /**
     * Get ContactModel data
     * @return json
     */
    public function getAllContact() 
    {
        $q      = $this->request->getGetPost('search');
        $filter = $this->request->getGetPost('filter');
        $limit  = $this->request->getGetPost('limit');

        if(!is_numeric($limit))
        {
            $limit = 100;
        }
        
        //Return Filter Str to Array
        $filterArray = null;
        if (!empty($filter) && is_string($filter)) 
        {
            parse_str($filter, $filterArray);
        }

        $model = new ContactModel();
        $allowedFields = $model->getAllowedFields();
        
        if(!empty($q))
        {
            $model->groupStart();
            $model->orLike('name', $q);
            $model->groupEnd();
        }

        //-------------------------------------//
        /**
        * status field
        */
        $model->where('status', 1);
        //-------------------------------------//

        $model->where('deleted_at', NULL);

        $model->orderBy('name', 'asc');

        if (!empty($filterArray)) {
            foreach ($filterArray as $fieldName => $fieldValue) {

                if (in_array($fieldName, ['status', 'deleted_at', 'created_at', 'updated_at'])) 
                {
                    continue;
                }
                if (! in_array($fieldName, $allowedFields) )
                {
                    continue;
                }
                
                if ( !empty($fieldValue) || is_numeric($fieldValue) ) 
                {
                    $model->where($fieldName, $fieldValue);
                }
            }
        }
        
        return $this->response->setJSON($model->findAll($limit));
    }

    //--------------------------------------------------------------------

    public function uploadSubFile($formSlug, $fieldName)
    {
        $formList = ['sales_invoice_relation_c4_invoice_item', 'detail_bill_relation_perchase_invoice_items'];

        if (!in_array($formSlug, $formList))
        {
            return $this->failNotFound("$formSlug not founded");
        }
                
        $fileService = \Financepanel\Config\Services::file();

        if (isset($return['upload_data']))
        {
            return $this->respond($return);
        }
        else
        {
            return $this->fail($return);
        }

    }

    //--------------------------------------------------------------------

    public function uploadFile($formSlug, $fieldName)
    {
        $formList = ['sales_invoice', 'fast_bill', 'detail_bill'];

        if (!in_array($formSlug, $formList))
        {
            return $this->failNotFound("$formSlug not founded");
        }
            
        $fileService = \Financepanel\Config\Services::file();

        if($fieldName === 'files')
        {
            if (!$this->validate(['file' => ['label' => lang('c4_invoice.files'), 'rules' => 'uploaded[file]|max_size[file,2048]|ext_in[file,pdf,gz,gzip,zip,rar]']]))
            {
                return $this->fail($this->validator->getErrors(), 400);
            }
            
            $return = $fileService->upload("c4_invoice/$fieldName", false);
        }
       
        

        if (isset($return['upload_data']))
        {
            return $this->respond($return);
        }
        else
        {
            return $this->fail($return);
        }

    }

    //--------------------------------------------------------------------

    public function deleteFile($file_id)
    {
        if (!is_numeric($file_id))
        {
            return $this->failValidationError(lang('home.error_invalid_id'));
        }
    
        $fileService = \Financepanel\Config\Services::file();

        $fileService->deleteFile((int) $file_id);

        return $this->respondDeleted(['id' => $file_id]);
    }

    //--------------------------------------------------------------------

    function updateFileOrder()
    {
        $order_ids = $this->request->getPost('order');        
        $fileService = \Financepanel\Config\Services::file();
        $fileService->updateFileOrders($order_ids);

        return $this->respond(['message' => lang('home.saved')]);
    }

    //--------------------------------------------------------------------
    /**
     * Update single field of c4_invoice 
     * 
     * @param int $id
     * @return mix
     */
    public function update($id)
    {
        if (!is_numeric($id))
        {
            log_message('critical', "SECURITY: Update ID is not numeric ID: " . esc($id) );
            return $this->fail('ID must be numeric');
        }
        $data = $this->request->getPost();
        //allowed update filelds
        $batchList = ['invoice_type', 'invoice_status', 'currency', 'invoice_discount_type', 'deleted_at'];

        //clear the post data
        $array_diff = array_diff(array_keys($data), $batchList);
        if (!empty($array_diff))
        {
            log_message('critical', 'SECURITY: NotAllowed update attempt');

            foreach ($array_diff as $value)
            {
                unset($data[$value]);
            }
        }

        if (empty($data))
        {
            log_message('error', 'ERROR: Update Post Data is Empty');
            return $this->fail(lang('home.error_data_empty'), 400, lang('home.error_data_empty'));
        }

        $model = new C4_invoiceModel();
        

        //validation
        if(isset($data['invoice_type']))
        {
            if (!$this->validate([
                'invoice_type' => ['label' => lang('c4_invoice.invoice_type'), 'rules' => 'required|in_list[sales_invoice,purchase_bill]|alpha_dash'],
            ]))
            {
                return $this->fail($this->validator->getErrors(), 400, lang('home.error_invalid_id'));
            }
        }
        if(isset($data['invoice_status']))
        {
            if (!$this->validate([
                'invoice_status' => ['label' => lang('c4_invoice.invoice_status'), 'rules' => 'required|in_list[DRAFT,SENT,PAID,CANCELLED,REFUNDED,PARTIALLY_PAID,PARTIALLY_REFUNDED,MARKED_AS_REFUNDED,UNPAID,PAYMENT_PENDING]|alpha_dash'],
            ]))
            {
                return $this->fail($this->validator->getErrors(), 400, lang('home.error_invalid_id'));
            }
        }
        if(isset($data['currency']))
        {
            if (!$this->validate([
                'currency' => ['label' => lang('c4_invoice.currency'), 'rules' => 'required|alpha_numeric_space|max_length[256]|in_list[TRY,USD,EUR,GBP]'],
            ]))
            {
                return $this->fail($this->validator->getErrors(), 400, lang('home.error_invalid_id'));
            }
        }
        if(isset($data['invoice_discount_type']))
        {
            if (!$this->validate([
                'invoice_discount_type' => ['label' => lang('c4_invoice.invoice_discount_type'), 'rules' => 'required|in_list[percentage,amount]|alpha_dash'],
            ]))
            {
                return $this->fail($this->validator->getErrors(), 400, lang('home.error_invalid_id'));
            }
        }
        if(isset($data['deleted_at']))
        {
            if($data['deleted_at'] === '1')
            {
                $model->delete($id, true);
                return  $this->respondDeleted(['id'=>$id]);                
            }
            else
            {
                $data['deleted_at'] = null;
            }
        }
        try
        {
            $model->update($id, $data);
        }
        catch (\Exception $e)
        {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            return $this->fail($e->getMessage(), 400, $e->getMessage());
        }

        return $this->respond(['message' => lang('home.updated'), 'id' => $id]);
    }
    //--------------------------------------------------------------------
    /**
     * Show chartPage
     * @param string $chartSlug
     * @return html
     */
    public function showchart($chartSlug)
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '09938a8']);

        $chartSlug = trim($chartSlug);
        $chartList = ['sales_invoice_daily_statistic', 'purchase'];

        if (!in_array($chartSlug, $chartList))
        {
            return $this->failNotFound("$chartSlug not founded");
        }

        $data = ['page_title' => lang("c4_invoice._chart_$chartSlug")];
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['url' => financepanel_url('c4_invoice/sales_invoice'), 'title' => lang('c4_invoice._page_sales_invoice')];
        $data['breadcrumb'][] = ['title' => lang('c4_invoice._chart_' . $chartSlug), 'class' => 'active'];

        $this->_render('chart/' . $chartSlug, $data);
    }
    //--------------------------------------------------------------------------

    /**
    * get chart data by chartSlug
    * @param string $chartSlug
    * @return json
    */
    public function readChartData($chartSlug, $series = null) 
    {
        $chartList = ['sales_invoice_daily_statistic', 'purchase']; 

        if(!in_array($chartSlug, $chartList))
        {
            return $this->failNotFound("$chartSlug not founded");
        }
        $langList = [];

        if($chartSlug === 'sales_invoice_daily_statistic')
        {
            $sql = "DATE_FORMAT(issue_date, '%Y-%m-%d') as CATEGORY, ROUND( SUM(CASE WHEN c4_invoice.invoice_type = 'sales_invoice' THEN  c4_invoice.gross_total ELSE 0 END), 2) AS series_205";
            $model = new C4_invoiceModel();
            $model->select($sql, FALSE);
            $model->groupBy("CATEGORY");
            $model->orderBy('CATEGORY', 'ASC');

            if (!empty($startDate = $this->request->getGet('startDate', FILTER_SANITIZE_STRING))) 
            {
                $model->where('issue_date >=', $startDate . ' 00:00:00');
            }
            if (!empty($endDate = $this->request->getGet('endDate', FILTER_SANITIZE_STRING))) 
            {
                $endDate = filter_var($endDate, FILTER_SANITIZE_STRING);
                $model->where('issue_date <=', $endDate . ' 23:59:59');
            }

            //Sql Where
            $model->where("invoice_type='sales_invoice'");
            $query_result = $model->findAll();

        }
        elseif($chartSlug === 'purchase')
        {
            $sql = "DATE_FORMAT(created_at, '%Y-%m-%d') as CATEGORY, ( COUNT(c4_invoice.c4_invoice_id) ) AS series_206";
            $model = new C4_invoiceModel();
            $model->select($sql, FALSE);
            $model->groupBy("CATEGORY");
            $model->orderBy('CATEGORY', 'ASC');

            if (!empty($startDate = $this->request->getGet('startDate', FILTER_SANITIZE_STRING))) 
            {
                $model->where('created_at >=', $startDate . ' 00:00:00');
            }
            if (!empty($endDate = $this->request->getGet('endDate', FILTER_SANITIZE_STRING))) 
            {
                $endDate = filter_var($endDate, FILTER_SANITIZE_STRING);
                $model->where('created_at <=', $endDate . ' 23:59:59');
            }

            //Sql Where
            $model->where("invoice_type='purchase_bill'");
            $query_result = $model->findAll();

        }

        if (!empty($query_result)) 
        {
            $total = [];
            //Calculate Total
            foreach ($query_result as $key => $data) 
            {
                foreach ($data as $data_key => $data_value) 
                {
                    if ($data_key !== 'CATEGORY' && is_numeric($data_value)) 
                    {
                        if(isset($total[$data_key. '_total']))
                        {
                             $total[$data_key. '_total'] += $data_value;
                        }
                        else
                        {
                           $total[$data_key. '_total'] = $data_value; 
                        }
                    }
                }
            }

            //Calculate Percentage for each series
            foreach ($query_result as $key => $data) 
            {
                $query_result[$key] = array_merge((array)$query_result[$key], $total);

                foreach ($data as $data_key => $data_value) 
                {
                    if ($data_key !== 'CATEGORY')
                    {
                        if(is_numeric($data_value) && intval($data_value) != 0)
                        {
                            $seriesTotal = $total[$data_key. '_total'];
                            $percentage =  ($data_value * 100) / $seriesTotal;
                            $query_result[$key][$data_key. '_percentage'] =  $percentage;
                            $query_result[$key][$data_key. '_percentage_over'] = 100 - $percentage;
                        }
                        else
                        {
                            $query_result[$key][$data_key. '_percentage'] =  0;
                            $query_result[$key][$data_key. '_percentage_over'] = 0;
                        }
                    }
                }
            }
        }
    
        return $this->response->setJSON($query_result);
    }

   //--------------------------------------------------------------------
    /**
     * Read statistic Card Data
     * 
     * @param string $cardSlug
     * @return json
     */
    public function readStatistic($pageSlug, $cardSlug)
    {
        $cardData = [];

        //Page: sales_invoice
        if($pageSlug === 'sales_invoice' && $cardSlug === 'Sales-Total-Remaining')
        {
            $C4_invoiceModel = new C4_invoiceModel();
            $C4_invoiceModel->select('IFNULL(SUM(remaining), 0) as SUM_remaining');
            $C4_invoiceModel->where("deleted_at IS NULL");
            $C4_invoiceModel->where("invoice_type='sales_invoice'");

            $cardData = $C4_invoiceModel->get()->getRowArray();
        }

        //Page: sales_invoice
        elseif($pageSlug === 'sales_invoice' && $cardSlug === 'Sales-Invoice-Gross-Total')
        {
            $C4_invoiceModel = new C4_invoiceModel();    
            $C4_invoiceModel->select("c4_invoice.invoice_status as CATEGORY, ROUND( SUM(c4_invoice.gross_total), 2) AS SUM_gross_total, ", FALSE);
            $C4_invoiceModel->groupBy("CATEGORY");
            $C4_invoiceModel->orderBy('CATEGORY', 'ASC');
            $C4_invoiceModel->where("deleted_at IS NULL");
            $C4_invoiceModel->where("invoice_type='sales_invoice'");


            $cardData = $C4_invoiceModel->get()->getResultArray();
            // Get Language values of invoice_status 
            if (!empty($cardData))
            {
                $langlist_invoice_status = lang('c4_invoice.list_invoice_status');

                foreach ($cardData as $key => $value)
                {
                    $category = $value['CATEGORY'];

                    $cardData[$key]['CATEGORY'] = $langlist_invoice_status[$category] ?? $category;
                }
            }

        }
        //Page: sales_invoice
        elseif($pageSlug === 'sales_invoice' && $cardSlug === 'Past-Due-Sales-Remaining')
        {
            $C4_invoiceModel = new C4_invoiceModel();
            $C4_invoiceModel->select('IFNULL(SUM(remaining), 0) as SUM_remaining');
            $C4_invoiceModel->where("deleted_at IS NULL");
            $C4_invoiceModel->where("due_date <= cast(now() as date) AND invoice_type='sales_invoice'");

            $cardData = $C4_invoiceModel->get()->getRowArray();
        }

        //Page: sales_invoice
        elseif($pageSlug === 'sales_invoice' && $cardSlug === 'Invoice-types')
        {
            $C4_invoiceModel = new C4_invoiceModel();    
            $C4_invoiceModel->select("c4_invoice.invoice_type as CATEGORY, ROUND( SUM(c4_invoice.gross_total), 2) AS SUM_gross_total, ", FALSE);
            $C4_invoiceModel->groupBy("CATEGORY");
            $C4_invoiceModel->orderBy('CATEGORY', 'ASC');
            $C4_invoiceModel->where("deleted_at IS NULL");


            $cardData = $C4_invoiceModel->get()->getResultArray();
            // Get Language values of invoice_type 
            if (!empty($cardData))
            {
                $langlist_invoice_type = lang('c4_invoice.list_invoice_type');

                foreach ($cardData as $key => $value)
                {
                    $category = $value['CATEGORY'];

                    $cardData[$key]['CATEGORY'] = $langlist_invoice_type[$category] ?? $category;
                }
            }

        }
        return $this->response->setJSON($cardData);
    }
 
    //--------------------------------------------------------------------

    /**
     * Return module lang used in JS file.
     */
    public function langJS()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => 'b74bc1a']);

        $conf   = new \Config\App();
        $locale = $this->request->getLocale();

        //Load Home Lang File
        $langFile = ROOTPATH . 'financepanel/Language/' . $locale . '/c4_invoice.php';

        if (!file_exists($langFile))
        {
            //Check default lang file
            $langFile = ROOTPATH . 'financepanel/Language/' . $conf->defaultLocale . '/c4_invoice.php';

            if (!file_exists($langFile))
            {
                $langFile = null;
            }
        }

        $langArray['panel_language'] = $locale;
        $langArray['panel_url'] = financepanel_url(null, $locale); 

        if (!empty($langFile))
        {
            $langArray += require $langFile; // Current local language
        }
        else
        {
            log_message('alert',  "There is no $locale  lang file");
            $langArray['error'] = "There is no $locale  lang file";
        }

        $this->response->setContentType('application/x-javascript');
        echo 'var LANG_c4_invoice = ' . json_encode($langArray, JSON_PRETTY_PRINT);
    }

    //--------------------------------------------------------------------

    private function _render($page, $data = [])
    {
        helper('form');

        $data['table_name']  = 'c4_invoice';

        if ($this->request->isAJAX())
        {
            try
            {
                echo financepanel_view('c4_invoice/' . $page, $data);
            }
            catch (\Exception $e)
            {
                log_message('alert', '[ERROR] {exception}', ['exception' => $e]);
                return $this->fail($e->getMessage(), 400, $e->getMessage());
            }
        }
        else
        {
            try
            {
                echo financepanel_view('themes/' . $this->theme . '/header', $data);
                echo financepanel_view('c4_invoice/' . $page, $data);
                echo financepanel_view('themes/' . $this->theme . '/footer', $data);
            }
            catch (\Exception $e)
            {
                log_message('alert', '[ERROR] {exception}', ['exception' => $e]);
                throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
            }
        }
    }

    //--------------------------------------------------------------------

}