@extends('layouts.app')
@section('content')
<div class="box box-primary">
	<div class="box-header with-border">
		Show <strong>{{ $users->name }}</strong>
    <div class="pull-right">
      <td class="text-center">
        <a href="{{ route('siswa.show', $users->no_identitas) }}" title="" class="btn  bg-navy">Kembali</a>
      </td>
    </div>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
    <h3><a href="{{ url('siswa/'.$users->no_identitas.'/'.$tahunAjaran.'/registrasi') }}" class="btn   btn-primary ">Registrasi Baru</a></h3>
    <div class="table-responsive">
      <table class="table table-bordered table-condensed">
        <thead>
          <tr>
            <th colspan="8" class="text-center">Registration</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle !important">Aksi</th>
          </tr>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">No Reg</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Jenis</th>
            <th class="text-center">Nominal</th>
            <th class="text-center">Bayar</th>
            <th class="text-center">Tunggakan</th>
            <th class="text-center">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($users->registrasi()->where('tahun_ajaran', $tahunAjaran)->get() as $key => $p)
          <tr>
            <td class="text-center">{{ ++$key }}</td>
            <td>{{ $p->no_reg }}</td>
            <td>{{ $p->created_at->format('j M Y') }}</td>
            <td>{{ $p->jenispembayaran->jenis }}</td>
            <td class="text-right">Rp. {{ number_format($p->jenispembayaran->nominal) }}</td>
            <td>
            @if ($p->pembayaran()->where('user_id', $users->id)->count() > 0)
              <table class="table table-bordered table-condensed">
                <tr>
                  <th class="text-center">No</th><th class="text-center">No Pembayaran</th><th class="text-center">Bulan</th><th class="text-center">Jumlah</th>
                </tr>
              @foreach ($p->pembayaran()->where('user_id', $users->id)->get() as $key => $c)
                <tr>
                  <td class="text-center">{{ ++$key }}</td><td class="text-center">{{ $c->no_pem }}</td><td>{{ Helper::namaBulan($c->bulan) }}</td><td class="text-right">Rp. {{ number_format($c->bayar) }}</td>
                </tr>
              @endforeach
            </table>
          @else
              <strong><p class="text-center">Belum dibayar</p></strong>
          @endif
            </td>
            <td class="{{ $p->pembayaran()->where('user_id', $p->user_id)->count() > 0 ? "text-right" : "text-center" }}">
              @php
                $s = 0;
              @endphp
              @if ($p->pembayaran()->where('user_id', $p->user_id)->count() > 0)
              @foreach ($p->pembayaran()->where('user_id', $p->user_id)->get() as $c)
                @php
                  $s += $c->bayar;
                  $tunggakan = $p->jenispembayaran->nominal - $s;
                @endphp
              @endforeach
              Rp. {{ number_format($tunggakan) }}
              @else
              <strong>Belum dibayar</strong>
              @endif
            </td>
            <td class="text-center">
              @if ($p->pembayaran()->where('user_id', $p->user_id)->count() >0)
              @foreach ($p->pembayaran()->where('user_id', $p->user_id)->take(1)->get() as $c)
          			@php if($s == $p->jenispembayaran->nominal) : @endphp
								<span class="label label-success"><b>Lunas</b></span>
								@php else : @endphp
								<span class="label label-danger"><b>Belum Lunas</b></span>
								@php endif	@endphp
              @endforeach
              @else
              <strong>Belum dibayar</strong>
              @endif
            </td>
            <td class="text-center">
              {!! Form::model($p, ['route'=>['registrasi.delete', $users->no_identitas, $p->id], 'method' => 'delete', 'class'=>'form-inline']) !!}
              <a href="{{ url('siswa/'.$users->no_identitas.'/'.$tahunAjaran.'/'.$p->no_reg) }}" title="" class="btn btn-info">Lihat Pembayaran</a>
              {{-- <button type="submit" class="btn   btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus {{$p->no_reg}}?')">Hapus</button> --}}
              {!! Form::close() !!}
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="9" class="text-center">Tidak ada data</td>
          </tr>
          @endforelse
          <tr>
            <th colspan="4" class="text-center">Total</th>
            <td class="text-right">
							<strong>  Rp.
							              @php
							              $nominal = DB::table('registrasis')
							              ->join('jenis_pembayarans','registrasis.jenis_pembayaran_id', '=', 'jenis_pembayarans.id')
							              ->where('user_id', $users->id)
														->where('tahun_ajaran', $tahunAjaran)
							              ->sum('nominal');
							              @endphp
							              {{ number_format($nominal) }}
													</strong>
            </td>
            <td class="text-right">
							<strong>Rp. @php $totalBayar = DB::table('pembayarans')->join('registrasis', 'registrasis.id', '=', 'pembayarans.registrasi_id')->where('pembayarans.user_id', $users->id)->where('tahun_ajaran', $tahunAjaran)->sum('bayar'); @endphp
							{{ number_format($totalBayar) }}</strong>
            </td>
            <td class="text-right">
              @php
                $tunggakan = $nominal - $totalBayar;
              @endphp
              <strong>Rp. {{ number_format($tunggakan) }}</strong>
            </td>
            <td colspan="2"></td>
          </tr>
        </tbody>
      </table>
    </div>
</div>
</div>
@endsection
