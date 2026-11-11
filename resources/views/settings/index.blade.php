@extends('layouts.app')
@section('title', 'Pengaturan')

@section('content')
<div class="mb-4"><h1 class="page-title">Pengaturan Akun</h1></div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card-box h-100">
            <h6 class="fw-bold mb-4">Profil Admin</h6>
            <form method="POST" action="{{ route('settings.profile') }}">
                @csrf @method('PUT')
                <div class="mb-4"><x-input name="name" label="Nama" :value="auth()->user()->name" required /></div>
                <div class="mb-4"><x-input name="email" label="Email" type="email" :value="auth()->user()->email" required /></div>
                <div class="text-end"><button class="btn btn-primary px-4">Simpan Profil</button></div>
            </form>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card-box h-100">
            <h6 class="fw-bold mb-4">Ubah Password</h6>
            <form method="POST" action="{{ route('settings.password') }}">
                @csrf @method('PUT')
                <div class="mb-4"><x-input name="current_password" label="Password Lama" type="password" required /></div>
                <div class="mb-4"><x-input name="password" label="Password Baru" type="password" required /></div>
                <div class="mb-4"><x-input name="password_confirmation" label="Konfirmasi Password Baru" type="password" required /></div>
                <div class="text-end"><button class="btn btn-primary px-4">Ubah Password</button></div>
            </form>
        </div>
    </div>
</div>
@endsection
