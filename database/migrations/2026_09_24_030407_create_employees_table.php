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
    Schema::create('employees', function (Blueprint $table) {
        $table->id();
        $table->string('employee_code')->unique();
        $table->string('name');
        $table->string('phone');
        $table->string('email')->nullable();
        $table->foreignId('user_id')
              ->nullable()
              ->constrained('users')
              ->onDelete('set null');
        $table->foreignId('team_leader_id')
              ->nullable()
              ->constrained('employees')
              ->onDelete('set null');
        $table->enum('role', [
            'employee',
            'team_leader'
        ])->default('employee');
        $table->boolean('is_active')->default(true);
        $table->date('joining_date')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
