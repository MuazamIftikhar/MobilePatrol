<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobilePatrolReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_patrol_reports', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mobile_patrol_id');
            $table->bigInteger('admin_id');
            $table->bigInteger('guard_id');
            $table->text('information');
            $table->dateTime('date');
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
        Schema::dropIfExists('mobile_patrol_reports');
    }
}
