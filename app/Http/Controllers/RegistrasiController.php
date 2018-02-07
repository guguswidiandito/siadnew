<?php

namespace App\Http\Controllers;

use App\JenisPembayaran;
use App\Pembayaran;
use App\Registrasi;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Session;
use App\Helpers\Helper;

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

    public function delRegistrasi($no_identitas, $id)
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

    public function createPembayaran($no_identitas, $tahunAjaran, $id)
    {
        if (Auth::check() && Auth::user()->hak_akses == "admin") {
            $user = User::where('no_identitas', $no_identitas)->firstOrFail();
            $registrasi = Registrasi::where('no_reg', $id)->where('user_id', $user->id)->firstOrFail();
            return view('siswa.pembayaran')->with(compact('user', 'registrasi', 'tahunAjaran'));
        } else {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "Bukan hak akses anda",
            ]);
            return redirect()->back();
        }
    }

    protected function existsBulan($request, $siswa, $registrasi)
    {
        return Pembayaran::where('bulan', $request->bulan)->where('user_id', $siswa)->where('registrasi_id', $registrasi)->count();
    }

    public function newPembayaran(Request $request, $siswa, $tahunAjaran, $registrasi)
    {
        $this->validate($request, [
            'no_pem' => 'required|unique:pembayarans',
            'bayar'    => 'required',
            'bulan' => 'required'
        ], [
            'no_pem.required'   => 'field no pembayaran harus diisi',
            'no_pem.unique'     => 'No Pembayaran sudah terpakai',
            'bayar.required'    => 'field bayar harus diisi',
        ]);
        $bayar = $request->bayar;
        $user = User::where('no_identitas', $siswa)->firstOrFail();
        $registrasi = Registrasi::where('no_reg', $registrasi)->where('user_id', $user->id)->firstOrFail();
        $user_id   = $registrasi->user_id;
        $registrasi_id       = $registrasi->id;
        $jenis     = $registrasi->jenis_pembayaran_id;
        $data                        = $request->all();
        $data['registrasi_id']       = $registrasi->id;
        $data['user_id']             = $user_id;
        $data['bulan']               = $request->bulan;
        $data['jenis_pembayaran_id'] = $jenis;
        $pembayaran = Pembayaran::where('registrasi_id', $registrasi->id)->get();
        $sum = 0;
        foreach ($pembayaran as $key => $value) {
            $sum += $value->bayar;
        }
        $min = $registrasi->jenispembayaran->nominal - $sum;
        // return $this->existsBulan($request, $user->id, $registrasi->id);
        // return $bayar;
        if ($this->existsBulan($request, $user->id, $registrasi->id) > 0) {
            Session::flash("flash_notification", [
            "level"   => "danger",
            "message" => "Bulan ".Helper::namaBulan($request->bulan)." sudah dibayar",
        ]);
            return redirect()->back();
        } else {
            if ($bayar > $min) {
                Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "Jumlah nominal yang diinputkan kelebihan",
            ]);
                return redirect()->back();
            } else {
                $pem = Pembayaran::create($data);
                Session::flash("flash_notification", [
                "level"   => "success",
                "message" => "$pem->no_pem berhasil disimpan.",
            ]);
                return redirect()->back();
            }
        }
    }

    public function editPembayaran($siswa, $registrasi, $pembayaran)
    {
        if (Auth::check() && Auth::user()->hak_akses == "admin") {
            $user = User::where('no_identitas', $siswa)->first();
            $registrasi = Registrasi::where('no_reg', $registrasi)->first();
            $pembayaran = Pembayaran::where('no_pem', $pembayaran)->first();
            return view('siswa.editpembayaran')->with(compact('user', 'registrasi', 'pembayaran'));
        } else {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "Bukan hak akses anda",
            ]);
            return redirect()->back();
        }
    }

    public function deletePembayaran($siswa, $tahunAjaran, $registrasi, $pembayaran)
    {
        $pembayaran = Pembayaran::where('no_pem', $pembayaran)->first();
        $pembayaran->delete();
        Session::flash("flash_notification", [
            "level"   => "danger",
            "message" => "No $pembayaran->no_pem pada bulan ".Helper::namaBulan($pembayaran->bulan)." berhasil dihapus!",
        ]);
        return redirect()->back();
    }
}
