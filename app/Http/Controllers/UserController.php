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
            $users = User::where('hak_akses', 'siswa')
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
            return view('siswa.create');
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
            'email'     => 'required|unique:users',
            'angkatan'     => 'required',
            'password'     => 'required',
        ], [
            'no_identitas.required' => 'field no identitas harus diisi',
            'no_identitas.integer'  => 'field no identitas harus berupa angka',
            'no_identitas.unique'   => 'no identitas yang anda masukkan sudah terpakai',
            'name.required'         => 'field nama harus diisi',
            'name.max'              => 'pengisian nama maxsimal 30 huruf',
            'email.required'     => 'field email harus diisi',
            'email.unique'       => 'email sudah terpakai',
            'email.max'          => 'pengisian email maksimal 20 huruf',
            'angkatan.required'     => 'field angkatan harus diisi',
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
            $users      = User::where('no_identitas', $id)->firstOrFail();
            $registrasi = Registrasi::where('user_id', $users->id)->get();
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
            return view('siswa.edit', compact('users'));
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

    public function tambahKelasPerSiswa($id)
    {
        if (Auth::check() && Auth::user()->hak_akses == "admin") {
            $users = User::where('no_identitas', $id)->firstOrFail();
            $kelas = Kelas::pluck('nama_kelas', 'id');
            return view('siswa.kelas')->with(compact('users', 'kelas'));
        } else {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "Bukan hak akses anda",
            ]);
            return redirect()->back();
        }
    }
    protected function existsKelas($request, $id)
    {
        return \DB::table('kelas_user')->where('user_id', $id)->where('kelas_id', $request->kelas_id)
            ->where('tahun_ajaran', $request->tahun_ajaran)->select('kelas_id')->count();
    }

    protected function existsTahun($request, $id)
    {
        return \DB::table('kelas_user')->where('user_id', $id)->select('tahun_ajaran')->where('tahun_ajaran', $request->tahun_ajaran)->count();
    }
    public function storeKelasPerSiswa(Request $request, $id)
    {
        $this->validate($request, [
        'kelas_id' => 'required',
        'tahun_ajaran' => 'required',
      ]);

        $user = User::where('no_identitas', $id)->firstOrFail();
        // return $this->existsKelas($request, $user->id);
        if ($this->existsTahun($request, $user->id) < 1) {
            $user->kelas()->attach($request->kelas_id, ['tahun_ajaran' => $request->tahun_ajaran]);
            Session::flash("flash_notification", [
            "level"   => "success",
            "message" => "Kelas berhasil disimpan!",
        ]);
            return redirect()->route('siswa.show', $user->no_identitas);
        } elseif ($this->existskelas($request, $id) > 1) {
            Session::flash("flash_notification", [
            "level"   => "danger",
            "message" => "Kelas dan tahun yang anda inputkan sudah ada!",
        ]);
            return redirect()->back();
        } else {
            Session::flash("flash_notification", [
            "level"   => "danger",
            "message" => "Kelas dan tahun yang anda inputkan sudah ada!",
        ]);
            return redirect()->back();
        }
    }

    protected function existsJenisPembayaran($request, $id, $tahunAjaran)
    {
        return Registrasi::where('jenis_pembayaran_id', $request->jenis_pembayaran_id)->where('user_id', $id)->where('tahun_ajaran', $tahunAjaran)->count();
    }

    public function registrasiPerTahunAjaran($siswa, $kelas, $tahunAjaran)
    {
        if (Auth::check() && Auth::user()->hak_akses == 'admin') {
            $users      = User::where('no_identitas', $siswa)->firstOrFail();
            $kelas = Kelas::where('nama_kelas', $kelas)->firstOrFail();
            $registrasi = Registrasi::where('user_id', $users->id)->get();
            return view('siswa.show-registrasi', compact('users', 'registrasi', 'tahunAjaran', 'kelas'));
        } else {
            Session::flash("flash_notification", [
              "level"   => "danger",
              "message" => "Tidak dapat mengakses",
          ]);
            return redirect()->back();
        }
    }

    public function createRegistrasi($id, $kelas, $tahunAjaran)
    {
        if (Auth::check() && Auth::user()->hak_akses == "admin") {
            $users = User::where('no_identitas', $id)->firstOrFail();
            $kelas = Kelas::where('nama_kelas', $kelas)->firstOrFail();
            $jenis = JenisPembayaran::pluck('jenis', 'id');
            return view('siswa.registrasi')->with(compact('users', 'jenis', 'tahunAjaran', 'kelas'));
        } else {
            Session::flash("flash_notification", [
                "level"   => "danger",
                "message" => "Bukan hak akses anda",
            ]);
            return redirect()->back();
        }
    }

    public function newRegistrasi(Request $request, $id, $kelas, $tahunAjaran)
    {
        $this->validate($request, [
            'no_reg'              => 'required|unique:registrasis',
            'jenis_pembayaran_id' => 'required',
        ], [
            'no_reg.required'              => 'field no registrasi harus diisi',
            'no_reg.unique'                => 'no registrasi sudah terpakai',
            'jenis_pembayaran_id.required' => 'field jenis pembayaran harus diisi',
        ]);
        $users           = User::where('no_identitas', $id)->firstOrFail();
        $kelas = Kelas::where('nama_kelas', $kelas)->firstOrFail();
        $data            = $request->all();
        $data['kelas_id'] = $kelas->id;
        $data['user_id'] = $users->id;
        $data['tahun_ajaran'] = $tahunAjaran;
        if ($this->existsJenisPembayaran($request, $users->id, $tahunAjaran) < 1) {
            $registrasi      = Registrasi::create($data);
            Session::flash("flash_notification", [
              "level"   => "success",
              "message" => "$registrasi->no_reg berhasil disimpan.",
          ]);
            return redirect(url('siswa/'.$id.'/'.$kelas->nama_kelas.'/'.$tahunAjaran));
        } else {
            Session::flash("flash_notification", [
              "level"   => "danger",
              "message" => "Jenis pembayaran yang anda inputkan pada tahun $tahunAjaran sudah ada",
          ]);
            return redirect()->back();
        }
    }
}
