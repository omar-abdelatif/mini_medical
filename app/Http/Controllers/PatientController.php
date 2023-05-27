<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patientsCount = Patient::count();
        $patients = Patient::all();
        return view('patients.index', compact('patients', 'patientsCount'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'ssn' => 'required|unique:patients',
            'address' => 'required|string',
            'phone' => 'required|integer',
            'birthdate' => 'required|date',
            'military_number' => 'required|integer',
            'gender' => 'required|string',
            'degree' => 'required|string',
            'specialization' => 'required|string',
            'img' => 'required|image|mimes: jpg,png,jpeg,webp,gif',
        ]);
        if ($request->hasFile('img')) {
            $upload = $request->file('img');
            $name = time() . '.' . $upload->getClientOriginalExtension();
            $destinationPath = public_path('assets/imgs');
            $upload->move($destinationPath, $name);
        } elseif (!$request->file('img')) {
            $name = 'download.png';
        }
        $patient = Patient::create([
            'name' => $request->name,
            'ssn' => $request->ssn,
            'address' => $request->address,
            'phone' => $request->phone,
            'birthdate' => $request->birthdate,
            'military_number' => $request->military_number,
            'gender' => $request->gender,
            'degree' => $request->degree,
            'specialization' => $request->specialization,
            'img' => $name,
        ]);
        if ($patient) {
            return redirect()->route('lieutenant.index')->with('success', 'تم الإضافة بنجاح');
        }
        return redirect()->route('lieutenant.index')->withErrors($validated);
    }
    public function update(Request $request)
    {
        $patient = Patient::find($request->id);
        //! Delete old Img
        if ($request->hasFile('img') && $patient->img !== null) {
            $oldImagePath = public_path('assets/imgs/' . $patient->img);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        //! Insert New Img
        if ($request->hasFile('img')) {
            $upload = $request->file('img');
            $name = time() . '.' . $upload->getClientOriginalExtension();
            $destinationPath = public_path('assets/imgs/');
            $upload->move($destinationPath, $name);
            $patient->img = $name;
        } elseif (!$request->file('img')) {
            $name = 'download.png';
        }
        //! Update Patient
        $patient->name = $request->name;
        $patient->ssn = $request->ssn;
        $patient->address = $request->address;
        $patient->phone = $request->phone;
        $patient->birthdate = $request->birthdate;
        $patient->military_number = $request->military_number;
        $patient->gender = $request->gender;
        $patient->degree = $request->degree;
        $patient->specialization = $request->specialization;
        $update = $patient->save();
        if($update){
            return redirect()->route('lieutenant.index')->with('success', 'تم التعديل بنجاح');
        }
        return redirect()->route('lieutenant.index')->withErrors('حدث خطأ أثناء التعديل');
    }
    public function destroy($id){
        $patient = Patient::find($id);
        if($patient){
            if ($patient->img !== null) {
                $oldPath = public_path('assets/imgs/' . $patient->img);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $patient->delete();
            return redirect()->route('lieutenant.index')->with('success', 'تم الحذف بنجاح');
        }
        return redirect()->route('lieutenant.index')->withErrors('هذا البيانات غير موجودة');
    }
}
