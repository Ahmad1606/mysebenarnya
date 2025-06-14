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
            $table->id();
            $table->string('MCUsername')->unique();
            $table->string('MCName');
            $table->string('MCEmail')->unique();
            $table->string('MCPassword');
            $table->string('MCContact');
            $table->timestamps();
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
