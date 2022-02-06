<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerLessonProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_lesson_progress', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('chapter_id');
            $table->smallInteger('lesson_id');
            $table->decimal('percentage', 5,2);
            $table->boolean('has_access')->default(0);
            $table->smallInteger('created_by')->nullable;
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
        Schema::dropIfExists('customer_lesson_progress');
    }
}
