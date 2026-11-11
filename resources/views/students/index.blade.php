@extends('layouts.app')
@section('title', 'Data Siswa')

@section('content')
<div class="card-box">
    <div class="card-head">
        <h1 class="page-title">Data Siswa</h1>
        <a href="{{ route('students.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Tambah Siswa</a>
    </div>

    {{-- Pencarian & filter --}}
    <form method="GET" action="{{ route('students.index') }}" class="row g-2 mb-4">
        <div class="col-lg-3"><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama / NIS / NISN"></div>
        <div class="col-6 col-lg-2">
            <select name="class_id" class="form-select">
                <option value="">Semua Kelas</option>
                @foreach ($classes as $c)<option value="{{ $c->id }}" @selected(request('class_id') == $c->id)>{{ $c->name }}</option>@endforeach
            </select>
        </div>
        <div class="col-6 col-lg-2">
            <select name="major_id" class="form-select">
                <option value="">Semua Jurusan</option>
                @foreach ($majors as $m)<option value="{{ $m->id }}" @selected(request('major_id') == $m->id)>{{ $m->code }}</option>@endforeach
            </select>
        </div>
        <div class="col-6 col-lg-2">
            <select name="gender" class="form-select">
                <option value="">Semua JK</option>
                @foreach (\App\Models\Student::GENDERS as $k => $v)<option value="{{ $k }}" @selected(request('gender') == $k)>{{ $v }}</option>@endforeach
            </select>
        </div>
        <div class="col-6 col-lg-2">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                @foreach (\App\Models\Student::STATUSES as $k => $v)<option value="{{ $k }}" @selected(request('status') == $k)>{{ $v }}</option>@endforeach
            </select>
        </div>
        <div class="col-lg-1 d-flex gap-1">
            <button class="btn btn-primary w-100 px-2" title="Cari"><i class="bi bi-search"></i></button>
            <a href="{{ route('students.index') }}" class="btn btn-soft px-2" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
            <tr><th>#</th><th>Siswa</th><th>NIS</th><th>JK</th><th>Kelas</th><th>Jurusan</th><th>Status</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
            @forelse ($students as $s)
                <tr>
                    <td>{{ $students->firstItem() + $loop->index }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img class="thumb" src="{{ $s->photo_url }}" alt="">
                            <div><span class="fw-semibold">{{ $s->name }}</span><span class="sub">{{ $s->email ?: '-' }}</span></div>
                        </div>
                    </td>
                    <td>{{ $s->nis }}</td>
                    <td>{{ $s->gender }}</td>
                    <td>{{ $s->schoolClass?->name }}</td>
                    <td>{{ $s->major?->code }}</td>
                    <td><span class="badge {{ $s->status_badge }}">{{ $s->status_label }}</span></td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('students.show', $s) }}" class="btn-icon view" title="Detail"><i class="bi bi-eye-fill"></i></a>
                        <a href="{{ route('students.edit', $s) }}" class="btn-icon edit" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                        <form action="{{ route('students.destroy', $s) }}" method="POST" class="d-inline" data-confirm="Hapus data {{ $s->name }}?">
                            @csrf @method('DELETE')
                            <button class="btn-icon del" title="Hapus"><i class="bi bi-trash-fill"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted py-5">Data siswa tidak ditemukan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-4">
        <small class="text-muted">Menampilkan {{ $students->firstItem() ?? 0 }}–{{ $students->lastItem() ?? 0 }} dari {{ $students->total() }} siswa</small>
        {{ $students->links() }}
    </div>
</div>
@endsection
