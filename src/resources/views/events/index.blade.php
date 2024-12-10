@extends ('layouts.default')

@section('page_title', Settings::getOrgName() . ' - Events')

@section('content')
    <div class="container pt-1">
        <div class="pb-2 mt-4 mb-4 border-bottom">
            <h1>
                Events
            </h1>
        </div>
        @foreach ($events as $event)
		<div class="mb-3">
            @include ('layouts._partials._events.information-card', ['enableCardTitle' => true])
		</div>
        @endforeach
    </div>

@endsection
