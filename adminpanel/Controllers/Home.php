<?php
/**
 * Adminpanel Home Controller
 * Dashboard of the panel
 */

namespace Adminpanel\Controllers;

use CodeIgniter\API\ResponseTrait;

class Home extends BaseController
{

    use ResponseTrait;

    //--------------------------------------------------------------------

    public function __construct()
    {


    }

    //--------------------------------------------------------------------

    /**
     * view default page
     * productsIndex    
     */
    public function index()
    {
        //Cache
        $this->response->setCache(['max-age'  => 300, 's-maxage' => 900, 'etag' => 'e7c5117']);

        $data['page_title'] = lang('home.panelTitle');
        //$data['breadcrumb'][] = ['url' => adminpanel_url('home/index'), 'title' => lang('home.dashboard')];

        $data['jsList'] = [adminpanel_assets('home/home.js')];

        $this->_render('index', $data);
    }

     
    
    //--------------------------------------------------------------------

    public function showForm($formSlug, $id = null)
    {
        $formSlug = trim($formSlug);
        $formList = ['email', 'sms', 'change_password'];

        if (!in_array($formSlug, $formList))
        {
            return $this->failNotFound("$formSlug form not founded");
        }
         
        $data['formData']   = $_POST;
        $data['id']   = $id;

        $this->_render('form/' . $formSlug, $data);
    }

    //--------------------------------------------------------------------

    public function sendEmail($id = null)
    {
        helper('Adminpanel\email');
        
        $data       = $this->request->getPost();
        $validation = \Config\Services::validation();

        $type = $this->request->getPost('type'); //single multiple

        if ($type === 'single')
        {
            // email_send form Validations and security
            $validation->setRules([
                'mailto'      => ['label' => lang('home.mailto'), 'rules' => "required|valid_emails"],
                'subject' => ['label' => lang('home.subject'), 'rules' => "required|string"],
                'message' => ['label' => lang('home.message'), 'rules' => "required|string"],
                'files.*' => ['label' => lang('home.files'), 'rules' => "permit_empty|numeric"],
            ]);

            if ($validation->run($data) === false)
            {
                return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
            }
            
            $emailHistory = sendPanelEmail($data);
 
        }
        elseif ($type === 'multiple')
        {

            $validation->setRules([
                'table_name'  => ['label' => 'table_name', 'rules' => "required|string"],
                'email_field' => ['label' => 'email_field', 'rules' => "required|string"],
                'subject'     => ['label' => lang('home.subject'), 'rules' => "required|string"],
                'message'     => ['label' => lang('home.message'), 'rules' => "required|string"],
                'files.*'     => ['label' => lang('home.files'), 'rules' => "permit_empty|numeric"],
            ]);

            if ($validation->run($data) === false)
            {

                $response = [
                    'status'    => 400,
                    'error'     => lang('home.error_validation_form'),
                    'messages'  => $validation->getErrors(),
                    'breakLoop' => 1
                ];

                return $this->respond($response, 400);
            }

            $table_name  = $this->request->getPost('table_name');
            $email_field = $this->request->getPost('email_field');
            $subject     = $this->request->getPost('subject');
            $message     = $this->request->getPost('message');
            $files       = $this->request->getPost('files');

            $helperFile = strtolower($table_name);
            
            helper("Adminpanel\\{$helperFile}");
            
            $functionName = 'get' . ucfirst(strtolower($table_name));

            if (!function_exists($functionName))
            {
                return $this->fail(['message' => "$functionName doesn't exist", 'breakLoop' => 1]);
            }

            $tableData = $functionName($id);

            if (!empty($tableData))
            {
                $mailto = $tableData[$email_field] ?? null;

                if (empty($mailto))
                {
                    return $this->fail(['message' => "$id ID doesn't have $email_field"]);
                }

                $parser = \Config\Services::parser();

                $tableData['HTTP_SITE_URL']  = site_url();
                $tableData['HTTP_PANEL_URL'] = adminpanel_url();

                $emailData['mailto']      = $mailto;
                $emailData['subject'] = $parser->setData($tableData)->renderString($subject);
                $emailData['message'] = $parser->setData($tableData)->renderString($message);
                $emailData['files']   = $files;
                
                $emailHistory = sendPanelEmail($emailData);
            }
            else
            {
                return $this->fail(['message' => "$id record doesn't exist"]);
            }            
        }

        if (intval($data['trackEmail'] ?? NULL) === 1)
        {
            saveEmailHistory($emailHistory);
        }

        if ($emailHistory['is_sended'])
        {
            return $this->respondCreated(['message' => lang('home.saved')]);
        }
        else
        {
            $mailto = $emailHistory['mailto'];
            return $this->fail(['message' => "Error on Sending Email to $mailto"]);
        }
    }
   
    // --------------------------------------------------------------------
    
    public function sendSms($id = null)
    {
        helper('Adminpanel\sms');
        
        $data       = $this->request->getPost();
        $validation = \Config\Services::validation();

        $type = $this->request->getPost('type'); //single multiple

        if ($type === 'single')
        {
            // sms_send form Validations and security
            $validation->setRules([
                'smsto'      => ['label' => lang('home.smsto'), 'rules' => "required"],
                'message' => ['label' => lang('home.message'), 'rules' => "required|string"],
            ]);

            if ($validation->run($data) === false)
            {
                return $this->fail($validation->getErrors(), 400, lang('home.error_validation_form'));
            }

            //----------------------------------------------------------------//
            // clear undefined post fields for security..
            //----------------------------------------------------------------//
            $filterFormFields = ['smsto', 'message'];
            $smsData          = array_intersect_key($data, array_flip($filterFormFields));
            //----------------------------------------------------------------//
        }
        elseif ($type === 'multiple')
        {

            $validation->setRules([
                'table_name'  => ['label' => 'table_name', 'rules' => "required|string"],
                'sms_field'   => ['label' => 'sms_field', 'rules' => "required|string"],
                'message'     => ['label' => lang('home.message'), 'rules' => "required|string"],
            ]);

            if ($validation->run($data) === false)
            {

                $response = [
                    'status'    => 400,
                    'error'     => lang('home.error_validation_form'),
                    'messages'  => $validation->getErrors(),
                    'breakLoop' => 1
                ];

                return $this->respond($response, 400);
            }

            $table_name  = $this->request->getPost('table_name');
            $sms_field   = $this->request->getPost('sms_field');
            $message     = $this->request->getPost('message');

            $helperFile = strtolower($table_name);
            
            helper("Adminpanel\\{$helperFile}");
            
            $functionName = 'get' . ucfirst(strtolower($table_name));

            if (!function_exists($functionName))
            {
                return $this->fail(['message' => "$functionName doesn't exist", 'breakLoop' => 1]);
            }

            $tableData = $functionName($id);

            if (!empty($tableData))
            {
                $smsto = $tableData[$sms_field] ?? null;

                if (empty($smsto))
                {
                    return $this->fail(['message' => "empty Sms No"]);
                }

                $parser = \Config\Services::parser();

                $tableData['HTTP_SITE_URL']  = site_url();
                $tableData['HTTP_PANEL_URL'] = adminpanel_url();

                $smsData['smsto']      = $smsto;
                $smsData['message'] = $parser->setData($tableData)->renderString($message);
            }
            else
            {
                return $this->fail(['message' => "$id record doesn't exist"]);
            }
        }

        $smsHistory = sendPanelSms($smsData);

        saveSmsHistory($smsHistory);

        if ($smsHistory['is_sended'])
        {
            return $this->respondCreated(['message' => lang('home.saved')]);
        }
        else
        {
            $smsto = $smsHistory['smsto'];
            return $this->fail(['message' => "Error on Sendinf Sms to $smsto"]);
        }
    }
    
    // --------------------------------------------------------------------
    
    public function uploadFile($formSlug, $fieldName)
    {
        $fileService = \Adminpanel\Config\Services::file();
        
        $formList = ['email_send', 'account'];
        
        if (!in_array($formSlug, $formList))
        {
            return $this->failNotFound("$formSlug not founded");
        }
        if($fieldName === 'files')
        {
            if (!$this->validate(['file' => ['label' => lang('email_sended.files'), 'rules' => 'uploaded[file]|is_image[file]|max_size[file,1024]']]))
            {
                return $this->fail($this->validator->getErrors(), 400);
            }
        }

        if ($fieldName === 'avatar')
        {
            if (!$this->validate(['avatar' => ['label' => lang('email_sended.files'), 'rules' => 'uploaded[file]|is_image[file]|max_size[file,2048]|ext_in[file,gif,jpg,jpeg,png]|max_dims[file,501,501]']]))
            {
                return $this->fail($this->validator->getErrors(), 400);
            }
        }

        //Save file to $formSlug folder  
        $return = $fileService->upload($formSlug, false);

        if (isset($return['upload_data']))
        {
            return $this->respond($return);
        }
        else
        {
            return $this->fail($return);
        }

    }
    
    // --------------------------------------------------------------------
    
    public function downloadfile($file_id)
    {
        $fileService = \Adminpanel\Config\Services::file();
        
        $fileDBData = $fileService->getFile(intval($file_id));

        if (empty($fileDBData))
        {
            return $this->response->fail(['message' => "There is no file data"]);
        }
 
        if ($fileDBData['extension'] === 'php')
        {
            log_message('critical', "SECURITY: PHP file download attemp." . $fileDBData['reelpath']);
            return $this->response->fail(['message' => "Security Alert"]);
        }

        return $this->response->download($fileDBData['reelpath'], NULL);
    }
    
    //--------------------------------------------------------------------/
    
    /**
     * Render File 
     * if request comes not as ajax, _render show header and footer files in themes/{theme}
     *
     * @param tring $fileName
     * @param array $data
     */
    private function _render($fileName, $data = [])
    {
        helper('form');
      
        if ($this->request->isAJAX())
        {
            echo adminpanel_view('home/' . $fileName, $data);
        }
        else
        {
            echo adminpanel_view('themes/' . $this->theme . '/header', $data);
            echo adminpanel_view('home/' . $fileName, $data);
            echo adminpanel_view('themes/' . $this->theme . '/footer', $data);
        }
    }
    
    
    //--------------------------------------------------------------------

    /**
     * Show Language/{locale}/home.php as Javascript file
     * @return application/x-javascript
     */
    public function langJS()
    {
        //Cache
        $this->response->setCache(['max-age'  => 300, 's-maxage' => 900, 'etag' => '3e84f6b']);

        $conf   = new \Config\App();
        $locale = $this->request->getLocale();

        //Load Home Lang File
        $homeLangFile = ROOTPATH . 'adminpanel/Language/' . $locale . '/home.php';

        if (!file_exists($homeLangFile))
        {
            //Check default lang file
            $homeLangFile = ROOTPATH . 'adminpanel/Language/' . $conf->defaultLocale . '/home.php';

            if (!file_exists($homeLangFile))
            {
                $homeLangFile = null;
            }
        }

        $langArray['panel_language'] = $locale;
        $langArray['panel_url'] = site_url("adminpanel/$locale");

        if (!empty($homeLangFile))
        {
            $langArray += require $homeLangFile; // Current local language
        }
        else
        {
            $langArray['error'] = $locale . ' lang file does not exist';
        }

        $this->response->setContentType('application/x-javascript');
        echo 'var LANG_home = ' . json_encode($langArray, JSON_PRETTY_PRINT);
    }
   
    
}