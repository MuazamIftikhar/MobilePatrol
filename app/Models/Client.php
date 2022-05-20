<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function checkpoints(){
        return $this->hasMany(Checkpoint::class);
    }

    public function schedule(){
        return $this->hasMany(Schedule::class);
    }
}
