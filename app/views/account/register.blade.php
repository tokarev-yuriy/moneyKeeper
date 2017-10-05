@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card panel-default">
                <h4 class="card-header"><?=trans('mkeep.register')?></h4>
                <div class="card-body">
                   <?=Form::open(array('url' => 'account/register'))?>

                        <div class="row form-group">
                            <label for="name" class="col-md-4 control-label"><?=trans('mkeep.name')?></label>

                            <div class="col-md-6">
                                <?=Form::text('name', Input::get('name'), array('class'=>($errors->has('name') ? 'form-control is-invalid' : 'form-control')))?>

                                <span class="invalid-feedback">
								@if ($errors->has('name'))
                                        <strong>{{ $errors->first('name') }}</strong>
								@endif
                                </span>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="email" class="col-md-4 control-label"><?=trans('mkeep.email')?></label>

                            <div class="col-md-6">
								<?=Form::email('email', Input::get('email'), array('class'=>($errors->has('email') ? 'form-control is-invalid' : 'form-control')))?>

                                <span class="invalid-feedback">
                                @if ($errors->has('email'))
                                        <strong>{{ $errors->first('email') }}</strong>
                                @endif
                                </span>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="password" class="col-md-4 control-label"><?=trans('mkeep.password')?></label>

                            <div class="col-md-6">
								<?=Form::password('password', array('class'=>($errors->has('password') ? 'form-control is-invalid' : 'form-control')))?>

                                <span class="invalid-feedback">
                                @if ($errors->has('password'))
                                        <strong>{{ $errors->first('password') }}</strong>
                                @endif
                                </span>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="password_confirmation" class="col-md-4 control-label"><?=trans('mkeep.confirm_password')?></label>

                            <div class="col-md-6">
                                <?=Form::password('password_confirmation', array('class'=>($errors->has('password_confirmation') ? 'form-control is-invalid' : 'form-control')))?>

                                <span class="invalid-feedback">
                                @if ($errors->has('password_confirmation'))
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                @endif
                                </span>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4"></div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> <?=trans('mkeep.register')?>
                                </button>
                            </div>
                        </div>
                    <?=Form::close();?>
                </div>
            </div>
        </div>
    </div>
@endsection
