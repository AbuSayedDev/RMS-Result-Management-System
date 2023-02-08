@extends('layouts/backend')

@push('title', 'RMS')

@section('content')
	<h3>Welcome {{ auth()->user()->name }}</h3>
@stop

@push('scripts')
	<script type="text/javascript">
        $('.sidebar_dashboard').addClass('current_section');
    </script>
@endpush