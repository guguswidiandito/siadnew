@extends('layouts.app')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h1 class="box-title">{{$registrasi->no_reg}}</h1>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::model($pembayaran, ['route' => ['pembayaran.update', $user->no_identitas, $registrasi->no_reg, $pembayaran->no_pem], 'method'=>'patch'])!!}
        <table class="table table-bordered">
           <tr>
                <th width="200px">No Pembayaran</th>
                <td>
                    {!! Form::text('no_pem', null, ['class'=>'form-control', 'placeholder'=>'No Pembayaran', 'disabled']) !!}
                </td>
            </tr>
            <tr>
                <th>Semester</th>
                <td>
                    {!! Form::select('semester', ['1 (Satu)'=>'1 (Satu)', '2 (Dua)'=>'2 (Dua)'], null , ['class'=>'form-control', 'placeholder' => 'Pilih semester', 'disabled']) !!}
                    {!! $errors->first('semester', '<p class="help-block">:message</p>') !!}
                </td>
            </tr>
            <tr>
                <th>Bayar</th>
                <td>
                    {!! Form::number('bayar',null , ['class'=>'form-control', 'placeholder' => 'Total Bayar', 'required', 'integer']) !!}
                    {!! $errors->first('bayar', '<p class="help-block">:message</p>') !!}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" class="btn btn-flat btn-danger">Update</button>
                    <a href="{{ url('siswa/'.$user->no_identitas.'/'.$registrasi->no_reg) }}" title="" class="btn btn-flat btn-success">Cancel</a>
                </td>
            </tr>
        </table>
        {!! Form::close() !!}
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection
