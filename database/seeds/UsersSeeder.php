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
        $users->email        = 'admin@gmail.com';
        $users->hak_akses    = 'admin';
        $users->angkatan     = null;
        $users->password     = bcrypt('rahasia');
        $users->save();

        $users               = new user();
        $users->no_identitas = 13115051;
        $users->name         = 'Gugus Widiandito';
        $users->email     = 'guguswidianditogmail.com';
        $users->hak_akses    = 'siswa';
        $users->angkatan     = 2017;
        $users->password     = bcrypt('rahasia');
        $users->save();

        $users               = new user();
        $users->no_identitas = null;
        $users->name         = 'Kepala Sekolah';
        $users->email     = 'kepsek@gmail.com';
        $users->hak_akses    = 'kepsek';
        $users->angkatan     = null;
        $users->password     = bcrypt('rahasia');
        $users->save();
    }
}
