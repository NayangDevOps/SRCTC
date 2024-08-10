<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\FeedbackModel;
use App\Models\NewsModel;
use App\Models\TicketModel;

class Home extends BaseController
{
    private $userModel;
    private $FeedbackModel;
    private $newsModel;
    private $TicketModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->FeedbackModel = new FeedbackModel();
        $this->newsModel = new NewsModel();
        $this->TicketModel = new TicketModel();

    }

    public function index()
    {
        $data = [];
        if ($this->request->getPost()) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            if (!empty($username) && !empty($password)) {
                $user = $this->userModel->where('email', $username)->first();
                if ($user) {
                    if (password_verify($password, $user['password'])) {
                        $session = session();
                        $session->set([
                            'user_id' => $user['id'],
                            'username' => $user['email'],
                            'logged_in' => true
                        ]);
                        return redirect()->to('dashboard');
                    } else {
                        $data['error'] = 'Invalid username or password.';
                    }
                } else {
                    $data['error'] = 'Invalid username or password.';
                }
            } else {
                $data['error'] = 'Both username and password are required.';
            }
            $header['head_title'] = "Login Page";
            $header['header_scripts'] = [
                'public/css/login_page.css',
                'public/js/login_page.js',
            ];
            echo view('header', $header);
            echo view('login_page', $data);
            echo view('footer');
        } else {
            $header['head_title'] = "Login Page";
            $header['header_scripts'] = [
                'public/css/login_page.css',
                'public/js/login_page.js',
            ];
            echo view('header', $header);
            echo view('login_page');
            echo view('footer');
        }
    }

    public function sign_up()
    {
        if ($this->request->getPost()) {
            $validationRules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|valid_email|is_unique[srctc_user_reg.email]',
                'mobile_no' => 'required|numeric|exact_length[10]',
                'password' => 'required|min_length[8]',
                'cpassword' => 'required|matches[password]',
            ];
            if ($this->validate($validationRules)) {
                $userData = [
                    'first_name' => $this->request->getVar('first_name'),
                    'last_name' => $this->request->getVar('last_name'),
                    'email' => $this->request->getVar('email'),
                    'mobile_no' => $this->request->getVar('mobile_no'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->userModel->insert($userData);
                $successMsg = 'You have registered successfully, Please login to proceed.';
                return redirect()->to('/')->with('success', $successMsg);    
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        } else {
            $header['head_title'] = "Sign Up Page";
            $header['header_scripts'] = [
                'public/css/login_page.css',
                'public/css/bootstrap.css',
                'public/js/login_page.js',
            ];
            echo view('header', $header);
            echo view('signup_page');
            echo view('footer');
        }
    }

    public function sign_out(){
        $session = session();
        $session->destroy();
        return redirect('/');
    }

    public function dashboard()
    {
        $result['data'] = $this->userModel->countAllRecords();
        $result['countUsersByType'] = $this->userModel->countUsersByType();
        $header['head_title'] = "Dashboard";
        $header['header_scripts'] = [
            'public/css/dashboard.css',
        ];        
        echo view('header', $header);
        echo view('dashboard', $result);
        echo view('footer');
    }

    public function user_profile($id) {
        $data = [];
        if ($this->request->getPost()){
            $first_name = $this->request->getPost('first_name');
            $last_name = $this->request->getPost('last_name');
            $display_name = $this->request->getPost('display_name');
            $email = $this->request->getPost('email');
            $mobile_no = $this->request->getPost('mobile_no');
            $gender = $this->request->getPost('gender');            
            $user_type = $this->request->getPost('user_type');
            $userData = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'display_name' => $display_name,
                'email' => $email,
                'mobile_no' => $mobile_no,
                'gender'   => $gender,
                'user_type' => $user_type,
            ];  
            $profilePicture = $this->request->getFile('profile_picture');
            if ($profilePicture->isValid() && !$profilePicture->hasMoved()) {
                $newName = $profilePicture->getRandomName();
                $profilePicture->move(FCPATH . 'uploads/', $newName); 
                $userData['profile_pic'] = $newName;
            }
            $this->userModel->update($id, $userData);
            $session = session();
            $id = $session->get('user_id');
            $user = user_data($id);
            if($user['user_type'] == 10){ 
                return redirect()->to('user_list')->with('success', 'User updated successfully.');  
            }else{
                return redirect('dashboard')->with('success', 'Your profile updated successfully.');  ;
            }
        } else {
            $header['head_title'] = "User Profile";
            $header['header_scripts'] = [
                'public/lib/select2/css/select2.css',
				'public/lib/select2/js/select2.js',
            ];
            $data['user_data'] = $this->userModel->getUserData($id);
            echo view('header', $header);
            echo view('user_profile', $data);
            echo view('footer');
        }
    }  
    
    public function user_list(){
        $header['head_title'] = "Users List";
        $header['header_scripts'] = [
            'public/js/dataTables/js/dataTables.min.js',
            'public/js/dataTables/js/jquery.dataTables.min.js',
            'public/js/dataTables/css/jquery.dataTables.min.css',
        ];
        echo view('header', $header);
        echo view('users_list');
        echo view('footer');
    }    

    public function user_list_ajax(){
        $users =  $this->userModel->findAll();    
        echo json_encode($users);
    }    

    public function delete($id) 
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);
        if (!$user) {
            return redirect()->to('user_list')->with('error', 'User not found.');
        }
        $userModel->delete($id);
        return redirect()->to('user_list')->with('success', 'User deleted successfully.');
    }

    public function add_user() 
    {
        if ($this->request->getPost()) {
            $validationRules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'display_name' => 'required',
                'gender' => 'required',
                'user_type' => 'required',
                'email' => 'required|valid_email|is_unique[srctc_user_reg.email]',
                'mobile_no' => 'required|numeric|exact_length[10]',
                'password' => 'required|min_length[8]',
                'cpassword' => 'required|matches[password]',
            ];
            if ($this->validate($validationRules)) {
                $userData = [
                    'first_name' => $this->request->getVar('first_name'),
                    'last_name' => $this->request->getVar('last_name'),
                    'email' => $this->request->getVar('email'),
                    'mobile_no' => $this->request->getVar('mobile_no'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'gender'   => $this->request->getVar('gender'),
                    'display_name' => $this->request->getVar('display_name'),
                    'user_type' => $this->request->getVar('user_type'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $profilePicture = $this->request->getFile('profile_picture');
                if ($profilePicture->isValid() && !$profilePicture->hasMoved()) {
                    $newName = $profilePicture->getRandomName();
                    $profilePicture->move(FCPATH . 'uploads/', $newName); 
                    $userData['profile_pic'] = $newName;
                }
                $this->userModel->insert($userData);
                $successMsg = 'User registered successfully.';
                return redirect()->to('user_list')->with('success', $successMsg);    
            } else {
                return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
            }
        } else {
            $header['head_title'] = "Add User";
            echo view('header', $header);
            echo view('add_user');
            echo view('footer');
        }
    }

    public function about_us(){
        $header['head_title'] = "About Us";
        echo view('header', $header);
        echo view('about_us');
        echo view('footer');       
    }

    public function contact_us(){
        if ($this->request->getPost()) {
            $validationRules = [
                'name' => 'required',
                'email' => 'required|valid_email',
                'message' => 'required',
                'rating' => 'required',
            ];
            if ($this->validate($validationRules)) {
                $userData = [
                    'name' => $this->request->getVar('name'),
                    'email' => $this->request->getVar('email'),
                    'message' => $this->request->getVar('message'),
                    'rating' => $this->request->getVar('rating'),
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->FeedbackModel->insert($userData);
                $successMsg = 'Thank you for your feedback or queries. We will be reaching out to you soon.';
                return redirect()->to('dashboard')->with('success', $successMsg);    
            } else {
                return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
            }
        } else {
            $header['head_title'] = "Contact Us";
            echo view('header', $header);
            echo view('contact_us');
            echo view('footer');       
        }
    }

    public function getUserData()
    {
        $filter = $this->request->getGet('filter') ?? 'week';
        $userModel = new UserModel();
        $data = $userModel->getDataBasedOnFilter($filter);
        return $this->response->setJSON($data); 
    } 

    public function getTicketData()
    {
        $filter = $this->request->getGet('filter') ?? 'week';
        $data = $this->TicketModel->getDataBasedOnFilter($filter);
        return $this->response->setJSON($data); 
    } 
    
    public function fetchNews()
    {
        $newsData = $this->newsModel->findAll(); 
        return $this->response->setJSON($newsData);
    }

    public function remove_news(){
        $news_id = $this->request->getVar('news_id');
        $news_data = [
            'news_status' => 0
        ];
        $this->newsModel->update($news_id, $news_data);
        return $this->response->setJSON(['status' => 'success', 'message' => 'News status changed successfully!']);
    }

    public function update_emoji_counts(){
        $newsId = $this->request->getVar('newsId');
        $emoji = $this->request->getVar('emoji');
        $count = $this->request->getVar('count');
        switch ($emoji) {
            case '😍':
                $field = 'news_lovely_counts';
                break;
            case '😊':
                $field = 'news_happy_counts';
                break;
            case '😐':
                $field = 'news_neutral_counts';
                break;
            case '😕':
                $field = 'news_sad_counts';
                break;
            case '😠':
                $field = 'news_angry_counts';
                break;
            default:
                return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid emoji']);
        }
        $news_data = [
            $field => $count
        ];
        $this->newsModel->update($newsId, $news_data);    
        return $this->response->setJSON(['status' => 'success', 'message' => 'Emoji count updated successfully']);
    }

    public function update_news_status(){
        $add_news_id = $this->request->getVar('add_news_id');
        $news_data = [
            'news_status' => 1
        ];
        $this->newsModel->update($add_news_id, $news_data);
        return $this->response->setJSON(['status' => 'success', 'message' => 'News status changed successfully!']); 
    }    

    public function delete_news(){
        $news_id = $this->request->getVar('news_id');
        $this->newsModel->delete($news_id);
        return $this->response->setJSON(['status' => 'success', 'message' => 'News deleted successfully!']); 
    }

    public function add_news_method(){
        if ($this->request->isAJAX()) {
            $title = $this->request->getPost('title');
            $description = $this->request->getPost('description');
            $image = $this->request->getFile('image');
            if ($image->isValid() && !$image->hasMoved()) {
                $newName = $image->getRandomName();
                $image->move(FCPATH . 'uploads/news_image/', $newName); 
            }
            $newsData = [
                'news_title' => $title,
                'news_content' => $description,
                'news_image' => base_url() . 'uploads/news_image/'.$newName, 
                'news_date' => date('Y-m-d H:i:s'),
            ];
            $this->newsModel->insert($newsData);
            $response = [
                'status' => 'success',
                'message' => 'News added successfully!'
            ];
            return $this->response->setJSON($response);
        }
    }
}
