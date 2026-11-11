@extends('layouts.app')
@php $editing = $class->exists; @endphp
@section('title', $editing ? 'Edit Kelas' : 'Tambah Kelas')

@section('content')
<div class="card-box">
    <div class="card-head"><h1 class="page-title">{{ $editing ? 'Edit Kelas' : 'Tambah Kelas' }}</h1></div>

    <form method="POST" action="{{ $editing ? route('classes.update', $class) : route('classes.store') }}">
        @csrf
        @if ($editing) @method('PUT') @endif

        <div class="row g-4">
            <div class="col-md-4"><x-input name="name" label="Nama Kelas" :value="$class->name" placeholder="contoh: X-1" required /></div>
            <div class="col-md-4"><x-select name="level" label="Tingkat" :options="['X' => 'X', 'XI' => 'XI', 'XII' => 'XII']" :value="$class->level" placeholder="Please Select Level" required /></div>
            <div class="col-md-4"><x-input name="homeroom_teacher" label="Wali Kelas" :value="$class->homeroom_teacher" /></div>
        </div>

        <div class="d-flex justify-content-end gap-3 mt-5">
            <a href="{{ route('classes.index') }}" class="btn btn-soft px-4">Cancel</a>
            <button type="submit" class="btn btn-primary px-4">Save</button>
        </div>
    </form>
</div>
@endsection
