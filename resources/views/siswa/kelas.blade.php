@extends('layouts.app')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h1 class="box-title">Tambah kelas atas nama <strong>{{ $users->name }}</strong></h1>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::model($users, ['route' => ['siswa.kelas.store', $users->no_identitas], 'method'=>'post'])!!}
        <table class="table table-bordered">
            <tr>
                <th width="200px">Kelas</th>
                <td>
                    {!! Form::select('kelas_id', $kelas, null, ['class'=>'form-control', 'placeholder'=>'Pilih kelas']) !!}
                </td>
            </tr>
            <tr>
                <th width="200px">Tahun Ajaran</th>
                <td>
                @php
                foreach (range($users->angkatan,date('Y')) as $i ) {
                $j=$i+1;
                $tahun_ajaran[$i.'-'.$j] = $i.' / '.$j;
                }
                @endphp
                {!! Form::select('tahun_ajaran', $tahun_ajaran, null, ['class' => 'form-control', 'placeholder' => 'Pilih']) !!}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" class="btn btn-primary ">Simpan</button>
                    <a href="{{ url('siswa/'.$users->no_identitas) }}" title="" class="btn btn-success ">Cancel</a>
                </td>
            </tr>
        </table>
        {!! Form::close() !!}
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection
