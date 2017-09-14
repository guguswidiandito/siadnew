<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users               = new user();
        $users->no_identitas = null;
        $users->name         = 'Admin';
        $users->username     = 'admin';
        $users->hak_akses    = 'admin';
        $users->kelas_id     = null;
        $users->angkatan     = null;
        $users->password     = bcrypt('rahasia');
        $users->save();

        $users               = new user();
        $users->no_identitas = 13115051;
        $users->name         = 'Gugus Widiandito';
        $users->username     = 'guguswidiandito';
        $users->hak_akses    = 'siswa';
        $users->kelas_id     = 1;
        $users->angkatan     = 2017;
        $users->password     = bcrypt('rahasia');
        $users->save();

        $users               = new user();
        $users->no_identitas = null;
        $users->name         = 'Kepala Sekolah';
        $users->username     = 'kepsek';
        $users->hak_akses    = 'kepsek';
        $users->kelas_id     = null;
        $users->angkatan     = null;
        $users->password     = bcrypt('rahasia');
        $users->save();
    }
}
