<?php

namespace App\Http\Controllers;

use App\Models\Diagnoses;
use App\Models\Patient;
use Illuminate\Http\Request;

class DiagnosesController extends Controller
{
    public function index($id){
        $patient = Patient::find($id);
        $diagnoses = $patient->diagnoses;
        return view('patients.diagnoses', compact('patient', 'diagnoses'));
    }
    public function create(Request $request){
        $patient = Patient::find($request->id);
        if($patient){
            $diagnoses = new Diagnoses();
            $diagnoses->diagnose = $request->diagnose;
            $diagnoses->cure = $request->cure;
            $diagnoses->patient_id = $patient->id;
            $create = $diagnoses->save();
        }
        if($create){
            return redirect()->route('diagnoses.index', $patient->id)->with('success', 'نم التسجيل بنجاح');
        }
        return redirect()->route('diagnoses.index', $patient->id)->with('error', 'حدث خطأ ما برجاء المحاولة لاحقا');
    }
}
