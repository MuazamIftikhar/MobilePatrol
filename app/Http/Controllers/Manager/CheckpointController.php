<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Traits\CheckpointTrait;
use App\Http\Traits\CompanySettingTrait;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\ScheduleTrait;
use App\Models\Checkpoint;
use App\Models\Client;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckpointController extends Controller
{
    //
    use CompanySettingTrait, ResponseTrait, CheckpointTrait , ScheduleTrait;

    public function client_checkpoints(Request $request){
        $checkpoints = Checkpoint::with(array('client'))->where('client_id',$request->client_id)->paginate(15);
        return view('manager.client.checkpoint.index',compact('checkpoints'))->with('title','Manage Checkpoints');
    }

    public function create_qr_checkpoint(Request $request){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $this->validate($request, [
            'qr_code' => ['required', 'string', 'max:255'],
        ]);
        try{
            $save_checkpoint = $this->save_qr_checkpoint($admin_id,$request->client_id,$request->qr_code);
            return $this->returnWebResponse('Checkpoint QR created successfully', 'success');
        }catch (\Exception $e) {
            return $this->returnWebResponse($e->getMessage(), 'danger');
        }
    }

    public function print_qr_single(Request $request){
        $checkpoint= Checkpoint::where('id','=',$request->id)->first();

        $fileName=$checkpoint->checkpoint_name;

        $pdf = PDF::loadView('manager.client.QR.single_qr_print', compact('checkpoint'));
        return $pdf->download($fileName.'.pdf');
    }

    public function create_qr_report(Request $request){
        $schedule = $this->getFirstSchedule($request->schedule_id);
        $admin_id = $this->getAdminID(Auth::user()->id);
        $checkpoint=Checkpoint::where('admin_id',$admin_id)->where('client_id',$schedule->client_id)->get();
        return view('manager.report.custom.checkpoint.create', ['schedule' => $schedule,'checkpoint'=>$checkpoint])->with('title', 'Create QR Report');
    }
}
