<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_values', function (Blueprint $table) {
            $table->id();
            $table->integer('guard_id');
            $table->integer('admin_id')->nullable();
            $table->integer('schedule_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('form_id');
            $table->json('form_element');
            $table->date('date');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('form_values');
    }
}
