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
    Route::get('siswa/{siswa}/registrasi', [
        'as'   => 'siswa.registrasi',
        'uses' => 'UserController@createRegistrasi',
    ]);
    Route::post('siswa/{siswa}/registrasi', [
        'as'   => 'registrasi.create',
        'uses' => 'UserController@newRegistrasi',
    ]);
    Route::delete('siswa/{user_id}/registrasi/{id}', [
        'as'   => 'registrasi.delete',
        'uses' => 'registrasiController@delRegistrasi',
    ]);
    Route::get('siswa/{user_id}/registrasi/{id}/edit', [
        'as'   => 'registrasi.edit',
        'uses' => 'RegistrasiController@editRegistrasi',
    ]);
    Route::patch('siswa/{user_id}/registrasi/{id}', [
        'as'   => 'registrasi.update',
        'uses' => 'RegistrasiController@updateRegistrasi',
    ]);
    Route::get('siswa/{user_id}/registrasi/{id}/pembayaran', [
        'as'   => 'siswa.pembayaran',
        'uses' => 'RegistrasiController@createPembayaran',
    ]);
    Route::post('siswa/{user_id}/registrasi/{id}/pembayaran', [
        'as'   => 'pembayaran.create',
        'uses' => 'RegistrasiController@newPembayaran',
    ]);
    Route::get('siswa/{user_id}/registrasi/{registrasi_id}/pembayaran/{id}/edit', [
        'as'   => 'pembayaran.edit',
        'uses' => 'RegistrasiController@editPembayaran',
    ]);
    Route::patch('siswa/{user_id}/registrasi/{registrasi_id}/pembayaran/{id}', [
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
