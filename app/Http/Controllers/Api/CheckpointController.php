<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountsTrait;
use App\Http\Traits\AttendanceTrait;
use App\Http\Traits\CheckpointTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Checkpoint;
use App\Models\CheckpointHistory;
use Illuminate\Http\Request;

class CheckpointController extends Controller
{
    //
    use AttendanceTrait,ResponseTrait,AccountsTrait,CheckpointTrait;
    public function save_history_checkpoint(Request $request){
//        Params, client_id,qr_code,type,schedule_id
        $guard=$this->get_guard_table_row($request->user()->id);
        $checkIfThisQrCodeIsAssociatedWithClient = Checkpoint::where('client_id',$request->client_id)
            ->where('admin_id',$guard->admin_id)
            ->where('qr_code',$request->qr_code)
            ->first();
        if($checkIfThisQrCodeIsAssociatedWithClient){
            $this->save_check_point_history($guard->admin_id,$request->client_id,$request->schedule_id,$guard->id,$checkIfThisQrCodeIsAssociatedWithClient->id,$request->type);
            return $this->returnApiResponse(200, 'success', array('response' => 'Qr Code scanned successfully'));
        }else{
            return $this->returnApiResponse(401, 'danger', array('response' => 'Invalid Qr Code'));
        }
    }

    public function get_qrcode_history(Request $request){
        $guard=$this->get_guard_table_row($request->user()->id);
        $checkpointHistory = CheckpointHistory::with('checkpoint','client')
            ->where('schedule_id',$request->schedule_id)
            ->where('guard_id',$guard->id)
            ->get();
        return $this->returnApiResponse(200, 'success',
            array('response' => 'Qr Code history fetched successfully','checkpoint_history' => $checkpointHistory));
    }

}
