<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InquiryProgress;

class InquiryProgressSeeder extends Seeder
{
    public function run(): void
    {
        InquiryProgress::insert([
            [
                'ProgressResult' => 'Verified',
                'ProgressDescription' => 'Inquiry verified and handed to BNM.',
                'ProgressEvidence' => 'bnm_report.pdf',
                'ProgressReferences' => 'BNM/2025/001',
                'AgencyID' => 1,
                'InquiryID' => 1,
                'MCMCID' => 1
            ],
            [
                'ProgressResult' => 'Rejected',
                'ProgressDescription' => 'Insufficient documentation.',
                'ProgressEvidence' => 'note.pdf',
                'ProgressReferences' => 'AGENCY/2025/REJ01',
                'AgencyID' => 2,
                'InquiryID' => 2,
                'MCMCID' => 2
            ]
        ]);
    }
}
