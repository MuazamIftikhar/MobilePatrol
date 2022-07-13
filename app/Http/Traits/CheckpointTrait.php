<?php

namespace App\Http\Traits;

use App\Models\Checkpoint;
use App\Models\CheckpointHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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



    public function save_check_point_history($admin_id,$client_id,$schedule_id,$guard_id,$checkpoint_id,$type,$date){
        $save = new CheckpointHistory();
        $save->admin_id = $admin_id;
        $save->guard_id = $guard_id;
        $save->client_id = $client_id;
        $save->schedule_id = $schedule_id;
        $save->checkpoint_id = $checkpoint_id;
        $save->type = $type;
        if ($date == ""){
            $save->date=$this->convertDateToDbFormat(Carbon::now());
        }else{
            $save->date=$this->convertDateToDbFormat($date);
        }
        $save->save();
        return $save;
    }

    public function update_check_point_history($checkpoint_history_id,$checkpoint_id,$type,$date){
        $update = CheckpointHistory::where('id',$checkpoint_history_id)->update([
            'checkpoint_id' =>$checkpoint_id,
            'type' =>$type,
            'date' => $date,
        ]);
        return $update;
    }

    public function delete_qr_report_trait($checkpoint_history_id){
        $update = CheckpointHistory::where('id',$checkpoint_history_id)->update([
            'status' => 0,
        ]);
        return $update;
    }

    public function showAllQrReportByScheduleId($schedule_id){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $check_point_history=CheckpointHistory::whereHas('admin',function ($query) use ($admin_id){
            $query->where('id',$admin_id);
        })->where('schedule_id',$schedule_id)->where('status',1)->paginate(10);
        return $check_point_history;
    }


//    public function showQrReportByGuardAndScheduleID($guard_id, $from, $to, $schedule_id){
//        $admin_id = $this->getAdminID(Auth::user()->id);
//        $check_point_history=CheckpointHistory::whereHas('admin',function ($query) use ($admin_id){
//            $query->where('id',$admin_id);
//        })->where('schedule_id',$schedule_id)->where('guard_id',$guard_id)->where('status',1)->whereBetween('date', [$from, $to])->paginate(10);
//        return $check_point_history;
//    }

    public function showAllQrReportByClientId($client_id){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $check_point_history=CheckpointHistory::whereHas('admin',function ($query) use ($admin_id){
            $query->where('id',$admin_id);
        })->where('client_id',$client_id)->where('status',1)->paginate(10);
        return $check_point_history;
    }


    public function showQrReportByGuardAndClientID($guard_id, $from, $to, $client_id){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $check_point_history=CheckpointHistory::whereHas('admin',function ($query) use ($admin_id){
            $query->where('id',$admin_id);
        })->where('client_id',$client_id)->where('guard_id',$guard_id)->where('status',1)->whereBetween('date', [$from, $to])->paginate(10);
        return $check_point_history;
    }

    public function getAllQrReportByScheduleId($schedule_id){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $check_point_history=CheckpointHistory::whereHas('admin',function ($query) use ($admin_id){
            $query->where('id',$admin_id);
        })->where('schedule_id',$schedule_id)->where('status',1)->get();
        return $check_point_history;
    }


//    public function getQrReportByGuardAndScheduleID($guard_id, $from, $to, $schedule_id){
//        $admin_id = $this->getAdminID(Auth::user()->id);
//        $check_point_history=CheckpointHistory::whereHas('admin',function ($query) use ($admin_id){
//            $query->where('id',$admin_id);
//        })->where('schedule_id',$schedule_id)->where('status',1)->where('guard_id',$guard_id)->whereBetween('date', [$from, $to])->get();
//        return $check_point_history;
//    }

    public function getAllQrReportByClientId($client_id){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $check_point_history=CheckpointHistory::whereHas('admin',function ($query) use ($admin_id){
            $query->where('id',$admin_id);
        })->where('client_id',$client_id)->where('status',1)->get();
        return $check_point_history;
    }


    public function getQrReportByGuardAndClientID($guard_id, $from, $to, $client_id){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $check_point_history=CheckpointHistory::whereHas('admin',function ($query) use ($admin_id){
            $query->where('id',$admin_id);
        })->where('client_id',$client_id)->where('status',1)->where('guard_id',$guard_id)->whereBetween('date', [$from, $to])->get();
        return $check_point_history;
    }

}
