<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserTableAddNewColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('sf_id')->nullable();
            $table->string('region')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('immediate_head')->nullable();
            $table->string('job_title')->nullable();
            $table->string('organization')->nullable();
            $table->string('avatar')->nullable();
            /* user_group foreign key */
            $table->foreignId('user_group_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
