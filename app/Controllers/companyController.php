<?php

namespace App\Controllers;
use App\Models\CompanyModel;

class companyController extends BaseController
{
        private $CompanyModel;

        public function __construct()
        {
            $this->CompanyModel = new CompanyModel();
        }

        public function index() 
        {
            if ($this->request->getPost()) {
                    $id = 1;
                    $session = session();
                    $id = $session->get('user_id');
                    $companyData = [
                        'company_name' => $this->request->getVar('company_name'),
                        'updated_by' => $id,
                        'updated_time' => date("Y-m-d H:i:s"),
                    ];
                    $company_banner = $this->request->getFile('company_banner');
                    if ($company_banner->isValid() && !$company_banner->hasMoved()) {
                        $newName = $company_banner->getRandomName();
                        $company_banner->move(FCPATH . 'uploads/company', $newName); 
                        $companyData['company_banner'] = $newName;
                    }
                    $company_header_logo = $this->request->getFile('header_logo');
                    if ($company_header_logo->isValid() && !$company_header_logo->hasMoved()) {
                        $newName = $company_header_logo->getRandomName();
                        $company_header_logo->move(FCPATH . 'uploads/company', $newName); 
                        $companyData['company_header_logo'] = $newName;
                    }
                    $welcome_page_image = $this->request->getFile('welcome_page_image');
                    if ($welcome_page_image->isValid() && !$welcome_page_image->hasMoved()) {
                        $newName = $welcome_page_image->getRandomName();
                        $welcome_page_image->move(FCPATH . 'uploads/company', $newName); 
                        $companyData['company_welcome_page_image'] = $newName;
                    }
                    $this->CompanyModel->update($id,$companyData);
                    $successMsg = 'Company data updated successfully.';
                    return redirect()->to('setting')->with('success', $successMsg);    
            } else {
                $data['companyData'] = company_data();
                $header['head_title'] = "Company Setting";
                echo view('header', $header);
                echo view('company_setting', $data);
                echo view('footer');
            }
    }
}