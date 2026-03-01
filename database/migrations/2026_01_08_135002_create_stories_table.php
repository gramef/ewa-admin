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
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('e_provider_id')->nullable();
            $table->string('media_url');
            $table->string('media_type')->default('image'); // image, video
            $table->timestamp('expires_at')->nullable();
            $table->integer('views_count')->default(0);
            $table->timestamps();

            $table->foreign('e_provider_id')->references('id')->on('e_providers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
