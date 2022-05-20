<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Form;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use ResponseTrait;

    public function index(Request $request){
        if(auth()->attempt($request->all())){
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            return $this->returnApiResponse('200', 'success', array('user' => auth()->user(), 'access_token' => $accessToken));
        }else{

            return $this->returnApiResponse( '401', 'warning','Login failed');
        }
    }

    public function form(){
        $form= Form::all();
        return $this->returnApiResponse('200', 'success', array('form' => $form));
    }
}
