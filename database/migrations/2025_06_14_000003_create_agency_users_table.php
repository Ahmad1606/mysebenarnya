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
        Schema::create('agency_users', function (Blueprint $table) {
            $table->bigIncrements("AgencyID");
            $table->string('AgencyUserName')->unique();
            $table->string('AgencyEmail')->unique();
            $table->string('AgencyPassword');
            $table->string('AgencyContact');
            $table->boolean('AgencyFirstLogin')->default(true);
            $table->unsignedBigInteger('RoleID');
            $table->unsignedBigInteger('MCMCID');
            $table->timestamps();
            // FK Constraints
            $table->foreign('MCMCID')->references('MCMCID')->on('mcmc_users')->onDelete('cascade');    
            $table->foreign('RoleID')->references('RoleID')->on('role_users')->onDelete('cascade');       
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_users');
    }
};
