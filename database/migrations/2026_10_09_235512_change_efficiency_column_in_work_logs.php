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
    Schema::table('work_logs', function (Blueprint $table) {
        $table->decimal('efficiency', 6, 1)
              ->nullable()->change();
    });
}

public function down()
{
    Schema::table('work_logs', function (Blueprint $table) {
        $table->decimal('efficiency', 5, 2)->nullable()->change();
    });
}
};
