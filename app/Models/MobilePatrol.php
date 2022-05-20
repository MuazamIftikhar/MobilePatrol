<?php

namespace App\Models;

use App\Http\Traits\AttendanceTrait;
use App\Http\Traits\ScheduleTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobilePatrol extends Model
{
    use HasFactory, AttendanceTrait, ScheduleTrait;

    public $appends = ['local_time'];

    public function guards(){
        return $this->belongsTo(Guard::class,'guard_id','id');
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function mobile_patrol_reports(){
        return $this->hasMany(MobilePatrolReport::class);
    }

    public function getLocalTimeAttribute(){
        if($this->created_at != null) {
            return $this->convertDateTimeToDbFormat($this->convertWithRespectToTimeZone(Carbon::parse($this->created_at)->toDateTimeString(), $this->admin_id));
        }else{
            return null;
        }
    }
}
