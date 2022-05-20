<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountsTrait;
use App\Http\Traits\ClientTrait;
use App\Http\Traits\CompanySettingTrait;
use App\Http\Traits\PhpFunctionsTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    //
    use CompanySettingTrait, ResponseTrait, AccountsTrait, ClientTrait, PhpFunctionsTrait;

    public function create_client(){
        return view('manager.client.create')->with('title','Create Client');
    }

    public function save_client(Request $request){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $this->validate($request, [
            'client_name' => ['required', 'string', 'max:255'],
            'client_email' => 'required|string|email|max:255',
            'client_phone' => ['required', 'string','unique:clients'],
            'client_address' => ['required', 'string'],
        ]);

        try{
            if($this->check_email_duplication_for_save_in_user_table($request->client_email)) {
                $user = $this->create_account_in_user($request->client_name, $request->client_email, $request->client_phone);
                $this->attach_role_to_user($user, 4);
                $this->save_as_client($admin_id,$user->id,$request->client_name, $request->client_email,$request->client_address,$request->client_phone);
                return $this->returnWebResponse('Client created successfully', 'success');
            }else {
                return $this->returnWebResponse('Someone with this email already present', 'warning');
            }
        }catch(\Exception $e){
            return $this->returnWebResponse($e->getMessage(), 'danger');
        }
    }

    public function manage_clients(){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $clients = Client::whereHas('admin',function ($query) use ($admin_id){
            $query->where('admin_id',$admin_id);
        })->with(array('admin','user'))->paginate(15);
        return view('manager.client.manage',compact('clients'))->with('title','Manage Clients');
    }

    public function edit_client(Request $request){
        if($this->checkHash($request->client_id,$request->hash)) {
            $client = Client::where('id', $request->client_id)->first();
            return view('manager.client.edit',compact('client'))->with('title','Edit Client');
        }else{
            return $this->returnWebResponse('Something went wrong', 'warning');
        }
    }

    public function update_client(Request $request){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $client = Client::where('id',$request->client_id)->first();
        $this->validate($request, [
            'client_name' => ['required', 'string', 'max:255'],
            'client_email' => 'required|string|email|max:255',
            'client_phone' => ['required', 'string','unique:clients'],
            'client_address' => ['required', 'string'],
        ]);

        try{
            if($this->check_email_duplication_for_update_in_user_table($request->client_email,$client->user_id)) {
                $this->update_account_in_user($client->user_id,$request->client_name, $request->client_email);
                $this->update_as_client($client->id,$request->client_name, $request->client_email,$request->client_address,$request->client_phone);
                return $this->returnWebResponse('Client updated successfully', 'success');
            }else {
                return $this->returnWebResponse('Someone with this email already present', 'warning');
            }
        }catch(\Exception $e){
            return $this->returnWebResponse($e->getMessage(), 'danger');
        }
    }
}
