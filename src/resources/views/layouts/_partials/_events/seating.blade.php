<!-- SEATING -->
@if (!$event->online_event &&
!$event->seatingPlans->isEmpty() &&
(
in_array('PUBLISHED', $event->seatingPlans->pluck('status')->toArray()) ||
in_array('PREVIEW', $event->seatingPlans->pluck('status')->toArray())
)
)
<div class="pb-2 mt-4 mb-4 border-bottom">
    <a name="seating"></a>
    <h3><i class="fas fa-chair me-3"></i>@lang('events.seatingplans') <small>- {{ $event->getSeatingCapacity() - $event->getSeatedCount() }} / {{ $event->getSeatingCapacity() }} @lang('events.seatsremaining')</small></h3>
</div>
<div class="card-group" id="accordion" role="tablist" aria-multiselectable="true">
    @foreach ($event->seatingPlans as $seatingPlan)
    @if ($seatingPlan->status != 'DRAFT')
    <div class="card mb-3">
        <a class="collapsed" role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $seatingPlan->slug }}" aria-expanded="true" aria-controls="collapse_{{ $seatingPlan->slug }}">
            <div class="card-header  bg-success-light" role="tab" id="headingOne">
                <h4 class="card-title m-0">
                    {{ $seatingPlan->name }} <small>- {{ $seatingPlan->getSeatingCapacity() - $seatingPlan->getSeatedCount() }} / {{ $seatingPlan->getSeatingCapacity() }} @lang('events.available')</small>
                    @if ($seatingPlan->status != 'PUBLISHED')
                    <small> - {{ $seatingPlan->status }}</small>
                    @endif
                </h4>
            </div>
        </a>
        <div id="collapse_{{ $seatingPlan->slug }}" class="collapse @if ($loop->first) in @endif" role="tabpanel" aria-labelledby="collaspe_{{ $seatingPlan->slug }}">
            <div class="card-body">
                <div class="table-responsive text-center">
                    <table class="table">

                        <tbody>
                            @for ($row = 1; $row <= $seatingPlan->rows; $row++)
                                <tr>
                                    <td>
                                        <h4><strong>{{ Helpers::getLatinAlphabetUpperLetterByIndex($row) }}</strong></h4>
                                    </td>
                                    @for ($column = 1; $column <= $seatingPlan->columns; $column++)

                                        <td style="padding-top:14px;">
                                            @if ($event->getSeat($seatingPlan->id, $column, $row))
                                            @if($event->getSeat($seatingPlan->id, $column, $row)->status == 'ACTIVE')
                                            @if ($seatingPlan->locked)
                                            <button class="btn btn-success btn-sm" disabled>
                                                {{ Helpers::getLatinAlphabetUpperLetterByIndex($row) . $column }} - {{ $event->getSeat($seatingPlan->id, $column, $row)->eventParticipant->user->username }}
                                            </button>
                                            @else
                                            <button class="btn btn-success btn-sm" disabled>
                                                {{ Helpers::getLatinAlphabetUpperLetterByIndex($row) . $column }} - {{ $event->getSeat($seatingPlan->id, $column, $row)->eventParticipant->user->username }}
                                            </button>
                                            @endif
                                            @endif
                                            @else
                                            @if ($seatingPlan->locked)
                                            <button class="btn btn-primary btn-sm" disabled>
                                                {{ Helpers::getLatinAlphabetUpperLetterByIndex($row) . $column }} - @lang('events.empty')
                                            </button>
                                            @else
                                            @if (Auth::user() 
                                                    && $event->getEventParticipant() 
                                                    && ($event->getEventParticipant()->staff 
                                                        || $event->getEventParticipant()->free 
                                                        || $event->getEventParticipant()->ticket->seatable
                                                    )
                                                )
                                            <button class="btn btn-primary btn-sm" onclick="pickSeat(
                                                                            '{{ $seatingPlan->slug }}',
                                                                            '{{ $column }}',
                                                                            '{{ $row }}',
                                                                            '{{ Helpers::getLatinAlphabetUpperLetterByIndex($row) . $column }}'
                                                                        )" data-bs-toggle="modal" data-bs-target="#pickSeatModal">
                                                {{ Helpers::getLatinAlphabetUpperLetterByIndex($row) . $column }} - @lang('events.empty')
                                            </button>
                                            @else
                                            <button class="btn btn-primary btn-sm" disabled>
                                                {{ Helpers::getLatinAlphabetUpperLetterByIndex($row) . $column }} - @lang('events.empty')
                                            </button>
                                            @endif
                                            @endif
                                            @endif
                                        </td>
                                        @endfor
                                </tr>
                                @endfor
                        </tbody>
                    </table>
                    @if ($seatingPlan->locked)
                    <p class="text-center"><strong> @lang('events.seatingplanlocked')</strong></p>
                    @endif
                </div>
            </div>
            <div class="card-footer">
                <div class="row" style="display: flex; align-items: center;">
                    <div class="col-12 col-md-8">
                        <img class="img-fluid" alt="{{ $seatingPlan->name }}" src="{{$seatingPlan->image_path}}" />
                    </div>
                    <div class="col-12 col-md-4">
                        @if ($user && !$user->getAllTickets($event->id)->isEmpty() && $user->hasSeatableTicket($event->id))
                        <h5>@lang('events.yourseats')</h5>
                        @foreach ($user->getAllTickets($event->id) as $participant)
                        @if ($participant->seat && $participant->seat->event_seating_plan_id == $seatingPlan->id)
                        {{ Form::open(array('url'=>'/events/' . $event->slug . '/seating/' . $seatingPlan->slug)) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::hidden('user_id', $user->id, array('id'=>'user_id','class'=>'form-control')) }}
                        {{ Form::hidden('participant_id', $participant->id, array('id'=>'participant_id','class'=>'form-control')) }}
                        {{ Form::hidden('seat_column_delete', $participant->seat->column, array('id'=>'seat_column_delete','class'=>'form-control')) }}
                        {{ Form::hidden('seat_row_delete', $participant->seat->row, array('id'=>'seat_row_delete','class'=>'form-control')) }}

                        <h5>
                            <button class="btn btn-success btn-block">
                                @lang('events.remove') - {{ $participant->seat->getName() }}
                            </button>
                        </h5>
                        {{ Form::close() }}
                        @endif
                        @endforeach
                        @elseif($user && !$user->hasSeatableTicket($event->id))
                        <div class="alert alert-info">
                            <h5>@lang('events.noseatableticket')</h5>
                        </div>
                        @elseif(Auth::user())
                        <div class="alert alert-info">
                            <h5>@lang('events.plspurchaseticket')</h5>
                        </div>
                        @else
                        <div class="alert alert-info">
                            <h5>@lang('events.plslogintopurchaseticket')</h5>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>
@endif

<!-- Seat Modal -->
<div class="modal fade" id="pickSeatModal" tabindex="-1" role="dialog" aria-labelledby="editSeatingModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="pickSeatModalLabel"></h4>
				<button type="button" class="btn-close text-decoration-none" data-bs-dismiss="modal" aria-hidden="true"></button>
			</div>
			@if (Auth::user())
			{{ Form::open(array('url'=>'/events/' . $event->slug . '/seating/', 'id'=>'pickSeatFormModal')) }}
			<div class="modal-body">
				<div class="mb-3">
					<h4>@lang('events.wichtickettoseat')</h4>
					{{
								Form::select(
									'participant_id',
									$user->getTickets($event->id),
									null,
									array(
										'id'    => 'format',
										'class' => 'form-control'
									)
								)
							}}
					<p class="pt-2">@lang('events.wantthisseat')</p>
					<p>@lang('events.removeitanytime')</p>
				</div>
			</div>
			{{ Form::hidden('user_id', $user->id, array('id'=>'user_id','class'=>'form-control')) }}
			{{ Form::hidden('seat_column', null, array('id'=>'seat_column','class'=>'form-control')) }}
			{{ Form::hidden('seat_row', null, array('id'=>'seat_row','class'=>'form-control')) }}
			<div class="modal-footer">
				<button type="submit" class="btn btn-success">@lang('events.yes')</button>
				<button type="button" class="btn btn-danger" data-bs-dismiss="modal">@lang('events.no')</button>
			</div>
			{{ Form::close() }}
			@endif
		</div>
	</div>
</div>

<script>
    function pickSeat(seating_plan_slug, seatColumn, seatRow, seatDisplay) {
        jQuery("#seat_column").val(seatColumn);
        jQuery("#seat_row").val(seatRow);
        jQuery("#seat_column_delete").val(seatColumn);
        jQuery("#seat_row_delete").val(seatRow);
        jQuery("#seat_number_modal").val(seatDisplay);
        jQuery("#pickSeatModalLabel").html('Do you what to choose seat ' + seatDisplay);
        jQuery("#pickSeatFormModal").prop('action', '/events/{{ $event->slug }}/seating/' + seating_plan_slug);
    }
</script>