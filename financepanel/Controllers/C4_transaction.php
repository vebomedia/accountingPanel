<?php

namespace Financepanel\Controllers;

use CodeIgniter\API\ResponseTrait;
use Financepanel\Models\C4_transactionModel;
use Financepanel\Models\C4_accountModel;
use Financepanel\Models\C4_paymentModel;

class C4_transaction extends BaseController
{

    use ResponseTrait;

    //--------------------------------------------------------------------

    public function __construct()
    {
        helper(['Financepanel\c4_transaction', 'Financepanel\c4_account', 'Financepanel\c4_payment']);
    }

    //--------------------------------------------------------------------
    /**
     * view default page = c4_transaction 
     * c4_transaction   
     */
    public function index()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '82aa5e1']);

        $data                 = ['page_title' => lang('c4_transaction._page_c4_transaction')];
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('c4_transaction._page_c4_transaction'), 'class' => 'active'];

        $this->_render('c4_transaction', $data);
    }
    //--------------------------------------------------------------------
    /**
     * view page = c4_transaction
     * Transaction  
     */
    public function c4_transaction()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '1a7cf6d']);

        $data                 = ['page_title' => lang('c4_transaction._page_c4_transaction')];
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('c4_transaction._page_c4_transaction'), 'class' => 'active'];

        $this->_render('c4_transaction', $data);
    }

    //--------------------------------------------------------------------
    /**
     * create or update
     * @return json
     */
    public function save($form_slug, $c4_transaction_id = '')
    {
        $data       = $this->request->getPost();
        $validation = \Config\Services::validation();

        //---------------------------------------------------------------------//
        //For form_slug=money_in pageSlug=c4_transaction
        if($form_slug === 'money_in')
        {

            //----------------------------------------------------------------//
            /**
            * debit_amount FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['debit_amount'] = filter_var($data['debit_amount'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            // money_in form Validations and security
            $validation->setRules([
                'c4_account_id' => ['label' => lang('c4_transaction.c4_account_id'), 'rules'=>"required|integer|max_length[20]"],
                'date'          => ['label' => lang('c4_transaction.date'), 'rules'=>"required|valid_date"],
                'description'   => ['label' => lang('c4_transaction.description'), 'rules'=>"permit_empty|max_length[255]|alpha_numeric_space_turkish"],
                'debit_amount'  => ['label' => lang('c4_transaction.debit_amount'), 'rules'=>"required|decimal|max_length[15]"],
            ]);
            if ($validation->run($data) === false)
            {
                return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
            }
            //----------------------------------------------------------------//
            // clear undefined post fields for security..
            //----------------------------------------------------------------//
            $filterFormFields = ['c4_account_id', 'date', 'description', 'debit_amount', 'debit_currency', 'c4_transaction_id'];
            $data             = array_intersect_key($data, array_flip($filterFormFields));
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * Check c4_account_id for security
            */        
            //----------------------------------------------------------------//
            if (empty($this->request->getPost('new_c4_account_id'))  && empty(getC4_account($data['c4_account_id'])))
            {
                log_message('error', 'SECURITY: Undefined c4_account_id value posted');
                return $this->fail(['c4_account_id'=>'You Can not set this value'], 400, lang('home.error_validation_form')); 
            }
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            //Form Condtions to Data
            //----------------------------------------------------------------//
            $data['transaction_type'] = 'account_debit';

        }
        //---------------------------------------------------------------------//
        //For form_slug=money_out pageSlug=c4_transaction
        elseif($form_slug === 'money_out')
        {

            //----------------------------------------------------------------//
            /**
            * credit_amount FILTER_CALLBACK
            */
            //----------------------------------------------------------------//
            $data['credit_amount'] = filter_var($data['credit_amount'] ?? null, FILTER_CALLBACK, array("options"=>"returnNumber")); 
            //----------------------------------------------------------------//

            // money_out form Validations and security
            $validation->setRules([
                'c4_account_id' => ['label' => lang('c4_transaction.c4_account_id'), 'rules'=>"required|integer|max_length[20]"],
                'date'          => ['label' => lang('c4_transaction.date'), 'rules'=>"required|valid_date"],
                'credit_amount' => ['label' => lang('c4_transaction.credit_amount'), 'rules'=>"required|decimal|max_length[15]"],
                'description'   => ['label' => lang('c4_transaction.description'), 'rules'=>"permit_empty|max_length[255]|alpha_numeric_space_turkish"],
            ]);
            if ($validation->run($data) === false)
            {
                return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
            }
            //----------------------------------------------------------------//
            // clear undefined post fields for security..
            //----------------------------------------------------------------//
            $filterFormFields = ['c4_account_id', 'date', 'credit_amount', 'description', 'credit_currency', 'c4_transaction_id'];
            $data             = array_intersect_key($data, array_flip($filterFormFields));
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            /**
            * Check c4_account_id for security
            */        
            //----------------------------------------------------------------//
            if (empty($this->request->getPost('new_c4_account_id'))  && empty(getC4_account($data['c4_account_id'])))
            {
                log_message('error', 'SECURITY: Undefined c4_account_id value posted');
                return $this->fail(['c4_account_id'=>'You Can not set this value'], 400, lang('home.error_validation_form')); 
            }
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            //Form Condtions to Data
            //----------------------------------------------------------------//
            $data['transaction_type'] = 'account_credit';

        }
        //---------------------------------------------------------------------//
        else
        {
            //not matched
            log_message('error', "SECURITY: $form_slug form not founded");
            return $this->failNotFound("$form_slug form not found");
        }

        $C4_transactionModel = new C4_transactionModel();

        try
        {
            $C4_transactionModel->save($data);
        }
        catch (\Exception $e)
        {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            return $this->fail($e->getMessage(), 400, lang('home.error_validation_form'));
        }
        
        if(empty($c4_transaction_id))
        {
            $c4_transaction_id = $C4_transactionModel->getInsertID();
        }

        return $this->respondCreated(['id' => $c4_transaction_id, 'message' => lang('home.saved')]);
    }
 
    //--------------------------------------------------------------------

    /**
     * Read c4_transaction data
     * Functions adds DT_RowId variable to each row for datatables.net
     * 
     * Search Contions may change according to $pageSlug
     * 
     * @param string $pageSlug
     * @return array
     * 
     */
    public function readC4_transaction($pageSlug)
    {

        $pageList = ['c4_transaction'];
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

        $model      = new C4_transactionModel();
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
        // Page c4_transaction
        //--------------------------------------------------------------------//

        if($pageSlug === 'c4_transaction')
        {
            $select_text       = "c4_transaction.*, c4_account.name as c4_account_RELATIONAL_name";
            $multipleFields    = [];

            //------------------------------------------------------------------//
            //merge relation fields names to make Sortable
            $table_colons = array_merge($table_colons, ['c4_account_RELATIONAL_name']);
            //------------------------------------------------------------------//
            //------------------------------------------------------------------//        
            // Left Join Text
            //------------------------------------------------------------------//
            $model->join("(SELECT c4_account_id, name FROM c4_account WHERE c4_account.deleted_at IS NULL AND c4_account.status = '1' GROUP BY c4_account_id ORDER BY c4_account_id DESC) c4_account", 'c4_account.c4_account_id = c4_transaction.c4_account_id', 'left');

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
                    $model->where("c4_transaction.$filterField", trim(filter_var($filterValue, FILTER_SANITIZE_STRING)));
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
                    $model->where("c4_transaction.$key_field >=", $fieldValue);
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
                    $model->where("c4_transaction.$key_field <=", $fieldValue .' 23:59:59');
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
                // Page c4_transaction
                //--------------------------------------------------------------------//

                if($pageSlug === 'c4_transaction')
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
     * Delete c4_transaction by id
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

        $C4_transactionModel = new C4_transactionModel();
        if ($C4_transactionModel->delete($id, true) === false)
        {
            log_message('error', "Error: $id ID C4_transactionModel Delete Error");
            return $this->fail($C4_transactionModel->errors());
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

        $data['page_title'] = lang('c4_transaction._form_' .$formSlug);
        $data['formData'] = $_POST;
        
        // -----------------------------------
        //breadcrumb if form is showed in Page
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];

        if($formSlug === 'money_in')
        {
            $data['breadcrumb'][] = ['url' => financepanel_url('c4_transaction/c4_transaction'), 'title' => lang('c4_transaction._page_c4_transaction')];
            $data['breadcrumb'][] = ['title' => lang('c4_transaction._form_money_in'), 'class' => 'active'];
        }
        elseif($formSlug === 'money_out')
        {
            $data['breadcrumb'][] = ['url' => financepanel_url('c4_transaction/c4_transaction'), 'title' => lang('c4_transaction._page_c4_transaction')];
            $data['breadcrumb'][] = ['title' => lang('c4_transaction._form_money_out'), 'class' => 'active'];
        }
        else
        {
            log_message('error', "SECURITY: $formSlug form not founded");
            return $this->failNotFound("$formSlug not founded");
        }

        if (!empty($id))
        {
            $C4_transactionModel = new C4_transactionModel();
            
            $data['formData'] += $C4_transactionModel->find($id) ?? [];
        }

        $copy      = (int) $this->request->getGet('copy');

        if (!empty($copy))
        {
            $C4_transactionModel = new C4_transactionModel();
            
            $data['formData'] += $C4_transactionModel->find($copy);
            
            if(isset($data['formData']['c4_transaction_id']))
            {
                unset($data['formData']['c4_transaction_id']);
            }
        }

        

        $this->_render('form/' . $formSlug, $data);
    }

    //--------------------------------------------------------------------

    /**
     * Get C4_accountModel data
     * @return json
     */
    public function getAllC4_account() 
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

        $model = new C4_accountModel();
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
     * Get C4_paymentModel data
     * @return json
     */
    public function getAllC4_payment() 
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

        $model = new C4_paymentModel();
        $allowedFields = $model->getAllowedFields();
        
        if(!empty($q))
        {
            $model->groupStart();
            $model->orLike('c4_invoice_id', $q);
            $model->groupEnd();
        }

        $model->where('deleted_at', NULL);

        $model->orderBy('c4_invoice_id', 'asc');

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
     * Update single field of c4_transaction 
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
        $batchList = ['transaction_type', 'debit_currency', 'credit_currency'];

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

        $model = new C4_transactionModel();
        

        //validation
        if(isset($data['transaction_type']))
        {
            if (!$this->validate([
                'transaction_type' => ['label' => lang('c4_transaction.transaction_type'), 'rules' => 'required|in_list[contact_debit,contact_credit,account_debit,account_credit]|alpha_dash'],
            ]))
            {
                return $this->fail($this->validator->getErrors(), 400, lang('home.error_invalid_id'));
            }
        }
        if(isset($data['debit_currency']))
        {
            if (!$this->validate([
                'debit_currency' => ['label' => lang('c4_transaction.debit_currency'), 'rules' => 'required|alpha_numeric_space|max_length[255]|in_list[TRY,USD,EUR,GBP]'],
            ]))
            {
                return $this->fail($this->validator->getErrors(), 400, lang('home.error_invalid_id'));
            }
        }
        if(isset($data['credit_currency']))
        {
            if (!$this->validate([
                'credit_currency' => ['label' => lang('c4_transaction.credit_currency'), 'rules' => 'required|alpha_numeric_space|max_length[255]|in_list[TRY,USD,EUR,GBP]'],
            ]))
            {
                return $this->fail($this->validator->getErrors(), 400, lang('home.error_invalid_id'));
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
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => 'eec7860']);

        $conf   = new \Config\App();
        $locale = $this->request->getLocale();

        //Load Home Lang File
        $langFile = ROOTPATH . 'financepanel/Language/' . $locale . '/c4_transaction.php';

        if (!file_exists($langFile))
        {
            //Check default lang file
            $langFile = ROOTPATH . 'financepanel/Language/' . $conf->defaultLocale . '/c4_transaction.php';

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
        echo 'var LANG_c4_transaction = ' . json_encode($langArray, JSON_PRETTY_PRINT);
    }

    //--------------------------------------------------------------------

    private function _render($page, $data = [])
    {
        helper('form');

        $data['table_name']  = 'c4_transaction';

        if ($this->request->isAJAX())
        {
            try
            {
                echo financepanel_view('c4_transaction/' . $page, $data);
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
                echo financepanel_view('c4_transaction/' . $page, $data);
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