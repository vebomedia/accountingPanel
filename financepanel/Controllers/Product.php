<?php

namespace Financepanel\Controllers;

use CodeIgniter\API\ResponseTrait;
use Financepanel\Models\C4_invoice_itemModel;
use Financepanel\Models\C4_invoiceModel;
use Financepanel\Models\ProductModel;

class Product extends BaseController
{

    use ResponseTrait;

    //--------------------------------------------------------------------

    public function __construct()
    {
        helper(['Financepanel\c4_invoice_item', 'Financepanel\c4_invoice', 'Financepanel\product']);
    }

    //--------------------------------------------------------------------
    /**
     * view default page = product 
     * product   
     */
    public function index()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '1038874']);

        $data                 = ['page_title' => lang('product._page_product')];
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('product._page_product'), 'class' => 'active'];

        $this->_render('product', $data);
    }
    //--------------------------------------------------------------------
    /**
     * view page = product
     * Products  
     */
    public function product()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '51bfd8f']);

        $data                 = ['page_title' => lang('product._page_product')];
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('product._page_product'), 'class' => 'active'];

        $this->_render('product', $data);
    }

    //--------------------------------------------------------------------
    /**
     * create or update
     * @return json
     */
    public function save($form_slug, $product_id = '')
    {
        $data       = $this->request->getPost();
        $validation = \Config\Services::validation();

        //---------------------------------------------------------------------//
        //For form_slug=product pageSlug=product
        if($form_slug === 'product')
        {

            //----------------------------------------------------------------//
            /**
            * inventory_tracking FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['inventory_tracking'] = filter_var($data['inventory_tracking'] ?? null, FILTER_CALLBACK, array("options"=>"intval")); 
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * initial_stock_count FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['initial_stock_count'] = filter_var($data['initial_stock_count'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * critical_stock_alert FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['critical_stock_alert'] = filter_var($data['critical_stock_alert'] ?? null, FILTER_CALLBACK, array("options"=>"intval")); 
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * critical_stock_count FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['critical_stock_count'] = filter_var($data['critical_stock_count'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * buying_price FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['buying_price'] = filter_var($data['buying_price'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * list_price FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['list_price'] = filter_var($data['list_price'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * communications_tax FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['communications_tax'] = filter_var($data['communications_tax'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * purchase_excise_duty FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['purchase_excise_duty'] = filter_var($data['purchase_excise_duty'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * sales_excise_duty FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['sales_excise_duty'] = filter_var($data['sales_excise_duty'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            // product form Validations and security
            $validation->setRules([
                'name'          => ['label' => lang('product.name'), 'rules'=>"required|alpha_numeric_space_turkish|max_length[255]"],
                'photo'         => ['label' => lang('product.photo'), 'rules'=>"permit_empty|max_length[255]"],
                'code'          => ['label' => lang('product.code'), 'rules'=>"permit_empty|alpha_numeric|max_length[255]"],
                'barcode'       => ['label' => lang('product.barcode'), 'rules'=>"permit_empty|alpha_numeric|max_length[255]"],
                'inventory_tracking' => ['label' => lang('product.inventory_tracking'), 'rules'=>"permit_empty|integer|max_length[1]|in_list[1,0]"],
                'initial_stock_count' => ['label' => lang('product.initial_stock_count'), 'rules'=>"permit_empty|decimal"],
                'critical_stock_alert' => ['label' => lang('product.critical_stock_alert'), 'rules'=>"permit_empty|integer|max_length[1]|in_list[0,1]"],
                'critical_stock_count' => ['label' => lang('product.critical_stock_count'), 'rules'=>"permit_empty|decimal|max_length[15]"],
                'buying_price'  => ['label' => lang('product.buying_price'), 'rules'=>"permit_empty|decimal|max_length[15]"],
                'list_price'    => ['label' => lang('product.list_price'), 'rules'=>"permit_empty|decimal|max_length[15]"],
                'vat_rate'      => ['label' => lang('product.vat_rate'), 'rules'=>"permit_empty|decimal|max_length[15]|in_list[18.0000,8.0000,1.0000,0.0000]"],
                'communications_tax' => ['label' => lang('product.communications_tax'), 'rules'=>"permit_empty|decimal|max_length[15]"],
                'purchase_excise_duty' => ['label' => lang('product.purchase_excise_duty'), 'rules'=>"permit_empty|decimal|max_length[15]"],
                'sales_excise_duty' => ['label' => lang('product.sales_excise_duty'), 'rules'=>"permit_empty|decimal|max_length[15]"],
            ]);
            if ($validation->run($data) === false)
            {
                return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
            }
            //----------------------------------------------------------------//
            // clear undefined post fields for security..
            //----------------------------------------------------------------//
            $filterFormFields = ['name', 'photo', 'code', 'barcode', 'inventory_tracking', 'initial_stock_count', 'critical_stock_alert', 'critical_stock_count', 'buying_price', 'list_price', 'vat_rate', 'communications_tax', 'purchase_excise_duty', 'sales_excise_duty', 'buying_currency', 'currency', 'communications_tax_type', 'purchase_excise_duty_type', 'sales_excise_duty_type', 'product_id'];
            $data             = array_intersect_key($data, array_flip($filterFormFields));
            //----------------------------------------------------------------//

        }
        //---------------------------------------------------------------------//
        else
        {
            //not matched
            log_message('error', "SECURITY: $form_slug form not founded");
            return $this->failNotFound("$form_slug form not found");
        }

        $ProductModel = new ProductModel();

        try
        {
            $ProductModel->save($data);
        }
        catch (\Exception $e)
        {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            return $this->fail($e->getMessage(), 400, lang('home.error_validation_form'));
        }
        
        if(empty($product_id))
        {
            $product_id = $ProductModel->getInsertID();
        }

        return $this->respondCreated(['id' => $product_id, 'message' => lang('home.saved')]);
    }
 
    //--------------------------------------------------------------------

    /**
     * Read product data
     * Functions adds DT_RowId variable to each row for datatables.net
     * 
     * Search Contions may change according to $pageSlug
     * 
     * @param string $pageSlug
     * @return array
     * 
     */
    public function readProduct($pageSlug)
    {

        $pageList = ['product'];
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

        $model      = new ProductModel();
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
        // Page product
        //--------------------------------------------------------------------//

        if($pageSlug === 'product')
        {
            $select_text       = "product.*";
            $multipleFields    = [];

            if (!empty($search_text))
            {
                $search_text = filter_var($search_text, FILTER_SANITIZE_STRING);
                $model->groupStart();
                $model->orLike('product.name', $search_text);
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
                    $model->where("product.$filterField", trim(filter_var($filterValue, FILTER_SANITIZE_STRING)));
                }
            }
        }
        //Show Allways active status if not filtered
        if (!isset($filterArray['status']))
        {
            $model->where('product.status', '1');
        }
        else
        {
            $model->where('product.status', $filterArray['status']);
        }
        if (isset($filterArray['deleted_at']) && $filterArray['deleted_at'] === '1')
        {
            $model->onlyDeleted();
        }
        else
        {
            $model->where('product.deleted_at', NULL);
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
                    $model->where("product.$key_field >=", $fieldValue);
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
                    $model->where("product.$key_field <=", $fieldValue .' 23:59:59');
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
                // Page product
                //--------------------------------------------------------------------//

                if($pageSlug === 'product')
                { 

                    //------------------------------------------------------------------//
                    // Get File Data From FileID
                    // Limit 1
                    //------------------------------------------------------------------//
                    $fileService = \Financepanel\Config\Services::file();

                    if(!empty($value->photo) && !empty($getFiles = $fileService->getAllFile($value->photo, 1, 'sort_order')))
                    {
                        $db_result[$key]->photo_c4_url_icon = $getFiles[0]['url_icon'];
                        $db_result[$key]->photo_c4_url_thumb = $getFiles[0]['url_thumb'];
                        $db_result[$key]->photo_c4_url_download = $getFiles[0]['url_download'];
                        $db_result[$key]->photo_c4_other = $getFiles;
                    }
                    else
                    {
                        $db_result[$key]->photo = '';
                        $db_result[$key]->photo_fileInfo = []; 
                    }
                    //------------------------------------------------------------------//

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

        $pageList = ['read_product_TO_c4_invoice_item'];
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
        // Page read_product_TO_c4_invoice_item
        //--------------------------------------------------------------------//

        if($pageSlug === 'read_product_TO_c4_invoice_item')
        {
            $select_text       = "c4_invoice_item.*, c4_invoice.description as c4_invoice_RELATIONAL_description";
            $multipleFields    = [];

            //------------------------------------------------------------------//
            //merge relation fields names to make Sortable
            $table_colons = array_merge($table_colons, ['c4_invoice_RELATIONAL_description']);
            //------------------------------------------------------------------//
            //------------------------------------------------------------------//        
            // Left Join Text
            //------------------------------------------------------------------//
            $model->join("(SELECT c4_invoice_id, description FROM c4_invoice WHERE c4_invoice.deleted_at IS NULL GROUP BY c4_invoice_id ORDER BY c4_invoice_id DESC) c4_invoice", 'c4_invoice.c4_invoice_id = c4_invoice_item.c4_invoice_id', 'left');

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
                // Page read_product_TO_c4_invoice_item
                //--------------------------------------------------------------------//

                if($pageSlug === 'read_product_TO_c4_invoice_item')
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
     * Delete product by id
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

        $ProductModel = new ProductModel();
        if ($ProductModel->delete($id, false) === false)
        {
            log_message('error', "Error: $id ID ProductModel Delete Error");
            return $this->fail($ProductModel->errors());
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

        $data['page_title'] = lang('product._form_' .$formSlug);
        $data['formData'] = $_POST;
        
        // -----------------------------------
        //breadcrumb if form is showed in Page
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];

        if($formSlug === 'product')
        {
            $data['breadcrumb'][] = ['url' => financepanel_url('product/product'), 'title' => lang('product._page_product')];
            $data['breadcrumb'][] = ['title' => lang('product._form_product'), 'class' => 'active'];
        }
        else
        {
            log_message('error', "SECURITY: $formSlug form not founded");
            return $this->failNotFound("$formSlug not founded");
        }

        if (!empty($id))
        {
            $ProductModel = new ProductModel();
            
            $data['formData'] += $ProductModel->find($id) ?? [];
        }

        $copy      = (int) $this->request->getGet('copy');

        if (!empty($copy))
        {
            $ProductModel = new ProductModel();
            
            $data['formData'] += $ProductModel->find($copy);
            
            if(isset($data['formData']['product_id']))
            {
                unset($data['formData']['product_id']);
            }
        }

        

        $this->_render('form/' . $formSlug, $data);
    }

    //--------------------------------------------------------------------

    public function uploadFile($formSlug, $fieldName)
    {
        $formList = ['product'];

        if (!in_array($formSlug, $formList))
        {
            return $this->failNotFound("$formSlug not founded");
        }
            
        $fileService = \Financepanel\Config\Services::file();

        if($fieldName === 'photo')
        {
            if (!$this->validate(['file' => ['label' => lang('product.photo'), 'rules' => 'uploaded[file]|is_image[file]|max_size[file,1024]|ext_in[file,gif,jpg,jpeg,png]|max_dims[file,600,600]']]))
            {
                return $this->fail($this->validator->getErrors(), 400);
            }
            
            $return = $fileService->upload("product/$fieldName", true);
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
     * Update single field of product 
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
        $batchList = ['buying_currency', 'currency', 'communications_tax_type', 'purchase_excise_duty_type', 'sales_excise_duty_type', 'status', 'deleted_at'];

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

        $model = new ProductModel();
        

        //validation
        if(isset($data['buying_currency']))
        {
            if (!$this->validate([
                'buying_currency' => ['label' => lang('product.buying_currency'), 'rules' => 'permit_empty|alpha_numeric_space|max_length[255]|in_list[TRY,USD,EUR,GBP]'],
            ]))
            {
                return $this->fail($this->validator->getErrors(), 400, lang('home.error_invalid_id'));
            }
        }
        if(isset($data['currency']))
        {
            if (!$this->validate([
                'currency' => ['label' => lang('product.currency'), 'rules' => 'permit_empty|alpha_numeric_space|max_length[255]|in_list[TRY,USD,EUR,GBP]'],
            ]))
            {
                return $this->fail($this->validator->getErrors(), 400, lang('home.error_invalid_id'));
            }
        }
        if(isset($data['communications_tax_type']))
        {
            if (!$this->validate([
                'communications_tax_type' => ['label' => lang('product.communications_tax_type'), 'rules' => 'required|in_list[percentage,amount]|alpha_dash'],
            ]))
            {
                return $this->fail($this->validator->getErrors(), 400, lang('home.error_invalid_id'));
            }
        }
        if(isset($data['purchase_excise_duty_type']))
        {
            if (!$this->validate([
                'purchase_excise_duty_type' => ['label' => lang('product.purchase_excise_duty_type'), 'rules' => 'permit_empty|in_list[percentage,amount]|alpha_dash'],
            ]))
            {
                return $this->fail($this->validator->getErrors(), 400, lang('home.error_invalid_id'));
            }
        }
        if(isset($data['sales_excise_duty_type']))
        {
            if (!$this->validate([
                'sales_excise_duty_type' => ['label' => lang('product.sales_excise_duty_type'), 'rules' => 'permit_empty|in_list[percentage,amount]|alpha_dash'],
            ]))
            {
                return $this->fail($this->validator->getErrors(), 400, lang('home.error_invalid_id'));
            }
        }
        if(isset($data['status']))
        {
            if (!$this->validate([
                'status' => ['label' => lang('product.status'), 'rules' => 'required|integer|max_length[1]|in_list[1,2]'],
            ]))
            {
                return $this->fail($this->validator->getErrors(), 400, lang('home.error_invalid_id'));
            }
        }
        if(isset($data['deleted_at']))
        {
            if($data['deleted_at'] === '1')
            {
                $model->delete($id, false);
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
     * Read statistic Card Data
     * 
     * @param string $cardSlug
     * @return json
     */
    public function readStatistic($pageSlug, $cardSlug)
    {
        $cardData = [];

        return $this->response->setJSON($cardData);
    }
 
    //--------------------------------------------------------------------

    /**
     * Return module lang used in JS file.
     */
    public function langJS()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '18fe7ad']);

        $conf   = new \Config\App();
        $locale = $this->request->getLocale();

        //Load Home Lang File
        $langFile = ROOTPATH . 'financepanel/Language/' . $locale . '/product.php';

        if (!file_exists($langFile))
        {
            //Check default lang file
            $langFile = ROOTPATH . 'financepanel/Language/' . $conf->defaultLocale . '/product.php';

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
        echo 'var LANG_product = ' . json_encode($langArray, JSON_PRETTY_PRINT);
    }

    //--------------------------------------------------------------------

    private function _render($page, $data = [])
    {
        helper('form');

        $data['table_name']  = 'product';

        if ($this->request->isAJAX())
        {
            try
            {
                echo financepanel_view('product/' . $page, $data);
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
                echo financepanel_view('product/' . $page, $data);
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