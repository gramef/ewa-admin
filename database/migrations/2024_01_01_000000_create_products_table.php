<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->json('name');
                $table->json('description')->nullable();
                $table->decimal('price', 10, 2);
                $table->decimal('discount_price', 10, 2)->default(0);
                $table->json('quantity_unit')->nullable();
                $table->boolean('featured')->default(false);
                $table->boolean('available')->default(true);
                $table->boolean('approved')->default(true);
                $table->unsignedInteger('store_id')->nullable();
                $table->unsignedInteger('category_id')->nullable();
                $table->integer('total_orders')->default(0);
                $table->timestamps();
                $table->softDeletes();

                $table->index(['featured', 'available', 'approved']);
                $table->index(['store_id']);
                $table->index(['category_id']);

                $table->foreign('store_id')->references('id')->on('e_providers')->onDelete('cascade');
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            });
        } else {
            // Table exists from a prior failed migration — fix column types with raw SQL
            // and add foreign keys if missing
            try {
                DB::statement('ALTER TABLE `products` MODIFY `store_id` INT UNSIGNED NULL');
            } catch (\Exception $e) {
            }

            try {
                DB::statement('ALTER TABLE `products` MODIFY `category_id` INT UNSIGNED NULL');
            } catch (\Exception $e) {
            }

            // Add indexes if missing
            try {
                DB::statement('ALTER TABLE `products` ADD INDEX `products_store_id_index` (`store_id`)');
            } catch (\Exception $e) {
            }

            try {
                DB::statement('ALTER TABLE `products` ADD INDEX `products_category_id_index` (`category_id`)');
            } catch (\Exception $e) {
            }

            try {
                DB::statement('ALTER TABLE `products` ADD INDEX `products_featured_available_approved_index` (`featured`, `available`, `approved`)');
            } catch (\Exception $e) {
            }

            // Add foreign keys
            try {
                DB::statement('ALTER TABLE `products` ADD CONSTRAINT `products_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `e_providers` (`id`) ON DELETE CASCADE');
            } catch (\Exception $e) {
            }

            try {
                DB::statement('ALTER TABLE `products` ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL');
            } catch (\Exception $e) {
            }
        }
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}