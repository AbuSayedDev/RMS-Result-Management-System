@extends('layouts.backend')

@push('title', 'Teachers')

@section('content')
        <div class="md-card uk-margin-medium-bottom">
            <div class="user_heading uk-sticky-placeholder" data-uk-sticky="{ top: 48, media: 960 }">
                <div class="user_heading_content">
                    <h2 class="heading_b uk-float-left">
                        <span>List of Teachers</span>
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
                            <th>Email</th>
                            <th>Registered At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($teachers as $teacher)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $teacher->name }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->created_at }}</td>
                            <td>
                                <div class="uk-button-group">
                                    <a data-uk-modal="{target: '#editModal{{ $teacher->id }}'}"><i class="material-icons uk-text-primary md-icon" data-uk-tooltip title="Edit">create</i></a>
                                    <a href="{{ route('admin_teachers_delete', $teacher->id) }}" onclick="deleterow(this); return false"><i class="material-icons uk-text-danger md-icon" data-uk-tooltip title="Delete">delete</i></a>
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
                    <h2 class="heading_b uk-text-center"><span>Add New Teacher</span></h2>
                </div>
            </div>
            <div class="uk-modal-dialog">
                <button type="button" class="uk-modal-close uk-close"></button>
                <form method="post" action="{{ route('admin_teachers_store') }}" enctype="multipart/form-data">
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

         @foreach ($teachers as $teacher)
            <div class="uk-modal" id="editModal{{ $teacher->id }}">
                <div class="user_heading">
                    <div class="user_heading_content">
                        <h2 class="heading_b uk-text-center"><span>{{ $teacher->name }}</span></h2>
                    </div>
                </div>
                <div class="uk-modal-dialog">
                    <button type="button" class="uk-modal-close uk-close"></button>
                    <form method="post" action="{{ route('admin_teachers_update', $teacher->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-5 uk-vertical-align uk-text-right">
                                <label for="name" class="uk-vertical-align-middle uk-text-bold">Name:</label>
                            </div>
                            <div class="uk-width-medium-4-5">
                                <label for="name">Name</label>
                                <input class="md-input" type="text" id="name" name="name" value="{{ $teacher->name }}" required="">
                                @error('name')
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
                                <input class="md-input" type="email" id="email" name="email" value="{{ $teacher->email }}" required="">
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
        $('.sidebar_teachers').addClass('current_section');
    </script>
@endpush