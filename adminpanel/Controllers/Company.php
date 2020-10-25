<?php

namespace Adminpanel\Controllers;

use CodeIgniter\API\ResponseTrait;
use Adminpanel\Models\CompanyModel;

class Company extends BaseController
{

    use ResponseTrait;

    //--------------------------------------------------------------------

    public function __construct()
    {
        helper(['Adminpanel\company']);
    }

    //--------------------------------------------------------------------
    /**
     * view default page = company 
     * company   
     */
    public function index()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '3f66a3c']);

        $data                 = ['page_title' => lang('company._page_company')];
        $data['breadcrumb'][] = ['url' => adminpanel_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('company._page_company'), 'class' => 'active'];

        $this->_render('company', $data);
    }
    //--------------------------------------------------------------------
    /**
     * view page = company
     * Company  
     */
    public function company()
    {
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '8fa8cc3']);

        $data                 = ['page_title' => lang('company._page_company')];
        $data['breadcrumb'][] = ['url' => adminpanel_url('home/index'), 'title' => lang('home.dashboard')];
        $data['breadcrumb'][] = ['title' => lang('company._page_company'), 'class' => 'active'];

        $this->_render('company', $data);
    }

    //--------------------------------------------------------------------
    /**
     * create or update
     * @return json
     */
    public function save($form_slug, $company_id = '')
    {
        $data       = $this->request->getPost();
        $validation = \Config\Services::validation();

        //---------------------------------------------------------------------//
        //For form_slug=company pageSlug=company
        if($form_slug === 'company')
        {

            // company form Validations and security
            $validation->setRules([
                'name'          => ['label' => lang('company.name'), 'rules'=>"required|string|max_length[128]"],
                'occupation_field' => ['label' => lang('company.occupation_field'), 'rules'=>"required|max_length[128]|string"],
                'logo'          => ['label' => lang('company.logo'), 'rules'=>"permit_empty|integer|max_length[11]"],
                'legal_name'    => ['label' => lang('company.legal_name'), 'rules'=>"permit_empty|max_length[250]|string"],
                'tax_number'    => ['label' => lang('company.tax_number'), 'rules'=>"permit_empty|max_length[250]|string"],
                'tax_office'    => ['label' => lang('company.tax_office'), 'rules'=>"permit_empty|max_length[250]|string"],
                'country_id'    => ['label' => lang('company.country_id'), 'rules'=>"permit_empty|integer|max_length[11]"],
                'zone_id'       => ['label' => lang('company.zone_id'), 'rules'=>"permit_empty|integer|max_length[11]"],
                'address'       => ['label' => lang('company.address'), 'rules'=>"permit_empty|string"],
            ]);
            if ($validation->run($data) === false)
            {
                return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
            }
            //----------------------------------------------------------------//
            // clear undefined post fields for security..
            //----------------------------------------------------------------//
            $filterFormFields = ['name', 'occupation_field', 'logo', 'legal_name', 'tax_number', 'tax_office', 'country_id', 'zone_id', 'address', 'company_id'];
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

        $CompanyModel = new CompanyModel();

        try
        {
            $CompanyModel->save($data);
        }
        catch (\Exception $e)
        {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            return $this->fail($e->getMessage(), 400, lang('home.error_validation_form'));
        }
        
        if(empty($company_id))
        {
            $company_id = $CompanyModel->getInsertID();
        }

        return $this->respondCreated(['id' => $company_id, 'message' => lang('home.saved')]);
    }
 
    //--------------------------------------------------------------------

    /**
     * Read company data
     * Functions adds DT_RowId variable to each row for datatables.net
     * 
     * Search Contions may change according to $pageSlug
     * 
     * @param string $pageSlug
     * @return array
     * 
     */
    public function readCompany($pageSlug)
    {

        $pageList = ['company'];
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

        $model      = new CompanyModel();
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
        // Page company
        //--------------------------------------------------------------------//

        if($pageSlug === 'company')
        {
            $select_text       = "company.*";
            $multipleFields    = [];

            if (!empty($search_text))
            {
                $search_text = filter_var($search_text, FILTER_SANITIZE_STRING);
                $model->groupStart();
                $model->orLike('company.name', $search_text);
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
                    $model->where("company.$filterField", trim(filter_var($filterValue, FILTER_SANITIZE_STRING)));
                }
            }
        }
        //Show Allways active status if not filtered
        if (!isset($filterArray['status']))
        {
            $model->where('company.status', '1');
        }
        else
        {
            $model->where('company.status', $filterArray['status']);
        }
        if (isset($filterArray['deleted_at']) && $filterArray['deleted_at'] === '1')
        {
            $model->onlyDeleted();
        }
        else
        {
            $model->where('company.deleted_at', NULL);
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
                    $model->where("company.$key_field >=", $fieldValue);
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
                    $model->where("company.$key_field <=", $fieldValue .' 23:59:59');
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
                // Page company
                //--------------------------------------------------------------------//

                if($pageSlug === 'company')
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
     * Delete company by id
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

        $CompanyModel = new CompanyModel();
        if ($CompanyModel->delete($id, false) === false)
        {
            log_message('error', "Error: $id ID CompanyModel Delete Error");
            return $this->fail($CompanyModel->errors());
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

        $data['page_title'] = lang('company._form_' .$formSlug);
        $data['formData'] = $_POST;
        
        // -----------------------------------
        //breadcrumb if form is showed in Page
        $data['breadcrumb'][] = ['url' => adminpanel_url('home/index'), 'title' => lang('home.dashboard')];

        if($formSlug === 'company')
        {
            $data['breadcrumb'][] = ['url' => adminpanel_url('company/company'), 'title' => lang('company._page_company')];
            $data['breadcrumb'][] = ['title' => lang('company._form_company'), 'class' => 'active'];
        }
        else
        {
            log_message('error', "SECURITY: $formSlug form not founded");
            return $this->failNotFound("$formSlug not founded");
        }

        if (!empty($id))
        {
            $CompanyModel = new CompanyModel();
            
            $data['formData'] += $CompanyModel->find($id) ?? [];
        }

        $copy      = (int) $this->request->getGet('copy');

        if (!empty($copy))
        {
            $CompanyModel = new CompanyModel();
            
            $data['formData'] += $CompanyModel->find($copy);
            
            if(isset($data['formData']['company_id']))
            {
                unset($data['formData']['company_id']);
            }
        }

        

        $this->_render('form/' . $formSlug, $data);
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
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => 'f5ec8a5']);

        $conf   = new \Config\App();
        $locale = $this->request->getLocale();

        //Load Home Lang File
        $langFile = ROOTPATH . 'adminpanel/Language/' . $locale . '/company.php';

        if (!file_exists($langFile))
        {
            //Check default lang file
            $langFile = ROOTPATH . 'adminpanel/Language/' . $conf->defaultLocale . '/company.php';

            if (!file_exists($langFile))
            {
                $langFile = null;
            }
        }

        $langArray['panel_language'] = $locale;
        $langArray['panel_url'] = adminpanel_url(null, $locale); 

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
        echo 'var LANG_company = ' . json_encode($langArray, JSON_PRETTY_PRINT);
    }

    //--------------------------------------------------------------------

    private function _render($page, $data = [])
    {
        helper('form');

        $data['table_name']  = 'company';

        if ($this->request->isAJAX())
        {
            try
            {
                echo adminpanel_view('company/' . $page, $data);
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
                echo adminpanel_view('themes/' . $this->theme . '/header', $data);
                echo adminpanel_view('company/' . $page, $data);
                echo adminpanel_view('themes/' . $this->theme . '/footer', $data);
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