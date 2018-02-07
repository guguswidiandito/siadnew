@extends('layouts.app')
@section('content')
<div class="box box-primary">
	<div class="box-header with-border">
		Show <strong>{{ $users->name }}</strong> <div class="pull-right">
			<a href="{{ route('siswa.index') }}" title="" class="btn  bg-navy">Kembali</a>
		</div>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table class="table table-bordered table-condensed">
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
				<td>
					<table class="table table-bordered">
						<tr>
							<td colspan="5">
								<a href="{{ route('siswa.kelas', $users->no_identitas) }}" class="btn btn-primary">Tambah Kelas</a>
							</td>
						</tr>
							<tr>
								<th width="40px"  class="text-center">#</th><th class="text-center">Kelas</th><th class="text-center">Jurusan</th><th class="text-center">Tahun Ajaran</th><th class="text-center">Aksi</th>
							</tr>
						@forelse ($users->kelas as $key => $kelas)
							<tr>
								<td class="text-center">{{ ++$key }}</td><td>{{ $kelas->nama_kelas }}</td><td class="text-center">{{ isset($kelas->jurusan) ? $kelas->jurusan : "-" }}</td><td class="text-center">{{ $kelas->pivot->tahun_ajaran }}</td><td class="text-center"><a href="{{ url('siswa/'.$users->no_identitas.'/'.$kelas->pivot->tahun_ajaran) }}" class="btn btn-success ">Registrasi</a></td>
							</tr>
						@empty
							<tr>
								<td class="text-center" colspan="3">Data tidak ditemukan</td>
							</tr>
						@endforelse
					</table>
				</td>
			</tr>
			<tr>
			</tr>
			<tr>
				<th>Angkatan</th>
				<td>{{ $users->angkatan }}</td>
			</tr>
		</table>

	</div>
</div>
<!-- /.box -->
@endsection
