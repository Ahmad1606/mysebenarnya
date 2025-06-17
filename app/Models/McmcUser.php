<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class McmcUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'mcmc_users';
    protected $primaryKey = 'MCMCID';
    public $timestamps = true;

    protected $fillable = [
        'MCMCUserName',
        'MCMCName',
        'MCMCEmail',
        'MCMCPassword',
        'MCMCContact',
        'RoleID',
    ];

    protected $hidden = [
        'MCMCPassword',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(RoleUser::class, 'RoleID', 'RoleID');
    }

    public function agencyUsers()
    {
        return $this->hasMany(AgencyUser::class, 'MCMCID', 'MCMCID');
    }

    public function inquiryProgresses()
    {
        return $this->hasMany(InquiryProgress::class, 'MCMCID');
    }
}
