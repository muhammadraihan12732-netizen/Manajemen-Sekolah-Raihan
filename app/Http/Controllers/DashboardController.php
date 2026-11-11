<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'total'   => Student::count(),
            'aktif'   => Student::where('status', 'aktif')->count(),
            'lulus'   => Student::where('status', 'lulus')->count(),
            'pindah'  => Student::where('status', 'pindah')->count(),
            'kelas'   => SchoolClass::count(),
            'jurusan' => Major::count(),
        ];

        $perClass = SchoolClass::withCount('students')->orderBy('name')->get();
        $perMajor = Major::withCount('students')->orderBy('name')->get();
        $gender   = Student::selectRaw('gender, COUNT(*) as total')->groupBy('gender')->pluck('total', 'gender');
        $latest   = Student::with(['schoolClass', 'major'])->latest()->take(6)->get();

        return view('dashboard.index', compact('stats', 'perClass', 'perMajor', 'gender', 'latest'));
    }
}
