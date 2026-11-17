@extends('layout.admin')
@section('title', 'Tambah Akun')
 
@section('content')
<div class="card">
 <h2>Tambah Akun</h2>
 <form method="POST" action="{{ route('akun.store') }}">
  @include('admin.akun._form')
 </form>
</div>
@endsection
 
@push('scripts')
<script>paint();</script>
@endpush
