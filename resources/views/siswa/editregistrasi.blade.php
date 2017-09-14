@extends('layouts.app')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h1 class="box-title">Edit No Reg. <strong>{{ $registrasi->no_reg }}</strong></h1>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::model($registrasi, ['route' => ['registrasi.update', $registrasi->user_id, $registrasi->id], 'method'=>'patch'])!!}
        <table class="table table-bordered">
            <tr>
                <th width="200px">No Registrasi</th>
                <td>
                    {!! Form::text('no_reg', null, ['class'=>'form-control', 'placeholder'=>'No Registrasi', 'required', 'autofocus']) !!}
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
                    <button type="submit" class="btn btn-flat btn-primary">Simpan</button>
                    <a href="{{ route('siswa.show', $registrasi->user_id) }}" title="" class="btn btn-flat btn-success">Cancel</a>
                </td>
            </tr>
        </table>
        {!! Form::close() !!}
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection