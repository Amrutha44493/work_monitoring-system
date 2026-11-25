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
    Schema::create('work_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('work_assignment_id')
              ->constrained('work_assignments')
              ->onDelete('cascade');
        $table->foreignId('employee_id')
              ->constrained('employees')
              ->onDelete('cascade');
        $table->foreignId('project_id')
              ->constrained('projects')
              ->onDelete('cascade');
        $table->foreignId('fitting_type_id')
              ->constrained('fitting_types')
              ->onDelete('cascade');
        $table->timestamp('start_time')->nullable();
        $table->timestamp('end_time')->nullable();
        $table->integer('actual_time')->nullable();
        // in minutes
        $table->integer('standard_time');
        // in minutes
        $table->integer('variance')->nullable();
        $table->decimal('efficiency', 5, 2)->nullable();
        $table->text('notes')->nullable();
        $table->enum('status', [
            'started',
            'paused',
            'completed'
        ])->default('started');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_logs');
    }
};
