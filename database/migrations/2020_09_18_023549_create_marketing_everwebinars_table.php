<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketingEverwebinarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing_everwebinars', function (Blueprint $table) {
            $table->id();
            $table->string('hash', 20)->unique();
            $table->string('fp_promoter', 25)->nullable();
            $table->integer('template_id');
            $table->integer('webinar_id');
            $table->boolean('is_active')->default(1)->nullable();
            $table->integer('created_by')->unsigned();
            $table->timestamps();
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
        Schema::dropIfExists('marketing_everwebinars');
    }
}
