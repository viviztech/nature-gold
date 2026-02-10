<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('districts'); // Array of Tamil Nadu districts
            $table->decimal('base_rate', 8, 2);
            $table->decimal('per_kg_rate', 8, 2)->default(0);
            $table->decimal('free_above', 10, 2)->nullable(); // Free shipping above this amount
            $table->string('estimated_days')->nullable(); // e.g., "2-3 days"
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_zones');
    }
};
