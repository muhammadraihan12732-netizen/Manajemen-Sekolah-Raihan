<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ClassController extends Controller
{
    private function rules(?SchoolClass $class = null): array
    {
        return [
            'name'             => ['required', 'string', 'max:50', Rule::unique('classes', 'name')->ignore($class?->id)],
            'level'            => ['required', Rule::in(['X', 'XI', 'XII'])],
            'homeroom_teacher' => ['nullable', 'string', 'max:255'],
        ];
    }

    private function messages(): array
    {
        return [
            'name.required'  => 'Nama kelas wajib diisi.',
            'name.unique'    => 'Nama kelas sudah ada.',
            'level.required' => 'Tingkat wajib dipilih.',
            'level.in'       => 'Tingkat tidak valid.',
        ];
    }

    public function index(Request $request): View
    {
        $classes = SchoolClass::withCount('students')
            ->when($request->q, fn ($q, $s) => $q->where('name', 'like', "%{$s}%")->orWhere('homeroom_teacher', 'like', "%{$s}%"))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('classes.index', compact('classes'));
    }

    public function create(): View
    {
        return view('classes.form', ['class' => new SchoolClass()]);
    }

    public function store(Request $request): RedirectResponse
    {
        SchoolClass::create($request->validate($this->rules(), $this->messages()));

        return redirect()->route('classes.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(SchoolClass $schoolClass): View
    {
        return view('classes.form', ['class' => $schoolClass]);
    }

    public function update(Request $request, SchoolClass $schoolClass): RedirectResponse
    {
        $schoolClass->update($request->validate($this->rules($schoolClass), $this->messages()));

        return redirect()->route('classes.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(SchoolClass $schoolClass): RedirectResponse
    {
        if ($schoolClass->students()->exists()) {
            return back()->with('error', 'Kelas tidak dapat dihapus karena masih memiliki siswa.');
        }

        $schoolClass->delete();

        return redirect()->route('classes.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
