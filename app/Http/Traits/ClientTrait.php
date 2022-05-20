<?php

namespace App\Http\Traits;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;

trait ClientTrait {

    public function save_as_client($admin_id,$user_id,$client_name,$client_email,$client_address,$client_phone){
        $save = new Client();
        $save->admin_id = $admin_id;
        $save->user_id = $user_id;
        $save->client_name = $client_name;
        $save->client_email = $client_email;
        $save->client_address = $client_address;
        $save->client_phone = $client_phone;
        $save->save();
        return $save;
    }

    public function update_as_client($client_id,$client_name,$client_email,$client_address,$client_phone){
        $update = Client::where('id',$client_id)->update([
         'client_name' => $client_name,
        'client_email' => $client_email,
        'client_address'=> $client_address,
        'client_phone' => $client_phone,
        ]);
    }

    public function showAdminClient(){
            $admin_id = $this->getAdminID(Auth::user()->id);
            $clients = Client::whereHas('admin',function ($query) use ($admin_id){
                $query->where('admin_id',$admin_id);
            })->with(array('admin','user'))->paginate(15);
            return $clients;
    }

    //Get admin clients without pagination.
    public function getAdminClient(){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $clients = Client::where('admin_id',$admin_id)->get();
        return $clients;
    }
}
