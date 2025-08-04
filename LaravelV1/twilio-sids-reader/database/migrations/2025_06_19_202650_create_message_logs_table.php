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
    Schema::create('message_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('twilcred_settings_id')->constrained();
        $table->string('sid');
        $table->string('status')->nullable();
        $table->string('error_code')->nullable();
        $table->text('body')->nullable();
        $table->text('error_message')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_logs');
    }
};
