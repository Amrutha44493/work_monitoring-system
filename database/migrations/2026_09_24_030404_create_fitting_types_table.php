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
    Schema::create('fitting_types', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')
              ->constrained('categories')
              ->onDelete('cascade');
        $table->string('name');
        $table->integer('standard_time');
        $table->string('unit')->default('per piece');
        $table->text('description')->nullable();
        $table->boolean('is_active')->default(true);
        $table->integer('sort_order')->default(0);
        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitting_types');
    }
};
