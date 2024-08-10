<?php

namespace App\Controllers;
use App\Models\TrainModel;
class TrainController extends BaseController
{
    private $trainModel;

    public function __construct()
    {
        $this->trainModel = new TrainModel();
    }

    public function index(){
        if ($this->request->getPost()) {
            $train_code = $this->request->getPost('train_code');
            $train_name = $this->request->getPost('train_name');
            $release_date = $this->request->getPost('release_date');
            $rate = $this->request->getPost('rate');  
            $coaches = $this->request->getPost('coaches');
            $coaches_csv = implode(', ', $coaches);
            $current_datetime = date('Y-m-d H:i:s');
            $trainData = [
                'train_code' => $train_code,
                'train_name' => $train_name,
                'rates' => $rate,
                'release_date' => $release_date,
                'coaches' => $coaches_csv,
                'created_at' => $current_datetime,
            ];
            $this->trainModel->insert($trainData);
            $successMsg = 'You have registered train successfully.';
            return redirect()->to('train_list')->with('success', $successMsg);    
        } else {
            $trains =  $this->trainModel->findAll();    
            $header['head_title'] = "Add New Train";
            echo view('header', $header);
            echo view('Train/add_train', $trains);
            echo view('footer');   
        }
    }

    public function train_list(){
        $header['head_title'] = "Train List";
        $header['header_scripts'] = [
            'public/js/dataTables/js/dataTables.min.js',
            'public/js/dataTables/js/jquery.dataTables.min.js',
            'public/js/dataTables/css/jquery.dataTables.min.css',
        ];
        echo view('header', $header);
        echo view('Train/train_list');
        echo view('footer');
    }

    function train_list_ajax(){
        $trains =  $this->trainModel->findAll();    
        echo json_encode($trains);
    }

    public function train_edit($id){
        $trainData = [];
        if ($this->request->getPost()) {
            $train_name = $this->request->getPost('train_name');
            $rate = $this->request->getPost('rate'); 
            $release_date = $this->request->getPost('release_date'); 
            $coaches = $this->request->getPost('coaches');
            $coaches_csv = implode(', ', $coaches);
            $current_datetime = date('Y-m-d H:i:s');
            $trainData = [
                'train_name' => $train_name,
                'rates' => $rate,
                'release_date' => $release_date,
                'coaches' => $coaches_csv,
                'updated_at' => $current_datetime,
            ];
            $this->trainModel->update($id, $trainData);
            $successMsg = 'You have update train successfully.';
            return redirect()->to('train_list')->with('success', $successMsg);    
        } else {
            $result['data'] = $this->trainModel->getTrainData($id);
            $header['head_title'] = "Update Train";
            echo view('header', $header);
            echo view('Train/add_train', $result);
            echo view('footer');   
        }
    }

    public function delete_train($id){
        $trainModel = new trainModel();
        $train = $trainModel->find($id);
        if (!$train) {
            return redirect()->to('train_list')->with('error', 'Train not found.');
        }
        $trainModel->delete($id);
        return redirect()->to('train_list')->with('success', 'Train deleted successfully.');
        
    }
}