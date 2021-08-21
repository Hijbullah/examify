<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Models\ExamCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ExamCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/ExamCategory/Index', [
            'filters' => request()->all('search'),
            'categories' => ExamCategory::filter(request()->only('search'))
                ->latest()
                ->paginate(10)
                ->transform(function ($examCategory) {
                    return [
                        'id' => $examCategory->id,
                        'name' => $examCategory->name,
                        'slug' => $examCategory->slug
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
        return Inertia::render('Admin/ExamCategory/Create');
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
            'name' => ['required', 'string' ,'unique:subjects', 'max:255']
        ]);

        ExamCategory::create([
            'name' => $request->name,
            'slug' => Str::of($request->name)->limit(100)->slug()
        ]);

        return Redirect::route('admin.exam-categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExamCategory  $examCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ExamCategory $examCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExamCategory  $examCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ExamCategory $examCategory)
    {
        return Inertia::render('Admin/ExamCategory/Edit', [
            'category' => $examCategory->only('id','slug', 'name'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExamCategory  $examCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExamCategory $examCategory)
    {
        $request->validate([
            'name' => ['required', 'max:255', Rule::unique('exam_categories')->ignore($examCategory->id)]
        ]);

        $examCategory->name = $request->name;

        if($examCategory->isDirty('name'))
        {
           $examCategory->slug = Str::of($request->name)->limit(100)->slug();
        }
        
        $examCategory->save();
        return Redirect::route('admin.exam-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExamCategory  $examCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamCategory $examCategory)
    {
        $examCategory->delete();
        return back();
    }
}
