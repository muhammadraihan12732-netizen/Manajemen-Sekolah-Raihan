<?php

namespace App\Http\Controllers;

use App\Exports\StudentsExport;
use App\Models\Major;
use App\Models\SchoolClass;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    private const FILTERS = ['q', 'class_id', 'major_id', 'gender', 'status'];

    private function query(Request $request)
    {
        return Student::with(['schoolClass', 'major'])
            ->filter($request->only(self::FILTERS))
            ->orderBy('name');
    }

    public function index(Request $request): View
    {
        $students = $this->query($request)->paginate(15)->withQueryString();

        return view('reports.index', [
            'students' => $students,
            'classes'  => SchoolClass::orderBy('name')->get(),
            'majors'   => Major::orderBy('name')->get(),
        ]);
    }

    public function print(Request $request): View
    {
        return view('reports.print', ['students' => $this->query($request)->get()]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new StudentsExport($request->only(self::FILTERS)), 'laporan-siswa-' . date('Ymd-His') . '.xlsx');
    }

    public function pdf(Request $request)
    {
        $pdf = Pdf::loadView('reports.pdf', ['students' => $this->query($request)->get()])
            ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-siswa-' . date('Ymd-His') . '.pdf');
    }
}
