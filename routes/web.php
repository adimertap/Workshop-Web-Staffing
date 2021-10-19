<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['verify' => true]);


Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/', 'Auth\LoginController@login')->name('login');

Route::get('/register', 'Auth\RegisterController@showRegisterForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register')->name('register');
Route::get("/getkabupaten/{id}", "Auth\RegisterController@kabupaten_baru");
Route::get("/getkecamatan/{id}", "Auth\RegisterController@kecamatan_baru");
Route::get("/getdesa/{id}", "Auth\RegisterController@desa_baru");


Route::get('account/password', 'Account\PasswordController@edit')->name('password.edit');
Route::patch('account/password', 'Account\PasswordController@update')->name('password.edit');

Route::group(
    ['middleware' => 'auth'],
    function () {
        // MASTER DATA KEPEGAWAIAN -------------------------------------------------------- Master Data Pegawai
        Route::prefix('kepegawaian/masterdatapegawai')
            ->namespace('Kepegawaian\Masterdata')
            ->middleware(['owner', 'verified'])
            ->group(function () {
                Route::get('/', 'MasterdatapegawaiController@index')
                    ->name('masterdatapegawai');

                Route::resource('pegawai', 'MasterdatapegawaiController');
            });

        Route::prefix('kepegawaian/masterdatajabatan')
            ->namespace('Kepegawaian\Masterdata')
            ->middleware(['owner', 'verified'])
            ->group(function () {
                Route::get('/', 'MasterdatajabatanController@index')
                    ->name('masterdatajabatan');

                Route::resource('jabatan', 'MasterdatajabatanController');
            });


        // ABSENSI PEGAWAI ---------------------------------------------------------------- ABSENSI
        Route::prefix('kepegawaian')
            ->namespace('Kepegawaian\Absensi')
            ->middleware(['owner', 'verified'])
            ->group(function () {

                Route::resource('absensi', 'AbsensipegawaiController');

                Route::get('Absensi/{id_absensi}', 'AbsensipegawaiController@pulang')
                    ->name('absensipulang');
            });

        // LAPORAN ABSENSI --------------------------------------------------------------- Laporan Absensi
        Route::prefix('kepegawaian/LaporanAbsensi')
            ->namespace('Kepegawaian\Absensi')
            ->middleware(['owner', 'verified'])
            ->group(function () {
                Route::get('/', 'LaporanabsensiController@index')
                    ->name('laporanabsensi');
            });

        // JADWAL PEGAWAI --------------------------------------------------------------- Jadwal
        Route::prefix('kepegawaian')
            ->namespace('Kepegawaian\Jadwal')
            ->middleware(['owner', 'verified'])
            ->group(function () {
                Route::get('jadwal-pegawai/tanggal', 'JadwalpegawaiController@JadwalPegawaiBulan');

                Route::resource('jadwal-pegawai', 'JadwalpegawaiController');
                Route::post('jadwal-pegawai/tanggal', 'JadwalpegawaiController@getJadwal');
                Route::post('jadwal-pegawai/masuk', 'JadwalpegawaiController@masuk');
                Route::post('jadwal-pegawai/libur', 'JadwalpegawaiController@libur');
            });
    }
);
