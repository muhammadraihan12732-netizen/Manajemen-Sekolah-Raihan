@extends('layouts.app')
@php $editing = $student->exists; @endphp
@section('title', $editing ? 'Edit Siswa' : 'Tambah Siswa')

@section('content')
<div class="card-box">
    <div class="card-head">
        <h1 class="page-title">{{ $editing ? 'Edit Data Siswa' : 'Add New Students' }}</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">Terdapat {{ $errors->count() }} kesalahan. Silakan periksa kembali isian formulir.</div>
    @endif

    <form method="POST" enctype="multipart/form-data"
          action="{{ $editing ? route('students.update', $student) : route('students.store') }}">
        @csrf
        @if ($editing) @method('PUT') @endif

        <div class="row g-4">
            <div class="col-md-4"><x-input name="nis" label="NIS" :value="$student->nis" required /></div>
            <div class="col-md-4"><x-input name="nisn" label="NISN" :value="$student->nisn" /></div>
            <div class="col-md-4"><x-input name="name" label="Nama Lengkap" :value="$student->name" required /></div>

            <div class="col-md-4"><x-select name="gender" label="Jenis Kelamin" :options="\App\Models\Student::GENDERS" :value="$student->gender" placeholder="Please Select Gender" required /></div>
            <div class="col-md-4"><x-input name="birth_place" label="Tempat Lahir" :value="$student->birth_place" required /></div>
            <div class="col-md-4"><x-input name="birth_date" label="Tanggal Lahir" type="date" :value="optional($student->birth_date)->format('Y-m-d')" required /></div>

            <div class="col-md-4"><x-select name="religion" label="Agama" :options="array_combine(\App\Models\Student::RELIGIONS, \App\Models\Student::RELIGIONS)" :value="$student->religion" placeholder="Please Select Religion" required /></div>
            <div class="col-md-4"><x-select name="class_id" label="Kelas" :options="$classes->pluck('name', 'id')" :value="$student->class_id" placeholder="Please Select Class" required /></div>
            <div class="col-md-4"><x-select name="major_id" label="Jurusan" :options="$majors->pluck('name', 'id')" :value="$student->major_id" placeholder="Please Select Major" required /></div>

            <div class="col-md-4"><x-input name="entry_year" label="Tahun Masuk" type="number" :value="$student->entry_year" required /></div>
            <div class="col-md-4"><x-input name="phone" label="No. HP Siswa" type="tel" :value="$student->phone" /></div>
            <div class="col-md-4"><x-input name="email" label="E-Mail" type="email" :value="$student->email" /></div>

            <div class="col-md-4"><x-input name="parent_name" label="Nama Orang Tua" :value="$student->parent_name" required /></div>
            <div class="col-md-4"><x-input name="parent_phone" label="No. HP Orang Tua" type="tel" :value="$student->parent_phone" /></div>
            <div class="col-md-4"><x-select name="status" label="Status Siswa" :options="\App\Models\Student::STATUSES" :value="$student->status" required /></div>

            <div class="col-md-8"><x-textarea name="address" label="Alamat Lengkap" :value="$student->address" required /></div>
            <div class="col-md-4">
                <label for="photo" class="form-label">Foto Siswa</label>
                <div class="d-flex align-items-center gap-3">
                    <img id="photoPreview" class="photo-preview" src="{{ $student->photo_url ?? asset('images/avatar.svg') }}" alt="Preview">
                    <div class="flex-grow-1">
                        <input type="file" id="photo" name="photo" accept="image/*" data-preview="#photoPreview"
                               class="form-control @error('photo') is-invalid @enderror">
                        <small class="text-muted">JPG/PNG/WEBP, maks. 2 MB</small>
                        @error('photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-3 mt-5">
            <a href="{{ route('students.index') }}" class="btn btn-soft px-4">Cancel</a>
            <button type="submit" class="btn btn-primary px-4">Save</button>
        </div>
    </form>
</div>
@endsection
