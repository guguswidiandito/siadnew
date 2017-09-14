<?php

namespace App\Http\Controllers;

use App\JenisPembayaran;
use App\Kelas;
use App\Registrasi;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Session;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check() && Auth::user()->hak_akses == "admin") {
            $users = User::with('kelas')
                ->where('hak_akses', 'siswa')
                ->where('kelas_id', 'LIKE', '%' . $request->kelas . '%')
                ->where('angkatan', 'LIKE', '%' . $request->angkatan . '%')
                ->where('no_identitas', 'LIKE', '%' . $request->q . '%')
                ->orderBy('no_identitas')
                ->get();
            return view('siswa.index')->withUsers($users);
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
            $kelas = Kelas::pluck('nama_kelas', 'id');
            return view('siswa.create', compact('kelas'));
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
            'no_identitas' => 'required|integer|unique:users',
            'name'         => 'required|max:30',
            'username'     => 'required|unique:users|max:20',
            'angkatan'     => 'required',
            'kelas_id'     => 'required',
            'password'     => 'required',
        ], [
            'no_identitas.required' => 'field no identitas harus diisi',
            'no_identitas.integer'  => 'field no identitas harus berupa angka',
            'no_identitas.unique'   => 'no identitas yang anda masukkan sudah terpakai',
            'name.required'         => 'field nama harus diisi',
            'name.max'              => 'pengisian nama maxsimal 30 huruf',
            'username.required'     => 'field username harus diisi',
            'username.unique'       => 'username sudah terpakai',
            'username.max'          => 'pengisian username maksimal 20 huruf',
            'angkatan.required'     => 'field angkatan harus diisi',
            'kelas_id.required'     => 'field kelas harus diisi',
            'password.required'     => 'field password harus diisi',
        ]);
        $data              = $request->all();
        $data['password']  = bcrypt($request->password);
        $data['hak_akses'] = 'siswa';
        $users             = User::create($data);
        Session::flash("flash_notification", [
            "level"   => "success",
            "message" => "nama $users->name dengan NIS $users->no_identitas berhasil disimpan.",
        ]);
        return redirect()->back();
    }

    public function show($id)
    {
        if (Auth::check() && Auth::user()->hak_akses == 'admin') {
            $users      = User::find($id);
            $registrasi = Registrasi::where('user_id', $id)->get();
            return view('siswa.show', compact('users', 'registrasi'));
        } else {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "Tidak dapat mengakses",
            ]);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if (Auth::check() && Auth::user()->hak_akses == 'admin') {
            $users = User::find($id);
            $kelas = Kelas::pluck('nama_kelas', 'id');
            return view('siswa.edit', compact('users', 'kelas'));
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
        $users = User::find($id);
        $users->update($request->all());
        Session::flash("flash_notification", [
            "level"   => "success",
            "message" => "$users->no_identitas berhasil diupdate.",
        ]);
        return redirect()->route('siswa.index');
    }

    public function destroy($id)
    {
        $users = User::find($id);
        if ($users->registrasi()->count() > 0) {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "NIS $users->no_identitas tidak dapat dihapus karena sudah melakukan registrasi.",
            ]);
            return redirect()->back();
        } else {
            $users->pembayaran()->delete();
            $users->registrasi()->delete();
            $users->delete();
            Session::flash("flash_notification", [
                "level"   => "success",
                "message" => "NIS $users->no_identitas berhasil dihapus.",
            ]);
            return redirect()->back();
        }
    }

    public function createRegistrasi($id)
    {
        if (Auth::check() && Auth::user()->hak_akses == "admin") {
            $users = User::find($id);
            $jenis = JenisPembayaran::pluck('jenis', 'id');
            return view('siswa.registrasi')->with(compact('jenis', 'users'));
        } else {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "Bukan hak akses anda",
            ]);
            return redirect()->back();
        }
    }

    public function newRegistrasi(Request $request, $id)
    {
        $this->validate($request, [
            'no_reg'              => 'required|unique:registrasis',
            'jenis_pembayaran_id' => 'required',
        ], [
            'no_reg.required'              => 'field no registrasi harus diisi',
            'no_reg.unique'                => 'no registrasi sudah terpakai',
            'jenis_pembayaran_id.required' => 'field jenis pembayaran harus diisi',
        ]);
        $users           = User::find($id);
        $data            = $request->all();
        $data['user_id'] = $users->id;
        $registrasi      = Registrasi::create($data);
        Session::flash("flash_notification", [
            "level"   => "success",
            "message" => "$registrasi->no_reg berhasil disimpan.",
        ]);
        return redirect()->route('siswa.show', $users->id);
    }
}
