@extends('layouts.app')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h1 class="box-title">Laporan Identitas</h1>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::open(['url' => route('laporan.identitas'), 'method' => 'post', 'target'=>'_blank']) !!}
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
                        <select name="angkatan" class="form-control">
                            <option selected="selected" disabled="disabled" hidden="hidden" value="">Pilih tahun</option>
                            <?php
                            for ($i=2010; $i<=date('Y'); $i++) {
                            echo "<option value='".$i."'>".$i."</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        {!! Form::submit('Download', ['class'=>'btn btn-primary']) !!}
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