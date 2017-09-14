@extends('layouts.app')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h1 class="box-title">Tambah Kelas</h1>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::model($kelas, ['route' => ['kelas.update', $kelas->id], 'method'=>'patch'])!!}
        <table class="table table-bordered">
            <tr>
                <th>Kelas</th>
                <td>
                    {!! Form::text('nama_kelas', null, ['class'=>'form-control','autofocus','required', 'placeholder'=>'Kelas']) !!}
                </td>
            </tr>
            <tr>
                <th>Jurusan</th>
                <td>
                    {!! Form::text('jurusan', null, ['class'=>'form-control', 'placeholder'=>'Jurusan']) !!}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('kelas.index') }}" class="btn btn-default" title="">Kembali</a>
                </td>
            </tr>
        </table>
        {!! Form::close() !!}
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection