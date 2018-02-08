@extends('layouts.app')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h1 class="box-title">
          Laporan Pembayaran
        </h1>
    <!-- /.box-header -->
  </div>
    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-bordered">
          <tr>
            <td>
              <div class="table-responsive">
                <table align="center" width="100%">
          			<tr>
          				<td rowspan="4" class="text-center" style="vertical-align: middle"><img src="{{ asset('/images/logo.jpg')}}" width="90px"></td>
                  <td align="center">
          					{{-- <strong> --}}
          						<font size="5">MAJELIS PENDIDIKAN DASAR DAN MENENGAH <br>PIMPINAN DAERAH MUHAMMADIYAH KABUPATEN TEGAL</font><br>
          					{{-- </strong> --}}
          				</td>
                </tr>
                <tr>
                  <td align="center" colspan="2">
          					<strong>
          						<font size="5">SMA MUHAMMADIYAH SURADADI</font><br>
          					</strong>
          				</td>
          			</tr>
                <tr>
                  <td align="center" colspan="2">
                    {{-- <strong> --}}
          						<font size="4">(TERAKREDITASI B)</font><br>
          					{{-- </strong> --}}
                  </td>
                </tr>
          			<tr>
          				<td align="center" colspan="2">
          					Alamat : Jalan Raya Suradadi Km.16 Tegal Telepon (0283) 853 271 Kode Pos 52182
          				</td>
          			</tr>
          		</table>
              </div>
              <hr>
              <table>
              <tr><th width="200px">Kelas</th><td width="10px">:</td><td>{{ request()->kelas }}</td></tr>
              <tr><th width="200px">Jenis Pembayaran</th><td width="10px">:</td><td>{{ DB::table('jenis_pembayarans')->where('id', request()->jenis_pembayaran_id)->first()->jenis }}</td></tr>
              <tr><th width="200px">Tahun Ajaran</th><td width="10px">:</td><td>{{ request()->tahun_ajaran }}</td><tr>
              </table>
              <hr>
              <div class="table-responsive">
                <table class="table table-bordered ">
                  <thead>
                    <tr>
                      <th class="text-center" style="vertical-align: middle" rowspan="2">No</th>
                      <th class="text-center" style="vertical-align: middle" rowspan="2">NIS</th>
                      <th class="text-center" style="vertical-align: middle" rowspan="2">Nama</th>
                      <th class="text-center" colspan="12">Bulan</th>
                      <th class="text-center" style="vertical-align: middle" rowspan="2">Tunggakan</th>
                      <th class="text-center" style="vertical-align: middle" rowspan="2">Keterangan</th>
                    </tr>
                    <tr>
                      @foreach (range(1,12) as $bulan)
                        <th class="text-center" width="40px">{{ $bulan }}</th>
                      @endforeach
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($registrasi as $key => $r)
                      <tr>
                        <td class="text-center">{{ ++$key }}</td>
                        <td>{{ $r->no_identitas }}</td>
                        <td>{{ $r->name }}</td>
                          @forelse ($r->registrasi()->where('jenis_pembayaran_id', request()->jenis_pembayaran_id)->get() as $k)
                              @foreach ($k->pembayaran as $e)
                                @php
                                  $sums = DB::table('pembayarans')->where('registrasi_id', $k->id)->sum('bayar');
                                  $counts = DB::table('pembayarans')->where('registrasi_id', $k->id)->count();
                                @endphp
                                @if ($counts > 0)
                                  <td class="bg-navy"> </td>
                                @endif
                              @endforeach
                              @foreach (range(1, 12-$counts) as $element)
                                @if ($sums < $e->jenispembayaran->nominal)
                                  <td class="bg-red"></td>
                                @else
                                  <td class="bg-green"></td>
                                @endif
                              @endforeach
                            @empty
                              @foreach (range(1,12) as $range)
                                <td class="bg-red"></td>
                              @endforeach
                          @endforelse
                          <td>
                            @forelse ($r->registrasi()->where('jenis_pembayaran_id', request()->jenis_pembayaran_id)->get() as $k)
                              @php
                                $nominal = $k->jenispembayaran->nominal;
                              @endphp
                              @foreach ($k->pembayaran as $p)
                                @php
                                $sumos = DB::table('pembayarans')->where('registrasi_id', $k->id)->sum('bayar');
                                @endphp
                              @endforeach
                              @php
                                $tunggakan = $p->jenispembayaran->nominal - $sumos;
                              @endphp
                              <p class="text-right">Rp. {{ number_format($tunggakan) }}</p>
                            @empty
                              <p class="text-center"><strong>Data belum ada</strong></p>
                            @endforelse
                          </td>
                          <td class="text-center">
                            @forelse ($r->registrasi()->where('jenis_pembayaran_id', request()->jenis_pembayaran_id)->get() as $k)
                              @php
                                $nominal = $k->jenispembayaran->nominal;
                              @endphp
                              @foreach ($k->pembayaran as $p)
                                @php
                                  $jumlah = DB::table('pembayarans')->where('registrasi_id', $k->id)->sum('bayar');
                                @endphp
                              @endforeach
                              @php
                                $tunggakan = $nominal - $jumlah;
                              @endphp
                              @if ($tunggakan > 0)
                                <span class="label label-danger">Belum Lunas</span>
                              @else
                                <span class="label label-success">Lunas</span>
                              @endif
                            @empty
                              <p><strong>Data belum ada</strong></p>
                            @endforelse
                          </td>
                      </tr>
                    @empty
                      <tr>
                        <td class="text-center" colspan="17">Data tidak ditemukan</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection
