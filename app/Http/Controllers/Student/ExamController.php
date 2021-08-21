<?php

namespace App\Http\Controllers\Student;

use App\Models\Exam;
use Inertia\Inertia;
use App\Models\Result;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ExamController extends Controller
{
    public function index()
    {
        $currentExam = Exam::whereBatchId(Student::where('user_id', Auth::id())->select('batch_id')->first()->batch_id)
                    ->whereNotIn('id', Result::whereUserId(Auth::id())->pluck('exam_id'))
                    ->whereStatus('published')
                    ->where('exam_started_at', '<=', now())
                    ->where('exam_ended_at', '>=', now())
                    ->oldest()
                    ->select('id', 'exam_code', 'name', 'exam_category_id', 'subjects', 'exam_started_at', 'exam_ended_at')
                    ->with('category:id,name')
                    ->first();

        return Inertia::render('Student/Exam/Index', [
            'currentExam' => function() use ($currentExam) {
                if(!$currentExam) {
                    return;
                }

                return [
                    'id' => $currentExam->id,
                    'exam_code' => $currentExam->exam_code,
                    'category' => $currentExam->category->name,
                    'name' => $currentExam->name,
                    'ended_at' => $currentExam->exam_ended_at->toDayDateTimeString(),
                ];
            }

            // 'nextExams' => Schedule::where([
            //                     'course_id' => $user->course_id, 
            //                     'batch_id' => $user->batch_id,
            //                     'status' => 'pending'
            //                 ])
            //                 ->whereDate('class_time', '>=', now())
            //                 ->oldest('class_time')
            //                 ->with('teacher:id,first_name,last_name')
            //                 ->take(10)
            //                 ->get()
            //                 ->transform(function($class) {
            //                     return [
            //                         'id' => $class->id,
            //                         'name' => $class->name,
            //                         'class_id' => $class->class_id,
            //                         'subject' => $class->subject,
            //                         'topics' => $class->topics,
            //                         'teacher' => $class->teacher->full_name,
            //                         'class_time' => Carbon::parse($class->class_time)->toDayDateTimeString()
            //                     ];
            //                 })
        ]);
    }

    public function startExam(Exam $exam)
    {
        //check already take the exam
        if(Result::where(['user_id' => Auth::id(), 'exam_id' => $exam->id])->exists()) 
        {
            return 'already taken';
        }

        //create the initial result data
        $result = Result::create([
            'result_code' => (string) Str::uuid(),
            'user_id' => Auth::id(),
            'exam_id' => $exam->id,

        ]);
        
        return Inertia::render('Student/Exam/TakeExam', [
            'result_code' => $result->result_code,
            'exam' => [
                'id' => $exam->id,
                'exam_code' => $exam->exam_code,
                'category' => $exam->category()->select('id', 'name')->first()->name,
                'name' => $exam->name,
                'total_question' => $exam->total_question,
                'duration' => $exam->exam_duration,
                'schedule' => [
                    'start' => $exam->exam_started_at->toDayDateTimeString(),
                    'end' => $exam->exam_ended_at->toDayDateTimeString(),
                ],
                'subjects' => $exam->subjects,
            ],
            'questions' => $exam->questions()->orderBy('subject_id')->inRandomOrder()->get()->map(function($question) {
                return [
                    'id' => $question->id,
                    'question' => $question->name,
                    'options' => [
                        'a' => $question->option_a,
                        'b' => $question->option_b,
                        'c' => $question->option_c,
                        'd' => $question->option_d,
                    ],
                    'subject' => $question->subject_id  
                ];
            })
        ]);
    }

    public function finishExam(Exam $exam, Request $request)
    {
        // get the result data
        $questions = $exam->questions()->with('subject:id,name')->orderBy('subject_id')->get();
        $answerSheet = collect($request->answerSheet);

        $totalAnswered = 0;
        $correctAnswer = 0;
        $wrongAnswer = 0;
        $negativeMark = 0;
        $questionData = [];

        // evaluating result
        if($answerSheet->count()) {
            foreach ($questions as $question) {
                $answer = $answerSheet->firstWhere('id', $question->id);

                if($answer) {
                    if($question->answer === $answer['answer']) {
                        $correctAnswer += 1;
                    }else {
                        $wrongAnswer += 1;
                    }

                    $totalAnswered += 1;
                }

                $questionData[] = [
                    'subject' => $question->subject->name,
                    'question' => $question->name,
                    'options' => [
                        'a' => $question->option_a,
                        'b' => $question->option_b,
                        'c' => $question->option_c,
                        'd' => $question->option_d,
                    ],
                    'answer' => $question->answer,
                    'selectedAnswer' => $answer ? $answer['answer'] : null
                ];
            };
        }

        // negetive mark
        if($exam->has_negative_mark) {
            $negativeMark = $wrongAnswer * $exam->negative_mark;
        }

        // total result
        $totalMark = $correctAnswer - $negativeMark;

        // storing result
        $result = Result::where('result_code', $request->result_code)->firstOrFail();
        $result->exam_category = $exam->category()->select('id', 'name')->first()->name;
        $result->exam_name = $exam->name;
        $result->total_question = $exam->total_question;
        $result->total_answered = $totalAnswered;
        $result->correct_answer = $correctAnswer;
        $result->wrong_answer = $wrongAnswer;
        $result->negative_mark = $negativeMark;
        $result->total_mark = $totalMark;
        $result->exam_meta_data = $questionData;
        $result->save();

        return Redirect::route('students.results.summary', $result->result_code);
    }

}
