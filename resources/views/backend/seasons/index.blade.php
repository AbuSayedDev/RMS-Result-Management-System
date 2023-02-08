@extends('layouts.backend')

@push('title', 'Seasons')

@section('content')
    <div class="md-card uk-margin-medium-bottom">
        <div class="user_heading uk-sticky-placeholder" data-uk-sticky="{ top: 48, media: 960 }">
            <div class="user_heading_content">
                <h2 class="heading_b uk-float-left">
                    <span>List of Seasons</span>
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
                        <th>Year</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                @foreach ($seasons as $season)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $season->name }}</td>
                        <td>{{ $season->year }}</td>
                        <td>
                            <div class="uk-button-group">
                                <a data-uk-modal="{target: '#editModal{{ $season->id }}'}"><i class="material-icons uk-text-primary md-icon" data-uk-tooltip title="Edit">create</i></a>
                                <a href="{{ route('admin_seasons_delete', $season->id) }}" onclick="deleterow(this); return false"><i class="material-icons uk-text-danger md-icon" data-uk-tooltip title="Delete">delete</i></a>
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
                <h2 class="heading_b uk-text-center"><span>Add New Season</span></h2>
            </div>
        </div>
        <div class="uk-modal-dialog">
            <button type="button" class="uk-modal-close uk-close"></button>
            <form method="post" action="{{ route('admin_seasons_store') }}" enctype="multipart/form-data">
                @csrf

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                        <label for="name" class="uk-vertical-align-middle uk-text-bold">Season Name:</label>
                    </div>
                    <div class="uk-width-medium-2-3">
                        <label for="name">Season Name</label>
                        <input class="md-input" type="text" id="name" name="name" value="{{ old('name') }}" required="">
                        @error('name')
                            <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                        <label for="year" class="uk-vertical-align-middle uk-text-bold">Year:</label>
                    </div>
                    <div class="uk-width-medium-2-3">
                        <select id="year" name="year" class="md-input" required>
                            <option value="">Select Year...</option>
                            @for ($year = 2021; $year < 2050; $year++)
                                <option value="{{ $year }}" {{ $year == old('year') ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                        @error('year')
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

     @foreach ($seasons as $season)
        <div class="uk-modal" id="editModal{{ $season->id }}">
            <div class="user_heading">
                <div class="user_heading_content">
                    <h2 class="heading_b uk-text-center"><span>{{ $season->name }}</span></h2>
                </div>
            </div>
            <div class="uk-modal-dialog">
                <button type="button" class="uk-modal-close uk-close"></button>
                <form method="post" action="{{ route('admin_seasons_update', $season->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                            <label for="name" class="uk-vertical-align-middle uk-text-bold">Name:</label>
                        </div>
                        <div class="uk-width-medium-2-3">
                            <label for="name">Name</label>
                            <input class="md-input" type="text" id="name" name="name" value="{{ $season->name }}" required="">
                            @error('name')
                                <span class="uk-margin-top uk-text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-3 uk-vertical-align uk-text-right">
                            <label for="year" class="uk-vertical-align-middle uk-text-bold">Year:</label>
                        </div>
                        <div class="uk-width-medium-2-3">
                            <select id="year" name="year" class="md-input" required>
                                <option value="">Select Year...</option>
                                @for ($year = 2021; $year < 2050; $year++)
                                    <option value="{{ $year }}" {{ $year == $season->year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                            @error('year')
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
        $('.sidebar_seasons').addClass('current_section');
    </script>
@endpush