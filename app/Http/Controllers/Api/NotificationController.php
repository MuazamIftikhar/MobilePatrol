<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountsTrait;
use App\Http\Traits\ImageUplaodTrait;
use App\Http\Traits\NotificationTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    use  AccountsTrait, ImageUplaodTrait, ResponseTrait, NotificationTrait;
    public function get_all_notifications(Request $request){
        try{
            $guard=$this->get_guard_table_row($request->user()->id);
            $notifications = $this->get_all_notifications_trait($guard->id,$guard->admin_id);
            return $this->returnApiResponse(200, 'success', array('response' => 'Notifications fetched Successfully','notifications' => $notifications));
        }catch(\Exception $e){
            return $this->returnApiResponse(401,'danger',array('error'=>$e->getMessage()));
        }
    }
}
