@extends('layouts.app')
@section('title', 'Data Kelas')

@section('content')
<div class="card-box">
    <div class="card-head">
        <h1 class="page-title">Data Kelas</h1>
        <a href="{{ route('classes.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Tambah Kelas</a>
    </div>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-5"><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama kelas / wali kelas"></div>
        <div class="col-auto"><button class="btn btn-primary"><i class="bi bi-search"></i></button></div>
    </form>

    <div class="table-responsive">
        <table class="table table-modern">
            <thead><tr><th>#</th><th>Nama Kelas</th><th>Tingkat</th><th>Wali Kelas</th><th>Jumlah Siswa</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
            @forelse ($classes as $c)
                <tr>
                    <td>{{ $classes->firstItem() + $loop->index }}</td>
                    <td class="fw-semibold">{{ $c->name }}</td>
                    <td>{{ $c->level }}</td>
                    <td>{{ $c->homeroom_teacher ?: '-' }}</td>
                    <td><span class="badge badge-soft-primary">{{ $c->students_count }} siswa</span></td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('students.index', ['class_id' => $c->id]) }}" class="btn-icon view" title="Lihat siswa"><i class="bi bi-people-fill"></i></a>
                        <a href="{{ route('classes.edit', $c) }}" class="btn-icon edit" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                        <form action="{{ route('classes.destroy', $c) }}" method="POST" class="d-inline" data-confirm="Hapus kelas {{ $c->name }}?">
                            @csrf @method('DELETE')
                            <button class="btn-icon del" title="Hapus"><i class="bi bi-trash-fill"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-5">Belum ada data kelas.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4 d-flex justify-content-end">{{ $classes->links() }}</div>
</div>
@endsection
