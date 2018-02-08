<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = ['nama_kelas', 'jurusan'];

    public function user()
    {
        return $this->belongsToMany(User::class, 'kelas_user', 'kelas_id', 'user_id')->withPivot('tahun_ajaran');
    }

    public function registrasi()
    {
        return $this->hasMany(Registrasi::class);
    }
}
