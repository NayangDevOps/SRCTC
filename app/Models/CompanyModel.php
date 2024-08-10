<?php
namespace App\Models;

use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table = 'srctc_company_setting';
    protected $primaryKey = 'id';
    protected $allowedFields = ['company_name', 'company_banner', 'company_header_logo', 'company_welcome_page_image', 'updated_by', 'updated_time'];

}