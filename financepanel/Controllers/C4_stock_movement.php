<?php

namespace Financepanel\Controllers;

use CodeIgniter\API\ResponseTrait;
use Financepanel\Models\C4_stock_movementModel;
use Financepanel\Models\C4_shipment_documentModel;
use Financepanel\Models\ProductModel;

class C4_stock_movement extends BaseController
{

    use ResponseTrait;

    //--------------------------------------------------------------------

    public function __construct()
    {
        helper(['Financepanel\c4_stock_movement', 'Financepanel\c4_shipment_document', 'Financepanel\product']);
    }

    //--------------------------------------------------------------------
    /**
     * view default page = inflow_stock_movement 
     * inflow_stock_movement   
     */
    public function index()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '555159f']);

        $data                 = ['page_title' => lang('c4_stock_movement._page_inflow_stock_movement')];
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('c4_stock_movement._page_inflow_stock_movement'), 'class' => 'active'];

        $this->_render('inflow_stock_movement', $data);
    }
    //--------------------------------------------------------------------
    /**
     * view page = inflow_stock_movement
     * Inflow Stock Movement  
     */
    public function inflow_stock_movement()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '41ac20f']);

        $data                 = ['page_title' => lang('c4_stock_movement._page_inflow_stock_movement')];
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('c4_stock_movement._page_inflow_stock_movement'), 'class' => 'active'];

        $this->_render('inflow_stock_movement', $data);
    }
    //--------------------------------------------------------------------
    /**
     * view page = outflow_stock_movement
     * Outflow Stock Movement  
     */
    public function outflow_stock_movement()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '6dd53e5']);

        $data                 = ['page_title' => lang('c4_stock_movement._page_outflow_stock_movement')];
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('c4_stock_movement._page_outflow_stock_movement'), 'class' => 'active'];

        $this->_render('outflow_stock_movement', $data);
    }

    //--------------------------------------------------------------------
    /**
     * create or update
     * @return json
     */
    public function save($form_slug, $c4_stock_movement_id = '')
    {
        $data       = $this->request->getPost();
        $validation = \Config\Services::validation();

        //---------------------------------------------------------------------//
        //For form_slug=stock_movement86369026 pageSlug=inflow_stock_movement
        if($form_slug === 'stock_movement86369026')
        {

            //----------------------------------------------------------------//
            /**
            * quantity FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['quantity'] = filter_var($data['quantity'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            // stock_movement86369026 form Validations and security
            $validation->setRules([
                'c4_shipment_document_id' => ['label' => lang('c4_stock_movement.c4_shipment_document_id'), 'rules'=>"required|integer|max_length[20]"],
                'product_id'    => ['label' => lang('c4_stock_movement.product_id'), 'rules'=>"required|integer|max_length[20]"],
                'date'          => ['label' => lang('c4_stock_movement.date'), 'rules'=>"required|valid_date"],
                'inflow'        => ['label' => lang('c4_stock_movement.inflow'), 'rules'=>"required|integer|max_length[1]|in_list[1,0]"],
                'quantity'      => ['label' => lang('c4_stock_movement.quantity'), 'rules'=>"required|decimal|max_length[15]"],
            ]);
            if ($validation->run($data) === false)
            {
                return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
            }
            //----------------------------------------------------------------//
            // clear undefined post fields for security..
            //----------------------------------------------------------------//
            $filterFormFields = ['c4_shipment_document_id', 'product_id', 'date', 'inflow', 'quantity', 'c4_stock_movement_id'];
            $data             = array_intersect_key($data, array_flip($filterFormFields));
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * Check c4_shipment_document_id for security
            */        
            //----------------------------------------------------------------//
            if (empty($this->request->getPost('new_c4_shipment_document_id'))  && empty(getC4_shipment_document($data['c4_shipment_document_id'])))
            {
                log_message('error', 'SECURITY: Undefined c4_shipment_document_id value posted');
                return $this->fail(['c4_shipment_document_id'=>'You Can not set this value'], 400, lang('home.error_validation_form')); 
            }
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * Check product_id for security
            */        
            //----------------------------------------------------------------//
            if (empty($this->request->getPost('new_product_id'))  && empty(getProduct($data['product_id'])))
            {
                log_message('error', 'SECURITY: Undefined product_id value posted');
                return $this->fail(['product_id'=>'You Can not set this value'], 400, lang('home.error_validation_form')); 
            }
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            //Form Condtions to Data
            //----------------------------------------------------------------//
            $data['inflow'] = '1';

        }
        //---------------------------------------------------------------------//
        //For form_slug=outflow_stock_movement pageSlug=outflow_stock_movement
        elseif($form_slug === 'outflow_stock_movement')
        {

            //----------------------------------------------------------------//
            /**
            * quantity FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['quantity'] = filter_var($data['quantity'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            // outflow_stock_movement form Validations and security
            $validation->setRules([
                'c4_shipment_document_id' => ['label' => lang('c4_stock_movement.c4_shipment_document_id'), 'rules'=>"required|integer|max_length[20]"],
                'product_id'    => ['label' => lang('c4_stock_movement.product_id'), 'rules'=>"required|integer|max_length[20]"],
                'date'          => ['label' => lang('c4_stock_movement.date'), 'rules'=>"required|valid_date"],
                'inflow'        => ['label' => lang('c4_stock_movement.inflow'), 'rules'=>"required|integer|max_length[1]|in_list[1,0]"],
                'quantity'      => ['label' => lang('c4_stock_movement.quantity'), 'rules'=>"required|decimal|max_length[15]"],
            ]);
            if ($validation->run($data) === false)
            {
                return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
            }
            //----------------------------------------------------------------//
            // clear undefined post fields for security..
            //----------------------------------------------------------------//
            $filterFormFields = ['c4_shipment_document_id', 'product_id', 'date', 'inflow', 'quantity', 'c4_stock_movement_id'];
            $data             = array_intersect_key($data, array_flip($filterFormFields));
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * Check c4_shipment_document_id for security
            */        
            //----------------------------------------------------------------//
            if (empty($this->request->getPost('new_c4_shipment_document_id'))  && empty(getC4_shipment_document($data['c4_shipment_document_id'])))
            {
                log_message('error', 'SECURITY: Undefined c4_shipment_document_id value posted');
                return $this->fail(['c4_shipment_document_id'=>'You Can not set this value'], 400, lang('home.error_validation_form')); 
            }
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * Check product_id for security
            */        
            //----------------------------------------------------------------//
            if (empty($this->request->getPost('new_product_id'))  && empty(getProduct($data['product_id'])))
            {
                log_message('error', 'SECURITY: Undefined product_id value posted');
                return $this->fail(['product_id'=>'You Can not set this value'], 400, lang('home.error_validation_form')); 
            }
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            //Form Condtions to Data
            //----------------------------------------------------------------//
            $data['inflow'] = '0';

        }
        //---------------------------------------------------------------------//
        else
        {
            //not matched
            log_message('error', "SECURITY: $form_slug form not founded");
            return $this->failNotFound("$form_slug form not found");
        }

        $C4_stock_movementModel = new C4_stock_movementModel();

        try
        {
            $C4_stock_movementModel->save($data);
        }
        catch (\Exception $e)
        {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            return $this->fail($e->getMessage(), 400, lang('home.error_validation_form'));
        }
        
        if(empty($c4_stock_movement_id))
        {
            $c4_stock_movement_id = $C4_stock_movementModel->getInsertID();
        }

        return $this->respondCreated(['id' => $c4_stock_movement_id, 'message' => lang('home.saved')]);
    }
 
    //--------------------------------------------------------------------

    /**
     * Read c4_stock_movement data
     * Functions adds DT_RowId variable to each row for datatables.net
     * 
     * Search Contions may change according to $pageSlug
     * 
     * @param string $pageSlug
     * @return array
     * 
     */
    public function readC4_stock_movement($pageSlug)
    {

        $pageList = ['inflow_stock_movement', 'outflow_stock_movement'];
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

        $model      = new C4_stock_movementModel();
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
        // Page inflow_stock_movement
        //--------------------------------------------------------------------//

        if($pageSlug === 'inflow_stock_movement')
        {
            $select_text       = "c4_stock_movement.*, c4_shipment_document.description as c4_shipment_document_RELATIONAL_description, product.name as product_RELATIONAL_name";
            $multipleFields    = [];

            //------------------------------------------------------------------//
            //merge relation fields names to make Sortable
            $table_colons = array_merge($table_colons, ['c4_shipment_document_RELATIONAL_description', 'product_RELATIONAL_name']);
            //------------------------------------------------------------------//
            //------------------------------------------------------------------//        
            // Left Join Text
            //------------------------------------------------------------------//
            $model->join("(SELECT c4_shipment_document_id, description FROM c4_shipment_document WHERE c4_shipment_document.deleted_at IS NULL GROUP BY c4_shipment_document_id ORDER BY c4_shipment_document_id DESC) c4_shipment_document", 'c4_shipment_document.c4_shipment_document_id = c4_stock_movement.c4_shipment_document_id', 'left');
            $model->join("(SELECT product_id, name FROM product WHERE product.deleted_at IS NULL AND product.status = '1' GROUP BY product_id ORDER BY product_id DESC) product", 'product.product_id = c4_stock_movement.product_id', 'left');

            //------------------------------------------------------------------//        
            // Conditions
            //------------------------------------------------------------------//

            $model->where('c4_stock_movement.inflow', '1');

            //------------------------------------------------------------------//  

            if (!empty($search_text))
            {
                $search_text = filter_var($search_text, FILTER_SANITIZE_STRING);
                $model->groupStart();
                $model->groupEnd();
            }

            $model->where("inflow=1");

        }
        //----------------------------oo----------------------------------//


        //--------------------------------------------------------------------//
        // Page outflow_stock_movement
        //--------------------------------------------------------------------//

        elseif($pageSlug === 'outflow_stock_movement')
        {
            $select_text       = "c4_stock_movement.*, c4_shipment_document.description as c4_shipment_document_RELATIONAL_description, product.name as product_RELATIONAL_name";
            $multipleFields    = [];

            //------------------------------------------------------------------//
            //merge relation fields names to make Sortable
            $table_colons = array_merge($table_colons, ['c4_shipment_document_RELATIONAL_description', 'product_RELATIONAL_name']);
            //------------------------------------------------------------------//
            //------------------------------------------------------------------//        
            // Left Join Text
            //------------------------------------------------------------------//
            $model->join("(SELECT c4_shipment_document_id, description FROM c4_shipment_document WHERE c4_shipment_document.deleted_at IS NULL GROUP BY c4_shipment_document_id ORDER BY c4_shipment_document_id DESC) c4_shipment_document", 'c4_shipment_document.c4_shipment_document_id = c4_stock_movement.c4_shipment_document_id', 'left');
            $model->join("(SELECT product_id, name FROM product WHERE product.deleted_at IS NULL AND product.status = '1' GROUP BY product_id ORDER BY product_id DESC) product", 'product.product_id = c4_stock_movement.product_id', 'left');

            if (!empty($search_text))
            {
                $search_text = filter_var($search_text, FILTER_SANITIZE_STRING);
                $model->groupStart();
                $model->groupEnd();
            }

            $model->where("inflow=0");

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
                    $model->where("c4_stock_movement.$filterField", trim(filter_var($filterValue, FILTER_SANITIZE_STRING)));
                }
            }
        }
        if (isset($filterArray['deleted_at']) && $filterArray['deleted_at'] === '1')
        {
            $model->onlyDeleted();
        }
        else
        {
            $model->where('c4_stock_movement.deleted_at', NULL);
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
                    $model->where("c4_stock_movement.$key_field >=", $fieldValue);
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
                    $model->where("c4_stock_movement.$key_field <=", $fieldValue .' 23:59:59');
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
                // Page inflow_stock_movement
                //--------------------------------------------------------------------//

                if($pageSlug === 'inflow_stock_movement')
                { 

                } //endif

                //--------------------------------------------------------------------//
                // Page outflow_stock_movement
                //--------------------------------------------------------------------//

                elseif($pageSlug === 'outflow_stock_movement')
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
     * Delete c4_stock_movement by id
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

        $C4_stock_movementModel = new C4_stock_movementModel();
        if ($C4_stock_movementModel->delete($id, false) === false)
        {
            log_message('error', "Error: $id ID C4_stock_movementModel Delete Error");
            return $this->fail($C4_stock_movementModel->errors());
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

        $data['page_title'] = lang('c4_stock_movement._form_' .$formSlug);
        $data['formData'] = $_POST;
        
        // -----------------------------------
        //breadcrumb if form is showed in Page
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];

        if($formSlug === 'stock_movement86369026')
        {
            $data['breadcrumb'][] = ['url' => financepanel_url('c4_stock_movement/inflow_stock_movement'), 'title' => lang('c4_stock_movement._page_inflow_stock_movement')];
            $data['breadcrumb'][] = ['title' => lang('c4_stock_movement._form_stock_movement86369026'), 'class' => 'active'];
        }
        elseif($formSlug === 'outflow_stock_movement')
        {
            $data['breadcrumb'][] = ['url' => financepanel_url('c4_stock_movement/outflow_stock_movement'), 'title' => lang('c4_stock_movement._page_outflow_stock_movement')];
            $data['breadcrumb'][] = ['title' => lang('c4_stock_movement._form_outflow_stock_movement'), 'class' => 'active'];
        }
        else
        {
            log_message('error', "SECURITY: $formSlug form not founded");
            return $this->failNotFound("$formSlug not founded");
        }

        if (!empty($id))
        {
            $C4_stock_movementModel = new C4_stock_movementModel();
            
            $data['formData'] += $C4_stock_movementModel->find($id) ?? [];
        }

        $copy      = (int) $this->request->getGet('copy');

        if (!empty($copy))
        {
            $C4_stock_movementModel = new C4_stock_movementModel();
            
            $data['formData'] += $C4_stock_movementModel->find($copy);
            
            if(isset($data['formData']['c4_stock_movement_id']))
            {
                unset($data['formData']['c4_stock_movement_id']);
            }
        }

        

        $this->_render('form/' . $formSlug, $data);
    }

    //--------------------------------------------------------------------

    /**
     * Get C4_shipment_documentModel data
     * @return json
     */
    public function getAllC4_shipment_document() 
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

        $model = new C4_shipment_documentModel();
        $allowedFields = $model->getAllowedFields();
        
        if(!empty($q))
        {
            $model->groupStart();
            $model->orLike('description', $q);
            $model->groupEnd();
        }

        $model->where('deleted_at', NULL);

        $model->orderBy('description', 'asc');

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

    /**
     * Get ProductModel data
     * @return json
     */
    public function getAllProduct() 
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

        $model = new ProductModel();
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
    /**
     * Update single field of c4_stock_movement 
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
        $batchList = ['deleted_at'];

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

        $model = new C4_stock_movementModel();
        

        //validation
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
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '7988f31']);

        $conf   = new \Config\App();
        $locale = $this->request->getLocale();

        //Load Home Lang File
        $langFile = ROOTPATH . 'financepanel/Language/' . $locale . '/c4_stock_movement.php';

        if (!file_exists($langFile))
        {
            //Check default lang file
            $langFile = ROOTPATH . 'financepanel/Language/' . $conf->defaultLocale . '/c4_stock_movement.php';

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
        echo 'var LANG_c4_stock_movement = ' . json_encode($langArray, JSON_PRETTY_PRINT);
    }

    //--------------------------------------------------------------------

    private function _render($page, $data = [])
    {
        helper('form');

        $data['table_name']  = 'c4_stock_movement';

        if ($this->request->isAJAX())
        {
            try
            {
                echo financepanel_view('c4_stock_movement/' . $page, $data);
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
                echo financepanel_view('c4_stock_movement/' . $page, $data);
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