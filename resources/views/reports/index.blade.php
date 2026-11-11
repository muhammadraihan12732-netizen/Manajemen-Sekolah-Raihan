@extends('layouts.app')
@section('title', 'Laporan')

@section('content')
@php $qs = request()->only(['q', 'class_id', 'major_id', 'gender', 'status']); @endphp
<div class="card-box">
    <div class="card-head">
        <h1 class="page-title">Laporan Data Siswa</h1>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('reports.print', $qs) }}" target="_blank" class="btn btn-soft"><i class="bi bi-printer-fill me-1"></i> Cetak</a>
            <a href="{{ route('reports.excel', $qs) }}" class="btn btn-success"><i class="bi bi-file-earmark-excel-fill me-1"></i> Excel</a>
            <a href="{{ route('reports.pdf', $qs) }}" target="_blank" class="btn btn-danger"><i class="bi bi-file-earmark-pdf-fill me-1"></i> PDF</a>
        </div>
    </div>

    <p class="text-muted">Atur filter di bawah ini, lalu ekspor atau cetak. Laporan akan mengikuti filter yang sedang aktif.</p>

    <form method="GET" action="{{ route('reports.index') }}" class="row g-2 mb-4">
        <div class="col-lg-3"><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama / NIS / NISN"></div>
        <div class="col-6 col-lg-2">
            <select name="class_id" class="form-select"><option value="">Semua Kelas</option>
                @foreach ($classes as $c)<option value="{{ $c->id }}" @selected(request('class_id') == $c->id)>{{ $c->name }}</option>@endforeach
            </select>
        </div>
        <div class="col-6 col-lg-2">
            <select name="major_id" class="form-select"><option value="">Semua Jurusan</option>
                @foreach ($majors as $m)<option value="{{ $m->id }}" @selected(request('major_id') == $m->id)>{{ $m->code }}</option>@endforeach
            </select>
        </div>
        <div class="col-6 col-lg-2">
            <select name="gender" class="form-select"><option value="">Semua JK</option>
                @foreach (\App\Models\Student::GENDERS as $k => $v)<option value="{{ $k }}" @selected(request('gender') == $k)>{{ $v }}</option>@endforeach
            </select>
        </div>
        <div class="col-6 col-lg-2">
            <select name="status" class="form-select"><option value="">Semua Status</option>
                @foreach (\App\Models\Student::STATUSES as $k => $v)<option value="{{ $k }}" @selected(request('status') == $k)>{{ $v }}</option>@endforeach
            </select>
        </div>
        <div class="col-lg-1"><button class="btn btn-primary w-100 px-2"><i class="bi bi-funnel-fill"></i></button></div>
    </form>

    <div class="table-responsive">
        <table class="table table-modern">
            <thead><tr><th>#</th><th>NIS</th><th>Nama</th><th>JK</th><th>Kelas</th><th>Jurusan</th><th>Tahun Masuk</th><th>Orang Tua</th><th>Status</th></tr></thead>
            <tbody>
            @forelse ($students as $s)
                <tr>
                    <td>{{ $students->firstItem() + $loop->index }}</td>
                    <td>{{ $s->nis }}</td>
                    <td class="fw-semibold">{{ $s->name }}</td>
                    <td>{{ $s->gender }}</td>
                    <td>{{ $s->schoolClass?->name }}</td>
                    <td>{{ $s->major?->code }}</td>
                    <td>{{ $s->entry_year }}</td>
                    <td>{{ $s->parent_name }}</td>
                    <td><span class="badge {{ $s->status_badge }}">{{ $s->status_label }}</span></td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center text-muted py-5">Tidak ada data sesuai filter.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-4">
        <small class="text-muted">Total: {{ $students->total() }} siswa</small>
        {{ $students->links() }}
    </div>
</div>
@endsection
