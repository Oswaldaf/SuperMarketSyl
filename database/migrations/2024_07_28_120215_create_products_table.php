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
            $table->foreignId("category_id")->constrained()->onDelete('cascade');;
            $table->string('image_file');
            $table->string('name')->length(128);
            $table->string("short_description")->nullable();
            $table->text("long_description")->nullable();
            $table->float("price")->default(0.0);
            $table->integer("quantity")->default(0);
            $table->string('image')->nullable();
          
            $table->timestamps();
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
