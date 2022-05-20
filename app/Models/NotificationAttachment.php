<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationAttachment extends Model
{
    use HasFactory;

    public $appends = ['attachment_url'];

    public function getAttachmentUrlAttribute(){
        if($this->attachment == null){
            return "";
        }
        return "https://square.cybermeteors.com/root/".$this->attachment;
    }
}
