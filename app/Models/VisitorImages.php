<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorImages extends Model
{
    use HasFactory;

    public function getImagesAttribute($value){
        return $value != null ? config("app.image_domain").$value : '';
    }
}
