<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserTableDropColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('sf_id');
            $table->dropColumn('region');
            $table->dropColumn('mobile_number');
            $table->dropColumn('employee_id');
            $table->dropColumn('immediate_head');
            $table->dropColumn('job_title');
            $table->dropColumn('organization');
            $table->dropColumn('avatar');
            $table->dropColumn('user_group_id');
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
