<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class McmcUser extends Authenticatable
{
    protected $table = 'mcmc_users';
    protected $primaryKey = 'MCUser_id';
    public $timestamps = true;

    protected $fillable = [
        'MCUsername',
        'MCName',
        'MCEmail',
        'MCPassword',
        'MCContact',
    ];

    protected $hidden = [
        'MCPassword',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->MCPassword;
    }

    public function agencyUsers()
    {
        return $this->hasMany(AgencyUser::class, 'MCMCID');
    }
}
