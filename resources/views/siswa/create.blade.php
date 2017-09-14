@extends('layouts.app')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h1 class="box-title">Tambah Siswa</h1>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::open(['route' => 'siswa.store'])!!}
        <table class="table table-bordered">
            <tr>
                <th>NIS</th>
                <td>
                    {!! Form::text('no_identitas',null , ['class'=>'form-control', 'placeholder' => 'NIS','autofocus' ]) !!}
                </td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>
                    {!! Form::text('name',null , ['class'=>'form-control', 'placeholder' => 'Name' ]) !!}
                </td>
            </tr>
            <tr>
                <th>Username</th>
                <td>
                    {!! Form::text('username', null, ['class'=>'form-control', 'placeholder' => 'Username' ]) !!}
                </td>
            </tr>
            <tr>
                <th width="200px">Kelas</th>
                <td>
                    {!! Form::select('kelas_id', $kelas, null, ['class'=>'form-control', 'placeholder'=>'Pilih kelas']) !!}
                </td>
            </tr>
            <tr>
                <th width="200px">Angkatan</th>
                <td>
                    <select name="angkatan" class="form-control">
                        <option selected="selected" disabled="disabled" hidden="hidden" value="">Pilih tahun angkatan</option>
                        <?php
                        for ($i=2010; $i<=date('Y'); $i++) {
                            echo "<option value='".$i."'>".$i."</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Password</th>
                <td>
                    {!! Form::text('password', null, ['class'=>'form-control', 'placeholder' => 'Password' ]) !!}
                </td>
            </tr>
            <tr>
            <td colspan="2">
                {!! Form::submit('Simpan', ['class'=>'btn btn-primary']) !!}
                <a href="{{ route('siswa.index') }}" class="btn btn-default">Kembali</a>
            </td>
        </tr>
        </table>
        {!! Form::close() !!}
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection