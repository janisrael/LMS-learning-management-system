<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_no', 20)->unique();
            $table->dateTime('schedule_start', 0);
            $table->dateTime('schedule_end', 0);
            $table->text('message')->nullable();
            $table->boolean('auto_up_on_schedule_end')->default(0)->nullable();
            $table->boolean('is_active')->default(1)->nullable();
            $table->integer('added_by');
            $table->integer('updated_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('maintenances');
    }
}
