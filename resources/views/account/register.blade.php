@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card panel-default">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">{{ trans('mkeep.register') }}</h4>
                </div>
                <div class="card-body">
                   {!! Form::open(array('url' => 'account/register')) !!}

                        <div class="form-group">
                            <label for="name">{{ trans('mkeep.name') }}</label>

                            {!! Form::text('name', Input::get('name'), array('class'=>($errors->has('name') ? 'form-control is-invalid' : 'form-control'))) !!}

                                <span class="invalid-feedback">
								@if ($errors->has('name'))
                                        <strong>{{ $errors->first('name') }}</strong>
								@endif
                                </span>
                        </div>

                        <div class="form-group">
                            <label for="email">{{ trans('mkeep.email') }}</label>

								{!! Form::email('email', Input::get('email'), array('class'=>($errors->has('email') ? 'form-control is-invalid' : 'form-control'))) !!}

                                <span class="invalid-feedback">
                                @if ($errors->has('email'))
                                        <strong>{{ $errors->first('email') }}</strong>
                                @endif
                                </span>
                        </div>

                        <div class="form-group">
                            <label for="password">{{ trans('mkeep.password') }}</label>

								{!! Form::password('password', array('class'=>($errors->has('password') ? 'form-control is-invalid' : 'form-control'))) !!}

                                <span class="invalid-feedback">
                                @if ($errors->has('password'))
                                        <strong>{{ $errors->first('password') }}</strong>
                                @endif
                                </span>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">{{ trans('mkeep.confirm_password') }}</label>

                                {!! Form::password('password_confirmation', array('class'=>($errors->has('password_confirmation') ? 'form-control is-invalid' : 'form-control'))) !!}

                                <span class="invalid-feedback">
                                @if ($errors->has('password_confirmation'))
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                @endif
                                </span>
                        </div>

                          <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="material-icons">person</i> {{ trans('mkeep.register') }}
                            </button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
