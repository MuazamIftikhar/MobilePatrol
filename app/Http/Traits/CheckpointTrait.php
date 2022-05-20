<?php

namespace App\Http\Traits;

use App\Models\Checkpoint;
use App\Models\CheckpointHistory;

trait CheckpointTrait {

    public function save_qr_checkpoint($admin_id,$client_id,$qr_code){
        $save = new Checkpoint();
        $save->admin_id = $admin_id;
        $save->client_id = $client_id;
        $save->qr_code = $qr_code.md5($qr_code);
        $save->checkpoint_name = $qr_code;
        $save->save();
        return $save;
    }

    public function save_check_point_history($admin_id,$client_id,$schedule_id,$guard_id,$checkpoint_id,$type){
        $save = new CheckpointHistory();
        $save->admin_id = $admin_id;
        $save->guard_id = $guard_id;
        $save->client_id = $client_id;
        $save->schedule_id = $schedule_id;
        $save->checkpoint_id = $admin_id;
        $save->type = $admin_id;
        $save->save();
        return $save;
    }
}
