<?php
namespace App\Models;

use CodeIgniter\Model;

class RoutetariffModel extends Model
{
    protected $table = 'srctc_tariff_routes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['route_id', 'sub_routes', 'route_km','route_rates','adult_price','child_price','senior_price','route_default_rate_pkm'];

    public function deleteByRouteId($routeId){
        return $this->where('route_id', $routeId)->delete();

    }

    public function getBookings($fromStation, $toStation)
    {
        $this->select('*');
        $this->like('sub_routes', "$fromStation,$toStation");
        $query = $this->get();
        return $query->getResultArray();
    }
}