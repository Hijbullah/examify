<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Subject;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Subject/Index', [
            'filters' => request()->all('search'),
            'subjects' => Subject::filter(request()->only('search'))
                ->latest()
                ->paginate(10)
                ->transform(function ($subject) {
                    return [
                        'id' => $subject->id,
                        'name' => $subject->name,
                        'slug' => $subject->slug,
                        'status' => $subject->status
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
        return Inertia::render('Admin/Subject/Create');
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
            'name' => ['required', 'string' ,'unique:subjects', 'max:255'],
            'status' => ['required', 'boolean']
        ]);

        Subject::create([
            'name' => $request->name,
            'slug' => Str::of($request->name)->limit(100)->slug(),
            'status' => $request->status
        ]);

        return Redirect::route('admin.subjects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        return Inertia::render('Admin/Subject/Edit', [
            'subject' => $subject->only('id','slug', 'name', 'status'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => ['required', 'max:255', Rule::unique('subjects')->ignore($subject->id)],
            'status' => ['required', 'boolean'],
        ]);

        $subject->name = $request->name;

        if($subject->isDirty('name'))
        {
           $subject->slug = Str::of($request->name)->limit(100)->slug();
        }

        $subject->status = $request->status;
        $subject->save();
        return Redirect::route('admin.subjects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return back();
    }
}
