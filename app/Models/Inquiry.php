<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    /** @use HasFactory<\Database\Factories\InquiryFactory> */
    use HasFactory;

    protected $table = 'inquiries';
    protected $primaryKey = 'InquiryID';
    public $incrementing = true;
    protected $keyType = 'int';

    // Define the fillable fields
    protected $fillable = [
        'InquirySubject',
        'InquiryCategory',
        'InquiryDescription',
        'InquirySource',
        'Attachment',
        'PublicID',
    ];

    public function publicUser()
    {
        return $this->belongsTo(PublicUser::class, 'PublicID');
    }

    public function progress()
    {
        return $this->hasOne(InquiryProgress::class, 'InquiryID');
    }
}
