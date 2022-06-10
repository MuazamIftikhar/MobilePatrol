<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReportImages extends Model
{
    use HasFactory;

    public $appends = ['image_url'];

    public function getImagesAttribute($value){
        return $value != null ? config("app.image_domain").$value : '';
    }
}
