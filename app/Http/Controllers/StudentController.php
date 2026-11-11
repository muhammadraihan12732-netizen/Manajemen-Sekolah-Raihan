<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Major;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StudentController extends Controller
{
    private function options(): array
    {
        return [
            'classes' => SchoolClass::orderBy('name')->get(),
            'majors'  => Major::orderBy('name')->get(),
        ];
    }

    public function index(Request $request): View
    {
        $students = Student::with(['schoolClass', 'major'])
            ->filter($request->only(['q', 'class_id', 'major_id', 'gender', 'status']))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('students.index', ['students' => $students] + $this->options());
    }

    public function create(): View
    {
        return view('students.form', ['student' => new Student(['status' => 'aktif', 'entry_year' => date('Y')])] + $this->options());
    }

    public function store(StudentRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show(Student $student): View
    {
        $student->load(['schoolClass', 'major']);

        return view('students.show', compact('student'));
    }

    public function edit(Student $student): View
    {
        return view('students.form', ['student' => $student] + $this->options());
    }

    public function update(StudentRequest $request, Student $student): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $data['photo'] = $request->file('photo')->store('students', 'public');
        } else {
            unset($data['photo']);
        }

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
