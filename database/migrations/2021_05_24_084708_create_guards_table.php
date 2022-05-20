<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guards', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id');
            $table->integer('user_id');
            $table->string('guard_name');
            $table->string('guard_email');
            $table->string('guard_phone');
            $table->string('guard_license_id');
            $table->date('guard_license_expiry');
            $table->integer('guard_type');
            $table->string('per_hour');
            $table->string('work_availability')->nullable();
            $table->date('available_start_date')->nullable();
            $table->string('driving_license');
            $table->string('driving_license_id')->nullable();
            $table->date('driving_license_expiry')->nullable();
            $table->string('driving_license_image')->nullable();
            $table->string('photo_id_image')->nullable();
            $table->boolean('status')->default(1);

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
        Schema::dropIfExists('guards');
    }
}
