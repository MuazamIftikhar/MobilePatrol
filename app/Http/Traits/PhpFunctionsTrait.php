<?php

namespace App\Http\Traits;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait PhpFunctionsTrait {

    public function removeSlashAndUpperCaseFirstLetter($variable){
        return ucfirst(str_replace('_',' ',$variable));
    }

    public function returnAuthUserAdminID($user_id){
        return User::findOrFail($user_id)->isAdmin->id;
    }

    public function checkHash($value,$hash){
        if(md5($value) == $hash){
            return true;
        }else{
            return false;
        }
    }

    public function convertHtmlDateTimeToDbFormat($datetime,$timezone){
        return Carbon::parse($datetime, $timezone)->setTimezone('UTC')->format('Y-m-d H:i');
    }
    public function convertDateTimeToDbFormat($datetime){
        return Carbon::parse($datetime)->format('Y-m-d H:i');
    }
    public function convertDateToDbFormat($date){
        return Carbon::parse($date)->format('Y-m-d');
    }
    public function convertDateTimeToDbFormatPlus1($datetime){
        return Carbon::parse($datetime)->addMinute(1)->format('Y-m-d H:i');
    }

    public function makeTitleForCalender($from_time,$to_time,$status){
        $title  = Carbon::parse($from_time)->format('H:i')." - ".Carbon::parse($to_time)->format('H:i');
        return $status == 0 ? $title." (Deleted)" :$title;
    }
    public function convertAndParseToISOString($date){
        $dateC = Carbon::parse($date)->toDateString();
        $time = Carbon::parse($date)->format('H:i');
        return $dateC.'T'.$time;
    }

    public function convertDateTimeToReadableDayTimeFormat($datetime){
        $readableDay =  Carbon::parse($datetime)->toFormattedDateString();
        $readabletime =  Carbon::parse($datetime)->format('H:i');

        return $readableDay." ".$readabletime;
    }

}
