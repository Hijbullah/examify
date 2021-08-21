<?php

namespace App\Http\Controllers\Student;

use Inertia\Inertia;
use App\Models\LectureSheet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LectureSheetController extends Controller
{
    public function index()
    {
        return Inertia::render('Student/LectureSheet/Index', [
            'lectureSheets' => LectureSheet::with('subject:id,name')
                ->select('id', 'subject_id', 'title')
                ->latest()
                ->paginate(10)
                ->transform(function ($lectureSheet) {
                    return [
                        'id' => $lectureSheet->id,
                        'subject' => $lectureSheet->subject->name,
                        'title' => $lectureSheet->title
                    ];
                })
        ]); 
    }

    public function download(LectureSheet $lectureSheet)
    {
        return $lectureSheet->getFirstMedia('lecture-sheet');
    }
}
