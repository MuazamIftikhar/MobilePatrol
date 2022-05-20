<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispatchReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatch_reports', function (Blueprint $table) {
            $table->id();
            $table->string('inspection');
            $table->string('incident');
            $table->string('person_on_site');
            $table->string('site_secure');
            $table->string('inspection_note');
            $table->string('incident_note');
            $table->string('person_on_site_note');
            $table->string('site_secure_note');
            $table->string('dispatch_report_note');
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
        Schema::dropIfExists('dispatch_reports');
    }
}
