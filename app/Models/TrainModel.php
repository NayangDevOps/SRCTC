<?php
namespace App\Models;

use CodeIgniter\Model;

class TrainModel extends Model
{
    protected $table = 'srctc_train';
    protected $primaryKey = 'id';
    protected $allowedFields = ['train_code', 'train_name', 'coaches','release_date', 'rates', 'status','created_at', 'updated_at'];

    public function getTrainData($id){
        return $this->find($id);
    }
}