@php
    if (isset($obItem) && $obItem->id) {
        if ($obItem->category_rules) {
            $obItem->category_rules = json_decode($obItem->category_rules, true);
        }
        
        if (!$obItem->category_rules) {
            $obItem->category_rules = array();
        }
        
        if ($obItem->params) {
            $obItem->params = json_decode($obItem->params, true);
        }
        
        if (!$obItem->params) {
            $obItem->params = array();
        }
    }
@endphp

    {!! Form::open(array('url' => ((isset($obItem) && $obItem->id)?$paths['update'].'/'.$obItem->id:$paths['add']), 'files' => true)) !!}
        
        {!! Form::hidden('type', Input::get('type', isset($obItem)?$obItem->type:'')) !!}
        
        <div class="col-6 form-group">
             <label for="wallet_id" class="mb-0">{{ trans('mkeep.wallet') }}</label>
              @php
                echo \App\MoneyKeeper\Helpers\Form::dropdownSelect('wallet_id', \App\MoneyKeeper\Models\Operation::getWalletsWithIcons(), Input::get('wallet_id', isset($obItem)?$obItem->wallet_id:Session::get('wallet_id')), (isset($errors) && $errors->has('wallet_id') ? 'is-invalid' : ''));
              @endphp
               <span class="invalid-feedback">
               @if (isset($errors) && $errors->has('wallet_id'))
                       <strong>{{ $errors->first('wallet_id') }}</strong>
               @endif
               </span>
         </div>
        
        <div class="row">
            <label for="clientId" class="col-md-4 control-label">{{ trans('mkeep.clientId') }}</label>
            <div class="col-md-8">
                 {!! Form::text('params[clientId]', Input::get('params[clientId]', isset($obItem)?$obItem->params['clientId']:''), array('class'=>(isset($errors) && $errors->has('params') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('params'))
                        <strong>{{ $errors->first('params') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
        <div class="row">
            <label for="clientSecret" class="col-md-4 control-label">{{ trans('mkeep.clientSecret') }}</label>
            <div class="col-md-8">
                 {!! Form::text('params[clientSecret]', Input::get('params[clientSecret]', isset($obItem)?$obItem->params['clientSecret']:''), array('class'=>(isset($errors) && $errors->has('params') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('params'))
                        <strong>{{ $errors->first('params') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
        <div class="row">
            <label for="refreshToken" class="col-md-4 control-label">{{ trans('mkeep.refreshToken') }}</label>
            <div class="col-md-8">
                 {!! Form::text('params[refreshToken]', Input::get('params[refreshToken]', isset($obItem)?$obItem->params['refreshToken']:''), array('class'=>(isset($errors) && $errors->has('params') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('params'))
                        <strong>{{ $errors->first('params') }}</strong>
                @endif
                </span>
            </div>
        </div>

        <h4>{{ trans('mkeep.import_profile_category_rules') }}</h4>
        <p class="text-secondary">{{ trans('mkeep.import_profile_category_rules_help') }}</p>
        @php 
          $arCategories = \App\MoneyKeeper\Models\Category::user()->select('id', 'name')->orderBy('sort')->get();
        @endphp
        @foreach($arCategories as $obCategory)
        <div class="row">
            <label for="desc_col" class="col-md-4 control-label">{{ $obCategory->name }}</label>
            <div class="col-md-8">
                 {!! Form::textarea('category_rules['.$obCategory->id.']', Input::get('category_rules['.$obCategory->id.']', (isset($obItem)&&isset($obItem->category_rules[$obCategory->id]))?$obItem->category_rules[$obCategory->id]:''), array('class'=>'form-control', 'rows'=>2, 'placeholder'=>trans('mkeep.import_profile_category_rules_help'))) !!}
            </div>
        </div>
        @endforeach

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-btn fa-save"></i> {{ trans('mkeep.save') }}
                </button>
            </div>
        </div>
     {!! Form::close() !!}
