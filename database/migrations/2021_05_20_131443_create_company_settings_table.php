<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id');
            $table->string('company_name')->default('Mobile Patrol');
            $table->string('company_address')->default("5328 Calgary Trial NW\n#1388 Edmonton, AB T6H 4J8");
            $table->string('company_phone')->default('+1 780 900 7473');
            $table->string('company_fax')->default('+1 780 900 7473');
            $table->string('company_email')->default('info@mobilepatrol.co');
            $table->string('company_website')->default('www.mobilepatrol.co');
            $table->text('company_logo')->default('');
            $table->text('company_clock_in_message')->default("CLOCK-IN ALERT\nYou have not yet clocked-in at your site\n** This no. does not receive incoming calls or SMS **");
            $table->string('company_clock_out_message')->default("CLOCK-OUT ALERT\nDo not forget to clock-out from your shift.\n** This no. does not receive incoming calls or SMS **");
            $table->string('company_time_zone')->default('America/Edmonton');
            $table->string('company_phone_number_for_sms')->default('+1 780 900 7473');
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
        Schema::dropIfExists('company_settings');
    }
}
