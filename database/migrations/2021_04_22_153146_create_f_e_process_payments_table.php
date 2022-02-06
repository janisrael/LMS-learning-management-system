<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFEProcessPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('f_e_process_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('request_payload');
            $table->text('response_payload')->nullable();
            $table->string('request_status')->default('processing');
            $table->tinyInteger('is_processed')->default(0);
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
        Schema::dropIfExists('f_e_process_payments');
    }
}
