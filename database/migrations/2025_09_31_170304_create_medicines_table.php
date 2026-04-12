<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('generic_name')->nullable();
            $table->string('brand')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('medicine_categories')->onDelete('set null');

            // New Inventory & Pricing Logic
            $table->integer('quantity')->default(0); // Strips Available
            $table->integer('tablets_per_strip')->default(1);
            $table->decimal('mrp', 10, 2); // Price for the full strip

            $table->string('supplier')->nullable();
            $table->date('manufacture_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
