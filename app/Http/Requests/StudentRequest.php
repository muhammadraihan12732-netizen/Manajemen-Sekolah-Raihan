<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('student')?->id;

        return [
            'nis'          => ['required', 'string', 'max:20', Rule::unique('students', 'nis')->ignore($id)],
            'nisn'         => ['nullable', 'string', 'max:20', Rule::unique('students', 'nisn')->ignore($id)],
            'name'         => ['required', 'string', 'max:255'],
            'gender'       => ['required', Rule::in(array_keys(Student::GENDERS))],
            'birth_place'  => ['required', 'string', 'max:100'],
            'birth_date'   => ['required', 'date', 'before:today'],
            'religion'     => ['required', Rule::in(Student::RELIGIONS)],
            'class_id'     => ['required', 'exists:classes,id'],
            'major_id'     => ['required', 'exists:majors,id'],
            'entry_year'   => ['required', 'integer', 'between:2000,' . (date('Y') + 1)],
            'address'      => ['required', 'string'],
            'phone'        => ['nullable', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'parent_name'  => ['required', 'string', 'max:255'],
            'parent_phone' => ['nullable', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'email'        => ['nullable', 'email', 'max:255', Rule::unique('students', 'email')->ignore($id)],
            'photo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status'       => ['required', Rule::in(array_keys(Student::STATUSES))],
        ];
    }

    public function attributes(): array
    {
        return [
            'nis' => 'NIS', 'nisn' => 'NISN', 'name' => 'nama lengkap', 'gender' => 'jenis kelamin',
            'birth_place' => 'tempat lahir', 'birth_date' => 'tanggal lahir', 'religion' => 'agama',
            'class_id' => 'kelas', 'major_id' => 'jurusan', 'entry_year' => 'tahun masuk',
            'address' => 'alamat', 'phone' => 'no. HP siswa', 'parent_name' => 'nama orang tua',
            'parent_phone' => 'no. HP orang tua', 'email' => 'email', 'photo' => 'foto', 'status' => 'status',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'unique'   => ':attribute sudah terdaftar.',
            'email'    => 'Format :attribute tidak valid.',
            'max'      => ':attribute terlalu panjang / terlalu besar (maks :max).',
            'date'     => 'Format :attribute tidak valid.',
            'before'   => ':attribute harus sebelum hari ini.',
            'exists'   => ':attribute yang dipilih tidak valid.',
            'in'       => ':attribute yang dipilih tidak valid.',
            'integer'  => ':attribute harus berupa angka.',
            'between'  => ':attribute harus antara :min dan :max.',
            'regex'    => 'Format :attribute tidak valid (hanya angka, 8-20 digit).',
            'image'    => ':attribute harus berupa gambar.',
            'mimes'    => ':attribute harus berformat jpg, jpeg, png, atau webp.',
        ];
    }
}
