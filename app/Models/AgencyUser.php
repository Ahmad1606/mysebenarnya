<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AgencyUser extends Authenticatable
{
    protected $table = 'agency_users';
    protected $primaryKey = 'AgenUser_id';
    public $timestamps = true;

    protected $fillable = [
        'AgenUsername',
        'AgenName',
        'AgenEmail',
        'AgenPassword',
        'AgenContact',
        'AgenFirstLogin',
        'MCMCID',
    ];

    protected $hidden = [
        'AgenPassword',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->AgenPassword;
    }

    public function mcmcUser()
    {
        return $this->belongsTo(McmcUser::class, 'MCMCID');
    }
}
