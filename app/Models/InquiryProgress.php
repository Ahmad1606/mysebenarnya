<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryProgress extends Model
{
    protected $table = 'inquiry_progress';
    protected $primaryKey = 'ProgressID';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * Fillable fields for mass assignment.
     */
    protected $fillable = [
        'ProgressResult',
        'ProgressDescription',
        'ProgressEvidence',
        'ProgressReferences',
        'Status',
        'AgencyID',
        'InquiryID',
        'MCMCID',
    ];

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'InquiryID');
    }

    public function agency()
    {
        return $this->belongsTo(AgencyUser::class, 'AgencyID');
    }

    public function mcmc()
    {
        return $this->belongsTo(McmcUser::class, 'MCMCID');
    }
}
