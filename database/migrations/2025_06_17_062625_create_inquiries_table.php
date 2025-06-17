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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->bigIncrements('InquiryID'); // Primary Key
            $table->string('InquirySubject', 200)->nullable(false);
            $table->string('InquiryCategory', 100)->nullable(false);
            $table->text('InquiryDescription')->nullable();
            $table->string('InquirySource', 255)->nullable();
            // For PDF attachment: store as filename/path
            $table->string('Attachment')->nullable();
            // Foreign keys
            $table->unsignedBigInteger('PublicID');
            // Foreign key constraints
            $table->foreign('PublicID')->references('PublicID')->on('public_users')->onDelete('cascade');
 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
