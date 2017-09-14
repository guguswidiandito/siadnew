@extends('layouts.app')
@section('content')
<div class="box box-primary">
	<div class="box-header with-border">
		Show <strong>{{ $users->name }}</strong>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<div class="row">
			<div class="col-md-12">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li><a data-toggle="tab" href="#student">Detail</a></li>
						<li class="active"><a data-toggle="tab" href="#registration">Registrasi</a></li>
					</ul>
					<div class="tab-content">
						<div id="student" class="tab-pane fade">
							<table class="table table-condensed">
								<tr>
									<th>NIS:</th>
									<td>{{ $users->no_identitas }}</td>
								</tr>
								<tr>
									<th>Nama:</th>
									<td>{{ $users->name }}</td>
								</tr>
								<tr>
									<th>Kelas</th>
									<td>{{ $users->kelas->nama_kelas }}</td>
								</tr>
								<tr>
									<th>Jurusan</th>
									<td>
										@php
										if ($users->kelas->jurusan == "") {
										echo "-";
										} else {
										echo $users->kelas->jurusan;
										}
										@endphp
										{{-- {{ $users->kelas->jurusan }} --}}
									</td>
								</tr>
								<tr>
									<th>Angkatan</th>
									<td>{{ $users->angkatan }}</td>
								</tr>
							</table>
						</div>
						<div id="registration" class="tab-pane fade in active">
							<h3><a href="{{ route('siswa.registrasi', $users->id) }}" title="" class="btn btn-flat  btn-primary btn-flat">New Registration</a></h3>
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
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
										@forelse ($users->registrasi as $key => $p)
										<tr>
											<td class="text-center">{{ ++$key }}</td>
											<td>{{ $p->no_reg }}</td>
											<td>{{ $p->created_at->format('j M Y') }}</td>
											<td>{{ $p->jenispembayaran->jenis }}</td>
											<td class="text-right">Rp. {{ number_format($p->jenispembayaran->nominal) }}</td>
											<td class="{{ $p->pembayaran()->where('user_id', $users->id)->count() > 0 ? "text-right" : "text-center" }}">
												@if ($p->pembayaran()->where('user_id', $users->id)->count() > 0)
												@foreach ($p->pembayaran()->where('user_id', $users->id)->get() as $c)
												Rp. {{ number_format($c->bayar) }}
												@endforeach
												@else
												<strong>Belum dibayar</strong>
												@endif
											</td>
											<td class="{{ $p->pembayaran()->where('user_id', $p->user_id)->count() > 0 ? "text-right" : "text-center" }}">
												@if ($p->pembayaran()->where('user_id', $p->user_id)->count() > 0)
												@foreach ($p->pembayaran()->where('user_id', $p->user_id)->get() as $c)
												Rp. {{ number_format($c->tunggakan) }}
												@endforeach
												@else
												<strong>Belum dibayar</strong>
												@endif
											</td>
											<td class="text-center">
												@if ($p->pembayaran()->where('user_id', $p->user_id)->count() == 1)
												@foreach ($p->pembayaran()->where('user_id', $p->user_id)->get() as $c)
												{{ $c->keterangan }}
												@endforeach
												@else
												<strong>Belum dibayar</strong>
												@endif
											</td>
											<td class="text-center">
												{!! Form::model($p, ['route'=>['registrasi.delete', $p->user_id, $p->id], 'method' => 'delete', 'class'=>'form-inline']) !!}
												@if ($p->pembayaran()->count() > 0)
												<a href="{{ url('siswa/'.$p->user_id.'/registrasi/'.$p->id.'/pembayaran') }}" title="" class="btn btn-flat  btn-success">Lihat Pembayaran</a>
												@else
												<a href="{{ url('siswa/'.$p->user_id.'/registrasi/'.$p->id.'/pembayaran') }}" title="" class="btn btn-flat  btn-warning">Pembayaran</a>
												<a href="{{ url('siswa/'.$p->user_id.'/registrasi/'.$p->id.'/edit') }}" class="btn btn-flat  btn-info">Edit</i></a>
												@endif
												<button type="submit" class="btn btn-flat  btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus {{$p->no_reg}}?')">Hapus</button>
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
												Rp. {{ number_format(DB::table('registrasis')
												->join('jenis_pembayarans','registrasis.jenis_pembayaran_id', '=', 'jenis_pembayarans.id')
												->where('user_id', $users->id)
												->sum('nominal')) }}
											</td>
											<td class="text-right">
												Rp. {{ number_format(DB::table('pembayarans')
												->join('jenis_pembayarans', 'pembayarans.jenis_pembayaran_id', '=', 'jenis_pembayarans.id')
												->where('user_id', $users->id)
												->sum('bayar')) }}
											</td>
											<td class="text-right">
												Rp. {{ number_format(DB::table('pembayarans')
												->join('jenis_pembayarans', 'pembayarans.jenis_pembayaran_id', '=', 'jenis_pembayarans.id')
												->where('user_id', $users->id)
												->sum('tunggakan')) }}
											</td>
											<td></td>
											<td class="text-center">
												<a href="{{ route('siswa.index') }}" title="" class="btn btn-flat bg-navy">Kembali</a>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.box -->
@endsection