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
    Schema::create('projects', function (Blueprint $table) {
        $table->id();
        $table->string('project_code')->unique();
        $table->foreignId('customer_id')
              ->constrained('customers')
              ->onDelete('cascade');
        $table->string('name');
        $table->text('site_address')->nullable();
        $table->string('site_city')->nullable();
        $table->date('start_date')->nullable();
        $table->date('expected_end_date')->nullable();
        $table->date('actual_end_date')->nullable();
        $table->enum('status', [
            'pending',
            'in_progress',
            'completed',
            'on_hold',
            'cancelled'
        ])->default('pending');
        $table->text('notes')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
