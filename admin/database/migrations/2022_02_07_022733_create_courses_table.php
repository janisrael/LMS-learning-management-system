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
            $table->string('is_global',5)->default('false');
            $table->string('is_featured',5)->default('false');
            $table->string('is_active',5)->default('true');
            $table->string('is_live',5)->default('true');
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
