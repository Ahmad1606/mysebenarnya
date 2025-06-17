<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inquiry;

class InquirySeeder extends Seeder
{
    public function run(): void
    {
        Inquiry::insert([
            [
                'InquirySubject' => 'Scam Call Report',
                'InquiryCategory' => 'Telecommunication Fraud',
                'InquiryDescription' => 'Received fake call claiming to be from LHDN.',
                'InquirySource' => 'Phone Call',
                'Attachment' => 'scam1.pdf',
                'PublicID' => 1
            ],
            [
                'InquirySubject' => 'Fake Investment App',
                'InquiryCategory' => 'Financial Scam',
                'InquiryDescription' => 'App asking for crypto wallet access.',
                'InquirySource' => 'Social Media',
                'Attachment' => 'scam2.jpg',
                'PublicID' => 2
            ]
        ]);
    }
}
