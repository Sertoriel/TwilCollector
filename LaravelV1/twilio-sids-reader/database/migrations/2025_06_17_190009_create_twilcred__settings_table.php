<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('twilcred_settings', function (Blueprint $table) {
            $table->id();
            $table->text('account_sid')->nullable();
            $table->text('auth_token')->nullable();
            $table->text('profile')->nullable();
            $table->text('password')->nullable();
            $table->timestamps();
        });

        Schema::create('LoginHistory', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->text('profile')->nullable();
            $table->text('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('login_at')->nullable();
            $table->timestamp('logout_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('twilcred_settings');
    }
};
