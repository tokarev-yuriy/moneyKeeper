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
                  {!! Form::open(array('url' => '/account/import/tinkoff')) !!}
                      <div class="form-group">
                          <label for="walletId" class="bmd-label-floating">{{ trans('mkeep.wallet') }}</label>
                          @php 
                            $wallets = array(0=>' - ') + \App\MoneyKeeper\Models\Operation::getWallets();
                          @endphp
                          {!! Form::select('walletId', $wallets, Input::get('walletId'), array('class'=>(isset($errors) && $errors->has('walletId') ? 'form-control is-invalid' : 'form-control'))) !!}

                          <span class="invalid-feedback">
                          @if (isset($errors) && $errors->has('walletId'))
                                  <strong>{{ $errors->first('walletId') }}</strong>
                          @endif
                          </span>
                      </div>
                      
                      <div class="form-group">
                          <label for="walletId" class="bmd-label-floating">{{ trans('mkeep.tinkoff.secretkey') }}</label>
                          {!! Form::text('secretKey', Input::get('secretKey'), array('class'=>(isset($errors) && $errors->has('secretKey') ? 'form-control is-invalid' : 'form-control'))) !!}

                          <span class="invalid-feedback">
                          @if (isset($errors) && $errors->has('secretKey'))
                                  <strong>{{ $errors->first('secretKey') }}</strong>
                          @endif
                          </span>
                      </div>

                      <div class="form-group">
                          <label for="round" class="bmd-label-floating">{{ trans('mkeep.round') }}</label>
                          @php
                            $round = Input::get('round', -10);
                            if (!$round) {
                              $round = -10;
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
        @php 
          $date = '';
        @endphp
        @if(empty($arTransactions) || count($arTransactions)==0)
            <div class="card" style="border-radius: 0;">
            <div class="card-header"><h3>{{ trans('mkeep.no_data') }}</h3></div>
            </div>
        @endif
        @foreach($arTransactions as $i=>$arItem)
            @if($arItem['date']!='' && $arItem['date']!=$date)
            <div class="card" style="border-radius: 0; border-bottom: 0px;">            
                <div class="card-header"><h3>{{ date("Y.m.d", strtotime($arItem['date'])) }}</h3></div>
                @php 
                  $date = $arItem['date'];
                @endphp
            </div>
            @endif
            <div class="card" style="border-radius: 0;">            
                <div class="card-body bg-{{ $arItem['type'] }} p-2">
                    <input type="hidden" name="importTransaction[{{ $i }}][value]" value="{{ $arItem['value'] }}" />
                    <input type="hidden" name="importTransaction[{{ $i }}][type]" value="{{ $arItem['type'] }}" />
                    <input type="hidden" name="importTransaction[{{ $i }}][date]" value="{{ $arItem['date'] }}" />
                    <input type="hidden" name="importTransaction[{{ $i }}][comment]" value="{{ $arItem['comment'] }}" />
                    <div class="row">
                        <div class="col-1 text-center align-middle">
                            {!! $arDictionaries['type'][$arItem['type']] !!}
                        </div>
                        <div class="col-1 text-center align-middle">
                            <div class="rounded-circle 
                            @if($arItem['type']=='spend')
                              bg-danger
                            @elseif($arItem['type']=='income')
                              bg-success
                            @elseif($arItem['type']=='transfer')
                              bg-secondary
                            @endif
                            category-icon">
                                <img src="{{ $arDictionaries['category_icon'][$arItem['category_id']] }}" alt="{{ $arDictionaries['category_id'][$arItem['category_id']] }}">
                            </div>
                        </div>
                        <div class="col-3">
                            {!! Form::select('importTransaction['.$i.'][category_id]', \App\MoneyKeeper\Models\Operation::getTypeCategories($arItem['type']), $arItem['category_id'], array('class'=>'form-control')) !!}
                            {{ $arItem['wallet'] }}
                        </div>
                        <div class="col-4">
                            <i>{{ $arItem['comment'] }}</i>
                        </div>
                        <div class="col-3 text-right">
                            <span class="h3 
                              @if($arItem['type']=='spend')
                                text-danger
                              @elseif($arItem['type']=='income')
                                text-success
                              @elseif($arItem['type']=='transfer')
                                text-secondary
                              @endif
                              "
                            >
                                @if($arItem['type']=='spend')
                                  -
                                @elseif($arItem['type']=='income')
                                  +
                                @endif
                                {{ Number::curf($arItem['value']) }}
                            </span>
                        </div>
                        <div class="card-btns pl-2">
                            <a class="btn btn-dark" data-btn-type="delete" href="javascript: void(0);" onclick="$(this).parents('.card').remove();"><i class="fa fa-remove fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
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
