@extends ('layouts.default')

@section ('page_title', Settings::getOrgName() . ' - ' . __('auth.register'))

@section ('content')

<div class="container pt-1">
    <div class="pb-2 mt-4 mb-4 border-bottom">
        <h1>@lang('auth.register_details')</h1>
    </div>
    <div class="row">
        {{ Form::open(array('url'=>'/register/' . $loginMethod )) }}
        {{ Form::hidden('method', $loginMethod, array('id'=>'method','class'=>'form-control')) }}
        @if ($loginMethod == "steam")
        {{ Form::hidden('avatar', $avatar, array('id'=>'avatar','class'=>'form-control')) }}
        {{ Form::hidden('steamid', $steamid, array('id'=>'steamid','class'=>'form-control')) }}
        {{ Form::hidden('steamname', $steamname, array('id'=>'steamname','class'=>'form-control')) }}
        @endif
        <div class="col-12 col-md-6">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="mb-3 @error('firstname') is-invalid @enderror">
                        {{ Form::label('firstname',__('auth.firstname'),array('id'=>'','class'=>'')) }}
                        <input id="firstname" type="firstname" class="form-control" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="mb-3  @error('surname') is-invalid @enderror">
                        {{ Form::label('surname',__('auth.surname'),array('id'=>'','class'=>'')) }}
                        <input id="surname" type="surname" class="form-control" name="surname" value="{{ old('surname') }}" required autocomplete="surname">
                    </div>
                </div>
            </div>
            <div class="mb-3 @error('username') is-invalid @enderror">
                {{ Form::label('username',__('auth.username'),array('id'=>'','class'=>'')) }}
                <input id="username" type="username" class="form-control" name="username" value="{{ old('username') }}" required autocomplete="username">
            </div>


            @if($loginMethod == "standard" || ($loginMethod == "steam" && Settings::isAuthSteamRequireEmailEnabled()))

            <div class="mb-3 @error('email') is-invalid @enderror">
                {{ Form::label('email',__('auth.email'),array('id'=>'','class'=>'')) }}
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email">
            </div>

            @endif

            @if(Settings::isAuthRequirePhonenumberEnabled())

            <div class="mb-3 @error('phonenumber') is-invalid @enderror">
                {{ Form::label('phonenumber',__('auth.phonenumber'),array('id'=>'','class'=>'')) }}
                <input id="phonenumber" type="phonenumber" class="form-control" name="phonenumber" value="{{ old('phonenumber') }}" required autocomplete="phonenumber">
            </div>

            @endif

            @if ($loginMethod == "standard")

            <div class="mb-3 @error('password1') is-invalid @enderror">
                {{ Form::label('password1',__('auth.password'),array('id'=>'','class'=>'')) }}
                <input id="password1" type="password" class="form-control" name="password1" required autocomplete="new-password">
            </div>
            <div class="mb-3 @error('password2') is-invalid @enderror">
                {{ Form::label('password2',__('auth.confirm_password'),array('id'=>'','class'=>'')) }}
                <input id="password2" type="password" class="form-control" name="password2" required autocomplete="new-password">
            </div>
            <input id="url" type="hidden" class="form-control" name="url">

            @endif
            @if ($loginMethod == "steam")
            <div class="mb-3">
                {{ Form::label('steamname',__('auth.steamname'),array('id'=>'','class'=>'')) }}
                {{ Form::text('steamname', $steamname, array('id'=>'steamname','class'=>'form-control', 'disabled'=>'true')) }}
            </div>
            @endif
        </div>
        <div class="col-12 col-md-6">
            {!! Settings::getRegistrationTermsAndConditions() !!}
            <h5>@lang('auth.register_confirmtext') {!! Settings::getOrgName() !!}</h5>
            <button type="submit" class="btn btn-block btn-primary">@lang('auth.register')</button>
        </div>
        {{ Form::close() }}
    </div>
</div>

@endsection