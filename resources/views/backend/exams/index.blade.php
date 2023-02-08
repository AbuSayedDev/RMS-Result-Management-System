@extends('layouts.backend')

@push('title', 'Exams')

@section('content')
    <div class="md-card uk-margin-medium-bottom">
        <div class="user_heading uk-sticky-placeholder" data-uk-sticky="{ top: 48, media: 960 }">
            <div class="user_heading_content">
                <h2 class="heading_b uk-float-left">
                    <span>List of Exams</span>
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
                        <th>Season</th>
                        <th>Year</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                @foreach ($exams as $exam)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $exam->name }}</td>
                        <td>{{ $exam->season_name }}</td>
                        <td>{{ $exam->season_year }}</td>
                        <td>
                            <div class="uk-button-group">
                                <a data-uk-modal="{target: '#editModal{{ $exam->id }}'}"><i class="material-icons uk-text-primary md-icon" data-uk-tooltip title="Edit">create</i></a>
                                <a href="{{ route('admin_exams_delete', $exam->id) }}" onclick="deleterow(this); return false"><i class="material-icons uk-text-danger md-icon" data-uk-tooltip title="Delete">delete</i></a>
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
                <h2 class="heading_b uk-text-center"><span>Add New Exam</span></h2>
            </div>
        </div>
        <div class="uk-modal-dialog">
            <button type="button" class="uk-modal-close uk-close"></button>
            <form method="post" action="{{ route('admin_exams_store') }}" enctype="multipart/form-data">
                @csrf

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                        <label for="name" class="uk-vertical-align-middle uk-text-bold">Exam Name:</label>
                    </div>
                    <div class="uk-width-medium-2-3">
                        <label for="name">Exam Name</label>
                        <input class="md-input" type="text" id="name" name="name" value="{{ old('name') }}" required="">
                        @error('name')
                            <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                        <label for="season_id" class="uk-vertical-align-middle uk-text-bold">Season:</label>
                    </div>
                    <div class="uk-width-medium-2-3">
                        <select id="season_id" name="season_id" class="md-input" required>
                            <option value="">Select Season...</option>
                            @foreach ($seasons as $season)
                                <option value="{{ $season->id }}" {{ $season->id == old('season_id') ? 'selected' : '' }}>{{ $season->name }}</option>
                            @endforeach
                        </select>
                        @error('season_id')
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

     @foreach ($exams as $exam)
        <div class="uk-modal" id="editModal{{ $exam->id }}">
            <div class="user_heading">
                <div class="user_heading_content">
                    <h2 class="heading_b uk-text-center"><span>{{ $exam->name }}</span></h2>
                </div>
            </div>
            <div class="uk-modal-dialog">
                <button type="button" class="uk-modal-close uk-close"></button>
                <form method="post" action="{{ route('admin_exams_update', $exam->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                            <label for="name" class="uk-vertical-align-middle uk-text-bold">Exam Name:</label>
                        </div>
                        <div class="uk-width-medium-2-3">
                            <label for="name">Exam Name</label>
                            <input class="md-input" type="text" id="name" name="name" value="{{ $exam->name }}" required="">
                            @error('name')
                                <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                            <label for="season_id" class="uk-vertical-align-middle uk-text-bold">Season:</label>
                        </div>
                        <div class="uk-width-medium-2-3">
                            <select id="season_id" name="season_id" class="md-input" required>
                                <option value="">Select Season...</option>
                                @foreach ($seasons as $season)
                                    <option value="{{ $season->id }}" {{ $season->id == $exam->season_id ? 'selected' : '' }}>{{ $season->name }}</option>
                                @endforeach
                            </select>
                            @error('season_id')
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
        $('.sidebar_exams').addClass('current_section');
    </script>
@endpush