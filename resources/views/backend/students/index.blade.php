@extends('layouts.backend')

@push('title', 'Students')

@section('content')
        <div class="md-card uk-margin-medium-bottom">
            <div class="user_heading uk-sticky-placeholder" data-uk-sticky="{ top: 48, media: 960 }">
                <div class="user_heading_content">
                    <h2 class="heading_b uk-float-left">
                        <span>List of Students</span>
                    </h2>
                </div>
            </div>

            <div class="md-card-content">
                <div class="dt_colVis_buttons"></div>
                <table id="dt_tableExport" class="uk-table uk-table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Id</th>
                            <th>Email</th>
                            <th>Registered At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->student_id }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->created_at }}</td>
                            <td>
                                <div class="uk-button-group">
                                    <a href="{{ route('admin_students_results', $student->id) }}" target="_blank"><i class="material-icons uk-text-success md-icon" data-uk-tooltip title="Results">receipt</i></a>
                                    <a data-uk-modal="{target: '#editModal{{ $student->id }}'}"><i class="material-icons uk-text-primary md-icon" data-uk-tooltip title="Edit">create</i></a>
                                    <a href="{{ route('admin_students_delete', $student->id) }}" onclick="deleterow(this); return false"><i class="material-icons uk-text-danger md-icon" data-uk-tooltip title="Delete">delete</i></a>
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
                    <h2 class="heading_b uk-text-center"><span>Add New Student</span></h2>
                </div>
            </div>
            <div class="uk-modal-dialog">
                <button type="button" class="uk-modal-close uk-close"></button>
                <form method="post" action="{{ route('admin_students_store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-5 uk-vertical-align uk-text-right">
                            <label for="name" class="uk-vertical-align-middle uk-text-bold">Name:</label>
                        </div>
                        <div class="uk-width-medium-4-5">
                            <label for="name">Name</label>
                            <input class="md-input" type="text" id="name" name="name" value="{{ old('name') }}" required="">
                            @error('name')
                                <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-5 uk-vertical-align uk-text-right">
                            <label for="student_id" class="uk-vertical-align-middle uk-text-bold">Student Id:</label>
                        </div>
                        <div class="uk-width-medium-4-5">
                            <label for="student_id">Student Id</label>
                            <input class="md-input" type="number" id="student_id" name="student_id" value="{{ old('student_id') }}" required="">
                            @error('student_id')
                                <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-5 uk-vertical-align uk-text-right">
                            <label for="email" class="uk-vertical-align-middle uk-text-bold">Email:</label>
                        </div>
                        <div class="uk-width-medium-4-5">
                            <label for="email">Email</label>
                            <input class="md-input" type="email" id="email" name="email" value="{{ old('email') }}" required="">
                            @error('email')
                                <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-5 uk-vertical-align uk-text-right">
                            <label for="password" class="uk-vertical-align-middle uk-text-bold">Password:</label>
                        </div>
                        <div class="uk-width-medium-4-5">
                            <label for="password">Password</label>
                            <input class="md-input" type="text" id="password" name="password" value="{{ old('password') ?? 12345678 }}" required="">
                            @error('password')
                                <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-5 uk-text-right">
                        </div>
                        <div class="uk-width-medium-4-5">
                            <button type="submit" class="md-btn md-btn-primary">Submit</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>

         @foreach ($students as $student)
            <div class="uk-modal" id="editModal{{ $student->id }}">
                <div class="user_heading">
                    <div class="user_heading_content">
                        <h2 class="heading_b uk-text-center"><span>{{ $student->name }}</span></h2>
                    </div>
                </div>
                <div class="uk-modal-dialog">
                    <button type="button" class="uk-modal-close uk-close"></button>
                    <form method="post" action="{{ route('admin_students_update', $student->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-5 uk-vertical-align uk-text-right">
                                <label for="name" class="uk-vertical-align-middle uk-text-bold">Name:</label>
                            </div>
                            <div class="uk-width-medium-4-5">
                                <label for="name">Name</label>
                                <input class="md-input" type="text" id="name" name="name" value="{{ $student->name }}" required="">
                                @error('name')
                                    <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-5 uk-vertical-align uk-text-right">
                                <label for="student_id" class="uk-vertical-align-middle uk-text-bold">Student Id:</label>
                            </div>
                            <div class="uk-width-medium-4-5">
                                <label for="student_id">Student Id</label>
                                <input class="md-input" type="number" id="student_id" name="student_id" value="{{ $student->student_id }}" required="">
                                @error('student_id')
                                    <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-5 uk-vertical-align uk-text-right">
                                <label for="email" class="uk-vertical-align-middle uk-text-bold">Email:</label>
                            </div>
                            <div class="uk-width-medium-4-5">
                                <label for="email">Email</label>
                                <input class="md-input" type="email" id="email" name="email" value="{{ $student->email }}" required="">
                                @error('email')
                                    <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-5 uk-text-right">
                            </div>
                            <div class="uk-width-medium-4-5">
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
        $('.sidebar_students').addClass('current_section');
    </script>
@endpush