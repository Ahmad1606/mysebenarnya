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
        Schema::create('mcmc_users', function (Blueprint $table) {
            $table->bigIncrements('MCMCID');
            $table->string('MCMCUserName')->unique();
            $table->string('MCMCEmail')->unique();
            $table->string('MCMCPassword');
            $table->string('MCMCContact');
            $table->unsignedBigInteger('RoleID');
            $table->timestamps();

            $table->foreign('RoleID')->references('ROleID')->on('role_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mcmc_users');
    }
};
