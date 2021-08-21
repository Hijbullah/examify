<?php

namespace App\Http\Controllers\Student;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function showProfile()
    {
        return Inertia::render('Student/Profile/Show');
    }

    public function updatePassword(Request $request)
    {
        $student = auth()->user();

        Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed',' min:8'],
        ])->after(function ($validator) use ($student, $request) {
            if (! isset($request->current_password) || ! Hash::check($request->current_password, $student->password)) {
                $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
            }
        })->validate();

        $student->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        return back();
    }
}
