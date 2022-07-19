<?php

namespace App\Http\Controllers;

use App\Http\Traits\AccountsTrait;
use App\Http\Traits\CompanySettingTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    use AccountsTrait,ResponseTrait,CompanySettingTrait;
    //
    public function index(){
        return view('managers.create')->with('title','Create Manager Account');
    }

    public function save_manager_account(Request $request){
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|string|email|max:255',
            'password' => ['required', 'string', 'min:8'],
            'account_valid_till' => ['required','date']
        ]);
        try{
            if($this->check_email_duplication_for_save_in_user_table($request->email)){
                $user = $this->create_account_in_user($request->name,$request->email,$request->password);
                $this->attach_role_to_user($user,2);
                $admin = $this->save_as_admin($user->id,$request->name,$request->email,$request->phone);
                return $this->returnWebResponse('Manager created successfully', 'success');
            }else {
                return $this->returnWebResponse('Someone with this email already present', 'warning');
            }
        }catch(\Exception $e){
            return $this->returnWebResponse($e->getMessage(),'danger');
        }
    }

    public function manage_manager_account(Request $request){
        $managers = User::role('manager')->get();
        return view('managers.manage',compact('managers'))->with('title','Manage Manager Account');
    }
}
