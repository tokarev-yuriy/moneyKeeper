@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">{{ trans('mkeep.login') }}</h4>
                </div>
                <div class="card-body">
					{!! Form::open(array('url' => 'account/login')) !!}
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
                        <div class="form-check">
                            <label class="form-check-label">
                                {!! Form::checkbox('remember', '1', Input::get('remember')?true:false, array('class'=>'form-check-input')) !!} 
                                {{ trans('mkeep.remember') }}
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                        <div class="form-group">	
                            <button type="submit" class="btn btn-primary">
                                <i class="material-icons">input</i> {{ trans('mkeep.login') }}
                            </button>&nbsp;<a href="<?=URL::to('/account/register')?>" class="btn btn-success">
                                <i class="material-icons">person</i> {{ trans('mkeep.register') }}
                            </a>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
