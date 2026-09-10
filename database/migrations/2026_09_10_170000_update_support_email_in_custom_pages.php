<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Replace support@ewaofficial.co.uk with support@ewaofficialapp.com in custom_pages table
        DB::table('custom_pages')->where('content', 'LIKE', '%support@ewaofficial.co.uk%')->get()->each(function ($page) {
            $updatedContent = str_replace('support@ewaofficial.co.uk', 'support@ewaofficialapp.com', $page->content);
            DB::table('custom_pages')->where('id', $page->id)->update(['content' => $updatedContent]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('custom_pages')->where('content', 'LIKE', '%support@ewaofficialapp.com%')->get()->each(function ($page) {
            $updatedContent = str_replace('support@ewaofficialapp.com', 'support@ewaofficial.co.uk', $page->content);
            DB::table('custom_pages')->where('id', $page->id)->update(['content' => $updatedContent]);
        });
    }
};
