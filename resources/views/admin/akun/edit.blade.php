@extends('layout.admin')
@section('title', 'Ubah Akun')
 
@section('content')
<div class="card">
 <h2>Ubah Akun</h2>
 <form method="POST" action="{{ route('akun.update', $user) }}">
  @method('PUT')
  @include('admin.akun._form')
 </form>
</div>
@endsection
 
@push('scripts')
<script>paint();</script>
@endpush
