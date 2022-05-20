<?php

namespace App\Http\Traits;

use App\Models\Notification;
use App\Models\Visitor;
use App\Models\VisitorImages;

trait NotificationTrait {

    public function get_all_notifications_trait($guard_id,$admin_id){
        $notifications = Notification::where('admin_id',$admin_id)->whereIn('guard_id',[0,$guard_id])->with('attachments')->get();
        return $notifications;
    }

}
