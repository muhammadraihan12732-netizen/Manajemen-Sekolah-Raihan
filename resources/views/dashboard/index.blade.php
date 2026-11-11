@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h1 class="page-title">Dashboard</h1>
    <div class="breadcrumb-note">Ringkasan data siswa sekolah</div>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-xl-4">
        <div class="stat-card"><div class="icon ic-blue"><i class="bi bi-people-fill"></i></div>
            <div><div class="num">{{ $stats['total'] }}</div><div class="label">Total Siswa</div></div></div>
    </div>
    <div class="col-6 col-xl-4">
        <div class="stat-card"><div class="icon ic-green"><i class="bi bi-person-check-fill"></i></div>
            <div><div class="num">{{ $stats['aktif'] }}</div><div class="label">Siswa Aktif</div></div></div>
    </div>
    <div class="col-6 col-xl-4">
        <div class="stat-card"><div class="icon ic-purple"><i class="bi bi-award-fill"></i></div>
            <div><div class="num">{{ $stats['lulus'] }}</div><div class="label">Siswa Lulus</div></div></div>
    </div>
    <div class="col-6 col-xl-4">
        <div class="stat-card"><div class="icon ic-orange"><i class="bi bi-box-arrow-right"></i></div>
            <div><div class="num">{{ $stats['pindah'] }}</div><div class="label">Siswa Pindah</div></div></div>
    </div>
    <div class="col-6 col-xl-4">
        <div class="stat-card"><div class="icon ic-teal"><i class="bi bi-journal-bookmark-fill"></i></div>
            <div><div class="num">{{ $stats['kelas'] }}</div><div class="label">Jumlah Kelas</div></div></div>
    </div>
    <div class="col-6 col-xl-4">
        <div class="stat-card"><div class="icon ic-red"><i class="bi bi-book-half"></i></div>
            <div><div class="num">{{ $stats['jurusan'] }}</div><div class="label">Jumlah Jurusan</div></div></div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-4">
        <div class="card-box h-100">
            <h6 class="fw-bold mb-3">Siswa per Kelas</h6>
            @php $maxC = max(1, $perClass->max('students_count')); @endphp
            @forelse ($perClass as $c)
                <div class="bar-row">
                    <div class="name" title="{{ $c->name }}">{{ $c->name }}</div>
                    <div class="track"><div class="fill" style="width: {{ $c->students_count / $maxC * 100 }}%"></div></div>
                    <div class="val">{{ $c->students_count }}</div>
                </div>
            @empty <p class="text-muted mb-0">Belum ada data kelas.</p> @endforelse
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-box h-100">
            <h6 class="fw-bold mb-3">Siswa per Jurusan</h6>
            @php $maxM = max(1, $perMajor->max('students_count')); @endphp
            @forelse ($perMajor as $m)
                <div class="bar-row">
                    <div class="name" title="{{ $m->name }}">{{ $m->code }}</div>
                    <div class="track"><div class="fill" style="width: {{ $m->students_count / $maxM * 100 }}%; background:#16925b"></div></div>
                    <div class="val">{{ $m->students_count }}</div>
                </div>
            @empty <p class="text-muted mb-0">Belum ada data jurusan.</p> @endforelse
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-box h-100">
            <h6 class="fw-bold mb-3">Jenis Kelamin</h6>
            @php $totalG = max(1, $stats['total']); @endphp
            @foreach (['L' => ['Laki-laki', '#0b2a85'], 'P' => ['Perempuan', '#d98a0b']] as $k => [$label, $color])
                <div class="bar-row">
                    <div class="name">{{ $label }}</div>
                    <div class="track"><div class="fill" style="width: {{ ($gender[$k] ?? 0) / $totalG * 100 }}%; background: {{ $color }}"></div></div>
                    <div class="val">{{ $gender[$k] ?? 0 }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="card-box">
    <div class="card-head mb-3">
        <h6 class="fw-bold m-0">Siswa Terbaru</h6>
        <a href="{{ route('students.index') }}" class="btn btn-soft btn-sm">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table table-modern">
            <thead><tr><th>Siswa</th><th>NIS</th><th>Kelas</th><th>Jurusan</th><th>Status</th></tr></thead>
            <tbody>
            @forelse ($latest as $s)
                <tr>
                    <td><div class="d-flex align-items-center gap-3">
                        <img class="thumb" src="{{ $s->photo_url }}" alt="">
                        <a href="{{ route('students.show', $s) }}" class="fw-semibold text-decoration-none text-reset">{{ $s->name }}</a></div></td>
                    <td>{{ $s->nis }}</td>
                    <td>{{ $s->schoolClass?->name }}</td>
                    <td>{{ $s->major?->code }}</td>
                    <td><span class="badge {{ $s->status_badge }}">{{ $s->status_label }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data siswa.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
