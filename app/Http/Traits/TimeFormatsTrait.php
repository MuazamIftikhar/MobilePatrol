<?php

namespace App\Http\Traits;

trait TimeFormatsTrait {

    public function timeZonesList(){
        $timezone = array();
        $timestamp = time();
        foreach(timezone_identifiers_list(\DateTimeZone::ALL) as $key => $t) {
            date_default_timezone_set($t);
            $timezone[$key]['zone'] = $t;
            $timezone[$key]['GMT_difference'] =  date('P', $timestamp);
        }
        $timezone = collect($timezone)->sortBy('GMT_difference');
        return $timezone;
    }

}
