<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMailStatus extends Model
{
    const MAIL_STATUS_UNREAD = 0;
    const MAIL_STATUS_SEND = 1;
    const MAIL_STATUS_READ = 2;
    const MAIL_STATUS_NOT_DELETED = 0;
    const MAIL_STATUS_DELETED = 1;
    
	protected $table = 'user_mail_status';
    protected $primaryKey = 'mail_status_id';
    public $timestamps = false;
}
