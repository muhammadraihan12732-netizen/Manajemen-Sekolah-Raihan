@extends('layouts.app')
@php $editing = $major->exists; @endphp
@section('title', $editing ? 'Edit Jurusan' : 'Tambah Jurusan')

@section('content')
<div class="card-box">
    <div class="card-head"><h1 class="page-title">{{ $editing ? 'Edit Jurusan' : 'Tambah Jurusan' }}</h1></div>

    <form method="POST" action="{{ $editing ? route('majors.update', $major) : route('majors.store') }}">
        @csrf
        @if ($editing) @method('PUT') @endif

        <div class="row g-4">
            <div class="col-md-4"><x-input name="code" label="Kode Jurusan" :value="$major->code" placeholder="contoh: RPL" required /></div>
            <div class="col-md-8"><x-input name="name" label="Nama Jurusan" :value="$major->name" required /></div>
            <div class="col-12"><x-textarea name="description" label="Deskripsi" :value="$major->description" :rows="3" /></div>
        </div>

        <div class="d-flex justify-content-end gap-3 mt-5">
            <a href="{{ route('majors.index') }}" class="btn btn-soft px-4">Cancel</a>
            <button type="submit" class="btn btn-primary px-4">Save</button>
        </div>
    </form>
</div>
@endsection
