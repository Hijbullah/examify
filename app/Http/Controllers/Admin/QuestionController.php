<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use Inertia\Inertia;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\QuestionsExport;
use App\Imports\QuestionsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;

class QuestionController extends Controller
{
    public function index(Exam $exam)
    {
        return Inertia::render('Admin/Question/Index', [
            'exam' => $exam->only('id', 'exam_code', 'name', 'total_question', 'status'),
            'questions' => $exam->questions()
                                ->with('subject:id,name')
                                ->orderBy('subject_id', 'asc')
                                ->latest()
                                ->get() 
                                ->transform(function($question) {
                                    return [
                                        'id' => $question->id,
                                        'question' => $question->name,
                                        'options' => [
                                            'a' => $question->option_a,
                                            'b' => $question->option_b,
                                            'c' => $question->option_c,
                                            'd' => $question->option_d,
                                        ],
                                        'answer' => $question->answer,
                                        'subject' => [
                                            'id' => $question->subject->id,
                                            'name' => $question->subject->name
                                        ]
                                    ];
                                })
        ]);
    }

    public function create(Exam $exam, $type)
    {
        return Inertia::render('Admin/Question/Create', [
            'type' => $type,
            'exam' => [
                'id' => $exam->id,
                'exam_code' => $exam->exam_code,
                'name' => $exam->name,
                'subjects' => collect($exam->subjects)->transform(function($subject) use($exam) {
                                    return [
                                        'id' => $subject['id'],
                                        'name' => $subject['name'],
                                        'no_of_question' => (Int) $subject['no_of_question'],
                                        'questions_count' => Question::where(['exam_id' => $exam->id, 'subject_id' => $subject['id']])->count()
                                    ];
                                })
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam' => ['required', 'numeric'],
            'subject' => ['required', 'numeric'],
            'question' => ['required', 'string'],
            'option_a' => ['required', 'string'],
            'option_b' => ['required', 'string'],
            'option_c' => ['required', 'string'],
            'option_d' => ['required', 'string'],
            'answer' => ['required', 'string'],
        ]);

      
        $question = Question::create([
            'exam_id' => $request->exam,
            'subject_id' => $request->subject,
            'name' => $request->question,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'answer' => $request->answer
        ]);


        return back();
    }

    public function importQuestions(Request $request)
    {
        $request->validate([
            'exam' => ['required', 'numeric'],
            'file' => ['required', 'file', 'mimes:csv,xlsx,ods', 'max:2048']
        ]);

        Excel::import(new QuestionsImport($request->exam), $request->file('file'));


        return Redirect::route('admin.questions.index', Exam::whereId($request->exam)->select('exam_code')->first()->exam_code);
    }

    public function downloadQuestionsFormat(Exam $exam)
    {
        $data = [];

        $fileName = Str::of($exam->name)->camel() . '.ods';


        foreach ($exam->subjects as $subject) {
            for ($i = 0; $i < $subject['no_of_question']; $i++) { 
                $data[] = [
                    'subject_id' => $subject['id'],
                    'subject' => $subject['name'],
                    'question' => '',
                    'option_a' => '',
                    'option_b' => '',
                    'option_c' => '',
                    'option_d' => '',
                    'answer' => ''
                ];
            }
        }

        return Excel::download(new QuestionsExport($data), $fileName);
    }

    public function edit(Exam $exam, Question $question)
    {
        return Inertia::render('Admin/Question/Edit', [
            'exam' => [
                'id' => $exam->id,
                'exam_code' => $exam->exam_code,
                'name' => $exam->name,
                'subjects' => $exam->subjects
            ],
            'question' => [
                'id' => $question->id,
                'question' => $question->name,
                'option_a' => $question->option_a,
                'option_b' => $question->option_b,
                'option_c' => $question->option_c,
                'option_d' => $question->option_d,
                'answer' => $question->answer,
                'subject' =>$question->subject_id
            ]
        ]);
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question' => ['required', 'string'],
            'option_a' => ['required', 'string'],
            'option_b' => ['required', 'string'],
            'option_c' => ['required', 'string'],
            'option_d' => ['required', 'string'],
            'answer' => ['required', 'string'],
        ]);

        $question->name = $request->question;
        $question->option_a = $request->option_a;
        $question->option_b = $request->option_b;
        $question->option_c = $request->option_c;
        $question->option_d = $request->option_d;
        $question->answer = $request->answer;
        $question->save();
        return back();
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return back();
    }
}
