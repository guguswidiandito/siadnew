@extends('layouts.app')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h1 class="box-title">Daftar Siswa</h1>
        <div class="pull-right">
            <a href="{{ url('siswa/create') }}" class="btn  bg-purple">Tambah Siswa</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="text-right">
          {!! Form::open(['url' => '/siswa', 'method'=>'GET', 'class'=>'form-inline']) !!}
          {!! Form::selectRange('angkatan', 2010, date('Y'), null, ['class'=>'form-control', 'placeholder'=>'Pilih tahun']) !!}
          <div class="input-group {!! $errors->has('q') ? 'has-error' : '' !!}">
              {!! Form::text('q', isset($q) ? $q : null, ['class'=>'form-control', 'placeholder' => 'NIS']) !!}
              <span class="input-group-btn">
                  <button class="btn  bg-maroon" type="submit">Cari</button>
              </span>
          </div>
          {!! Form::close() !!}
      </div>
      <br>
        <div class="table-responsive">
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th class="text-center">Jumlah Registrasi</th>
                        <th class="text-center">Tahun Angkatan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 1
                    @endphp
                    @forelse ($users as $s)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $s->no_identitas }}</td>
                        <td>{{ $s->name }}</td>
                        <td class="text-center">
                            @php
                            echo $s->registrasi()->count()." Registrasi";
                            @endphp
                        </td>
                        <td class="text-center">{{ $s->angkatan }}</td>
                        <td class="text-center">
                            {!! Form::model($s, ['route' => ['siswa.destroy', $s->id], 'method' => 'delete', 'class'=>'form-inline'] ) !!}
                            <a href="{{ route('siswa.show', $s->no_identitas) }}" class="btn  bg-olive">Show</a>
                            <a href="{{ route('siswa.edit', $s->id) }}" class="btn  bg-blue">Edit</a>
                            <button type="submit" class="btn   btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus {{ $s->name }}?')">Hapus </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- {{ $siswa->appends(compact('q', 'kelas', 'angkatan'))->links() }} --}}
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection
