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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id')->references('id')->on('brands')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id')->references('id')->on('units')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->string('barcode')->nullable();
            $table->string('image')->nullable();
            $table->double('quantity', 10, 2)->default(0);
            $table->double('quantity_alert', 10, 2)->default(0);
            $table->double('purchase_price')->default(0);
            $table->double('mrp')->default(0);
            $table->double('selling_price')->default(0);
            $table->double('discount')->default(0);
            $table->enum('discount_type', ['Fixed', 'Percentage'])->default('Fixed');
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->foreign('tax_id')->references('id')->on('taxes')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->enum('tax_type', ['Inclusive', 'Exclusive'])->nullable();
            $table->text('short_description');
            $table->enum('status', ['Active', 'Inactive']);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
