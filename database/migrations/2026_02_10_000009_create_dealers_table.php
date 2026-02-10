<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('business_name');
            $table->string('gst_number')->nullable();
            $table->string('business_type')->default('retail'); // retail, wholesale, distributor
            $table->string('territory')->nullable(); // Tamil Nadu district
            $table->text('business_address')->nullable();
            $table->string('trade_license')->nullable(); // file path
            $table->string('gst_certificate')->nullable(); // file path
            $table->decimal('commission_rate', 5, 2)->default(0);
            $table->string('status')->default('pending'); // pending, approved, rejected, suspended
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });

        Schema::create('dealer_pricing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dealer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('special_price', 10, 2);
            $table->integer('min_quantity')->default(1);
            $table->timestamps();

            $table->unique(['dealer_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dealer_pricing');
        Schema::dropIfExists('dealers');
    }
};
