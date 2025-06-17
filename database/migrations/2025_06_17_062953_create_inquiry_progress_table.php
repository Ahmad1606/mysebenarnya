<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inquiry_progress', function (Blueprint $table) {
            $table->bigIncrements('ProgressID'); // Primary Key

            $table->string('ProgressResult', 100)->nullable();
            $table->text('ProgressDescription')->nullable();
            $table->text('ProgressEvidence')->nullable();
            $table->text('ProgressReferences')->nullable();

            // ENUM status field
            $table->enum('Status', [
                'Under Investigation',
                'Verified as True',
                'Identified as Fake',
                'Rejected'
            ])->default('Under Investigation');

            // Foreign keys
            $table->unsignedBigInteger('AgencyID');
            $table->unsignedBigInteger('InquiryID');
            $table->unsignedBigInteger('MCMCID');

            $table->foreign('AgencyID')->references('AgencyID')->on('agency_users')->onDelete('cascade');
            $table->foreign('InquiryID')->references('InquiryID')->on('inquiries')->onDelete('cascade');
            $table->foreign('MCMCID')->references('MCMCID')->on('mcmc_users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiry_progress');
    }
};
