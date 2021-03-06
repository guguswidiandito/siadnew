<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    protected $fillable = ['no_reg', 'user_id', 'kelas_id', 'jenis_pembayaran_id', 'tahun_ajaran'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function jenispembayaran()
    {
        return $this->belongsTo('App\JenisPembayaran', 'jenis_pembayaran_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
