<?php

namespace App\Http\Controllers;

use App\JenisPembayaran;
use Auth;
use Illuminate\Http\Request;
use Session;

class JenisController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->hak_akses == "admin") {
            $jenis = JenisPembayaran::all();
            return view('jenis.index')->withJenis($jenis);
        } else {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "Bukan hak akses anda",
            ]);
            return redirect()->back();
        }
    }

    public function create()
    {
        if (Auth::check() && Auth::user()->hak_akses == "admin") {
            return view('jenis.create');
        } else {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "Bukan hak akses anda",
            ]);
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'jenis'   => 'required|unique:jenis_pembayarans',
            'nominal' => 'required',
        ], [
            'jenis.required'   => 'field jenis pembayaran harus diisi',
            'jenis.unique'     => 'jenis pembayaran sudah ada',
            'nominal.required' => 'field nominal harus diisi',
        ]);

        $jenis = JenisPembayaran::create($request->all());
        Session::flash("flash_notification", [
            "level"   => "success",
            "message" => "$jenis->jenis berhasil disimpan.",
        ]);
        return redirect()->route('jenis.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        if (Auth::check() && Auth::user()->hak_akses == "admin") {
            $jenis = JenisPembayaran::find($id);
            return view('jenis.edit')->withJenis($jenis);
        } else {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "Bukan hak akses anda",
            ]);
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $jenis = JenisPembayaran::find($id);
        if ($jenis->registrasi()->count() > 0) {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "$jenis->jenis tidak bisa diupdate, karena sudah dipakai oleh registrasi",
            ]);
            return redirect()->back();
        } else {
            $jenis->update($request->all());
            Session::flash("flash_notification", [
                "level"   => "success",
                "message" => "$jenis->jenis berhasil diupdate.",
            ]);
            return redirect()->route('jenis.index');
        }
    }

    public function destroy($id)
    {
        $jenis = JenisPembayaran::find($id);
        if ($jenis->registrasi()->count() > 0) {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "$jenis->jenis tidak bisa dihapus, karena sudah dipakai oleh registrasi",
            ]);
            return redirect()->back();
        } else {
            $jenis->delete();
            Session::flash("flash_notification", [
                "level"   => "success",
                "message" => "$jenis->jenis berhasil dihapus.",
            ]);
            return redirect()->back();
        }
    }
}
