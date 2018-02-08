@extends('layouts.app')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h1 class="box-title">Pembayaran dengan No Reg:
        <strong>{{ $registrasi->no_reg }}</strong></h1>
        <div class="pull-right">
          <a href="{{ url('siswa/'.$user->no_identitas.'/'.$kelas->nama_kelas.'/'.$tahunAjaran) }}" class="btn bg-navy ">Kembali</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      @php
        $s = 0;
      @endphp
      @foreach ($registrasi->pembayaran()->get() as $p)
        @php $s += $p->bayar; @endphp
      @endforeach
      @if ($registrasi->jenispembayaran->nominal == $s)
        <table class="table table-bordered table-condensed">
          <thead>
            <th class="text-center" width="20px">No</th>
            <th class="text-center">No Pembayaran</th>
            <th class="text-center">Bulan</th>
            <th class="text-center">Nominal</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Aksi</th>
          </thead>
          <tbody>
            @forelse($registrasi->pembayaran()->get() as $key => $p)
              <tr>
                <td class="text-center">{{ ++$key }}</td>
                <td class="text-center">{{ $p->no_pem }}</td>
                <td>{{ Helper::namaBulan($p->bulan) }}</td>
                <td class="text-right">Rp. {{ number_format($p->bayar) }}</td>
                <td class="text-center">{{ $p->created_at->format('d/m/Y') }}</td>
                <td class="text-center">
                  {!! Form::open(['route' => ['pembayaran.destroy', $user->no_identitas, $kelas->nama_kelas, $tahunAjaran, $registrasi->no_reg, $p->no_pem], 'method' => 'DELETE']) !!}
                          {!! Form::submit("Hapus", ['class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Apakah anda yakin akan menghapus $p->no_pem?')"]) !!}
                  {!! Form::close() !!}
              </td>
              </tr>
            @empty
              <tr>
                <td class="text-center" colspan="5">Data tidak ditemukan</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      @else
      {!! Form::open(['method' => 'POST', 'route' => ['pembayaran.store', $user->no_identitas, $kelas->nama_kelas, $tahunAjaran, $registrasi->no_reg]]) !!}
      <table class="table table-bordered table-condensed">
        <tr>
          <th>No Pembayaran</th>
          <td>
              {!! Form::text('no_pem', $registrasi->no_reg, ['class' => 'form-control', 'placeholder' => 'No Pembayaran', 'autofocus']) !!}
            </td>
        </tr>
        <tr>
          <th>Bulan</th>
          <td>
                {!! Form::selectMonth('bulan', null, ['class' => 'form-control', 'placeholder' => 'Pilih bulan']) !!}
            </div>
          </td>
        </tr>
        <tr>
          <th>Nominal</th>
          <td>
              {!! Form::number('bayar', null, ['class' => 'form-control', 'placeholder' => 'Nominal']) !!}
          </td>
        </tr>
        <tr>
          <td colspan="2">{!! Form::submit('Simpan', ['class' => 'btn btn-info ']) !!}</td>
        </tr>
      </table>
      <br>
      {!! Form::close() !!}
      <table class="table table-bordered table-condensed">
        <thead>
          <th class="text-center" width="20px">No</th>
          <th class="text-center">No Pembayaran</th>
          <th class="text-center">Bulan</th>
          <th class="text-center">Nominal</th>
          <th class="text-center">Tanggal</th>
          <th class="text-center">Aksi</th>
        </thead>
        <tbody>
          @forelse($registrasi->pembayaran()->get() as $key => $p)
            <tr>
              <td class="text-center">{{ ++$key }}</td>
              <td class="text-center">{{ $p->no_pem }}</td>
              <td>{{ Helper::namaBulan($p->bulan) }}</td>
              <td class="text-right">Rp. {{ number_format($p->bayar) }}</td>
              <td class="text-center">{{ $p->created_at->format('d/m/Y') }}</td>
              <td class="text-center">
              {!! Form::open(['route' => ['pembayaran.destroy', $user->no_identitas, $kelas->nama_kelas, $tahunAjaran, $registrasi->no_reg, $p->no_pem], 'method' => 'DELETE']) !!}
                      {!! Form::submit("Hapus", ['class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Apakah anda yakin akan menghapus $p->no_pem?')"]) !!}
              {!! Form::close() !!}
            </td>
            </tr>
          @empty
            <tr>
              <td class="text-center" colspan="5">Data tidak ditemukan</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    @endif
      </div>
</div>
<!-- /.box -->
@endsection
