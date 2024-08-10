<?php
namespace App\Models;

use CodeIgniter\Model;

class FeedbackModel extends Model
{
    protected $table = 'srctc_feedback';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'message','rating', 'created_at'];
}