@extends('layouts.app')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h1 class="box-title">Edit <strong>{{ $jenis->jenis }}</strong></h1>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::model($jenis, ['route' => ['jenis.update', $jenis->id], 'method' => 'patch'])!!}
        <table class="table table-bordered">
            <tr>
                <th>Jenis Pembayaran</th>
                <td>
                    {!! Form::text('jenis', null, ['class'=>'form-control','autofocus','required', 'placeholder'=>'Jenis Pembayaran']) !!}
                </td>
            </tr>
            <tr>
                <th>Nominal</th>
                <td>
                    {!! Form::number('nominal', null, ['class'=>'form-control','min'=>50000,'required', 'placeholder'=>'Nominal']) !!}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('jenis.index') }}" class="btn btn-default" title="">Kembali</a>
                </td>
            </tr>
        </table>
        {!! Form::close() !!}
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection