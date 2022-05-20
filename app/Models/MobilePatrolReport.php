<?php

namespace App\Models;

use App\Http\Traits\AttendanceTrait;
use App\Http\Traits\ScheduleTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobilePatrolReport extends Model
{
    use HasFactory, AttendanceTrait, ScheduleTrait;

    public $appends = ['local_time','has_images'];

    public function getLocalTimeAttribute(){
        if($this->date != null) {
            return $this->convertDateTimeToDbFormat($this->convertWithRespectToTimeZone(Carbon::parse($this->date)->toDateTimeString(), $this->admin_id));
        }else{
            return null;
        }
    }

    public function mobile_patrol_report_images(){
        return $this->hasMany(MobilePatrolReportImages::class);
    }
    public function guards(){
        return $this->belongsTo(Guard::class,'guard_id','id');
    }

    public function getHasImagesAttribute(){
        return count($this->mobile_patrol_report_images()->get()) > 0 ? true : false;
    }
}
