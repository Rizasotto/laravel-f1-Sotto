<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artworks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('image_path');
            $table->decimal('price', 10, 2);
            $table->string('category')->default('General');
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('active');
            $table->integer('stock')->default(1);
            $table->integer('views')->default(0);
            $table->timestamps();
            $table->index('user_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artworks');
    }
};
