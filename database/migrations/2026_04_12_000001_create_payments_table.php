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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->decimal('amount', 12, 2);
            $table->string('payment_method')->default('gcash');
            $table->string('reference_number')->unique();
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            // Indexes
            $table->index('order_id');
            $table->index('status');
            $table->index('reference_number');
        });

        // Add payment-related columns to orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('payment_status');
            $table->string('gcash_reference_number')->nullable()->after('payment_method');
            $table->timestamp('paid_at')->nullable()->after('gcash_reference_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'gcash_reference_number', 'paid_at']);
        });

        Schema::dropIfExists('payments');
    }
};
