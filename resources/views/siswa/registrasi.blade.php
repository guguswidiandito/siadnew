@extends('layouts.app')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h1 class="box-title">Registrasi Baru atas nama <strong>{{ $users->name }}</strong></h1>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::model($users, ['route' => ['registrasi.store', $users->no_identitas, $kelas->nama_kelas, $tahunAjaran], 'method'=>'post'])!!}
        <table class="table table-bordered">
            <tr>
                <th width="200px">No Registrasi</th>
                <td>
                    {!! Form::text('no_reg', null, ['class'=>'form-control', 'placeholder'=>'No Registrasi', 'autofocus']) !!}
                </td>
            </tr>
            <tr>
                <th width="200px">Jenis Pembayaran</th>
                <td>
                    {!! Form::select('jenis_pembayaran_id', $jenis, null, ['class'=>'form-control', 'placeholder'=>'Pilih jenis pembayaran']) !!}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" class="btn btn-primary ">Simpan</button>
                    <a href="{{ url('siswa/'.$users->no_identitas.'/'.$kelas->nama_kelas.'/'.$tahunAjaran) }}" title="" class="btn btn-success ">Cancel</a>
                </td>
            </tr>
        </table>
        {!! Form::close() !!}
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection
