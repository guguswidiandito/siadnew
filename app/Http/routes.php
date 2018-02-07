<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */
Route::auth();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('siswa', 'UserController');
    Route::resource('kelas', 'KelasController');
    Route::resource('jenis', 'JenisController');
    Route::get('siswa/{siswa}/kelas', [
      'as'   => 'siswa.kelas',
      'uses' => 'UserController@tambahKelasPerSiswa',
    ]);
    Route::post('siswa/{siswa}/kelas', [
      'as'   => 'siswa.kelas.store',
      'uses' => 'UserController@storeKelasPerSiswa',
    ]);
    Route::get('siswa/{siswa}/{tahun_ajaran}', [
      'as'   => 'siswa.tahun.ajaran',
      'uses' => 'UserController@registrasiPerTahunAjaran',
    ]);
    Route::get('siswa/{siswa}/{tahun_ajaran}/registrasi', [
        'as'   => 'siswa.registrasi',
        'uses' => 'UserController@createRegistrasi',
    ]);
    Route::post('siswa/{siswa}/{tahun_ajaran}/registrasi', [
        'as'   => 'registrasi.store',
        'uses' => 'UserController@newRegistrasi',
    ]);
    Route::delete('siswa/{user_id}/registrasi/{id}', [
        'as'   => 'registrasi.delete',
        'uses' => 'RegistrasiController@delRegistrasi',
    ]);
    Route::get('siswa/{user_id}/registrasi/{id}/edit', [
        'as'   => 'registrasi.edit',
        'uses' => 'RegistrasiController@editRegistrasi',
    ]);
    Route::patch('siswa/{user_id}/registrasi/{id}', [
        'as'   => 'registrasi.update',
        'uses' => 'RegistrasiController@updateRegistrasi',
    ]);
    Route::get('siswa/{siswa}/{tahun_ajaran}/{registrasi}', [
        'as'   => 'siswa.pembayaran',
        'uses' => 'RegistrasiController@createPembayaran',
    ]);
    Route::post('siswa/{siswa}/{tahun_ajaran}/{registrasi}', [
        'as'   => 'pembayaran.store',
        'uses' => 'RegistrasiController@newPembayaran',
    ]);
    Route::get('siswa/{siswa}/{registrasi}/{pembayaran}', [
        'as'   => 'pembayaran.edit',
        'uses' => 'RegistrasiController@editPembayaran',
    ]);
    Route::patch('siswa/{siswa}/{registrasi}/{pembayaran}', [
        'as'   => 'pembayaran.update',
        'uses' => 'RegistrasiController@updatePembayaran',
    ]);
    Route::get('siswa/laporan/identitas', 'ReportController@identitas');
    Route::post('siswa/laporan/identitas/pdf', [
        'as'   => 'laporan.identitas',
        'uses' => 'ReportController@identitasPdf',
    ]);

    Route::get('siswa/laporan/pembayaran', 'ReportController@pembayaran');
    Route::post('siswa/laporan/pembayaran/pdf', [
        'as'   => 'laporan.pembayaran',
        'uses' => 'ReportController@pembayaranPdf',
    ]);
    Route::get('setelan/password', 'PasswordController@editPassword');
    Route::post('setelan/password', 'PasswordController@updatePassword');
});
