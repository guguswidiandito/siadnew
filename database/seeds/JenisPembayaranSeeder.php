<?php

use App\JenisPembayaran;
use Illuminate\Database\Seeder;

class JenisPembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis          = new JenisPembayaran();
        $jenis->jenis   = 'SPP';
        $jenis->nominal = 1200000;
        $jenis->save();

        $jenis          = new JenisPembayaran();
        $jenis->jenis   = 'Infaq';
        $jenis->nominal = 250000;
        $jenis->save();

        $jenis          = new JenisPembayaran();
        $jenis->jenis   = 'Ekskul';
        $jenis->nominal = 150000;
        $jenis->save();
    }
}
