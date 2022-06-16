<?php

namespace App\Http\Traits;

use App\Models\Yard;

trait YardTrait {

        public function save_yard_report_trait($guard_id, $client_id, $schedule_id, $admin_id,
                        $yard_name, $yard_number){
            $save=new Yard();
            $save->guard_id=$guard_id;
            $save->client_id=$client_id;
            $save->schedule_id=$schedule_id;
            $save->admin_id=$admin_id;
            $save->yard_name=$yard_name;
            $save->yard_number=$yard_number;
            $save->save();
            return $save;
        }
}
