<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_pem');
            $table->integer('registrasi_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('jenis_pembayaran_id')->unsigned();
            $table->string('bulan');
            $table->integer('bayar');
            $table->foreign('jenis_pembayaran_id')->references('id')->on('jenis_pembayarans');
            $table->foreign('registrasi_id')->references('id')->on('registrasis');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::drop('pembayarans');
    }
}
