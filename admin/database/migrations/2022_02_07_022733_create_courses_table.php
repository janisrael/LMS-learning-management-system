<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->string('course_number', 20);

            $table->integer('author_id')->nullable();
            
            $table->string('name');
            $table->longText('description')->nullable();
            $table->integer('category_id')->nullable();
            $table->smallInteger('sort_order');
            $table->boolean('is_global')->default(0);
            $table->boolean('is_featured')->default(0);
            $table->boolean('is_active')->default(1);
            $table->boolean('is_live')->default(1);
            $table->text('course_image_url')->nullable();
            $table->decimal('percentage', 5,2)->nullable()->default(0);
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
        Schema::dropIfExists('courses');
    }
}
