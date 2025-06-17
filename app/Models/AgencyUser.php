<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AgencyUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'agency_users';
    protected $primaryKey = 'AgencyID';
    public $timestamps = true;

    protected $fillable = [
        'AgencyUserName',
        'AgencyEmail',
        'AgencyPassword',
        'AgencyContact',
        'AgencyFirstLogin',
        'RoleID',
        'MCMCID',
    ];

    protected $hidden = [
        'AgencyPassword',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(RoleUser::class, 'RoleID', 'RoleID');
    }

    public function mcmc()
    {
        return $this->belongsTo(McmcUser::class, 'MCMCID', 'MCMCID');
    }

    public function inquiryProgresses()
    {
        return $this->hasMany(InquiryProgress::class, 'AgencyID');
    }
}
