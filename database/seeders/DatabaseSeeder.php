<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun admin (password otomatis di-hash oleh cast "hashed" pada model User Laravel 12)
        User::updateOrCreate(
            ['email' => 'admin@sekolah.test'],
            ['name' => 'Steve Admin', 'password' => 'password']
        );

        // Jurusan
        $majors = collect([
            ['RPL', 'Rekayasa Perangkat Lunak'],
            ['TKJ', 'Teknik Komputer dan Jaringan'],
            ['AKL', 'Akuntansi dan Keuangan Lembaga'],
            ['MPLB', 'Manajemen Perkantoran dan Layanan Bisnis'],
        ])->map(fn ($m) => Major::updateOrCreate(['code' => $m[0]], ['name' => $m[1]]));

        // Kelas
        $classes = collect();
        foreach (['X', 'XI', 'XII'] as $level) {
            foreach ([1, 2] as $no) {
                $classes->push(SchoolClass::updateOrCreate(
                    ['name' => "$level-$no"],
                    ['level' => $level, 'homeroom_teacher' => fake('id_ID')->name()]
                ));
            }
        }

        // Data siswa contoh
        if (Student::count() === 0) {
            $faker = fake('id_ID');
            for ($i = 1; $i <= 40; $i++) {
                $gender = $i % 2 ? 'L' : 'P';
                Student::create([
                    'nis'          => '2024' . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'nisn'         => '00' . $faker->unique()->numerify('########'),
                    'name'         => $faker->name($gender === 'L' ? 'male' : 'female'),
                    'gender'       => $gender,
                    'birth_place'  => $faker->city(),
                    'birth_date'   => $faker->dateTimeBetween('-18 years', '-14 years')->format('Y-m-d'),
                    'religion'     => $faker->randomElement(['Islam', 'Islam', 'Islam', 'Kristen', 'Katolik', 'Hindu']),
                    'class_id'     => $classes->random()->id,
                    'major_id'     => $majors->random()->id,
                    'entry_year'   => $faker->numberBetween(2022, 2024),
                    'address'      => $faker->address(),
                    'phone'        => $faker->numerify('08##########'),
                    'parent_name'  => $faker->name(),
                    'parent_phone' => $faker->numerify('08##########'),
                    'email'        => $faker->unique()->safeEmail(),
                    'status'       => $faker->randomElement(['aktif', 'aktif', 'aktif', 'aktif', 'lulus', 'pindah']),
                ]);
            }
        }
    }
}
