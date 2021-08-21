<?php

namespace App\Http\Controllers\Student;

use Inertia\Inertia;
use App\Models\Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ResultController extends Controller
{
    public function index()
    {
        return Inertia::render('Student/Result/Index', [
            'results' => Result::whereUserId(Auth::id())
                    ->latest()
                    ->select('id', 'result_code', 'exam_category', 'exam_name', 'total_mark', 'updated_at')
                    ->paginate(10)
                    ->transform(function($result) {
                        return [
                            'id' => $result->id,
                            'result_code' => $result->result_code,
                            'exam' => $result->exam_category . ': ' . $result->exam_name,
                            'total_mark' => $result->total_mark,
                            'exam_taken_at' => $result->updated_at->format('d/m/Y h:i A')
                        ];
                    })
        ]);
    }
    public function resultSummary(Result $result)
    {
        return Inertia::render('Student/Result/Summary', [
            'result' => [
                'id' => $result->id,
                'result_code' => $result->result_code,
                'exam_category' => $result->exam_category,
                'exam_name' => $result->exam_name,
                'total_question' => $result->total_question,
                'correct_answer' => $result->correct_answer,
                'wrong_answer' => $result->wrong_answer,
                'negative_mark' => $result->negative_mark,
                'total_mark' => $result->total_mark,
                'position' => $result->position,
                'is_published' => $result->is_published
            ]
        ]);
    }

    public function detailsResult(Result $result)
    {
        if (!$result->is_published) {
            return Redirect::route('students.results.summary', $result->result_code);
        }

        return Inertia::render('Student/Result/Details', [
            'result' => $result
        ]);
    
    }
}
