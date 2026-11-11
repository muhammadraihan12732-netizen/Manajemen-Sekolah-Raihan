<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MajorController extends Controller
{
    private function rules(?Major $major = null): array
    {
        return [
            'code'        => ['required', 'string', 'max:20', Rule::unique('majors', 'code')->ignore($major?->id)],
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    private function messages(): array
    {
        return [
            'code.required' => 'Kode jurusan wajib diisi.',
            'code.unique'   => 'Kode jurusan sudah digunakan.',
            'name.required' => 'Nama jurusan wajib diisi.',
        ];
    }

    public function index(Request $request): View
    {
        $majors = Major::withCount('students')
            ->when($request->q, fn ($q, $s) => $q->where('name', 'like', "%{$s}%")->orWhere('code', 'like', "%{$s}%"))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('majors.index', compact('majors'));
    }

    public function create(): View
    {
        return view('majors.form', ['major' => new Major()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Major::create($request->validate($this->rules(), $this->messages()));

        return redirect()->route('majors.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function edit(Major $major): View
    {
        return view('majors.form', compact('major'));
    }

    public function update(Request $request, Major $major): RedirectResponse
    {
        $major->update($request->validate($this->rules($major), $this->messages()));

        return redirect()->route('majors.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(Major $major): RedirectResponse
    {
        if ($major->students()->exists()) {
            return back()->with('error', 'Jurusan tidak dapat dihapus karena masih memiliki siswa.');
        }

        $major->delete();

        return redirect()->route('majors.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}
