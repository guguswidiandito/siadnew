<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use PDF;
use App\Kelas;

class ReportController extends Controller
{
    public function identitas()
    {
        return view('siswa.identitas');
    }

    public function identitasFilter(Request $request)
    {
        $this->validate($request, [
          'kelas_id' => 'required',
          'angkatan' => 'required'
      ], [
          'kelas_id.required' => 'Anda masih belum memilih kelas yang akan diproses.',
      ]);
        $siswa   = User::where('hak_akses', 'siswa')
          ->join('kelas_user', 'kelas_user.user_id', '=', 'users.id')
          ->where('kelas_user.kelas_id', $request->kelas_id)
          ->where('angkatan', 'LIKE', $request->angkatan)
          ->orderBy('no_identitas')
          ->get();
        return view('siswa.laporan-filter', compact('siswa'));
    }

    public function identitasPdf(Request $request)
    {
        $this->validate($request, [
            'kelas_id' => 'required',
        ], [
            'kelas_id.required' => 'Anda masih belum memilih kelas yang akan diproses.',
        ]);
        $kelas   = $request->get('kelas_id');
        $tanggal = $request->get('angkatan');
        $siswa   = User::where('kelas_id', 'LIKE', '%' . $kelas . '%')
            ->where('angkatan', array($tanggal))
            ->get();
        $pdf = PDF::loadview('siswa.siswa', compact('siswa'));
        return $pdf->stream('Laporan Identitas.pdf');
    }

    public function pembayaran()
    {
        return view('siswa.exportpembayaran');
    }

    public function pembayaranFilter(Request $request)
    {
        $this->validate($request, [
          'kelas' => 'required',
          'jenis_pembayaran_id' => 'required',
          'tahun_ajaran' => 'required',
          'angkatan' => 'required'
      ]);
        $registrasi = User::where('hak_akses', 'siswa')
        ->whereHas('kelas', function ($q) use ($request) {
            $q->where('tahun_ajaran', $request->tahun_ajaran)
            ->where('nama_kelas', $request->kelas)
            ->whereHas('registrasi', function ($q) use ($request) {
                $q->whereHas('jenispembayaran', function ($q) use ($request) {
                    $q->where('id', $request->jenis_pembayaran_id);
                })->with('pembayaran');
            });
        })->where('angkatan', $request->angkatan)->get();

        return view('siswa.pembayaran-filter', compact('registrasi'));
    }

    public function pembayaranPdf(Request $request)
    {
        $registrasi = \DB::table('users')
            ->join('registrasis', 'registrasis.user_id', '=', 'users.id')
            ->join('jenis_pembayarans', 'registrasis.jenis_pembayaran_id', '=', 'jenis_pembayarans.id')
            ->join('pembayarans', 'pembayarans.registrasi_id', '=', 'registrasis.id')
            ->join('kelas_user', 'kelas_user.user_id', '=', 'users.id')
            ->join('kelas', 'kelas.id', '=', 'kelas_user.kelas_id')
            ->where('jenis_pembayarans.jenis', $request->jenis_pembayaran)
            ->where('kelas.nama_kelas', $request->kelas)
            ->where('registrasis.tahun_ajaran', $request->tahun_ajaran)
            ->orderBy('no_reg')
            ->get();
        return $registrasi;
        // return $registrasi;
        $pdf = PDF::loadview('siswa.laporanPembayaran', compact('registrasi'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan Pembayaran.pdf');
    }
}
