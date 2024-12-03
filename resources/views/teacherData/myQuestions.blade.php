@extends('layouts.master')

@section('content')

<div class="main-wrapper">
    <div class="page-wrapper">
        <div class="content container-fluid">

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mt-4 custom-alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-name">Questions</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Questions</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Adding a New Question</h4>
                    <div class="button-list">
                        <button type="button" class="btn btn-success waves-effect waves-light mt-1" data-bs-toggle="modal" data-bs-target="#question-modal" id="add-question">ADD QUESTION</button>
                    </div>
                    @include('components.modal', [
                    'modalId' => 'question-modal',
                    'modalTitle' => 'Add New Question',
                    'formId' => 'question-form',
                    'formAction' => route('questions.store'),
                    'fields' => [
                    [
                    'id' => 'field-1-question-text',
                    'label' => 'Question Text',
                    'name' => 'question_text',
                    'type' => 'text',
                    'placeholder' => 'Enter question text',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-2-answers',
                    'label' => 'Answers (One per line)',
                    'name' => 'answers',
                    'type' => 'textarea',
                    'placeholder' => 'Enter answers, one per line. For example:\nhtml\ncss\njs',
                    'required' => true,
                    ],

                    [
                    'id' => 'field-3-correct-answer',
                    'label' => 'Correct Answer',
                    'name' => 'correct_answer',
                    'type' => 'text',
                    'placeholder' => 'Enter correct answer',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-4-score',
                    'label' => 'Score',
                    'name' => 'score',
                    'type' => 'number',
                    'placeholder' => 'Enter score for the question',
                    'required' => true,
                    ],
                    [
                    'id' => 'field-5-exam-id',
                    'label' => 'Exam Name',
                    'name' => 'exam_id',
                    'type' => 'select',
                    'options' => $exams->pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select exam',
                    'required' => true,
                    ],
                    ],
                    'saveBtn'=>'save-button-question'
                    ])
                </div>
            </div>

            @php
            $headers = ['ID', 'Question Text','Answers','Correct Answer', 'Score', 'Exam Name'];
            $modelName = 'Question';
            $routeDestroy = 'questions.destroy';

            $rows = $questions->map(function ($question) {
            $answers = !empty($question->answers) ? implode(', ', json_decode($question->answers, true)) : '';
            return [
            'id' => $question->id,
            'data' => [
            $question->id,
            $question->question_text,
            $answers,
            $question->correct_answer,
            $question->score,
            $question->exam->name,
            ],
            ];
            })->toArray();

            $actionButtons = function ($row) {

            $cleanAnswers = preg_replace('/\r\n|\r|\n/', ' ', $row['data'][2]);
            $cleanAnswers = trim($cleanAnswers);

            return '
            <button class="btn btn-rounded btn-warning edit-question"
                data-bs-toggle="modal"
                data-bs-target="#question-modal"
                data-id="' . $row['id'] . '"
                data-question-text="' . $row['data'][1] . '"
                data-answers="' . htmlentities($cleanAnswers) . '"
                data-correct-answer="' . $row['data'][3] . '"
                data-score="' . $row['data'][4] . '"
                data-exam-name="' . $row['data'][5] . '">
                Edit
            </button>


            <form action="' . route('questions.destroy', $row['data'][0]) . '" method="POST" style="display: inline-block;">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                    data-name="Delete Question"
                    data-body="Are you sure you want to delete this question?"
                    data-action="delete"
                    data-url="/questions/' . $row['data'][0] . '">
                    Delete
                </button>
            </form>
            ';
            };
            @endphp

            @include('components.data-table', [
            'title' => 'Questions',
            'description' => 'Add a new question to the table',
            'headers' => $headers,
            'rows' => $rows,
            'modelName' => $modelName,
            'routeDestroy' => $routeDestroy,
            'actionButtons' => $actionButtons,
            'bulkDelete'=>'questions_list'
            ])

        </div>

        <footer>
            <p>Copyright © 2024 Dreamguys.</p>
        </footer>
    </div>
</div>

@endsection