<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->nullable()->restrictOnDelete();
            $table->foreignId('chapter_id')->nullable()->nullOnDelete();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->longText('video_url')->nullable();
            $table->longText('preview_url')->nullable();
            $table->integer('sort_order');
            $table->longText('image_url')->nullable();
            $table->string('is_active',5)->default('false');
            $table->string('is_published', 5)->default('false');
            $table->integer('author_id')->nullable();
            $table->integer('duration')->nullable()->default(0);
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
        Schema::dropIfExists('lessons');
    }
}
