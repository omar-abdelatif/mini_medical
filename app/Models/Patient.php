<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $table = 'patients';
    protected $fillable = [
        'name',
        'ssn',
        'phone',
        'gender',
        'birthdate',
        'address',
        'military_number',
        'degree',
        'img',
        'specialization',
    ];
    public function diagnoses(){
        return $this->hasMany(Diagnoses::class);
    }
}
