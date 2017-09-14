@extends('layouts.app')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h1 class="box-title">Pembayaran dengan No Reg:
        <strong>{{ $users->no_reg }}</strong></h1>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        @if ($users->pembayaran()->count() < 1)
        {!! Form::model($users, ['route' => ['pembayaran.create',$users->user_id, $users->id], 'method'=>'post'])!!}
        <table class="table table-bordered">
            <tr>
                <th>No Pembayaran</th>
                <td>
                    {!! Form::text('no_pem', null, ['class'=>'form-control', 'placeholder'=>'No Pembayaran', 'autofocus']) !!}
                </td>
            </tr>
            <tr>
                <th>Semester</th>
                <td>
                    {!! Form::select('semester', ['1 (Satu)'=>'1 (Satu)', '2 (Dua)'=>'2 (Dua)'], null , ['class'=>'form-control', 'placeholder' => 'Pilih semester']) !!}
                </td>
            </tr>
            <tr>
                <th>Bayar</th>
                <td>
                    {!! Form::number('bayar',null , ['class'=>'form-control', 'placeholder' => 'Total Bayar', 'integer']) !!}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" class="btn btn-flat btn-primary">Simpan</button>
                    <a href="{{ route('siswa.show', $users->user_id) }}" title="" class="btn btn-flat btn-success">Cancel</a>
                </td>
            </tr>
        </table>
        {!! Form::close() !!}
        @else
        <div class="row">
            <div class="col-md-6">
                <table class="table table-striped table-bordered">
                    @foreach ($users->pembayaran()->where('user_id', $users->user_id)->get() as $u)
                    <tr>
                        <th width="300px">No Pembayaran</th>
                        <td>{{ $u->no_pem }}</td>
                    </tr>
                    <tr>
                        <th width="300px">No Registrasi</th>
                        <td>{{ $u->registrasi->no_reg }}</td>
                    </tr>
                    <tr>
                        <th width="300px">Nama</th>
                        <td>{{ $u->users->name }}</td>
                    </tr>
                    <tr>
                        <th width="300px">Jenis Pembayaran</th>
                        <td>{{ $u->registrasi->jenispembayaran->jenis }}</td>
                    </tr>
                    <tr>
                        <th width="300px">Nominal</th>
                        <td>Rp. {{ number_format($u->jenispembayaran->nominal) }}</td>
                    </tr>
                    <tr>
                        <th width="300px">Total Bayar</th>
                        <td>Rp. {{ number_format($u->bayar) }}</td>
                    </tr>
                    <tr>
                        <th width="300px">Tunggakan</th>
                        <td>Rp. {{ number_format($u->tunggakan) }}</td>
                    </tr>
                    <tr>
                        <th width="300px">Keterangan</th>
                        <td>{{ $u->keterangan }}</td>
                    </tr>
                    <tr>
                        <th width="300px">Tanggal Awal Pembayaran</th>
                        <td>{{ $u->created_at->format('j M Y') }}</td>
                    </tr>
                    <tr>
                        <th width="300px">Tanggal Terakhir Pelunasan</th>
                        <td>{{ $u->updated_at->format('j M Y') }}</td>
                    </tr>
                    @php
                    $progress = ($u->bayar/$u->jenispembayaran->nominal)*100;
                    @endphp
                    @endforeach
                </table>
            </div>
            <div class="col-md-5">
                
                @if ($progress < 100)
                <div class="well">
                    <h1>{{ $u->keterangan }}</h1>
                    <div class="progress">
                        <div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: {{ $progress }}%">
                        </div>
                    </div>
                </div>
                <h3>Tunggakan: <strong>Rp. {{ number_format($u->tunggakan) }}</strong></h3>
                @else
                <div class="well">
                    <h1>{{ $u->keterangan }}</h1>
                    <div class="progress">
                        <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: {{ $progress }}%">
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @foreach ($users->pembayaran()->where('user_id', $users->user_id)->get() as $e)
        @if ($e->keterangan == "Belum Lunas" )
        <a href="{{ url('siswa/'.$e->user_id.'/registrasi/'.$e->registrasi_id.'/pembayaran/'.$e->id.'/edit') }}" title="" class="btn btn-flat btn-danger">Update Pembayaran</a>
        @endif
        @endforeach
        <a href="{{ route('siswa.show', $users->user_id) }}" title="" class="btn  btn-flat btn-success">Kembali</a>
        @endif
    </div>
</div>
<!-- /.box -->
@endsection