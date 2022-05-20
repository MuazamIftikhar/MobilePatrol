<?php

namespace App\Http\Traits;

trait ResponseTrait {

    public function returnWebResponse($result,$type){
        return back()->with('message',array('result' =>$result,'class' => $type));
    }

    public function returnApiResponse($status,$message,$data){
        return response()->json(array('message' => $message, 'data' => $data),$status);
    }

    public function ResponseVariables(){
        $stdVars = new \stdClass();
        $stdVars->ERROR_IMAGE_RESPONSE = "Error occurred while uploading image, We are trying to fix it.";
        $stdVars->ERROR_RESPONSE = "Regret, Something went wrong. We are trying to fix it.";
        return $stdVars;
    }
}
