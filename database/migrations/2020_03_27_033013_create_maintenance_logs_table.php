<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceLogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('maintenance_id');
            $table->integer('user_id');
            $table->enum('action', ['create', 'update', 'delete']);
            $table->dateTime('schedule_start', 0);
            $table->dateTime('schedule_end', 0);
            $table->text('message')->nullable();
            $table->boolean('auto_up_on_schedule_end')->default(0)->nullable();
            $table->boolean('is_active')->default(1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('maintenance_logs');
    }
}
