<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Batch;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Batch/Index', [
            'filters' => request()->all('search'),
            'batches' => Batch::filter(request()->only('search'))
                ->with('course:id,name')
                ->latest()
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($batch) => [
                    'id' => $batch->id,
                    'name' => $batch->name,
                    'slug' => $batch->slug,
                    'course' => $batch->course,
                    'status' => $batch->status
                ])
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Batch/Create', [
            'courses' => Course::all()->transform(fn($course) => [
                'value' => $course->id,
                'label' => $course->name
            ])
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
            'name' => ['required', 'unique:batches', 'max:255'],
            'course' => ['required', 'numeric'],
            'status' => ['required', 'boolean'],
        ]);

        Batch::create([
            'course_id' => $request->course,
            'name' => $request->name,
            'slug' => Str::of($request->name)->limit(100)->slug(),
            'status' => $request->status,
        ]);

        return Redirect::route('admin.batches.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function show(Batch $batch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function edit(Batch $batch)
    {
        return Inertia::render('Admin/Batch/Edit', [
            'batch' => $batch->only('id','slug', 'name', 'course_id', 'status'),
            'courses' => Course::all()->transform(fn($course) => [
                'value' => $course->id,
                'label' => $course->name
            ])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Batch $batch)
    {
        $request->validate([
            'name' => ['required', 'max:255', Rule::unique('batches')->ignore($batch->id)],
            'course' => ['required', 'numeric'],
            'status' => ['required', 'boolean'],
        ]);
        
        $batch->course_id = $request->course;
        $batch->name = $request->name;

        if($batch->isDirty('name'))
        {
           $batch->slug = Str::of($request->name)->limit(100)->slug();
        }

        $batch->status = $request->status;
        $batch->save();
        return Redirect::route('admin.batches.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Batch $batch)
    {
        $batch->delete();
        return back();
    }
}
