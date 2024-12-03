@if (!$questions || count($questions) === 0)
    <script>
        var modalHtml = `
            <div class="modal fade" id="noQuestionsModal" tabindex="-1" aria-labelledby="noQuestionsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-body p-4">
                            <div class="text-center">
                                <i class="dripicons-information h1 text-info"></i>
                                <h4 class="mt-2">Heads up!</h4>
                                <p class="mt-3">
                                  No questions available for this exam.
                                  You will be redirected to the exams page shortly.
                                </p>
                                <button
                                    type="button"
                                    class="btn btn-info my-2"
                                    data-bs-dismiss="modal"
                                    onclick="window.location.href = '{{ route('student.exams') }}';"
                                >
                                  Continue
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        
        var modal = new bootstrap.Modal(document.getElementById('noQuestionsModal'));
        modal.show();

        var modalButton = document.querySelector('#noQuestionsModal .btn-info');
        modalButton.addEventListener('click', function() {
            window.location.href = "{{ route('student.exams') }}";
        });
    </script>
@endif



<div class="container mt-5"
    x-data="{ 
        selectedAnswer: @entangle('selectedAnswer'), 
        cheatingDetected: false,
        alertShown: false, // Prevent duplicate alerts
         questionId: {{ $questions[$currentQuestionIndex]->id ?? 'null' }},
         correctAnswer: '{{ $questions[$currentQuestionIndex]->correct_answer ?? '' }}',
          score: '{{ $questions[$currentQuestionIndex]->score ?? '' }}'
    }"
    x-init="
        if (!alertShown) {
            alert('Please do not refresh the page or navigate outside. This action will be detected as cheating.');
            alertShown = true;
        }

        window.addEventListener('beforeunload', function () {
            if (!cheatingDetected) {
                cheatingDetected = true; // Prevent further calls
                @this.call('markCheating', questionId, correctAnswer, score); // Call method once
            }
        });

        window.addEventListener('visibilitychange', function () {
            if (document.hidden && !cheatingDetected) {
                cheatingDetected = true; // Prevent further calls
                @this.call('markCheating', questionId, correctAnswer, score); // Call method once
            }
        });

        window.addEventListener('cheating-detected', function () {
            cheatingDetected = true; // Prevent further calls
            window.location.href = '{{ route('student.exams') }}'; 
        });
    ">
    {{-- Exam Details --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="card-title">Exam Details</h4>
            <p><strong>Student ID:</strong> {{ $studentId }}</p>
            <p><strong>Student Name:</strong> {{ $studentName }}</p>
            <p><strong>Exam Name:</strong> {{ $exam->name }}</p>
            <p><strong>Created At:</strong> {{ $exam->created_at->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>

    {{-- Show Question --}}
    @if (isset($questions[$currentQuestionIndex]))
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p><strong>Question {{ $currentQuestionIndex + 1 }} of {{ count($questions) }}</strong></p>
            <p><strong>{{ $questions[$currentQuestionIndex]->question_text }}</strong></p>

            @php
            // Decode the JSON answers and handle splitting based on space or comma.
            $answers = json_decode($questions[$currentQuestionIndex]->answers);
            $answers = is_array($answers) ? $answers : explode(',', preg_replace('/\s+/', ',', $answers)); // Replace spaces with commas, then split by commas
            @endphp

            {{-- Display Answers --}}
            @foreach ($answers as $answer)
            <div class="form-check">
                <input
                    type="radio"
                    class="form-check-input"
                    name="answer"
                    value="{{ trim($answer) }}"
                    id="answer-{{ $loop->index }}"
                    wire:model="selectedAnswer"
                    x-on:change="selectedAnswer = '{{ trim($answer) }}'"> <!-- Sync with Alpine.js -->
                <label class="form-check-label" for="answer-{{ $loop->index }}">
                    {{ trim($answer) }}
                </label>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Next Button --}}
    <div class="text-center mb-5">
        <button
            wire:click="nextQuestion('{{ $questions[$currentQuestionIndex]->id }}', '{{ $questions[$currentQuestionIndex]->correct_answer }}', '{{ $questions[$currentQuestionIndex]->score }}')"
            class="btn btn-primary btn-lg"
            :disabled="!selectedAnswer">
            Next Question
        </button>
    </div>
    @else
    <p class="text-center mt-4">No questions available!</p>
    @endif
</div>