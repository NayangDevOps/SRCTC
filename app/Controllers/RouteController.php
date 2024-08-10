<?php
namespace App\Controllers;
use App\Models\TrainModel;
use App\Models\RouteModel;
use App\Models\StationModel;
use App\Models\RoutetariffModel;
class RouteController extends BaseController
{
    private $TrainModel;
    private $routeModel;
    private $StationModel;
    private $tariffModel;

    public function __construct()
    {
        $this->routeModel = new RouteModel();
        $this->TrainModel = new TrainModel();
        $this->StationModel = new StationModel();
        $this->tariffModel = new RoutetariffModel();
    }

    public function index(){
        if ($this->request->getPost()) {
            $train_id = $this->request->getPost('train_id');
            $start_point = $this->request->getPost('start_point');
            $end_point = $this->request->getPost('end_point');
            $route_station = $this->request->getPost('route_station');
            $departure_time = $this->request->getPost('departure_time');
            $arrival_time = $this->request->getPost('arrival_time');
            $avl_days = $this->request->getPost('avl_days');
            $avl_days_string = '';
            if(is_array($avl_days)) {
                $avl_days_string = implode(',', $avl_days);
            }            
            $new_route_station = array(); 
            if(is_array($route_station)) {
                foreach ($route_station as $station) {
                    $parts = explode('-', $station);                
                    if (count($parts) === 2) {
                        $new_route_station[] = $parts[0] . ',' . $parts[1];
                    }
                }
            }
            $current_datetime = date('Y-m-d H:i:s');
            $new_route_station_combined = implode('|', $new_route_station);
            $routeData = [
                'route_train' => $train_id,
                'route_start' => $start_point,
                'route_end' => $end_point,
                'route_stations' => $new_route_station_combined,
                'departure_time' => $departure_time,
                'arrival_time' => $arrival_time,
                'avl_days' => $avl_days_string,
                'created_at' => $current_datetime,
            ];
            $this->routeModel->insert($routeData);
            $updatedData = [
                'status' => 1
            ];
            $this->TrainModel->update($train_id, $updatedData);
            $lastInsertID = $this->routeModel->getInsertID();
            $defaultRate = train_details($train_id);
            if(is_array($new_route_station)) {
                foreach ($new_route_station as $routeStation) {
                    $tariffData = [
                        'route_id' => $lastInsertID,
                        'sub_routes' => $routeStation,
                        'route_default_rate_pkm' => $defaultRate['rates'],                        
                    ];
                    $this->tariffModel->insert($tariffData);
                }
            }
            $successMsg = 'You have enter route successfully.';
            return redirect()->to('route_list')->with('success', $successMsg);    
        } else {
            $data['trains'] = $this->TrainModel->where('status', 0)->findAll(); 
            $data['stations'] = $this->StationModel->findAll(); 
            $header['head_title'] = "Add New Route";
            echo view('header', $header);
            echo view('Route/add_route', $data);
            echo view('footer');   
        }
    }

    public function route_list(){
        $header['head_title'] = "Route List";
        $header['header_scripts'] = [
            'public/js/dataTables/js/dataTables.min.js',
            'public/js/dataTables/js/jquery.dataTables.min.js',
            'public/js/dataTables/css/jquery.dataTables.min.css',
        ];
        echo view('header', $header);
        echo view('Route/route_list');
        echo view('footer');
    }

    function route_list_ajax(){
        $routes = $this->routeModel->findAll();   
        foreach ($routes as &$route) {
            $trainDetails = train_details($route['route_train']);
            $route['train_name'] = $trainDetails['train_code'] . ' - ' . $trainDetails['train_name'];
            $route['startPoint'] = getStation($route['route_start']);
            $route['endPoint'] = getStation($route['route_end']); 
            $stationPairs = explode('|', $route['route_stations']);
            $stations = [];
            foreach($stationPairs as $pair){
                list($start, $end) = explode(',', $pair);
                $stations[] = getStation($start) . ' - ' . getStation($end);
            }
            $route['stations'] = $stations;
        }
        echo json_encode($routes);
    }

    public function route_edit($id){
        $routeData = [];
        if ($this->request->getPost()) {
            $train_id = $this->request->getPost('train_id');
            $start_point = $this->request->getPost('start_point');
            $end_point = $this->request->getPost('end_point');
            $route_station = $this->request->getPost('route_station');
            $departure_time = $this->request->getPost('departure_time');
            $arrival_time = $this->request->getPost('arrival_time');
            $avl_days = $this->request->getPost('avl_days');
            $old_train_id = $this->request->getPost('old_train_id');
            $avl_days_string = '';
            if(is_array($avl_days)) {
                $avl_days_string = implode(',', $avl_days);
            }            
            $new_route_station = array(); 
            if(is_array($route_station)) {
                foreach ($route_station as $station) {
                    $parts = explode('-', $station);                
                    if (count($parts) === 2) {
                        $new_route_station[] = $parts[0] . ',' . $parts[1];
                    }
                }
            }
            $current_datetime = date('Y-m-d H:i:s');
            $new_route_station_combined = implode('|', $new_route_station);
            $routeData = [
                'route_train' => $train_id,
                'route_start' => $start_point,
                'route_end' => $end_point,
                'route_stations' => $new_route_station_combined,
                'departure_time' => $departure_time,
                'arrival_time' => $arrival_time,
                'avl_days' => $avl_days_string,
                'created_at' => $current_datetime,
            ];
            $this->routeModel->update($id, $routeData);
            $updated = [
                'status' => 0
            ];
            $this->TrainModel->update($old_train_id, $updated);
            $updatedData = [
                'status' => 1
            ];
            $routeTariffModel = new RoutetariffModel();
            $routeTariffModel->where('route_id', $id)->delete();
            $defaultRate = train_details($train_id);
            if(is_array($new_route_station)) {
                foreach ($new_route_station as $routeStation) {
                    $tariffData = [
                        'route_id' => $id,
                        'sub_routes' => $routeStation,
                        'route_default_rate_pkm' => $defaultRate['rates'],                        
                    ];
                    $this->tariffModel->insert($tariffData);
                }
            }
            $this->TrainModel->update($train_id, $updatedData);
            $successMsg = 'You have updated route successfully.';
            return redirect()->to('route_list')->with('success', $successMsg);    
        } else {
            $data['trains'] = $this->TrainModel->findAll(); 
            $data['stations'] = $this->StationModel->findAll(); 
            $data['data'] = $this->routeModel->getRouteData($id);
            $header['head_title'] = "Update Route";
            echo view('header', $header);
            echo view('Route/add_route', $data);
            echo view('footer');   
        }
    }

    public function delete_route($id){
        $trainModel = new RouteModel();
        $train = $trainModel->find($id);
        $this->tariffModel->deleteByRouteId($id);
        $data = $this->routeModel->getRouteData($id);
        $old_train_id = $data['route_train'];
        $updated = [
            'status' => 0,
        ];
        $this->TrainModel->update($old_train_id, $updated);
        if (!$train) {
            return redirect()->to('route_list')->with('error', 'Route not found.');
        }
        $trainModel->delete($id);
        return redirect()->to('route_list')->with('success', 'Route deleted successfully.');
    }
}