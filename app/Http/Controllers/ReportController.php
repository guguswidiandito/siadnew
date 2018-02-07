<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    public function identitas()
    {
        return view('siswa.identitas');
    }

    public function identitasFilter(Request $request)
    {
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

    public function pembayaranPdf(Request $request)
    {
        $registrasi = \DB::table('users')
            ->join('kelas', 'users.kelas_id', '=', 'kelas.id')
            ->join('registrasis', 'registrasis.user_id', '=', 'users.id')
            ->join('jenis_pembayarans', 'registrasis.jenis_pembayaran_id', '=', 'jenis_pembayarans.id')
            ->join('pembayarans', 'pembayarans.registrasi_id', '=', 'registrasis.id')
            ->where('kelas_id', 'like', '%' . $request->get('kelas') . '%')
            ->where('angkatan', 'LIKE', '%' . $request->get('tahun') . '%')
            ->orderBy('no_reg')
            ->get();
        // return $registrasi;
        $pdf = PDF::loadview('siswa.laporanPembayaran', compact('registrasi'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan Pembayaran.pdf');
    }
}
