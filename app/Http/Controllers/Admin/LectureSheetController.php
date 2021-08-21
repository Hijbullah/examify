<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Support\Str;
use App\Models\LectureSheet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class LectureSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/LectureSheet/Index', [
            'filters' => request()->all('search'),
            'lectureSheets' => LectureSheet::filter(request()->only('search'))
                ->with('course:id,name')
                ->with('subject:id,name')
                ->latest()
                ->paginate(10)
                ->transform(function ($lectureSheet) {
                    return [
                        'id' => $lectureSheet->id,
                        'course' => $lectureSheet->course->name,
                        'subject' => $lectureSheet->subject->name,
                        'title' => $lectureSheet->title,
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
        return Inertia::render('Admin/LectureSheet/Create', [
            'courses' => Course::all()->map->only('id', 'name'),
            'subjects' => Subject::all()->map->only('id', 'name')
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
            'course' => ['required', 'numeric'],
            'subject' => ['required', 'numeric'],
            'title' => ['required', 'string', 'max:100'],
            'topics' => ['required', 'string'],
            'file' => ['required', 'file', 'mimes:csv,xlsx,xls,pdf,doc,docx', 'max:2048']
        ]);

        $lectureSheet = LectureSheet::create([
            'course_id' => $request->course,
            'subject_id' => $request->subject,
            'title' => $request->title,
            'topics' => $request->topics
        ]);

        $lectureSheet->addMedia($request->file('file'))->toMediaCollection('lecture-sheet');

        return Redirect::route('admin.lecture-sheets.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LectureSheet  $lectureSheet
     * @return \Illuminate\Http\Response
     */
    public function show(LectureSheet $lectureSheet)
    {
        $file = $lectureSheet->getFirstMedia('lecture-sheet');

        return Inertia::render('Admin/LectureSheet/Show', [
            'lectureSheet' => [
                'id' => $lectureSheet->id,
                'course' => $lectureSheet->course()->select('id', 'name')->first()->name,
                'subject' => $lectureSheet->subject()->select('id', 'name')->first()->name,
                'title' => $lectureSheet->title,
                'topics' => $lectureSheet->topics,
                'file' => [
                    'id' => $file->id,
                    'name' => $file->file_name,
                    'type' => $file->mime_type,
                    'size' => $file->human_readable_size,
                ]
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LectureSheet  $lectureSheet
     * @return \Illuminate\Http\Response
     */
    public function edit(LectureSheet $lectureSheet)
    {
        return Inertia::render('Admin/LectureSheet/Edit', [
            'courses' => Course::all()->map->only('id', 'name'),
            'subjects' => Subject::all()->map->only('id', 'name'),
            'lectureSheet' => [
                'id' => $lectureSheet->id,
                'course' => $lectureSheet->course_id,
                'subject' => $lectureSheet->subject_id,
                'title' => $lectureSheet->title,
                'topics' => $lectureSheet->topics,
                'file' => $lectureSheet->getFirstMedia('lecture-sheet')->file_name
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LectureSheet  $lectureSheet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LectureSheet $lectureSheet)
    {
        $request->validate([
            'course' => ['required', 'numeric'],
            'subject' => ['required', 'numeric'],
            'title' => ['required', 'string', 'max:100'],
            'topics' => ['required', 'string'],
            'file' => ['nullable', 'file', 'mimes:csv,xlsx,xls,pdf,doc,docx', 'max:2048']
        ]);

        $lectureSheet->course_id = $request->course;
        $lectureSheet->subject_id = $request->subject;
        $lectureSheet->title = $request->title;
        $lectureSheet->topics = $request->topics;
        $lectureSheet->save();

        if($request->hasFile('file'))
        {
            $lectureSheet->addMedia($request->file('file'))->toMediaCollection('lecture-sheet');
        }

        return Redirect::route('admin.lecture-sheets.show', $lectureSheet->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LectureSheet  $lectureSheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(LectureSheet $lectureSheet)
    {
        Storage::delete($lectureSheet->file);
        $lectureSheet->delete();
        return back();
    }
}
