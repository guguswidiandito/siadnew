@extends('layouts.app')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h1 class="box-title">Laporan Identitas</h1>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::open(['url' => route('laporan.identitas.filter'), 'method' => 'POST']) !!}
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th width="200px">Kelas</th>
                    <td>
                        {!! Form::select('kelas_id', []+App\Kelas::pluck('nama_kelas','id')->all(), null, [
                        'class'=>'form-control', 'placeholder'=>'Pilih kelas']) !!}
                    </td>
                </tr>
                <tr>
                    <th width="200px">Tahun Angkatan</th>
                    <td>
                            {!! Form::selectRange('angkatan', 2010, date('Y'), null, ['class'=>'form-control', 'placeholder'=>'Pilih tahun']) !!}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        {!! Form::submit('Lihat', ['class'=>'btn btn-primary']) !!}
                    </td>
                </tr>
            </tbody>
        </table>
        {!! Form::close() !!}
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection
