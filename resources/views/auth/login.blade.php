<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<div class="login-wrap">
    <div class="login-card">
        <div class="logo"><i class="bi bi-mortarboard-fill"></i> Education</div>
        <p class="text-center text-muted mb-4">Sistem Informasi Manajemen Data Siswa</p>

        @if (session('success'))<div class="alert alert-success py-2">{{ session('success') }}</div>@endif

        <form method="POST" action="{{ route('login.process') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" autofocus
                       class="form-control @error('email') is-invalid @enderror" placeholder="admin@sekolah.test">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password"
                       class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">Masuk</button>
        </form>
    </div>
</div>
</body>
</html>
