<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class PublicUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'public_users';
    protected $primaryKey = 'PublicID';
    public $timestamps = true;

    protected $fillable = [
        'PublicName',
        'PublicEmail',
        'PublicPassword',
        'PublicContact',
        'PublicStatusVerify',
        'RoleID',
    ];

    protected $hidden = [
        'PublicPassword',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(RoleUser::class, 'RoleID', 'RoleID');
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class, 'PublicID');
    }

    public function allInquiryProgresses()
    {
        return $this->inquiries->flatMap(function ($inquiry) {
            return $inquiry->progress;
        });
    }

}
