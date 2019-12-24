@extends('layouts.app')

@section('content')
   <h1>{{ trans('mkeep.import') }}</h1>
   <br/>
   <div class="container">
    
    @if (!isset($arTransactions) || (isset($errors) && !$errors->isEmpty()))
    
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">{{ trans('mkeep.import') }}</h4>
                </div>
                <div class="card-body">
                  {!! Form::open(array('url' => '/account/import', 'files' => true)) !!}
                  
                     <div class="form-group">
                         <label for="walletId" class="mb-0">{{ trans('mkeep.wallet') }}</label>
                          @php
                            echo \App\MoneyKeeper\Helpers\Form::dropdownSelect('walletId', \App\MoneyKeeper\Models\Operation::getWalletsWithIcons(), Input::get('walletId'), (isset($errors) && $errors->has('walletId') ? 'is-invalid' : ''));
                          @endphp
                           <span class="invalid-feedback">
                           @if (isset($errors) && $errors->has('walletId'))
                                   <strong>{{ $errors->first('walletId') }}</strong>
                           @endif
                           </span>
                      </div>
                      
                      <div class="form-group">
                        <label class="btn">
                          {!! Form::file('importFile', array('class'=>(isset($errors) && $errors->has('importFile') ? 'form-control-file is-invalid' : 'form-control-file'))) !!}
                          {{ trans('mkeep.import_file') }}
                        </label>

                        <span class="invalid-feedback">
                        @if (isset($errors) && $errors->has('importFile'))
                                <strong>{{ $errors->first('importFile') }}</strong>
                        @endif
                        </span>
                      </div>

                      <div class="form-group">
                          <label for="round" class="bmd-label-floating">{{ trans('mkeep.round') }}</label>
                          @php
                            $round = Input::get('round', -50);
                            if (!$round) {
                              $round = -50;
                            }
                          @endphp
                          {!! Form::select('round', array(2=>'0,00',1=>'0,10',0=>'1',-10=>'10',-50=>'50',-100=>'100'), $round, array('class'=>(isset($errors) && $errors->has('round') ? 'form-control is-invalid' : 'form-control'))) !!}

                          <span class="invalid-feedback">
                          @if (isset($errors) && $errors->has('round'))
                                  <strong>{{ $errors->first('round') }}</strong>
                          @endif
                          </span>
                      </div>
                      
                      <div class="form-group">
                          <button type="submit" class="btn btn-success">
                              <i class="fa fa-btn fa-upload"></i> {{ trans('mkeep.import') }}
                          </button>
                      </div>
                  {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    
    @else
    <h4>{{ trans('mkeep.import_check_items') }}</h4>
    {!! Form::open(array('url' => '/account/import', 'files' => true)) !!}
        <input type="hidden" name="mode" value="save" />
        <input type="hidden" name="walletId" value="{{ Input::get('walletId') }}" />
        @include('widgets.tableedit')
        <br/>
        <br/>
        <div class="row form-group">
            <div class="col-md-4"></div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-btn fa-save"></i> {{ trans('mkeep.save') }}
                </button>
            </div>
        </div>
        
    {!! Form::close() !!}
    
    @endif
    
    </div>
@endsection
