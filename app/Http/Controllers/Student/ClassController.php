<?php

namespace App\Http\Controllers\Student;

use Inertia\Inertia;
use App\Models\Student;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ClassController extends Controller
{
    public function index()
    {
        $user = Student::whereUserId(Auth::id())->select('batch_id')->first();

        return Inertia::render('Student/Class/Index', [
            'currentClass' => Schedule::where([
                                'batch_id' => $user->batch_id,
                                'status' => 'ongoing'
                            ])
                            ->whereNotNull('meeting_id')
                            ->select('id', 'class_id', 'name', 'user_id', 'subject_id', 'class_time', 'status')
                            ->oldest('class_time')
                            ->with('teacher:id,first_name,last_name')
                            ->with('subject:id,name')
                            ->first(),

            'nextClasses' => Schedule::where([
                                'batch_id' => $user->batch_id,
                                'status' => 'pending'
                            ])
                            ->whereDate('class_time', '>=', now())
                            ->oldest('class_time')
                            ->with('teacher:id,first_name,last_name')
                            ->with('subject:id,name')
                            ->take(10)
                            ->get()
                            ->transform(function($class) {
                                return [
                                    'id' => $class->id,
                                    'class_id' => $class->class_id,
                                    'name' => $class->name,
                                    'subject' => $class->subject->name,
                                    'teacher' => $class->teacher ? $class->teacher->full_name : '',
                                    'class_time' => $class->class_time->toDayDateTimeString()
                                ];
                            })
        ]);
    }

    public function show(Schedule $schedule)
    {
        return Inertia::render('Student/Class/Show', [
            'schedule' => [
                'id' => $schedule->id,
                'class_id' => $schedule->class_id,
                'batch' => $schedule->batch()->select('id', 'name', 'course_id')->with('course:id,name')->first(),
                'subject' => $schedule->subject()->select('id', 'name')->first(),
                'teacher' => $schedule->teacher()->select('id', 'first_name', 'last_name')->first(),
                'name' => $schedule->name,
                'topics' => $schedule->topics,
                'class_time' => $schedule->class_time->toDayDateTimeString(),
                'status' => $schedule->status,
            ],
            'classNotes' => $schedule->getMedia('class-notes')->map(function(Media $media) {
                return [
                    'id' => $media->id,
                    'name' => $media->file_name,
                    'type' => $media->mime_type,
                    'size' => $media->human_readable_size,
                ];
            })
        ]);
    }

    public function join($classId)
    {
        $schedule = Schedule::whereClassId($classId)
                    ->where('status', 'ongoing')
                    ->firstOrFail();  
                    
        return Inertia::render('LiveClass/LiveClass', [
            'classId' => $schedule->class_id,
            'subject' => $schedule->name,
            'meetingId' => $schedule->meeting_id,
            'userInfo' => [
                'name' => Auth::user()->full_name,
                'email' => Auth::user()->email
            ],
            'mode' => 'join',
            'backRoute' => 'students.classes.index'
        ]);
    }
}
