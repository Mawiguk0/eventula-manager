<!-- All Participants -->
@if (@$all)
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>
						Name
					</th>
					<th>
						Seat
					</th>
					@if($tournament->team_size != '1v1' && (@$admin && $user->admin))
						<th>
							PUG
						</th>
						<th>
							Team
						</th>
					@endif
					@if (@$admin && $user->admin)
						<th>
						</th>
					@endif

				</tr>
			</thead>
			<tbody>
				@foreach ($tournament->tournamentParticipants as $tournamentParticipant)
					@php
						$context = 'default';
					@endphp
					@if (($tournamentParticipant->pug && !$tournamentParticipant->tournamentTeam) && (@$admin && $user->admin))
						@php
							$context = 'warning';
						@endphp
					@endif
					<tr class='{{ $context }}'>
						<td class="align-middle">
								<img alt="{{ $tournamentParticipant->eventParticipant->user->username }}'s Avatar" class="rounded" style="max-width: 4%;" src="{{ $tournamentParticipant->eventParticipant->user->avatar }}">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $tournamentParticipant->eventParticipant->user->username }}
								<small> - {{ $tournamentParticipant->eventParticipant->user->username }}</small>
						</td>
						<td class="align-middle">
							@if ($tournamentParticipant->eventParticipant->seat)
								{{ $tournamentParticipant->eventParticipant->seat->seat }}
							@else
								Not Seated
							@endif
						</td>
						@if ($tournament->team_size != '1v1' && (@$admin && $user->admin))
							<td  class="align-middle">
								@if($tournamentParticipant->pug)
									Yes
								@else
									No
								@endif
							</td>
							<td  class="align-middle">
								{{ Form::open(array('url'=>'/admin/events/' . $event->slug . '/tournaments/' . $tournament->slug . '/participants/' . $tournamentParticipant->id  . '/team')) }}
									<div class="row">
										<div class="col">
											@if ($tournament->status != 'LIVE' || $tournament->status != 'COMPLETE' && (@$admin && $user->admin))
												@if ($tournamentParticipant->event_tournament_team_id == 0)
													{{ Form::select('event_tournament_team_id', [0 => 'None'] + $tournament->getTeams(), $tournamentParticipant->event_tournament_team_id, array('id'=>'name','class'=>'form-control')) }}
												@else
														{{ Form::select('event_tournament_team_id', $tournament->getTeams(), $tournamentParticipant->event_tournament_team_id, array('id'=>'name','class'=>'form-control')) }}
												@endif
											@else
												{{ $tournamentParticipant->tournamentTeam->name }}
											@endif
										</div>
										<div class="col">
											@if (($tournament->status == 'LIVE' && !$tournament->enable_live_editing)|| $tournament->status == 'COMPLETE')
												<button type="submit" class="btn btn-secondary btn-block" disabled>Update</button>
											@else
												<button type="submit" class="btn btn-secondary btn-block">Update</button>
											@endif
										</div>
									</div>
								{{ Form::close() }}
							</td>
						@endif
						@if (@$admin && $user->admin)
							<td  class="align-middle">
								{{ Form::open(array('url'=>'/admin/events/' . $event->slug . '/tournaments/' . $tournament->slug . '/participants/' . $tournamentParticipant->event_participant_id  . '/remove')) }}
										<button type="submit" class="btn btn-danger btn-block">Remove</button>
								{{ Form::close() }}
							</td>
						@endif
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endif
<!-- Teams -->
@if ($tournament->team_size != '1v1')
	@if (!$tournament->random_teams || $tournament->status == 'LIVE' || $tournament->status == 'COMPLETE' )
		<h3>Teams</h3>
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>
							Name
						</th>
						<th>
							Roster
						</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($tournament->tournamentTeams as $tournamentTeam)
						<tr>
							<td width="50%">
								<h4>{{ $tournamentTeam->name }}</h4>
							</td>
							<td>
								@if ($tournamentTeam->tournamentParticipants)
									@foreach ($tournamentTeam->tournamentParticipants as $participant)
										<img alt="{{ $participant->eventParticipant->user->username }}'s Avatar" class="rounded" style="max-width: 8%;" src="{{ $participant->eventParticipant->user->avatar }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $participant->eventParticipant->user->username }}
										<span class="float-end">
											@if ($participant->eventParticipant->seat)
												{{ $participant->eventParticipant->seat->seat }}
											@else
												Not Seated
											@endif
										</span>
										<br><br>
									@endforeach
								@else
									No one yet
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	@endif
	<h3>PUGs</h3>
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>
						Name
					</th>
					<th>
						Seat
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($tournament->tournamentParticipants as $tournamentParticipant)
					@if ($tournamentParticipant->pug)
						<tr>
							<td>
								<p>
									<img alt="{{ $tournamentParticipant->eventParticipant->user->username }}'s Avatar" class="rounded" style="max-width: 6%;" src="{{ $tournamentParticipant->eventParticipant->user->avatar }}">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $tournamentParticipant->eventParticipant->user->username }}
								</p>
							</td>
							<td>
								<p>
									@if ($tournamentParticipant->eventParticipant->seat)
										{{ $tournamentParticipant->eventParticipant->seat->seat }}
									@else
										Not Seated
									@endif
								</p>
							</td>
						</tr>
					@endif
				@endforeach
			</tbody>
		</table>
	</div>

@endif
@if (Request::is('admin/*'))
<h3>Add Event participants</h3>
<div class="table-responsive">
	<table class="table">
		 <thead>
			<tr>
				<th>
					Name
				</th>
				<th>
					Add
				</th>
			</tr>
		</thead>
		<tbody>

			@foreach ($event->eventParticipants as $participant)
				@php
					$istournamentpartitipant = false;
				@endphp
					@foreach ($tournament->tournamentParticipants as $tournamentParticipant)
						@if ($tournamentParticipant->eventParticipant->user->username == $participant->user->username)
							@php
								$istournamentpartitipant = true;
							@endphp
						@endif
					@endforeach
					@if (!$istournamentpartitipant)
						<tr>
							<td>
								<p>
									<img alt="{{ $participant->user->username }}'s Avatar" class="img-rounded" style="max-width: 6%;" src="{{ $participant->user->avatar }}">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $participant->user->username }}
								</p>
							</td>
							<td>
								<p>
									@if ($tournament->team_size != '1v1')
										{{ Form::open(array('url'=>'/admin/events/' . $event->slug . '/tournaments/' . $tournament->slug . '/participants/' . $participant->id . '/addpug')) }}
										<button type="submit" class="btn btn-primary btn-block">Add as PUG</button>
										{{ Form::close() }}

										@if (count($tournament->getTeams()) != 0)
										{{ Form::open(array('url'=>'/admin/events/' . $event->slug . '/tournaments/' . $tournament->slug . '/participants/' . $participant->id . '/addsingle')) }}
										<div class="mb-3 col-12 col-sm-8">
												{{ Form::select('event_tournament_team_id', $tournament->getTeams(), NULL, array('id'=>'name','class'=>'form-control')) }}
										</div>
										<div class="mb-3 col-12 col-sm-4">
												<button type="submit" class="btn btn-default btn-sm btn-block">Add to Team</button>
										</div>
										{{ Form::close() }}
									@endif

									@else
										{{ Form::open(array('url'=>'/admin/events/' . $event->slug . '/tournaments/' . $tournament->slug . '/participants/' . $participant->id . '/addsingle')) }}
												<button type="submit" class="btn btn-default btn-sm btn-block">Add to 1vs1</button>
										{{ Form::close() }}
									@endif
								</p>
							</td>
						</tr>
					@endif
			@endforeach


		</tbody>
	</table>
</div>
@endif
