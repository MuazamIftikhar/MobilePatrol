<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuardAvailable extends Model
{
    use HasFactory;

    public function guards(){
        return $this->belongsTo(Guard::class);
    }
}
