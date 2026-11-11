@extends('layouts.app')
@section('title', 'Data Jurusan')

@section('content')
<div class="card-box">
    <div class="card-head">
        <h1 class="page-title">Data Jurusan</h1>
        <a href="{{ route('majors.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Tambah Jurusan</a>
    </div>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-5"><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari kode / nama jurusan"></div>
        <div class="col-auto"><button class="btn btn-primary"><i class="bi bi-search"></i></button></div>
    </form>

    <div class="table-responsive">
        <table class="table table-modern">
            <thead><tr><th>#</th><th>Kode</th><th>Nama Jurusan</th><th>Deskripsi</th><th>Jumlah Siswa</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
            @forelse ($majors as $m)
                <tr>
                    <td>{{ $majors->firstItem() + $loop->index }}</td>
                    <td><span class="badge badge-soft-primary">{{ $m->code }}</span></td>
                    <td class="fw-semibold">{{ $m->name }}</td>
                    <td class="text-muted">{{ \Illuminate\Support\Str::limit($m->description, 60) ?: '-' }}</td>
                    <td>{{ $m->students_count }}</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('students.index', ['major_id' => $m->id]) }}" class="btn-icon view" title="Lihat siswa"><i class="bi bi-people-fill"></i></a>
                        <a href="{{ route('majors.edit', $m) }}" class="btn-icon edit" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                        <form action="{{ route('majors.destroy', $m) }}" method="POST" class="d-inline" data-confirm="Hapus jurusan {{ $m->name }}?">
                            @csrf @method('DELETE')
                            <button class="btn-icon del" title="Hapus"><i class="bi bi-trash-fill"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-5">Belum ada data jurusan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4 d-flex justify-content-end">{{ $majors->links() }}</div>
</div>
@endsection
