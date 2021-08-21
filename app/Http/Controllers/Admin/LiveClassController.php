<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Schedule;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LiveClassController extends Controller
{
    public function startClass($classId)
    {    
        $schedule = Schedule::whereClassId($classId)
                        ->with('teacher:id,first_name,last_name,email')
                        ->firstOrFail();  
        
      
        // return $class;                
        return Inertia::render('LiveClass/LiveClass', [
            'classId' => $schedule->class_id,
            'subject' => $schedule->name,
            'meetingId' => (string) Str::uuid(),
            'userInfo' => [
                'name' => $schedule->teacher->full_name,
                'email' => $schedule->teacher->email
            ],
            'mode' => 'start',
            'backRoute' => Auth::user()->type == 'admin' ? 'admin.schedules.index' : 'teachers.schedules.index'
        ]);
    }

    public function updateLiveClass($classId, Request $request)
    {
        $schedule = Schedule::where('class_id', $classId)->first();
        $schedule->meeting_id = $request->meeting_id;
        $schedule->status = 'ongoing';
        $schedule->save();
        return response()->json(true);
    }

    public function endLiveClass($classId)
    {
        $schedule = Schedule::where('class_id', $classId)->first();
        $schedule->status = 'ended';
        $schedule->save();
        return response()->json(true);
    }
}
