<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMail extends Model
{
    protected $table = 'user_mail';
    protected $primaryKey = 'mail_id';
    public $timestamps = false;
}
