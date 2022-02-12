<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseHasSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_has_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->restrictOnDelete();
            $table->foreignId('subscription_id')->nullOnDelete();
            $table->integer('last_viewed_lesson')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_has_subscriptions');
    }
}
