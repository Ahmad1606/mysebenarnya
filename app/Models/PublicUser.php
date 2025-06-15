<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class PublicUser extends Authenticatable
{
    protected $table = 'public_users';
    protected $primaryKey = 'PubUser_id';
    public $timestamps = true;

    protected $fillable = [
        'PubName',
        'PubEmail',
        'PubPassword',
        'PubContact',
        'PubStatusVerify',
    ];

    protected $hidden = [
        'PubPassword',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->PubPassword;
    }
}
