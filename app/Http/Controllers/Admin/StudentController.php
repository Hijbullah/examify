<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Batch;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller
{
    public function allStudents()
    {
        return Inertia::render('Admin/Student/Index', [
            'students' => Student::with('course:id,name')
                            ->with('batch:id,name')
                            ->where('is_approved', true)
                            ->latest()
                            ->paginate(10)
                            ->transform(function ($application) {
                                return [
                                    'id' => $application->id,
                                    'name' => $application->first_name. ' ' . $application->last_name,
                                    'email' => $application->email,
                                    'course' => $application->course,
                                    'batch' => $application->batch,
                                    'approval_date' => $application->updated_at->diffForHumans()
                                ];
                            })
        ]); 
    }

    public function showStudent($id)
    {
        $student = Student::where(['id' => $id, 'is_approved' => true])->with('course:id,name')->with('batch:id,name')->firstOrFail();
        $student['approval_date'] = $student->updated_at->diffForHumans();

        return Inertia::render('Admin/Student/Show', [
            'student' => $student
        ]);
    }

    public function allApplication()
    {
        return Inertia::render('Admin/Application/Index', [
            'applications' => Student::with('course:id,name')
                            ->where('is_approved', false)
                            ->latest()
                            ->paginate(10)
                            ->transform(function ($application) {
                                return [
                                    'id' => $application->id,
                                    'name' => $application->first_name. ' ' . $application->last_name,
                                    'email' => $application->email,
                                    'course' => $application->course,
                                    'application_date' => $application->created_at->diffForHumans()
                                ];
                            })
        ]); 
    }

    public function showApplication($id)
    {
        $application = Student::where(['id' => $id, 'is_approved' => false])->with('course:id,name')->firstOrFail();
        return Inertia::render('Admin/Application/Show', [
            'application' => $application,
            'batches' => Batch::where('course_id', $application->course->id)->select('id', 'name')->get()
        ]);
    }

    public function confirmApplication($id, Request $request)
    {
        $student = Student::find($id);
        
        $user = User::create([
            'first_name' => $student->first_name,
            'last_name' => $student->last_name,
            'email' => $student->email,
            'type' => 'student',
            'password' => Hash::make($student->phone),
            'email_verified_at' => now(),
        ]);

        $student->user_id = $user->id;
        $student->batch_id = $request->batch;
        $student->is_approved = true;
        $student->save();
        
        return Redirect::route('admin.applications.index');
    }
}
