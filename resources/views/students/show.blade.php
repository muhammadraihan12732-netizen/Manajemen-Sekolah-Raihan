@extends('layouts.app')
@section('title', 'Detail Siswa')

@section('content')
<div class="card-box">
    <div class="card-head">
        <h1 class="page-title">Detail Siswa</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('students.index') }}" class="btn btn-soft">Kembali</a>
            <a href="{{ route('students.edit', $student) }}" class="btn btn-primary"><i class="bi bi-pencil-fill me-1"></i> Edit</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-3 text-center">
            <img class="detail-photo mb-3" src="{{ $student->photo_url }}" alt="{{ $student->name }}">
            <h5 class="fw-bold mb-1">{{ $student->name }}</h5>
            <span class="badge {{ $student->status_badge }}">{{ $student->status_label }}</span>
        </div>
        <div class="col-md-9">
            <dl class="row detail-grid">
                @php
                    $rows = [
                        'NIS' => $student->nis,
                        'NISN' => $student->nisn ?: '-',
                        'Jenis Kelamin' => $student->gender_label,
                        'Tempat, Tanggal Lahir' => $student->birth_place . ', ' . $student->birth_date->translatedFormat('d F Y'),
                        'Agama' => $student->religion,
                        'Kelas' => $student->schoolClass?->name,
                        'Jurusan' => $student->major?->name,
                        'Tahun Masuk' => $student->entry_year,
                        'No. HP Siswa' => $student->phone ?: '-',
                        'Email' => $student->email ?: '-',
                        'Nama Orang Tua' => $student->parent_name,
                        'No. HP Orang Tua' => $student->parent_phone ?: '-',
                    ];
                @endphp
                @foreach ($rows as $label => $val)
                    <div class="col-sm-6"><dt>{{ $label }}</dt><dd>{{ $val }}</dd></div>
                @endforeach
                <div class="col-12"><dt>Alamat Lengkap</dt><dd>{{ $student->address }}</dd></div>
            </dl>
        </div>
    </div>
</div>
@endsection
