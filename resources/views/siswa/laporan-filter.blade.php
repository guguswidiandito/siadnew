@extends('layouts.app')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h1 class="box-title">
          <p><strong>Kelas:</strong> {{ DB::table('kelas')->where('id', request()->kelas_id)->first()->nama_kelas }}</p><p><strong>Angkatan:</strong> {{ request()->angkatan }}</p></h1>
          <div class="pull-right"><a href="{{ url('laporan/identitas') }}" class="btn bg-navy">Kembali</a></div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">NIS</th>
              <th class="text-center">Nama</th>
              <th class="text-center">Kelas</th>
              <th class="text-center">Tahun Masuk</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($siswa as $key => $s)
              <tr>
                <td class="text-center">{{ ++$key }}</td>
                <td>{{ $s->no_identitas }}</td>
                <td>{{ $s->name }}</td>
                <td class="text-center">{{ DB::table('kelas')->where('id', request()->kelas_id)->first()->nama_kelas }}</td>
                <td class="text-center">{{ $s->angkatan }}</td>
              </tr>
            @empty
              <tr>
                <td class="text-center" colspan="5">Data tidak ditemukan</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection
