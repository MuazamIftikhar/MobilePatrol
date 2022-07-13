<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckpointHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkpoint_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id');
            $table->integer('schedule_id')->nullable();
            $table->integer('guard_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('checkpoint_id');
            $table->string('type')->nullable();
            $table->date('date');
            $table->integer('status')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations....00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkpoint_histories');
    }
}
