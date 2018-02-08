@extends('layouts.app')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h1 class="box-title">Laporan Pembayaran</h1>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::open(['url' => route('laporan.pembayaran.filter'), 'method' => 'POST']) !!}
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th width="200px">Kelas</th>
                    <td>
                        {!! Form::select('kelas', []+App\Kelas::pluck('nama_kelas','nama_kelas')->all(), null, ['class'=>'form-control', 'placeholder' => 'Pilih kelas']) !!}
                    </td>
                </tr>
                <tr>
                    <th width="200px">Jenis Pembayaran</th>
                    <td>
                        {!! Form::select('jenis_pembayaran_id', []+App\JenisPembayaran::pluck('jenis','id')->all(), null, ['class'=>'form-control', 'placeholder' => 'Pilih jenis pembayaran']) !!}
                    </td>
                </tr>
                <tr>
                    <th width="200px">Tahun Ajaran</th>
                    <td>
                      @php
                      foreach (range(2010,date('Y')) as $i ) {
                      $j=$i+1;
                      $tahun_ajaran[$i.'-'.$j] = $i.' / '.$j;
                      }
                      @endphp
                      {!! Form::select('tahun_ajaran', $tahun_ajaran, null, ['class' => 'form-control', 'placeholder' => 'Pilih tahun ajaran']) !!}
                    </td>
                </tr>
                <tr>
                    <th width="200px">Tahun Angkatan</th>
                    <td>
                      {!! Form::selectRange('angkatan', 2010, date('Y'), null, ['class' => 'form-control', 'placeholder' => 'Pilih tahun angkatan']) !!}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        {!! Form::submit('lihat', ['class'=>'btn btn-primary']) !!}
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
