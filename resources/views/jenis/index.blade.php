@extends('layouts.app')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <a href="{{ url('/jenis/create') }}" class="btn btn-primary">Tambah Jenis Pembayaran</a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
       <div class="table-responsive">
            <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Jenis Pembayaran</th>
                    <th>Nominal</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jenis as $j)
                <tr>
                    <td>{{ $j->jenis }}</td>
                    <td>Rp. {{ number_format($j->nominal) }}</td>
                    <td class="text-center">
                        {!! Form::model($j, ['route' => ['jenis.destroy', $j->id], 'method' => 'delete', 'class'=>'form-inline'] ) !!}
                        <a href="{{ route('jenis.edit', $j->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus?')"><i class="fa fa-trash"></i></button>
                        {!! Form::close() !!}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
       </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection
