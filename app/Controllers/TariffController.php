<?php

namespace App\Controllers;
use App\Models\RoutetariffModel;
use App\Models\TrainModel;

class TariffController extends BaseController
{
    private $TrainModel;
    private $RoutetariffModel;

    public function __construct()
    {
        $this->TrainModel = new TrainModel();
        $this->RoutetariffModel = new RoutetariffModel();
    }
    
    public function index() 
    {
        if ($this->request->getPost()) {
            $fromStationArray = $this->request->getVar('station_from');
            $toStationArray = $this->request->getVar('station_to');
            $routeKmArray = $this->request->getVar('route_km');
            $routeRatesPkmArray = $this->request->getVar('route_rates_pkm');
            $hiddenIDArray = $this->request->getVar('hiddenID');  
            $gstRate = $this->request->getVar('gstRate'); 
            if (!empty($routeKmArray) && !empty($routeRatesPkmArray) && !empty($hiddenIDArray)
                && count($routeKmArray) === count($routeRatesPkmArray) && count($routeKmArray) === count($hiddenIDArray)) {
                foreach ($hiddenIDArray as $key => $hiddenID) {
                    $tariffData = [
                        'id' => $hiddenID,
                        'route_km' => $routeKmArray[$key],
                        'route_rates' => $routeRatesPkmArray[$key],
                    ];
                    $this->RoutetariffModel->update($hiddenID, $tariffData);
                }                
                $updatedPrices = [];                   
                foreach ($routeRatesPkmArray as $key => $rate) {
                    $finalRate = $rate * (1 + $gstRate);
                    $childPrice = $finalRate * 0.5;
                    $seniorPrice = $finalRate * 0.8;
                    $updatedPrices[] = [
                        'from_station' => $fromStationArray[$key],
                        'to_station' => $toStationArray[$key],
                        'adult_price' => $finalRate,
                        'child_price' => $childPrice,
                        'senior_price' => $seniorPrice,
                        'id' => $hiddenIDArray[$key],
                    ];
                }
                $response = [
                    'status' => 'success',
                    'updatedPrices' => $updatedPrices
                ];    
                return $this->response->setJSON($response);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Empty or invalid data arrays']);
            }
        } else {
            $data['trains'] = $this->TrainModel->findAll();                     
            $header['head_title'] = "Add Tariff"; 
            echo view('header', $header);
            echo view('Tariff/add_tariff', $data);
            echo view('footer');
        }
    }   
    
    public function save_price()
    {
        if ($this->request->getPost()) {
            $updatedPrices = $this->request->getVar('updatedPrices');
            if (!empty($updatedPrices)) {
                foreach ($updatedPrices as $priceData) {
                    $id = $priceData['id'];                    
                    $adult_price = $priceData['adult_price'];
                    $child_price = $priceData['child_price'];
                    $senior_price = $priceData['senior_price'];
                    $tariffData = [
                        'adult_price' => $adult_price,
                        'child_price' => $child_price,
                        'senior_price' => $senior_price,
                    ];
                    $this->RoutetariffModel->update($id, $tariffData);
                }
                $session = session();
                $session->setFlashdata('success', 'Prices saved successfully.');
                echo json_encode(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'No data to update']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }
    }

    public function tariffs(){
        $header['head_title'] = "Tariff List";
        $header['header_scripts'] = [
            'public/js/dataTables/js/dataTables.min.js',
            'public/js/dataTables/js/jquery.dataTables.min.js',
            'public/js/dataTables/css/jquery.dataTables.min.css',
        ];
        echo view('header', $header);
        echo view('Tariff/tariff_list');
        echo view('footer');
    }

    public function tariff_list_ajax() {
        $tariffs = $this->RoutetariffModel->findAll();   
        foreach ($tariffs as &$tariff) {
            $tariff['train_name'] = getTrainByRoute($tariff['route_id']);
            $sub_routes = explode(',', $tariff['sub_routes']);
            $combined_stations = [];
            foreach ($sub_routes as $route) {
                $station_name = getStation($route);
                $combined_stations[] = $station_name;
            }
            $tariff['routes_station_name'] = implode(' - ', $combined_stations);
        }
        echo json_encode($tariffs);
    }       

    public function edit_tariff($id) {
        if ($this->request->getPost()) {
            $fromStationArray = $this->request->getVar('station_from');
            $toStationArray = $this->request->getVar('station_to');
            $routeKmArray = $this->request->getVar('route_km');
            $routeRatesPkmArray = $this->request->getVar('route_rates_pkm');
            $hiddenIDArray = $this->request->getVar('hiddenID');  
            $gstRate = $this->request->getVar('gstRate'); 
            if (!empty($routeKmArray) && !empty($routeRatesPkmArray) && !empty($hiddenIDArray)
                && count($routeKmArray) === count($routeRatesPkmArray) && count($routeKmArray) === count($hiddenIDArray)) {
                foreach ($hiddenIDArray as $key => $hiddenID) {
                    $tariffData = [
                        'id' => $hiddenID,
                        'route_km' => $routeKmArray[$key],
                        'route_rates' => $routeRatesPkmArray[$key],
                    ];
                    $this->RoutetariffModel->update($hiddenID, $tariffData);
                }                
                $updatedPrices = [];                   
                foreach ($routeRatesPkmArray as $key => $rate) {
                    $finalRate = $rate * (1 + $gstRate);
                    $childPrice = $finalRate * 0.5;
                    $seniorPrice = $finalRate * 0.8;
                    $updatedPrices[] = [
                        'from_station' => $fromStationArray[$key],
                        'to_station' => $toStationArray[$key],
                        'adult_price' => $finalRate,
                        'child_price' => $childPrice,
                        'senior_price' => $seniorPrice,
                        'id' => $hiddenIDArray[$key],
                    ];
                }
                $response = [
                    'status' => 'success',
                    'updatedPrices' => $updatedPrices
                ];    
                return $this->response->setJSON($response);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Empty or invalid data arrays']);
            }
        } else {
            $data['trains'] = $this->TrainModel->findAll();                     
            $data['data'] = $this->RoutetariffModel->find($id);            
            $header['head_title'] = "Update Tariff";
            echo view('header', $header);
            echo view('Tariff/edit_tariff', $data);
            echo view('footer');   
        }
    }  

    public function delete_tariffs($id) 
    {        
        $tariff = $this->RoutetariffModel->find($id);
        if (!$tariff) {
            return redirect()->to('tariffs')->with('error', 'Tariff not found.');
        }
        $this->RoutetariffModel->delete($id);
        return redirect()->to('tariffs')->with('success', 'Tariff deleted successfully.');
    }

    public function fetch_data()
    {
        $id = $this->request->getPost('train_id');
        $StationModel = new RoutetariffModel();
        $stations = $StationModel->where('route_id', $id)->findAll();
        $data = [];
        foreach ($stations as $station) {
            $subRoutes = explode(',', $station['sub_routes']);
            $stationNames = [];
            foreach ($subRoutes as $subRoute) {
                $stationNames[] = getStation($subRoute);
            }
            $station['station_names'] = implode(' - ', $stationNames);
            $data[] = $station;
        }
        return $this->response->setJSON($data);
    }
    
}