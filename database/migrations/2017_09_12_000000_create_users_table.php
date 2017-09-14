<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->increments('id');
            $table->integer('no_identitas')->unsigned()->nullable();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('hak_akses');
            $table->integer('kelas_id')->unsigned()->nullable();
            $table->string('angkatan', 6)->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::drop('users');
    }
}
