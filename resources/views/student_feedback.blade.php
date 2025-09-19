<!-- resources/views/student_feedback.blade.php -->

@extends('layouts')

@section('content')
<div class="container mt-4">
    <div class="card shadow p-4">
        <h4 class="text-center fw-bold">Lourdes College, Inc.</h4>
        <p class="text-center mb-0">Higher Education Department</p>
        <p class="text-center fw-bold">Guidance and Counseling Center</p>
        <p class="text-center">SY 2022-2023 2ND SEMESTER Guidance and Counseling Evaluation</p>

        <p class="mt-3">
            The purpose of this tool is to evaluate the session you had with your counselor/advocate. 
            This will be used as the basis for our improvement in the Guidance and Counseling Center. Thank you!
        </p>

        <!-- Student Information -->
        <form method="POST" action="{{ route('feedback.store') }}">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Name:</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Course & Year Level:</label>
                    <input type="text" name="course_year" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Counselor’s Name:</label>
                <input type="text" name="counselor" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Purpose of Counseling:</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="purpose[]" value="Academic">
                    <label class="form-check-label">Academic</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="purpose[]" value="Career">
                    <label class="form-check-label">Career</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="purpose[]" value="Personal">
                    <label class="form-check-label">Personal</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="purpose[]" value="Social">
                    <label class="form-check-label">Social</label>
                </div>
            </div>

            <!-- Part A: Likert Scale -->
            <h6 class="fw-bold mt-4">PART A: Evaluate both the session and the counselor using the Likert scale</h6>
            <p>5 = Strongly Agree | 4 = Agree | 3 = Disagree | 2 = Strongly Disagree | 1 = No Opinion/Not Applicable</p>

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>About the Counseling Session</th>
                        <th class="text-center">5</th>
                        <th class="text-center">4</th>
                        <th class="text-center">3</th>
                        <th class="text-center">2</th>
                        <th class="text-center">1</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $questions = [
                            'The session was helpful in accomplishing my immediate objective(s).',
                            'All information was thoroughly and clearly explained.',
                            'My questions were answered.',
                            'The counselor was sensitive to deal with my concerns.',
                            'The session will be valuable to me in completing my academic, career and/or personal goals.',
                            'Demonstrated a genuine desire to help me and listened attentively.',
                            'Was knowledgeable and prepared for the session.',
                            'Made me feel comfortable and welcome.',
                            'Helped me to examine my alternatives and encouraged me to ask questions.',
                            'Used the counseling time efficiently.',
                            'Demonstrated respect for individuality and sensitivity to diversity.',
                            'I was made aware of the confidentiality clause as agreed on the informed consent.'
                        ];
                    @endphp

                    @foreach($questions as $index => $question)
                    <tr>
                        <td>{{ $question }}</td>
                        @for($i=5; $i>=1; $i--)
                            <td class="text-center">
                                <input type="radio" name="q{{ $index+1 }}" value="{{ $i }}">
                            </td>
                        @endfor
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Part B: Written Evaluation -->
            <h6 class="fw-bold mt-4">PART B: Written Evaluation</h6>

            <div class="mb-3">
                <label class="form-label">1. What did you like about this counseling session?</label>
                <textarea name="like" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">2. Comments/Suggestions to improve the session:</label>
                <textarea name="suggestions" class="form-control" rows="3"></textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success px-4">Submit</button>
            </div>
        </form>

        <hr>
        <p class="text-muted small">
            Reference: The form was adapted and modified from Foothill-De Anza Community College District. <br>
            STRICTLY CONFIDENTIAL. All data is stored securely. Survey results will not contain any personally identifiable information.
        </p>
    </div>
</div>
@endsection
