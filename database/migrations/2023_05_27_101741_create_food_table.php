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
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // $table->integer('price');
            $table->decimal('price',8,2);
            $table->text('description');
            $table->longText('excerpt');
            $table->integer('status')->default(1);
            // $table->integer('category_id');
            // $table->unsignedBigInteger('user_id')->nullable();
            // $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            // $table->integer('tag_id')->nullable();
            $table->string('image')->nullable();
            $table->integer('type')->default(1);//FOOD or Drink

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};