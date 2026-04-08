<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->uuid('uuid');
            $table->string('last_name');
            $table->string('first_name');
            $table->integer('business_name_id')->default(2);
            $table->date('admission');
            $table->foreignId('job_id')->default(73);
            $table->integer('boss_id')->nullable()->index('fk_boss_id');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('profile_image')->default('https://res.cloudinary.com/gpt-services/image/upload/v1635975373/logo_GPT_yhm2ut.svg')->nullable();
            $table->string('cloudinary_public_id')->nullable();
            $table->boolean('active')->default(1);

            $table->string('libreta_mar')->nullable();
            $table->string('escolaridad')->nullable();
            $table->string('escolaridad_nombre')->nullable();
            $table->string('cedula')->nullable();
            $table->string('remember_token',100)->nullable();

            $table->foreign('business_name_id', 'fk_bussiness_id')->references('id')->on('razones_sociales');
            $table->foreign('job_id', 'fk_job_id')->references('id')->on('jobs');
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
        Schema::dropIfExists('users');
    }
}
