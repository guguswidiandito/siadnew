<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = ['no_pem', 'registrasi_id', 'user_id', 'jenis_pembayaran_id', 'bulan', 'bayar'];

    public function registrasi()
    {
        return $this->belongsTo(Registrasi::class);
    }

    public function jenispembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class, 'jenis_pembayaran_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
