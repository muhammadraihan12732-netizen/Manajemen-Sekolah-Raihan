<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    // "Class" adalah kata cadangan PHP, jadi model diberi nama SchoolClass
    protected $table = 'classes';

    protected $fillable = ['name', 'level', 'homeroom_teacher'];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
