<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdBanEmail extends Model
{
    protected $table        = 'ad_ban_email';
    protected $primaryKey   = 'ban_email_id';
    protected $fillable     = ['ban_email'];
    public $timestamps      = false;
}
