<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('post_category') && ! Schema::hasTable('category_post')) {
            Schema::rename('post_category', 'category_post');
        }

        if (! Schema::hasTable('category_post')) {
            return;
        }

        if (! Schema::hasIndex('category_post', ['post_id', 'category_id'], 'unique')) {
            Schema::table('category_post', function (Blueprint $table): void {
                $table->unique(['post_id', 'category_id']);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('category_post') && ! Schema::hasTable('post_category')) {
            Schema::rename('category_post', 'post_category');
        }
    }
};
