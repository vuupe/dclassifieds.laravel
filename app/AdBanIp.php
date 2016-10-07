<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdBanIp extends Model
{
    protected $table        = 'ad_ban_ip';
    protected $primaryKey   = 'ban_ip_id';
    protected $fillable     = ['ban_ip'];
    public $timestamps      = false;
}
