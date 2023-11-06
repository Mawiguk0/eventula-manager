@extends ('layouts.admin-default')

@section ('page_title', 'Participants - ' . $event->display_name . ' | ' . Settings::getOrgName() . ' Admin')

@section ('content')

<div class="row">
	<div class="col-lg-12">
		<h3 class="pb-2 mt-4 mb-4 border-bottom">Participants</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="/admin/events/">Events</a>
			</li>
			<li class="breadcrumb-item">
				<a href="/admin/events/{{ $event->slug }}">{{ $event->display_name }}</a>
			</li>
			<li class="breadcrumb-item active">
				Participants
			</li>
		</ol>
	</div>
</div>

@include ('layouts._partials._admin._event.dashMini')

<div class="row">
	<div class="col-lg-12">

		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-users fa-fw"></i> All Participants
				{{ Form::open(array('url'=>'/admin/events/' . $event->slug . '/participants/signoutall' , 'onsubmit' => 'return ConfirmSignOutAll()')) }}
				{{ Form::hidden('_method', 'GET') }}
				<button type="submit" class="btn btn-danger btn-sm float-end me-3 ms-3">Sign Out all Participants</button>
				{{ Form::close() }}
				<a href="/admin/events/{{ $event->slug }}/tickets#freebies" class="btn btn-info btn-sm float-right">Freebies</a>
			</div>
			<div class="card-body">
				<div class="dataTable_wrapper">
					<table width="100%" class="table table-striped table-hover" id="seating_table">
						<thead>
							<tr>
								<th>User</th>
								<th>Name</th>
								<th>Contact</th>
								<th>Seat</th>
								<th>Ticket</th>
								<th>Paypal Email</th>
								<th>Free/Staff/Gift</th>
								<th>Signed in</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($participants as $participant)
							<tr class="odd gradeX">
								<td>
									{{ $participant->user->username }}
									@if ($participant->user->steamid)
									<br><span class="text-muted"><small>Steam: {{ $participant->user->steamname }}</small></span>
									@endif
								</td>
								<td>{{ $participant->user->firstname }} {{ $participant->user->surname }}</td>
								<td>{{ $participant->user->email }} @if (isset($participant->user->phonenumber) && !empty($participant->user->phonenumber)) <br /><a href="tel:{{ $participant->user->phonenumber }}">{{ $participant->user->phonenumber }}</a>@endif</td>
								<td>
									@if (isset($participant->seat)) {{ $participant->seat->seat }} @endif
								</td>
								<td>
									@if ($participant->free) Free @endif
									@if ($participant->staff) Staff @endif
									@if ($participant->ticket) {{ $participant->ticket->name }} @endif
								</td>
								<td>
									@if ($participant->purchase) {{ $participant->purchase->paypal_email }} @endif
								</td>
								<td>
									@if ($participant->free)
									<strong>Free</strong>
									<small>Assigned by: {{ $participant->getAssignedByUser()->username }}</small>
									@elseif ($participant->staff)
									<strong>Staff</strong>
									<small>Assigned by: {{ $participant->getAssignedByUser()->username }}</small>
									@elseif ($participant->gift)
									<strong>Gift</strong>
									<small>Assigned by: {{ $participant->getGiftedByUser()->username }}</small>
									@endif
								</td>
								<td>
									@if ($participant->signed_in)
									Yes
									@else
									No
									@endif
								</td>
								<td width="10%">
									<a href="/admin/events/{{ $event->slug }}/participants/{{ $participant->id }}">
										<button type="button" class="btn btn-primary btn-sm btn-block">Edit</button>
									</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					{{ $participants->links() }}
				</div>
			</div>
		</div>

	</div>
</div>

<script>
	function ConfirmSignOutAll() {
		var x = confirm("do you really want to sign out all participants? This cannot be undone!");
		if (x)
			return true;
		else
			return false;
	}
</script>

@endsection