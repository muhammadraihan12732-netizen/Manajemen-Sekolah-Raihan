<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;

// StringValueBinder: semua sel disimpan sebagai teks, sehingga NIS/NISN tidak berubah jadi angka ilmiah
class StudentsExport extends StringValueBinder implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithCustomValueBinder
{
    private int $no = 0;

    public function __construct(private array $filters = [])
    {
    }

    public function query()
    {
        return Student::with(['schoolClass', 'major'])->filter($this->filters)->orderBy('name');
    }

    public function headings(): array
    {
        return [
            'No', 'NIS', 'NISN', 'Nama Lengkap', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir',
            'Agama', 'Kelas', 'Jurusan', 'Tahun Masuk', 'Alamat', 'No. HP Siswa',
            'Nama Orang Tua', 'No. HP Orang Tua', 'Email', 'Status',
        ];
    }

    public function map($s): array
    {
        return [
            ++$this->no,
            $s->nis,
            $s->nisn,
            $s->name,
            $s->gender_label,
            $s->birth_place,
            $s->birth_date->format('d/m/Y'),
            $s->religion,
            $s->schoolClass?->name,
            $s->major?->name,
            $s->entry_year,
            $s->address,
            $s->phone,
            $s->parent_name,
            $s->parent_phone,
            $s->email,
            $s->status_label,
        ];
    }
}
