<?php

namespace App\Http\Controllers;

use App\Kelas;
use Auth;
use Illuminate\Http\Request;
use Session;

class KelasController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->hak_akses == "admin") {
            $kelas = Kelas::all();
            return view('kelas.index')->withKelas($kelas);
        } else {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "Tidak dapat mengakses",
            ]);
            return redirect()->back();
        }
    }

    public function create()
    {
        if (Auth::check() && Auth::user()->hak_akses == "admin") {
            return view('kelas.create');
        } else {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "Tidak dapat mengakses",
            ]);
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_kelas' => 'required|unique:kelas',
        ], [
            'nama_kelas.required' => 'nama kelas harus diisi',
            'nama_kelas.unique'   => 'nama kelas sudah ada',
        ]);

        $kelas = Kelas::create($request->all());
        Session::flash("flash_notification", [
            "level"   => "success",
            "message" => "$kelas->nama berhasil disimpan.",
        ]);
        return redirect()->back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        if (Auth::check() && Auth::user()->hak_akses == "admin") {
            $kelas = Kelas::find($id);
            return view('kelas.edit', compact('kelas'));
        } else {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "Tidak dapat mengakses",
            ]);
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_kelas' => 'required|unique:kelas',
        ], [
            'nama_kelas.required' => 'nama kelas harus diisi',
            'nama_kelas.unique'   => 'nama kelas sudah ada',
        ]);
        $kelas = Kelas::find($id);
        $kelas->update($request->all());
        Session::flash("flash_notification", [
            "level"   => "success",
            "message" => "$kelas->nama berhasil diupdate.",
        ]);
    }

    public function destroy($id)
    {
        $kelas = Kelas::find($id);
        if ($kelas->users()->count() > 0) {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "kelas $kelas->nama_kelas tidak dapat dihapus karena masih terdapat " . $kelas->users()->count() . " siswa",
            ]);
            return redirect()->back();
        } else {
            $kelas->users()->delete();
            $kelas->delete();
            Session::flash("flash_notification", [
                "level"   => "success",
                "message" => "$kelas->nama berhasil diupdate.",
            ]);
            return redirect()->back();
        }

    }
}
