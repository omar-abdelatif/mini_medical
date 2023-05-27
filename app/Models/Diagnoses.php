<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnoses extends Model
{
    use HasFactory;
    protected $table = 'diagnoses';
    protected $fillable = [
        'diagnose',
        'cure',
        'patient_id'
    ];
    public function patients(){
        return $this->belongsTo(Patient::class);
    }
}

