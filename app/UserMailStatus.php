<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMailStatus extends Model
{
    protected $table = 'user_mail_status';
    protected $primaryKey = 'mail_status_id';
    public $timestamps = false;
}
