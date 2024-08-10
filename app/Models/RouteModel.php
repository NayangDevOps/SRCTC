<?php
namespace App\Models;

use CodeIgniter\Model;

class RouteModel extends Model
{
    protected $table = 'srctc_routes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['route_train', 'route_start', 'route_end','route_stations', 'departure_time', 'arrival_time', 'avl_days', 'created_at', 'updated_at'];

    public function getRouteData($id){
        return $this->find($id);
    }

    public function getRouteIdByTrainId($trainId){
        $route = $this->where('route_train', $trainId)->first();
        if($route){
            return $route['id'];
        } else {
            return null; 
        }
    }
}