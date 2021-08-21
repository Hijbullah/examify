<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Schedule;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Class/Index', [
            'filters' => request()->all('search'),
            'schedules' => Schedule::filter(request()->only('search'))
                            ->with(['batch' => function($query) {
                                $query->select('id', 'name', 'course_id')->with('course:id,name');
                            }])
                            ->with('teacher:id,first_name,last_name')
                            ->with('subject:id,name')
                            ->latest()
                            ->paginate(10)
                            ->transform(function ($schedule) {
                                return [
                                    'id' => $schedule->id,
                                    'class_id' => $schedule->class_id,
                                    'course' => $schedule->batch->course->name,
                                    'batch' => $schedule->batch->name,
                                    'subject' => $schedule->subject->name,
                                    'name' => $schedule->name,
                                    'teacher' => $schedule->teacher ? $schedule->teacher->full_name : 'Not Assigned',
                                    'class_time' => $schedule->class_time->format('d/m/Y h:i A'),
                                    'status' => $schedule->status
                                ];
                            })
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Class/Create', [
            'courses' => Course::all()->map->only('id', 'name'),
            'subjects' => Subject::all()->map->only('id', 'name'),
            'teachers' => User::whereType('teacher')->get()->map->only('id', 'full_name'),        
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'batch' => ['required', 'numeric'],
            'subject' => ['required', 'numeric'],
            'name' => ['required', 'string', 'max:255'],
            'teacher' => ['nullable', 'numeric'],
            'topics' => ['nullable', 'string'],
            'class_time' => ['required'],
        ]);

        Schedule::create([
            'class_id' => (string) Str::uuid(),
            'batch_id' => $request->batch,
            'subject_id' => $request->subject,
            'user_id' => $request->teacher,
            'name' => $request->name,
            'topics' => $request->topics,
            'class_time' =>$request->class_time,
        ]);

        return Redirect::route('admin.schedules.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        return Inertia::render('Admin/Class/Show', [
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        return Inertia::render('Admin/Class/Edit', [
            'schedule' => [
                'id' => $schedule->id,
                'class_id' => $schedule->class_id,
                'batch' => $schedule->batch()->select('id', 'name', 'course_id')->with('course:id,name')->first(),
                'subject' => $schedule->subject_id,
                'teacher' => $schedule->user_id,
                'name' => $schedule->name,
                'topics' => $schedule->topics,
                'class_time' => $schedule->class_time
            ],
            'subjects' => Subject::select('id', 'name')->get(),
            'teachers' => User::whereType('teacher')->select('id', 'first_name', 'last_name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'teacher' => ['nullable', 'numeric'],
            'subject' => ['required', 'numeric'],
            'name' => ['required', 'string', 'max:255'],
            'topics' => ['nullable', 'string'],
            'class_time' => ['required'],
        ]);

        $schedule->name = $request->name;
        $schedule->user_id = $request->teacher;
        $schedule->subject_id = $request->subject;
        $schedule->topics = $request->topics;
        $schedule->class_time = $request->class_time;
        $schedule->save();

        return Redirect::route('admin.schedules.show', $schedule->class_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return back();
    }

    public function getBatches($courseId)
    {
        $batches = Batch::where('course_id', $courseId)->select('id', 'name')->get();
        return response()->json($batches);
    }
}
