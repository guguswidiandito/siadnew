@extends('layouts.app')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h1 class="box-title">
        <p><strong>Kelas:</strong> {{ DB::table('kelas')->where('id', request()->kelas_id)->first()->nama_kelas }}</p>
        <p><strong>Angkatan:</strong> {{ request()->angkatan }}</p></h1>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection
