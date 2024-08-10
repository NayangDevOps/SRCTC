<?php
namespace App\Models;

use CodeIgniter\Model;

class StationModel extends Model
{
    protected $table = 'srctc_stations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['station_name', 'created_at'];

    public function getStationData($id){
        return $this->find($id);
    }
}