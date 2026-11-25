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
    Schema::create('work_assignments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('project_id')
              ->constrained('projects')
              ->onDelete('cascade');
        $table->foreignId('project_fitting_item_id')
              ->constrained('project_fitting_items')
              ->onDelete('cascade');
        $table->foreignId('employee_id')
              ->constrained('employees')
              ->onDelete('cascade');
        $table->foreignId('team_leader_id')
              ->constrained('employees')
              ->onDelete('cascade');
        $table->foreignId('fitting_type_id')
              ->constrained('fitting_types')
              ->onDelete('cascade');
        $table->integer('quantity');
        $table->integer('standard_time');
        // total standard time for this qty
        $table->date('assigned_date');
        $table->enum('status', [
            'pending',
            'in_progress',
            'completed',
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
        Schema::dropIfExists('work_assignments');
    }
};
