<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageUplaodTrait {

    public function uploadImage($image){
        // Get filename with the extension
        //get filename with extension
        try {
            $filenamewithextension = $image->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $image->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename . '_' . uniqid() . '.' . $extension;

            //Upload File to external server
            Storage::disk('ftp')->put($filenametostore, fopen($image, 'r+'));

            //Store $filenametostore in the database
            return $filenametostore;
        }catch (\Exception $e){
            return $e;
        }
    }
}
