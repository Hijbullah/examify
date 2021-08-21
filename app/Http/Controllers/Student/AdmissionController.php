<?php

namespace App\Http\Controllers\Student;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Support\Facades\Redirect;

class AdmissionController extends Controller
{
    public function showAdmissionForm()
    {
        return Inertia::render('Student/Admission/New', [
            'courses' => Course::where(['admission_status' => true, 'status' => true])
                        ->select('id', 'name')
                        ->get()
        ]); 
    }

    public function storeAdmission(Request $request)
    {
        $data = $request->validate([
            'course_id' => ['required', 'numeric'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:students'],
            'phone' => ['required', 'string', 'min:11', 'max:14', 'unique:students'],
            'gender' => ['required'],
            'dob' => ['required'],
            'guardian_name' => ['required', 'string', 'max:255'],
            'guardian_phone' => ['required', 'string', 'min:11', 'max:14'],
        ]);

        $student = Student::create($data);
        
        return Redirect::route('students.admission-confirmation');
    }

    public function showConfirmation()
    {
        return Inertia::render('Student/Admission/Confirmation');
    }
}
