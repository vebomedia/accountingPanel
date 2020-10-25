<?php

namespace Financepanel\Controllers;

use CodeIgniter\API\ResponseTrait;
use Financepanel\Models\C4_shipment_documentModel;

class C4_shipment_document extends BaseController
{

    use ResponseTrait;

    //--------------------------------------------------------------------

    public function __construct()
    {
        helper(['Financepanel\c4_shipment_document']);
    }

    //--------------------------------------------------------------------
    /**
     * view default page = inflow_shipment_document 
     * inflow_shipment_document   
     */
    public function index()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '339c638']);

        $data                 = ['page_title' => lang('c4_shipment_document._page_inflow_shipment_document')];
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('c4_shipment_document._page_inflow_shipment_document'), 'class' => 'active'];

        $this->_render('inflow_shipment_document', $data);
    }
    //--------------------------------------------------------------------
    /**
     * view page = inflow_shipment_document
     * Inflow Shipment Document  
     */
    public function inflow_shipment_document()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => 'de525ed']);

        $data                 = ['page_title' => lang('c4_shipment_document._page_inflow_shipment_document')];
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('c4_shipment_document._page_inflow_shipment_document'), 'class' => 'active'];

        $this->_render('inflow_shipment_document', $data);
    }
    //--------------------------------------------------------------------
    /**
     * view page = outflow_shipment_document
     * Outflow Shipment Document  
     */
    public function outflow_shipment_document()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '9b6ceef']);

        $data                 = ['page_title' => lang('c4_shipment_document._page_outflow_shipment_document')];
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('c4_shipment_document._page_outflow_shipment_document'), 'class' => 'active'];

        $this->_render('outflow_shipment_document', $data);
    }

    //--------------------------------------------------------------------
    /**
     * create or update
     * @return json
     */
    public function save($form_slug, $c4_shipment_document_id = '')
    {
        $data       = $this->request->getPost();
        $validation = \Config\Services::validation();

        //---------------------------------------------------------------------//
        //For form_slug=inflow_shipment_document pageSlug=inflow_shipment_document
        if($form_slug === 'inflow_shipment_document')
        {

            // inflow_shipment_document form Validations and security
            $validation->setRules([
                'description'   => ['label' => lang('c4_shipment_document.description'), 'rules'=>"required|max_length[255]|alpha_numeric_space_turkish"],
                'address'       => ['label' => lang('c4_shipment_document.address'), 'rules'=>"required|alpha_numeric_space_turkish"],
                'inflow'        => ['label' => lang('c4_shipment_document.inflow'), 'rules'=>"required|integer|max_length[1]|in_list[1,0]"],
                'issue_date'    => ['label' => lang('c4_shipment_document.issue_date'), 'rules'=>"required|valid_date"],
                'shipment_date' => ['label' => lang('c4_shipment_document.shipment_date'), 'rules'=>"required|valid_date"],
                'procurement_number' => ['label' => lang('c4_shipment_document.procurement_number'), 'rules'=>"required|max_length[255]|alpha_numeric_space_turkish"],
            ]);
            if ($validation->run($data) === false)
            {
                return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
            }
            //----------------------------------------------------------------//
            // clear undefined post fields for security..
            //----------------------------------------------------------------//
            $filterFormFields = ['description', 'address', 'inflow', 'issue_date', 'shipment_date', 'procurement_number', 'c4_shipment_document_id'];
            $data             = array_intersect_key($data, array_flip($filterFormFields));
            //----------------------------------------------------------------//

            //----------------------------------------------------------------//
            //Form Condtions to Data
            //----------------------------------------------------------------//
            $data['inflow'] = '1';

        }
        //---------------------------------------------------------------------//
        //For form_slug=outflow_shipment_document pageSlug=outflow_shipment_document
        elseif($form_slug === 'outflow_shipment_document')
        {

            // outflow_shipment_document form Validations and security
            $validation->setRules([
                'description'   => ['label' => lang('c4_shipment_document.description'), 'rules'=>"required|max_length[255]|alpha_numeric_space_turkish"],
                'address'       => ['label' => lang('c4_shipment_document.address'), 'rules'=>"required|alpha_numeric_space_turkish"],
                'inflow'        => ['label' => lang('c4_shipment_document.inflow'), 'rules'=>"required|integer|max_length[1]|in_list[1,0]"],
                'issue_date'    => ['label' => lang('c4_shipment_document.issue_date'), 'rules'=>"required|valid_date"],
                'shipment_date' => ['label' => lang('c4_shipment_document.shipment_date'), 'rules'=>"required|valid_date"],
                'procurement_number' => ['label' => lang('c4_shipment_document.procurement_number'), 'rules'=>"required|max_length[255]|alpha_numeric_space_turkish"],
            ]);
            if ($validation->run($data) === false)
            {
                return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
            }
            //----------------------------------------------------------------//
            // clear undefined post fields for security..
            //----------------------------------------------------------------//
            $filterFormFields = ['description', 'address', 'inflow', 'issue_date', 'shipment_date', 'procurement_number', 'c4_shipment_document_id'];
            $data             = array_intersect_key($data, array_flip($filterFormFields));
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

        $C4_shipment_documentModel = new C4_shipment_documentModel();

        try
        {
            $C4_shipment_documentModel->save($data);
        }
        catch (\Exception $e)
        {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            return $this->fail($e->getMessage(), 400, lang('home.error_validation_form'));
        }
        
        if(empty($c4_shipment_document_id))
        {
            $c4_shipment_document_id = $C4_shipment_documentModel->getInsertID();
        }

        return $this->respondCreated(['id' => $c4_shipment_document_id, 'message' => lang('home.saved')]);
    }
 
    //--------------------------------------------------------------------

    /**
     * Read c4_shipment_document data
     * Functions adds DT_RowId variable to each row for datatables.net
     * 
     * Search Contions may change according to $pageSlug
     * 
     * @param string $pageSlug
     * @return array
     * 
     */
    public function readC4_shipment_document($pageSlug)
    {

        $pageList = ['inflow_shipment_document', 'outflow_shipment_document'];
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

        $model      = new C4_shipment_documentModel();
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
        // Page inflow_shipment_document
        //--------------------------------------------------------------------//

        if($pageSlug === 'inflow_shipment_document')
        {
            $select_text       = "c4_shipment_document.*";
            $multipleFields    = [];

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
        // Page outflow_shipment_document
        //--------------------------------------------------------------------//

        elseif($pageSlug === 'outflow_shipment_document')
        {
            $select_text       = "c4_shipment_document.*";
            $multipleFields    = [];

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
                    $model->where("c4_shipment_document.$filterField", trim(filter_var($filterValue, FILTER_SANITIZE_STRING)));
                }
            }
        }
        if (isset($filterArray['deleted_at']) && $filterArray['deleted_at'] === '1')
        {
            $model->onlyDeleted();
        }
        else
        {
            $model->where('c4_shipment_document.deleted_at', NULL);
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
                    $model->where("c4_shipment_document.$key_field >=", $fieldValue);
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
                    $model->where("c4_shipment_document.$key_field <=", $fieldValue .' 23:59:59');
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
                // Page inflow_shipment_document
                //--------------------------------------------------------------------//

                if($pageSlug === 'inflow_shipment_document')
                { 

                } //endif

                //--------------------------------------------------------------------//
                // Page outflow_shipment_document
                //--------------------------------------------------------------------//

                elseif($pageSlug === 'outflow_shipment_document')
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
     * Delete c4_shipment_document by id
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

        $C4_shipment_documentModel = new C4_shipment_documentModel();
        if ($C4_shipment_documentModel->delete($id, false) === false)
        {
            log_message('error', "Error: $id ID C4_shipment_documentModel Delete Error");
            return $this->fail($C4_shipment_documentModel->errors());
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

        $data['page_title'] = lang('c4_shipment_document._form_' .$formSlug);
        $data['formData'] = $_POST;
        
        // -----------------------------------
        //breadcrumb if form is showed in Page
        $data['breadcrumb'][] = ['url' => financepanel_url('home/index'), 'title' => lang('home.dashboard')];

        if($formSlug === 'inflow_shipment_document')
        {
            $data['breadcrumb'][] = ['url' => financepanel_url('c4_shipment_document/inflow_shipment_document'), 'title' => lang('c4_shipment_document._page_inflow_shipment_document')];
            $data['breadcrumb'][] = ['title' => lang('c4_shipment_document._form_inflow_shipment_document'), 'class' => 'active'];
        }
        elseif($formSlug === 'outflow_shipment_document')
        {
            $data['breadcrumb'][] = ['url' => financepanel_url('c4_shipment_document/outflow_shipment_document'), 'title' => lang('c4_shipment_document._page_outflow_shipment_document')];
            $data['breadcrumb'][] = ['title' => lang('c4_shipment_document._form_outflow_shipment_document'), 'class' => 'active'];
        }
        else
        {
            log_message('error', "SECURITY: $formSlug form not founded");
            return $this->failNotFound("$formSlug not founded");
        }

        if (!empty($id))
        {
            $C4_shipment_documentModel = new C4_shipment_documentModel();
            
            $data['formData'] += $C4_shipment_documentModel->find($id) ?? [];
        }

        $copy      = (int) $this->request->getGet('copy');

        if (!empty($copy))
        {
            $C4_shipment_documentModel = new C4_shipment_documentModel();
            
            $data['formData'] += $C4_shipment_documentModel->find($copy);
            
            if(isset($data['formData']['c4_shipment_document_id']))
            {
                unset($data['formData']['c4_shipment_document_id']);
            }
        }

        

        $this->_render('form/' . $formSlug, $data);
    }

    //--------------------------------------------------------------------
    /**
     * Update single field of c4_shipment_document 
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
        $batchList = ['status', 'deleted_at'];

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

        $model = new C4_shipment_documentModel();
        

        //validation
        if(isset($data['status']))
        {
            if (!$this->validate([
                'status' => ['label' => lang('c4_shipment_document.status'), 'rules' => 'required|integer|max_length[1]|in_list[1,2]'],
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
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => 'df9fac5']);

        $conf   = new \Config\App();
        $locale = $this->request->getLocale();

        //Load Home Lang File
        $langFile = ROOTPATH . 'financepanel/Language/' . $locale . '/c4_shipment_document.php';

        if (!file_exists($langFile))
        {
            //Check default lang file
            $langFile = ROOTPATH . 'financepanel/Language/' . $conf->defaultLocale . '/c4_shipment_document.php';

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
        echo 'var LANG_c4_shipment_document = ' . json_encode($langArray, JSON_PRETTY_PRINT);
    }

    //--------------------------------------------------------------------

    private function _render($page, $data = [])
    {
        helper('form');

        $data['table_name']  = 'c4_shipment_document';

        if ($this->request->isAJAX())
        {
            try
            {
                echo financepanel_view('c4_shipment_document/' . $page, $data);
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
                echo financepanel_view('c4_shipment_document/' . $page, $data);
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