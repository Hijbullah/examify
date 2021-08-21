<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    public function showExamResults(Exam $exam)
    {
        return Inertia::render('Admin/Result/Index', [
            'filters' => request()->all('search'),
            'exam' => [
                'id' => $exam->id,
                'exam_code' => $exam->exam_code,
                'name' => $exam->name,
                'schedule' => [
                    'start' => $exam->exam_started_at->format('d/m/Y h:i A'),
                    'end' => $exam->exam_ended_at->format('d/m/Y h:i A'),
                ],
                'status' => $exam->status
            ],
            'results' => $exam->results()
                        ->select(
                            'id', 
                            'result_code', 
                            'user_id', 
                            'total_mark',
                            'position',
                            'updated_at'
                        )
                        ->with('student:id,first_name,last_name')
                        ->orderBy('position', 'asc')
                        ->paginate(10)
                        ->transform(function($result) {
                            return [
                                'id' => $result->id,
                                'result_code' => $result->result_code,
                                'total_mark' => $result->total_mark,
                                'position' => $result->position,
                                'exam_taken_at' => $result->updated_at->format('d/m/Y h:i A'),
                                'student' => $result->student
                            ];
                        })
        ]);
    }

    public function publishResults(Exam $exam)
    {
        $position = 0;
        $currentMark = 0; //8
        $exam->results()
            ->select('id', 'total_mark', 'position', 'is_published')
            ->orderBy('total_mark', 'desc')
            ->chunk(100, function($results) use(&$position, &$currentMark) {
                foreach ($results as $result) {
                    if($currentMark != $result->total_mark) // 0 != 8
                    {
                        $currentMark = $result->total_mark;
                        $position += 1;
                    }

                    $result->update(['position' => $position, 'is_published' => true]);
                }
            });
        
        $exam->status = 'closed';
        $exam->save();
        
        return back();
    }
}
