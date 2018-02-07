<?php

use App\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kelas             = new kelas();
        $kelas->nama_kelas = 'XA';
        $kelas->jurusan    = null;
        $kelas->save();

        $kelas             = new kelas();
        $kelas->nama_kelas = 'XIIPA';
        $kelas->jurusan    = 'IPA';
        $kelas->save();
    }
}
