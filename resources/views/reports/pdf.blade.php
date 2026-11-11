<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Data Siswa</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; color: #000; }
        h2 { margin: 0; text-align: center; font-size: 15px; }
        p.sub { text-align: center; margin: 3px 0 12px; color: #444; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 4px 5px; text-align: left; }
        th { background: #e8ebfc; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <h2>LAPORAN DATA SISWA</h2>
    <p class="sub">Dicetak pada {{ now()->format('d/m/Y H:i') }} &middot; Total {{ $students->count() }} siswa</p>
    <table>
        <thead><tr><th>No</th><th>NIS</th><th>NISN</th><th>Nama Lengkap</th><th>JK</th><th>TTL</th><th>Agama</th><th>Kelas</th><th>Jurusan</th><th>Thn</th><th>Orang Tua</th><th>Status</th></tr></thead>
        <tbody>
        @foreach ($students as $s)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $s->nis }}</td><td>{{ $s->nisn }}</td><td>{{ $s->name }}</td>
                <td class="center">{{ $s->gender }}</td>
                <td>{{ $s->birth_place }}, {{ $s->birth_date->format('d/m/Y') }}</td>
                <td>{{ $s->religion }}</td>
                <td>{{ $s->schoolClass?->name }}</td><td>{{ $s->major?->code }}</td>
                <td class="center">{{ $s->entry_year }}</td><td>{{ $s->parent_name }}</td>
                <td>{{ $s->status_label }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
