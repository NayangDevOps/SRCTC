<?php
namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'srctc_news';
    protected $primaryKey = 'id';
    protected $allowedFields = ['news_title', 'news_image', 'news_content','news_date', 'news_status', 'news_lovely_counts', 'news_happy_counts', 'news_neutral_counts', 'news_sad_counts', 'news_angry_counts'];
}