@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card panel-default">
                <h4 class="card-header"><?=trans('mkeep.login')?></h4>
                <div class="card-body">
					<?=Form::open(array('url' => 'account/login'))?>
                        <div class="row justify-content-center form-group">
                            <label for="email" class="col-md-3 control-label"><?=trans('mkeep.email')?></label>

                            <div class="col-md-5">
                                <?=Form::email('email', Input::get('email'), array('class'=>($errors->has('email') ? 'form-control is-invalid' : 'form-control')))?>

                                <span class="invalid-feedback">
                                @if ($errors->has('email'))
                                        <strong>{{ $errors->first('email') }}</strong>
                                @endif
                                </span>
                            </div>
                        </div>

                        <div class="row justify-content-center form-group">
                            <label for="password" class="col-md-3 control-label"><?=trans('mkeep.password')?></label>

                            <div class="col-md-5">
                                <?=Form::password('password', array('class'=>($errors->has('password') ? 'form-control is-invalid' : 'form-control')))?>

                                <span class="invalid-feedback">
                                @if ($errors->has('password'))
                                        <strong>{{ $errors->first('password') }}</strong>
                                @endif
                                </span>
                            </div>
                        </div>
                        <div class="row justify-content-center form-group">
                            <div class="col-md-3">&nbsp;</div>
                            <div class="col-md-5">
                                <div class="checkbox">
                                    <label>
										<?=Form::checkbox('remember', '1', Input::get('remember')?true:false);?> <?=trans('mkeep.remember')?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">	
                            <div class="col-md-3">&nbsp;</div>
                            <div class="col-md-5">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> <?=trans('mkeep.login')?>
                                </button>&nbsp;<a href="<?=URL::to('/account/register')?>" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> <?=trans('mkeep.register')?>
                                </a>
                            </div>
                        </div>
                    <?=Form::close();?>
                </div>
            </div>
        </div>
    </div>
@endsection
