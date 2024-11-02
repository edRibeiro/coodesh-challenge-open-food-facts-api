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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('status', ['draft', 'trash', 'published']);
            $table->string('url');
            $table->string('creator');
            $table->unsignedInteger('created_t');
            $table->unsignedInteger('last_modified_t');
            $table->string('product_name');
            $table->string('quantity');
            $table->string('brands');
            $table->string('categories');
            $table->string('labels');
            $table->string('cities')->nullable();
            $table->string('purchase_places');
            $table->string('stores');
            $table->text('ingredients_text');
            $table->string('traces')->nullable();
            $table->string('serving_size');
            $table->decimal('serving_quantity', 8, 2);
            $table->integer('nutriscore_score');
            $table->char('nutriscore_grade', 1);
            $table->string('main_category');
            $table->string('image_url');
            $table->timestamp('imported_t');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
