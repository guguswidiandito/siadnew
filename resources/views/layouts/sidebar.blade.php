@if (Auth::check())
<li class="header">MAIN NAVIGATION</li>
<li class="active">
	<a href="{{ url('/')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
</li>
@if (Auth::user()->hak_akses == "admin")
<li class="tree-view">
	<a href="#">
		<i class="fa fa-sitemap"></i><span>Data Master</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li>
			<a href="{{ route('kelas.index') }}"><i class="fa fa-circle-o"></i>Kelas</a>
		</li>		
		<li>
			<a href="{{ route('siswa.index') }}"><i class="fa fa-circle-o"></i>Siswa</a>
		</li>
		<li>
			<a href="{{ route('jenis.index') }}"><i class="fa fa-circle-o"></i>Jenis Pembayaran</a>
		</li>
	</ul>
</li>
<li class="tree-view">
	<a href="#">
		<i class="fa fa-file"></i><span>Laporan</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li>
			<a href="{{ url('siswa/laporan/identitas') }}"><i class="fa fa-circle-o"></i>Identitas</a>
		</li>
		<li>
			<a href="{{ url('siswa/laporan/pembayaran') }}"><i class="fa fa-circle-o"></i>Pembayaran</a>
		</li>
		{{-- <li>
			<a href="{{ route('export.registrasi') }}"><i class="fa fa-circle-o"></i>Registrasi</a>
		</li> --}}
	</ul>
</li>
@endif
@if (Auth::user()->hak_akses == "kepsek")
<li class="tree-view">
	<a href="#">
		<i class="fa fa-file"></i><span>Laporan</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li>
			<a href="{{ url('siswa/laporan/identitas') }}"><i class="fa fa-circle-o"></i>Identitas</a>
		</li>
		{{-- <li>
			<a href="{{ route('export.pembayaran') }}"><i class="fa fa-circle-o"></i>Pembayaran</a>
		</li>
		<li>
			<a href="{{ route('export.registrasi') }}"><i class="fa fa-circle-o"></i>Registrasi</a>
		</li> --}}
	</ul>
</li>
@endif
@if (Auth::user()->hak_akses == "siswa")
<li class="tree-view">
	<a href="#">
		<i class="fa fa-file"></i><span>Data Siswa</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		{{-- <li>
			<a href="{{ route('siswa.identitas') }}"><i class="fa fa-circle-o"></i>Identitas</a>
		</li>
		<li>
			<a href="{{ route('siswa.pembayaran') }}"><i class="fa fa-circle-o"></i>Pembayaran</a>
		</li>
		<li>
			<a href="{{ route('siswa.registrasi') }}"><i class="fa fa-circle-o"></i>Registrasi</a>
		</li> --}}
	</ul>
</li>
@endif
<li class="tree-view">
	<a href="#">
		<i class="fa fa-sliders"></i><span>Setelan</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li>
			<a href="{{ url('setelan/password') }}"><i class="fa fa-lock"></i>Ubah Password</a>
		</li>
		<li>
			<a href="{{ url('/logout') }}" onclick="return confirm('Apakah anda yakin akan keluar?')"><i class="fa fa-power-off"></i>Logout
			</a>
		</li>
	</ul>
</li>
@endif