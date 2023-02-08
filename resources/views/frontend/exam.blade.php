@extends('layouts/backend')

@push('title', 'Exams')

@section('content')
	<h3>Exam wise Results</h3>

	<div class="uk-grid">
		@foreach ($exams as $exam)
			<div class="uk-width-1-2">
				<div class="md-card uk-margin-large-bottom">
					<div class="md-card-content">
						<h4 class="uk-text-center">{{ $exam->name }}</h4>
						<table class="uk-table">
							<thead>
								<tr>
									<th>#</th>
									<th>Subject</th>
									<th>Your Mark</th>
									<th>Subject Full Mark</th>
									<th>Grade</th>
								</tr>
							</thead>
							<tbody>
								@forelse ($exam->results as $result)
									<tr>
										<td>{{ $loop->index+1 }}</td>
										<td>{{ $result->subject_name }}</td>
										<td>{{ number_format($result->mark, 2) }}</td>
										<td>{{ number_format($result->full_mark, 2) }}</td>
										<td>{{ $result->grade }}</td>
									</tr>
								@empty
									<tr>
										<td colspan="10" class="uk-text-danger uk-text-center">Nothing found</td>
									</tr>
								@endforelse
							</tbody>
							<tfoot>
								<tr>
									<th colspan="4"><strong class="uk-float-right">GPA</strong></th>
									<th><strong>{{ $exam->gpa }}</strong></th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		@endforeach
	</div>

@stop

@push('scripts')
	<script type="text/javascript">
		@if (auth()->user()->role_id == 1)
			$('.sidebar_students').addClass('current_section');
		@else
        	$('.sidebar_exams').addClass('current_section');
        @endif
    </script>
@endpush