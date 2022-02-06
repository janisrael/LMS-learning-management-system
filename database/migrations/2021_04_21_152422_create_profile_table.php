<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('sf_id')->nullable();
            $table->string('region')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('immediate_head')->nullable();
            $table->string('job_title')->nullable();
            $table->string('organization')->nullable();
            $table->string('avatar')->nullable();
            $table->string('branch')->nullable();
            $table->text('address')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('user_group_id')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile');
    }
}
