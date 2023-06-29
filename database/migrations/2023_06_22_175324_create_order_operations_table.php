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
        Schema::create('order_operations', function (Blueprint $table) {
            $table->id();
            $table->string('order_code');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('items');
            // $table->integer('type');
            $table->integer('quantity');
            $table->decimal('total',8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_operations');
    }
};