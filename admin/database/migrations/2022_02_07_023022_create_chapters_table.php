<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('course_id');
            $table->smallInteger('chapter_id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->longText('video_url')->nullable();
            $table->smallInteger('sort_order');
            $table->longText('preview_image_url')->nullable();
            $table->boolean('is_active')->default(0);
            $table->smallInteger('author_id');
            $table->integer('duration');
            $table->decimal('percentage', 5,2)->default(0);
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
        Schema::dropIfExists('chapters');
    }
}
