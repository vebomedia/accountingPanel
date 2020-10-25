<?php

namespace Financepanel\Controllers;

use CodeIgniter\API\ResponseTrait;
use Financepanel\Models\C4_transaction_history_itemModel;
use Financepanel\Models\C4_transactionModel;

class C4_transaction_history_item extends BaseController
{

    use ResponseTrait;

    //--------------------------------------------------------------------

    public function __construct()
    {
        helper(['Financepanel\c4_transaction_history_item', 'Financepanel\c4_transaction']);
    }

    //--------------------------------------------------------------------
    /**
     * view default page = c4_transaction_history_item 
     * c4_transaction_history_item   
     */
    public function index()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '819f888']);

        $data                 = ['page_title' => lang('c4_transaction_history_item._page_c4_transaction_history_item')];
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('c4_transaction_history_item._page_c4_transaction_history_item'), 'class' => 'active'];

        $this->_render('c4_transaction_history_item', $data);
    }
    //--------------------------------------------------------------------
    /**
     * view page = c4_transaction_history_item
     * Transaction History  
     */
    public function c4_transaction_history_item()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '804a0c0']);

        $data                 = ['page_title' => lang('c4_transaction_history_item._page_c4_transaction_history_item')];
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('c4_transaction_history_item._page_c4_transaction_history_item'), 'class' => 'active'];

        $this->_render('c4_transaction_history_item', $data);
    }

    //--------------------------------------------------------------------
    /**
     * create or update
     * @return json
     */
    public function save($form_slug, $c4_transaction_history_item_id = '')
    {
        $data       = $this->request->getPost();
        $validation = \Config\Services::validation();

        //---------------------------------------------------------------------//
        //For form_slug=c4_transaction_history_item pageSlug=c4_transaction_history_item
        if($form_slug === 'c4_transaction_history_item')
        {

            //----------------------------------------------------------------//
            /**
            * eur_balance FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['eur_balance'] = filter_var($data['eur_balance'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * gbp_balance FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['gbp_balance'] = filter_var($data['gbp_balance'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * try_balance FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['try_balance'] = filter_var($data['try_balance'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * usd_balance FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['usd_balance'] = filter_var($data['usd_balance'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            // c4_transaction_history_item form Validations and security
            $validation->setRules([
                'c4_transaction_id' => ['label' => lang('c4_transaction_history_item.c4_transaction_id'), 'rules'=>"required|integer|max_length[20]"],
                'eur_balance'   => ['label' => lang('c4_transaction_history_item.eur_balance'), 'rules'=>"required|decimal|max_length[15]"],
                'gbp_balance'   => ['label' => lang('c4_transaction_history_item.gbp_balance'), 'rules'=>"required|decimal|max_length[15]"],
                'try_balance'   => ['label' => lang('c4_transaction_history_item.try_balance'), 'rules'=>"required|decimal|max_length[15]"],
                'usd_balance'   => ['label' => lang('c4_transaction_history_item.usd_balance'), 'rules'=>"required|decimal|max_length[15]"],
            ]);
            if ($validation->run($data) === false)
            {
                return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
            }
            //----------------------------------------------------------------//
            // clear undefined post fields for security..
            //----------------------------------------------------------------//
            $filterFormFields = ['c4_transaction_id', 'eur_balance', 'gbp_balance', 'try_balance', 'usd_balance', 'c4_transaction_history_item_id'];
            $data             = array_intersect_key($data, array_flip($filterFormFields));
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * Check c4_transaction_id for security
            */        
            //----------------------------------------------------------------//
            if (empty($this->request->getPost('new_c4_transaction_id'))  && empty(getC4_transaction($data['c4_transaction_id'])))
            {
                log_message('error', 'SECURITY: Undefined c4_transaction_id value posted');
                return $this->fail(['c4_transaction_id'=>'You Can not set this value'], 400, lang('home.error_validation_form')); 
            }
            //----------------------------------------------------------------//

        }
        //---------------------------------------------------------------------//
        else
        {
            //not matched
            log_message('error', "SECURITY: $form_slug form not founded");
            return $this->failNotFound("$form_slug form not found");
        }

        $C4_transaction_history_itemModel = new C4_transaction_history_itemModel();

        try
        {
            $C4_transaction_history_itemModel->save($data);
        }
        catch (\Exception $e)
        {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            return $this->fail($e->getMessage(), 400, lang('home.error_validation_form'));
        }
        
        if(empty($c4_transaction_history_item_id))
        {
            $c4_transaction_history_item_id = $C4_transaction_history_itemModel->getInsertID();
        }

        return $this->respondCreated(['id' => $c4_transaction_history_item_id, 'message' => lang('home.saved')]);
    }
 
    //--------------------------------------------------------------------

    /**
     * Read c4_transaction_history_item data
     * Functions adds DT_RowId variable to each row for datatables.net
     * 
     * Search Contions may change according to $pageSlug
     * 
     * @param string $pageSlug
     * @return array
     * 
     */
    public function readC4_transaction_history_item($pageSlug)
    {

        $pageList = ['c4_transaction_history_item'];
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

        $model      = new C4_transaction_history_itemModel();
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
        // Page c4_transaction_history_item
        //--------------------------------------------------------------------//

        if($pageSlug === 'c4_transaction_history_item')
        {
            $select_text       = "c4_transaction_history_item.*, c4_transaction.transaction_type as c4_transaction_RELATIONAL_transaction_type";
            $multipleFields    = [];

            //------------------------------------------------------------------//
            //merge relation fields names to make Sortable
            $table_colons = array_merge($table_colons, ['c4_transaction_RELATIONAL_transaction_type']);
            //------------------------------------------------------------------//
            //------------------------------------------------------------------//        
            // Left Join Text
            //------------------------------------------------------------------//
            $model->join("(SELECT c4_transaction_id, transaction_type FROM c4_transaction GROUP BY c4_transaction_id ORDER BY c4_transaction_id DESC) c4_transaction", 'c4_transaction.c4_transaction_id = c4_transaction_history_item.c4_transaction_id', 'left');

            if (!empty($search_text))
            {
                $search_text = filter_var($search_text, FILTER_SANITIZE_STRING);
                $model->groupStart();
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

                if(!in_array($filterField, $table_colons) || in_array($filterField, ['filterSearch']))
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
                    $model->where("c4_transaction_history_item.$filterField", trim(filter_var($filterValue, FILTER_SANITIZE_STRING)));
                }
            }
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
                    $model->where("c4_transaction_history_item.$key_field >=", $fieldValue);
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
                    $model->where("c4_transaction_history_item.$key_field <=", $fieldValue .' 23:59:59');
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
                // Page c4_transaction_history_item
                //--------------------------------------------------------------------//

                if($pageSlug === 'c4_transaction_history_item')
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
     * Delete c4_transaction_history_item by id
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

        $C4_transaction_history_itemModel = new C4_transaction_history_itemModel();
        if ($C4_transaction_history_itemModel->delete($id, true) === false)
        {
            log_message('error', "Error: $id ID C4_transaction_history_itemModel Delete Error");
            return $this->fail($C4_transaction_history_itemModel->errors());
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

        $data['page_title'] = lang('c4_transaction_history_item._form_' .$formSlug);
        $data['formData'] = $_POST;
        
        // -----------------------------------
        //breadcrumb if form is showed in Page
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];

        if($formSlug === 'c4_transaction_history_item')
        {
            $data['breadcrumb'][] = ['url' => financepanel_url('c4_transaction_history_item/c4_transaction_history_item'), 'title' => lang('c4_transaction_history_item._page_c4_transaction_history_item')];
            $data['breadcrumb'][] = ['title' => lang('c4_transaction_history_item._form_c4_transaction_history_item'), 'class' => 'active'];
        }
        else
        {
            log_message('error', "SECURITY: $formSlug form not founded");
            return $this->failNotFound("$formSlug not founded");
        }

        if (!empty($id))
        {
            $C4_transaction_history_itemModel = new C4_transaction_history_itemModel();
            
            $data['formData'] += $C4_transaction_history_itemModel->find($id) ?? [];
        }

        $copy      = (int) $this->request->getGet('copy');

        if (!empty($copy))
        {
            $C4_transaction_history_itemModel = new C4_transaction_history_itemModel();
            
            $data['formData'] += $C4_transaction_history_itemModel->find($copy);
            
            if(isset($data['formData']['c4_transaction_history_item_id']))
            {
                unset($data['formData']['c4_transaction_history_item_id']);
            }
        }

        

        $this->_render('form/' . $formSlug, $data);
    }

    //--------------------------------------------------------------------

    /**
     * Get C4_transactionModel data
     * @return json
     */
    public function getAllC4_transaction() 
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

        $model = new C4_transactionModel();
        $allowedFields = $model->getAllowedFields();
        
        if(!empty($q))
        {
            $model->groupStart();
            $model->orLike('transaction_type', $q);
            $model->groupEnd();
        }

        $model->orderBy('transaction_type', 'asc');

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
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '4a19f73']);

        $conf   = new \Config\App();
        $locale = $this->request->getLocale();

        //Load Home Lang File
        $langFile = ROOTPATH . 'financepanel/Language/' . $locale . '/c4_transaction_history_item.php';

        if (!file_exists($langFile))
        {
            //Check default lang file
            $langFile = ROOTPATH . 'financepanel/Language/' . $conf->defaultLocale . '/c4_transaction_history_item.php';

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
        echo 'var LANG_c4_transaction_history_item = ' . json_encode($langArray, JSON_PRETTY_PRINT);
    }

    //--------------------------------------------------------------------

    private function _render($page, $data = [])
    {
        helper('form');

        $data['table_name']  = 'c4_transaction_history_item';

        if ($this->request->isAJAX())
        {
            try
            {
                echo financepanel_view('c4_transaction_history_item/' . $page, $data);
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
                echo financepanel_view('c4_transaction_history_item/' . $page, $data);
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