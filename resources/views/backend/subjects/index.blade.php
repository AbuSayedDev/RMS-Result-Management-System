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
                        <th>Name</th>
                        <th>Batch</th>
                        <th>Mark</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                @foreach ($subjects as $subject)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->batch_name }}</td>
                        <td>{{ $subject->mark }}</td>
                        <td>
                            <div class="uk-button-group">
                                <a data-uk-modal="{target: '#editModal{{ $subject->id }}'}"><i class="material-icons uk-text-primary md-icon" data-uk-tooltip title="Edit">create</i></a>
                                <a href="{{ route('admin_subjects_delete', $subject->id) }}" onclick="deleterow(this); return false"><i class="material-icons uk-text-danger md-icon" data-uk-tooltip title="Delete">delete</i></a>
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
                <h2 class="heading_b uk-text-center"><span>Add New Subject</span></h2>
            </div>
        </div>
        <div class="uk-modal-dialog">
            <button type="button" class="uk-modal-close uk-close"></button>
            <form method="post" action="{{ route('admin_subjects_store') }}" enctype="multipart/form-data">
                @csrf

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                        <label for="name" class="uk-vertical-align-middle uk-text-bold">Subject Name:</label>
                    </div>
                    <div class="uk-width-medium-2-3">
                        <label for="name">Subject Name</label>
                        <input class="md-input" type="text" id="name" name="name" value="{{ old('name') }}" required="">
                        @error('name')
                            <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                        <label for="batch_id" class="uk-vertical-align-middle uk-text-bold">Batch:</label>
                    </div>
                    <div class="uk-width-medium-2-3">
                        <select id="batch_id" name="batch_id" class="md-input" required>
                            <option value="">Select Batch...</option>
                            @foreach ($batches as $batch)
                                <option value="{{ $batch->id }}" {{ $batch->id == old('batch_id') ? 'selected' : '' }}>{{ $batch->name }}</option>
                            @endforeach
                        </select>
                        @error('batch_id')
                            <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                        <label for="mark" class="uk-vertical-align-middle uk-text-bold">Subject Mark:</label>
                    </div>
                    <div class="uk-width-medium-2-3">
                        <label for="mark">Subject Mark</label>
                        <input class="md-input" type="number" id="mark" name="mark" value="{{ old('mark') }}" required="">
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

     @foreach ($subjects as $subject)
        <div class="uk-modal" id="editModal{{ $subject->id }}">
            <div class="user_heading">
                <div class="user_heading_content">
                    <h2 class="heading_b uk-text-center"><span>{{ $subject->name }}</span></h2>
                </div>
            </div>
            <div class="uk-modal-dialog">
                <button type="button" class="uk-modal-close uk-close"></button>
                <form method="post" action="{{ route('admin_subjects_update', $subject->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                            <label for="name" class="uk-vertical-align-middle uk-text-bold">Subject Name:</label>
                        </div>
                        <div class="uk-width-medium-2-3">
                            <label for="name">Subject Name</label>
                            <input class="md-input" type="text" id="name" name="name" value="{{ $subject->name }}" required="">
                            @error('name')
                                <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                            <label for="batch_id" class="uk-vertical-align-middle uk-text-bold">Batch:</label>
                        </div>
                        <div class="uk-width-medium-2-3">
                            <select id="batch_id" name="batch_id" class="md-input" required>
                                <option value="">Select Batch...</option>
                                @foreach ($batches as $batch)
                                    <option value="{{ $batch->id }}" {{ $batch->id == $subject->batch_id ? 'selected' : '' }}>{{ $batch->name }}</option>
                                @endforeach
                            </select>
                            @error('batch_id')
                                <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                            <label for="mark" class="uk-vertical-align-middle uk-text-bold">Subject Mark:</label>
                        </div>
                        <div class="uk-width-medium-2-3">
                            <label for="mark">Subject Mark</label>
                            <input class="md-input" type="number" id="mark" name="mark" value="{{ $subject->mark }}" required="">
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
        $('.sidebar_subjects').addClass('current_section');
    </script>
@endpush