<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('communication_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id')->nullable()->index();
            $table->unsignedBigInteger('caller_id')->nullable()->index();
            $table->unsignedBigInteger('receiver_id')->nullable()->index();
            $table->unsignedBigInteger('e_provider_id')->nullable()->index();
            $table->string('type', 32)->default('phone_call'); // phone_call, sms, whatsapp
            $table->string('caller_role', 32)->default('client'); // client, vendor, admin
            $table->string('phone_dialed', 32)->nullable();
            $table->string('status', 32)->default('initiated'); // initiated, completed
            $table->text('note')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['booking_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('communication_logs');
    }
};
