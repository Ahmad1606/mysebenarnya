<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_users';     // Matches your table name
    protected $primaryKey = 'RoleID';    // Matches your PK column
    public $timestamps = true;           // Because you used $table->timestamps()

    protected $fillable = [
        'RoleName'
    ];

    // Optional: Define relationships (if needed later)
    public function publicUsers()
    {
        return $this->hasMany(PublicUser::class, 'RoleID', 'RoleID');
    }

    public function agencyUsers()
    {
        return $this->hasMany(AgencyUser::class, 'RoleID', 'RoleID');
    }

    public function mcmcUsers()
    {
        return $this->hasMany(McmcUser::class, 'RoleID', 'RoleID');
    }
}
