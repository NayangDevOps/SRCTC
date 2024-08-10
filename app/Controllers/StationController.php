<?php

namespace App\Controllers;
use App\Models\StationModel;

class StationController extends BaseController
{
        private $StationModel;

        public function __construct()
        {
            $this->StationModel = new StationModel();
        }

    public function index(){
            if ($this->request->getPost()) {
                    $StationData = [
                        'station_name' => $this->request->getVar('station_name'),
                        'created_at' => date("Y-m-d H:i:s"),
                    ];
                    $this->StationModel->insert($StationData);
                    $successMsg = 'Station inserted successfully.';
                    return redirect()->to('stations')->with('success', $successMsg);    
            } else {
                $header['head_title'] = "Add Station";
                echo view('header', $header);
                echo view('add_station');
                echo view('footer');
            }
    }

    public function stations(){
        $header['head_title'] = "Stations List";
        $header['header_scripts'] = [
            'public/js/dataTables/js/dataTables.min.js',
            'public/js/dataTables/js/jquery.dataTables.min.js',
            'public/js/dataTables/css/jquery.dataTables.min.css',
        ];
        echo view('header', $header);
        echo view('station_list');
        echo view('footer');
    }

    public function station_list_ajax(){
        $station =  $this->StationModel->findAll();    
        echo json_encode($station);
    }

    public function edit_station() {
        $id = $this->request->getPost('station_id');
        $station_name = $this->request->getPost('station_name');
            $station_name = $this->request->getPost('station_name');
            $stationData = [
                'station_name' => $station_name,
            ];
            $this->StationModel->update($id, $stationData);
            $response = [
                'success' => true,
                'message' => 'Station updated successfully.',
            ];
            return $this->response->setJSON($response);
    }  

    public function delete_station($id) 
    {
        $StationModel = new StationModel();
        $station = $StationModel->find($id);
        if (!$station) {
            return redirect()->to('stations')->with('error', 'User not found.');
        }
        $StationModel->delete($id);
        return redirect()->to('stations')->with('success', 'Station deleted successfully.');
    }
}