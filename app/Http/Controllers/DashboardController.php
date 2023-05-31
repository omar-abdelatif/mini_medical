<?php

namespace App\Http\Controllers;

use App\Models\Diagnoses;
use App\Models\Patient;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $patientCount = Patient::count();
        $diagnosesCount = Diagnoses::count();
        return view('home', compact('patientCount', 'diagnosesCount'));
    }
}
