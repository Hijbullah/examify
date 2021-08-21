<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Course/Index', [
            'filters' => request()->all('search'),
            'courses' => Course::filter(request()->only('search'))
                ->withCount(['batches'])
                ->latest()
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($course) => [
                    'id' => $course->id,
                    'name' => $course->name,
                    'slug' => $course->slug,
                    'batches_count' => $course->batches_count,
                    'admission_status' => $course->admission_status
                ])
                // ->transform(function ($course) {
                //     return [
                //         'id' => $course->id,
                //         'name' => $course->name,
                //         'slug' => $course->slug,
                //         'batches_count' => $course->batches_count,
                //         'admission_status' => $course->admission_status
                //     ];
                // })
        ]); 
                
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Course/Create');
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
            'name' => ['required', 'unique:courses', 'max:255'],
            'details' => ['nullable', 'string'],
            'admission_status' => ['required', 'boolean'],
        ]);

        Course::create([
            'name' => $request->name,
            'slug' => Str::of($request->name)->limit(100)->slug(),
            'details' => $request->details,
            'admission_status' => $request->admission_status,
        ]);

        return Redirect::route('admin.courses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return Inertia::render('Admin/Course/Edit', [
            'course' => $course->only('id','slug', 'name', 'details', 'admission_status')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => ['required', 'max:255', Rule::unique('courses')->ignore($course->id)],
            'details' => ['nullable', 'string'],
            'admission_status' => ['required', 'boolean'],
        ]);

        $course->name = $request->name;

        if($course->isDirty('name'))
        {
           $course->slug = Str::of($request->name)->limit(100)->slug();
        }

        $course->details = $request->details;
        $course->admission_status = $request->admission_status;
        $course->save();
        return Redirect::route('admin.courses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return back();
    }
}
