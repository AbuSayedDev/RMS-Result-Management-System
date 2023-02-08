@extends('layouts.backend')

@push('title', 'Subject')

@section('content')
    <div class="md-card uk-margin-medium-bottom">
        <div class="user_heading uk-sticky-placeholder" data-uk-sticky="{ top: 48, media: 960 }">
            <div class="user_heading_content">
                <h2 class="heading_b uk-float-left">
                    <span>List of Subject</span>
                </h2>
            </div>
        </div>

        <div class="md-card-content">
            <div class="dt_colVis_buttons"></div>
            <table id="dt_tableExport" class="uk-table uk-table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Subject</th>
                        <th>Exam</th>
                        <th>Batch</th>
                        <th>Mark</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                @foreach ($results as $result)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $result->student_name }}</td>
                        <td>{{ $result->subject_name }}</td>
                        <td>{{ $result->exam_name }}</td>
                        <td>{{ $result->batch_name }}</td>
                        <td>{{ $result->mark }}</td>
                        <td>
                            <div class="uk-button-group">
                                <a data-uk-modal="{target: '#editModal{{ $result->id }}'}"><i class="material-icons uk-text-primary md-icon" data-uk-tooltip title="Edit">create</i></a>
                                <a href="{{ route('admin_results_delete', $result->id) }}" onclick="deleterow(this); return false"><i class="material-icons uk-text-danger md-icon" data-uk-tooltip title="Delete">delete</i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="md-fab-wrapper">
        <a data-uk-modal="{target:'#createModal'}" class="md-fab md-fab-accent">
            <i class="material-icons">add</i>
        </a>
    </div>

    <div class="uk-modal" id="createModal">
        <div class="user_heading">
            <div class="user_heading_content">
                <h2 class="heading_b uk-text-center"><span>Add A Result</span></h2>
            </div>
        </div>
        <div class="uk-modal-dialog">
            <button type="button" class="uk-modal-close uk-close"></button>
            <form method="post" action="{{ route('admin_results_store') }}" enctype="multipart/form-data">
                @csrf

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                        <label for="student_id" class="uk-vertical-align-middle uk-text-bold">Student:</label>
                    </div>
                    <div class="uk-width-medium-2-3">
                        <select id="student_id" name="student_id" class="md-input" required>
                            <option value="">Select Student...</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}" {{ $student->id == old('student_id') ? 'selected' : '' }}>{{ $student->name }}</option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                        <label for="exam_id" class="uk-vertical-align-middle uk-text-bold">Exam:</label>
                    </div>
                    <div class="uk-width-medium-2-3">
                        <select id="exam_id" name="exam_id" class="md-input" required>
                            <option value="">Select Exam...</option>
                            @foreach ($exams as $exam)
                                <option value="{{ $exam->id }}" {{ $exam->id == old('exam_id') ? 'selected' : '' }}>{{ $exam->name }}</option>
                            @endforeach
                        </select>
                        @error('exam_id')
                            <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                        <label for="subject_id" class="uk-vertical-align-middle uk-text-bold">Subject:</label>
                    </div>
                    <div class="uk-width-medium-2-3">
                        <select id="subject_id" name="subject_id" class="md-input" required>
                            <option value="">Select Subject...</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ $subject->id == old('subject_id') ? 'selected' : '' }}>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                        <label for="mark" class="uk-vertical-align-middle uk-text-bold">Mark:</label>
                    </div>
                    <div class="uk-width-medium-2-3">
                        <label for="mark">Mark</label>
                        <input class="md-input" type="text" id="mark" name="mark" value="{{ old('mark') }}" required="">
                        @error('mark')
                            <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3 uk-text-right">
                    </div>
                    <div class="uk-width-medium-2-3">
                        <button type="submit" class="md-btn md-btn-primary">Submit</button>
                    </div>
                </div>

            </form>

        </div>
    </div>

    @foreach ($results as $result)
        <div class="uk-modal" id="editModal{{ $result->id }}">
            <div class="user_heading">
                <div class="user_heading_content">
                    <h2 class="heading_b uk-text-center"><span>Edit Result - {{ $result->student_name }}</span></h2>
                </div>
            </div>
            <div class="uk-modal-dialog">
                <button type="button" class="uk-modal-close uk-close"></button>
                <form method="post" action="{{ route('admin_results_update', $result->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                            <label for="student_id" class="uk-vertical-align-middle uk-text-bold">Student:</label>
                        </div>
                        <div class="uk-width-medium-2-3">
                            <select id="student_id" name="student_id" class="md-input" required>
                                <option value="">Select Student...</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}" {{ $student->id == $result->student_id ? 'selected' : '' }}>{{ $student->name }}</option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                            <label for="exam_id" class="uk-vertical-align-middle uk-text-bold">Exam:</label>
                        </div>
                        <div class="uk-width-medium-2-3">
                            <select id="exam_id" name="exam_id" class="md-input" required>
                                <option value="">Select Exam...</option>
                                @foreach ($exams as $exam)
                                    <option value="{{ $exam->id }}" {{ $exam->id == $result->exam_id ? 'selected' : '' }}>{{ $exam->name }}</option>
                                @endforeach
                            </select>
                            @error('exam_id')
                                <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                            <label for="subject_id" class="uk-vertical-align-middle uk-text-bold">Subject:</label>
                        </div>
                        <div class="uk-width-medium-2-3">
                            <select id="subject_id" name="subject_id" class="md-input" required>
                                <option value="">Select Subject...</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ $subject->id == $result->subject_id ? 'selected' : '' }}>{{ $subject->name }}</option>
                                @endforeach
                            </select>
                            @error('subject_id')
                                <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                            <label for="mark" class="uk-vertical-align-middle uk-text-bold">Mark:</label>
                        </div>
                        <div class="uk-width-medium-2-3">
                            <label for="mark">Mark</label>
                            <input class="md-input" type="text" id="mark" name="mark" value="{{ $result->mark }}" required="">
                            @error('mark')
                                <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-3 uk-text-right">
                        </div>
                        <div class="uk-width-medium-2-3">
                            <button type="submit" class="md-btn md-btn-primary">Submit</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <script type="text/javascript">
        $('.sidebar_results').addClass('current_section');
    </script>
@endpush