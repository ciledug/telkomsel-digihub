<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            // $table->engine = 'MyISAM';
            $table->collaction = 'utf8mb4_unicode_ci';

            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('client_id', 15);
            $table->string('company', 50);
            $table->datetime('join_date')->nullable();
            $table->tinyInteger('number_of_apis')->unsigned()->default(0)->nullable();
            $table->string('legal_entity', 50)->nullable();
            $table->string('business_field', 50)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('company_site', 50)->nullable();
            $table->string('contact_person', 50)->nullable();
            $table->string('cp_position', 50)->nullable();
            $table->string('cp_email', 50)->nullable();
            $table->string('cp_phone', 50)->nullable();

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
        Schema::dropIfExists('user_profiles');
    }
}
