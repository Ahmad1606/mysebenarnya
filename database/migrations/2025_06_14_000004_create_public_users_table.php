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
        Schema::create('public_users', function (Blueprint $table) {
            $table->bigIncrements("PublicID");
            $table->string('PublicName');
            $table->string('PublicEmail')->unique();
            $table->string('PublicPassword');
            $table->string('PublicContact');
            $table->boolean('PublicStatusVerify')->default(false);
            $table->unsignedBigInteger('RoleID');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('RoleID')->references('RoleID')->on('role_users')->onDelete('cascade');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_users');
    }
};
