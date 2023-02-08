@extends('layouts.backend')

@push('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h3 class="card-header">Welcome Admin</h3>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $('.sidebar_dashboard').addClass('current_section');
    </script>
@endpush