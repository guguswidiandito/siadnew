<?php

namespace App\Http\Controllers;

use App\JenisPembayaran;
use App\Pembayaran;
use App\Registrasi;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Session;

class RegistrasiController extends Controller
{
    public function editRegistrasi($user_id, $id)
    {
        if (Auth::check() && Auth::user()->hak_akses == "admin") {
            $jenis      = JenisPembayaran::pluck('jenis', 'id');
            $registrasi = Registrasi::find($id);
            return view('siswa.editregistrasi')->with(compact('jenis', 'registrasi'));
        } else {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "Bukan hak akses anda",
            ]);
            return redirect()->back();
        }
    }

    public function delRegistrasi($user_id, $id)
    {
        $registrasi = Registrasi::find($id);
        if ($registrasi->pembayaran()->count() > 0) {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "No reg. $registrasi->no_reg tidak bisa dihapus karena sudah ada pembayaran",
            ]);
            return redirect()->back();
        } else {
            $registrasi->delete();
            Session::flash("flash_notification", [
                "level"   => "success",
                "message" => "No reg. $registrasi->no_reg berhasil dihapus.",
            ]);
            return redirect()->back();
        }
    }

    public function updateRegistrasi(Request $request, $user_id, $id)
    {
        $registrasi = Registrasi::find($id);
        $registrasi->update($request->all());
        Session::flash("flash_notification", [
            "level"   => "success",
            "message" => "$registrasi->no_reg berhasil diupdate.",
        ]);
        return redirect()->route('siswa.show', $registrasi->user_id);
    }

    public function createPembayaran($user_id, $id)
    {
        if (Auth::check() && Auth::user()->hak_akses == "admin") {
            $users = Registrasi::find($id);
            return view('siswa.pembayaran')->with(compact('users'));
        } else {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "Bukan hak akses anda",
            ]);
            return redirect()->back();
        }
    }

    public function newPembayaran(Request $request, $id)
    {
        $this->validate($request, [
            'no_pem'   => 'required|unique:pembayarans',
            'semester' => 'required',
            'bayar'    => 'required',
        ], [
            'no_pem.required'   => 'field no pembayaran harus diisi',
            'no_pem.unique'     => 'No Pembayaran sudah terpakai',
            'semester.required' => 'field semester harus diisi',
            'bayar.required'    => 'field bayar harus diisi',
        ]);
        $bayar = $request->bayar;
        $users = User::find($id)->registrasi;
        foreach ($users as $value) {
            $user_id   = $value->user_id;
            $reg       = $value->id;
            $jenis     = $value->jenis_pembayaran_id;
            $tunggakan = $value->jenispembayaran->nominal - $bayar;
            if ($tunggakan <= 0) {
                $keterangan = 'Lunas';
            } else {
                $keterangan = 'Belum Lunas';
            }
        }
        $data                        = $request->all();
        $data['registrasi_id']       = $reg;
        $data['user_id']             = $user_id;
        $data['jenis_pembayaran_id'] = $jenis;
        $data['tunggakan']           = $tunggakan;
        $data['keterangan']          = $keterangan;
        $pembayaran                  = Pembayaran::create($data);
        Session::flash("flash_notification", [
            "level"   => "success",
            "message" => "$pembayaran->no_pem berhasil disimpan.",
        ]);
        return redirect(url('siswa/' . $pembayaran->user_id . '/registrasi/' . $pembayaran->registrasi_id . '/pembayaran'));
    }

    public function editPembayaran($user_id, $registrasi_id, $id)
    {
        if (Auth::check() && Auth::user()->hak_akses == "admin") {
            $registrasi = Pembayaran::find($id);
            return view('siswa.editpembayaran')->with(compact('registrasi'));
        } else {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "Bukan hak akses anda",
            ]);
            return redirect()->back();
        }
    }

    public function updatePembayaran(Request $request, $user_id, $registrasi_id, $id)
    {
        $this->validate($request, [
            'bayar' => 'required|integer',
        ]);
        $bayar                 = $request->get('bayar');
        $pembayaran            = Pembayaran::find($id);
        $pembayaran->tunggakan = $pembayaran->jenispembayaran->nominal - $bayar;
        if ($pembayaran->tunggakan == 0) {
            $pembayaran->keterangan = 'Lunas';
        } else {
            $pembayaran->keterangan = 'Belum Lunas';
        }
        $pembayaran->update($request->all());
        Session::flash("flash_notification", [
            "level"   => "success",
            "message" => "$pembayaran->no_pem berhasil diupdate.",
        ]);
        return redirect(url('siswa/' . $pembayaran->user_id . '/registrasi/' . $pembayaran->registrasi_id . '/pembayaran'));
    }
}
