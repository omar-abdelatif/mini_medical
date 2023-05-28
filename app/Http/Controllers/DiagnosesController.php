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
        $diagnosesCount = Diagnoses::count();
        return view('patients.diagnoses', compact('patient', 'diagnoses', 'diagnosesCount'));
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
    public function destroy($id)
    {
        $diagnoses = Diagnoses::find($id);
        if ($diagnoses) {
            $diagnoses->delete();
            return redirect()->route('diagnoses.index', $diagnoses->patient_id)->with('success', 'تم الحذف بنجاح');
        }
        return redirect()->route('diagnoses.index', $diagnoses->patient_id)->withErrors('حدث خطأ ما برجاء المحاولة مره اخرى');
    }
}
