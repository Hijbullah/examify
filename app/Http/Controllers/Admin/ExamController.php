<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use Inertia\Inertia;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Support\Str;
use App\Models\ExamCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Exam/Index', [
            'filters' => request()->all('search'),
            'exams' => Exam::filter(request()->only('search'))
                ->with('batch:id,name')
                ->with('category:id,name')
                ->withCount('questions')
                ->latest()
                ->paginate(10)
                ->transform(function ($exam) {
                    return [
                        'id' => $exam->id,
                        'exam_code' => $exam->exam_code,
                        'batch' => $exam->batch,
                        'category' => $exam->category,
                        'name' => $exam->name,
                        'total_question' => $exam->total_question,
                        'schedule' => [
                            'start' => $exam->exam_started_at->toDayDateTimeString(),
                            'end' => $exam->exam_ended_at->toDayDateTimeString()
                        ],
                        'questions_count' => $exam->questions_count,
                        'status' => $exam->status,
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
        return Inertia::render('Admin/Exam/Create', [
            'courses' => Course::all()->map->only('id', 'name'),
            'subjects' => Subject::all()->map->only('id', 'name'),
            'categories' => ExamCategory::all()->map->only('id', 'name'),
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
        
        Validator::make($request->all(), [
            'name' => ['required', 'unique:exams', 'max:255'],
            'course' => ['required'],
            'batch' => ['required'],
            'category' => ['required'],
            'total_question' => ['required', 'numeric', 'min:5', 'max:200'],
            'exam_duration' => ['required', 'numeric', 'min:0'],
            'negative_mark' => [ 'nullable' ,'numeric', 'min:0', 'max:1'],
            'exam_start_at' => ['required'],
            'exam_end_at' => ['required'],
            'subjects' => ['required'],
        ])->after(function ($validator) use ($request) {
            if ($request->total_question != $request->total_question_in_subjects) {
                $validator->errors()->add(
                    'subjects', 'Total Number of Questions is not matched with the number of questions in subject.'
                );
            }
        })->validate();
        
 
        $exam = new Exam;
        $exam->exam_code = (string) Str::uuid();
        $exam->batch_id = $request->batch;
        $exam->exam_category_id = $request->category;
        $exam->name = $request->name;
        $exam->total_question = $request->total_question;
        $exam->exam_duration = $request->exam_duration;
        $exam->exam_started_at = $request->exam_start_at;
        $exam->exam_ended_at = $request->exam_end_at;
        $exam->subjects = $request->subjects;

        if($request->has_negative_mark)
        {
            $exam->has_negative_mark = true;
            $exam->negative_mark = $request->negative_mark;
        }

        $exam->save();
        return Redirect::route('admin.exams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        $exam->loadCount('questions');

        return Inertia::render('Admin/Exam/Show', [
            'exam' => [
                'id' => $exam->id,
                'exam_code' => $exam->exam_code,
                'name' => $exam->name,
                'batch' => $exam->batch()->select('id', 'name', 'course_id')->with('course:id,name')->first(),
                'category' => $exam->category()->select('id', 'name')->first(),
                'total_question' => (Int) $exam->total_question,
                'exam_duration' => $exam->exam_duration,
                'schedule' => [
                    'start' => $exam->exam_started_at->toDayDateTimeString(),
                    'end' => $exam->exam_ended_at->toDayDateTimeString()
                ],
                'questions_count' => $exam->questions_count,
                'subjects' => $exam->subjects,
                'has_negative_mark' => $exam->has_negative_mark,
                'negative_mark' => $exam->negative_mark,
                'status' => $exam->status
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        return Inertia::render('Admin/Exam/Edit', [
            'categories' => ExamCategory::all()->map->only('id', 'name'),
            'subjects' => Subject::all()->map->only('id', 'name'),
            'exam' => [
                'id' => $exam->id,
                'exam_code' => $exam->exam_code,
                'name' => $exam->name,
                'batch' => $exam->batch()->select('id', 'name', 'course_id')->with('course:id,name')->first(),
                'category' => $exam->exam_category_id,
                'total_question' => $exam->total_question,
                'exam_duration' => $exam->exam_duration,
                'exam_start_at' => $exam->exam_started_at,
                'exam_end_at' => $exam->exam_ended_at,
                'subjects' => $exam->subjects,
                'has_negative_mark' => $exam->has_negative_mark,
                'negative_mark' => $exam->negative_mark,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        Validator::make($request->all(), [
            'name' => ['required', Rule::unique('exams')->ignore($exam->id), 'max:255'],
            'category' => ['required'],
            'total_question' => ['required', 'numeric', 'min:5', 'max:200'],
            'exam_duration' => ['required', 'numeric', 'min:0'],
            'negative_mark' => [ 'nullable' ,'numeric', 'min:0', 'max:1'],
            'exam_start_at' => ['required'],
            'exam_end_at' => ['required'],
            'subjects' => ['required'],
        ])->after(function ($validator) use ($request) {
            if ($request->total_question != $request->total_question_in_subjects) {
                $validator->errors()->add(
                    'subjects', 'Total Number of Questions is not matched with the number of questions in subject.'
                );
            }
        })->validate();

        $exam->name = $request->name;
        $exam->exam_category_id = $request->category;
        $exam->total_question = $request->total_question;
        $exam->exam_duration = $request->exam_duration;
        $exam->exam_started_at = $request->exam_start_at;
        $exam->exam_ended_at = $request->exam_end_at;
        $exam->subjects = $request->subjects;

        if($request->has_negative_mark)
        {
            $exam->has_negative_mark = true;
            $exam->negative_mark = $request->negative_mark;
        }else {
            $exam->has_negative_mark = false;
            $exam->negative_mark = 0.25;
        }

        $exam->save();
        return Redirect::route('admin.exams.show', $exam->exam_code);
    }

    /**
     * Change Exam Status to published.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function toogleExamPublication(Exam $exam)
    {
        if($exam->status === 'published')
        {
            $exam->status = 'pending';
        }else {
            $exam->status = 'published';
        }
        
        $exam->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();
        return Redirect::route('admin.exams.index');
    }
}
