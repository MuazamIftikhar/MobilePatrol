<?php

namespace App\Models;

use App\Http\Traits\PhpFunctionsTrait;
use App\Http\Traits\ScheduleTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory,PhpFunctionsTrait,ScheduleTrait;
    public $appends = ['local_date'];

    public function getLocalDateAttribute(){
        if($this->created_at != null) {
            return $this->convertDateTimeToDbFormat($this->convertWithRespectToTimeZone($this->created_at, $this->admin_id));
        }else{
            return NULL;
        }
    }

    public function guards(){
        return $this->belongsTo(Guard::class,'guard_id','id');
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }
    public function incident_report_images(){
        return $this->hasMany(IncidentImages::class);
    }
}
