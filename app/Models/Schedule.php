<?php

namespace App\Models;

use App\Http\Traits\CompanySettingTrait;
use App\Http\Traits\PhpFunctionsTrait;
use App\Http\Traits\ScheduleTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Schedule extends Model
{
    use HasFactory, CompanySettingTrait, PhpFunctionsTrait, ScheduleTrait;

    protected $casts = [
        'from_date_time' => 'datetime:Y-m-d H:i',
        'to_date_time' => 'datetime:Y-m-d H:i',
    ];

    public $appends = ['local_from_date_time',
        'local_to_date_time',
        'iso_local_from_date_time',
        'iso_local_to_date_time',
        'title',
        'start',
        'end',
        'class_name',
        'only_date',
        'only_hours'];

    public function guards(){
        return $this->belongsTo(Guard::class,'guard_id','id');
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function admin(){
        return $this->belongsTo(Admin::class);
    }
    //Carbon::parse($request->ShootDateTime)->timezone('America/Los_Angeles');

    public function getLocalFromDateTimeAttribute(){
        return $this->convertDateTimeToDbFormat($this->convertWithRespectToTimeZone($this->from_date_time,$this->admin_id));
    }

    public function getLocalToDateTimeAttribute(){
        return $this->convertDateTimeToDbFormat($this->convertWithRespectToTimeZone($this->to_date_time,$this->admin_id));
    }

    public function getIsoLocalFromDateTimeAttribute(){
        return $this->convertWithRespectToTimeZone($this->from_date_time,$this->admin_id);
    }

    public function getIsoLocalToDateTimeAttribute(){
        return $this->convertWithRespectToTimeZone($this->to_date_time,$this->admin_id);
    }

    public function getTitleAttribute(){
        return $this->makeTitleForCalender($this->getLocalFromDateTimeAttribute(),$this->getLocalToDateTimeAttribute(),$this->status);
    }

    public function getStartAttribute(){
        return $this->convertAndParseToISOString($this->getLocalFromDateTimeAttribute());
    }

    public function getEndAttribute(){
        return $this->convertAndParseToISOString($this->getLocalToDateTimeAttribute());
    }

    public function getClassNameAttribute(){
        return $this->makeCalenderClassColors($this->getLocalFromDateTimeAttribute(),$this->getLocalToDateTimeAttribute(),$this->status);
    }

    public function getOnlyDateAttribute(){
        return Carbon::parse($this->getIsoLocalFromDateTimeAttribute())->toFormattedDateString();
    }

    public function getOnlyHoursAttribute(){
        $total_duration = $this->getIsoLocalToDateTimeAttribute()->diffInSeconds($this->getIsoLocalFromDateTimeAttribute());
        return gmdate('H:i:s', $total_duration);
    }
}
