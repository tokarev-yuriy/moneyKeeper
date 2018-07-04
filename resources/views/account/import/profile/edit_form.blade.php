@php
    if (isset($obItem) && $obItem->id) {
        if ($obItem->category_rules) {
            $obItem->category_rules = unserialize($obItem->category_rules);
        }
        
        if (!$obItem->category_rules) {
            $obItem->category_rules = array();
        }
    }
@endphp

    {!! Form::open(array('url' => ((isset($obItem) && $obItem->id)?$paths['update'].'/'.$obItem->id:$paths['add']), 'files' => true)) !!}

        <div class="row form-group">
            <label for="name" class="col-md-4 control-label">{{ trans('mkeep.name') }}</label>
            <div class="col-md-8">
                 {!! Form::text('name', Input::get('name', isset($obItem)?$obItem->name:''), array('class'=>(isset($errors) && $errors->has('name') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('name'))
                        <strong>{{ $errors->first('name') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
        <div class="row form-group">
            <label for="encoding" class="col-md-4 control-label">{{ trans('mkeep.encoding') }}</label>
            <div class="col-md-8">
                 {!! Form::select('encoding', \App\MoneyKeeper\Models\ImportProfile::getEncodings(), Input::get('encoding', isset($obItem)?$obItem->encoding:''), array('class'=>(isset($errors) && $errors->has('encoding') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('encoding'))
                        <strong>{{ $errors->first('encoding') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
        <div class="row form-group">
            <label for="start_row" class="col-md-4 control-label">{{ trans('mkeep.start_row') }}</label>
            <div class="col-md-8">
                 {!! Form::select('start_row', \App\MoneyKeeper\Models\ImportProfile::getRowNums(30), Input::get('start_row', isset($obItem)?$obItem->start_row:''), array('class'=>(isset($errors) && $errors->has('start_row') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('start_row'))
                        <strong>{{ $errors->first('start_row') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
        <div class="row form-group">
            <label for="control_row" class="col-md-4 control-label">{{ trans('mkeep.control_row') }}</label>
            <div class="col-md-8">
                 {!! Form::select('control_row', \App\MoneyKeeper\Models\ImportProfile::getRowNums(30), Input::get('control_row', isset($obItem)?$obItem->control_row:''), array('class'=>(isset($errors) && $errors->has('control_row') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('control_row'))
                        <strong>{{ $errors->first('control_row') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
        <div class="row form-group">
            <label for="control_string" class="col-md-4 control-label">{{ trans('mkeep.control_string') }}</label>
            <div class="col-md-8">
                 {!! Form::text('control_string', Input::get('control_string', isset($obItem)?$obItem->control_string:''), array('class'=>(isset($errors) && $errors->has('control_string') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('control_string'))
                        <strong>{{ $errors->first('control_string') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
        <div class="row form-group">
            <label for="date_col" class="col-md-4 control-label">{{ trans('mkeep.date_col') }}</label>
            <div class="col-md-8">
                 {!! Form::select('date_col', \App\MoneyKeeper\Models\ImportProfile::getRowNums(20), Input::get('date_col', isset($obItem)?$obItem->date_col:''), array('class'=>(isset($errors) && $errors->has('date_col') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('date_col'))
                        <strong>{{ $errors->first('date_col') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
        <div class="row form-group">
            <label for="summ_col" class="col-md-4 control-label">{{ trans('mkeep.summ_col') }}</label>
            <div class="col-md-8">
                 {!! Form::select('summ_col', \App\MoneyKeeper\Models\ImportProfile::getRowNums(20), Input::get('summ_col', isset($obItem)?$obItem->summ_col:''), array('class'=>(isset($errors) && $errors->has('summ_col') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('summ_col'))
                        <strong>{{ $errors->first('summ_col') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
        <div class="row form-group">
            <label for="category_col" class="col-md-4 control-label">{{ trans('mkeep.category_col') }}</label>
            <div class="col-md-8">
                 {!! Form::select('category_col', \App\MoneyKeeper\Models\ImportProfile::getRowNums(20), Input::get('category_col', isset($obItem)?$obItem->category_col:''), array('class'=>(isset($errors) && $errors->has('category_col') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('category_col'))
                        <strong>{{ $errors->first('category_col') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
        <div class="row form-group">
            <label for="desc_col" class="col-md-4 control-label">{{ trans('mkeep.desc_col') }}</label>
            <div class="col-md-8">
                 {!! Form::select('desc_col', \App\MoneyKeeper\Models\ImportProfile::getRowNums(20), Input::get('desc_col', isset($obItem)?$obItem->desc_col:''), array('class'=>(isset($errors) && $errors->has('desc_col') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('desc_col'))
                        <strong>{{ $errors->first('desc_col') }}</strong>
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
        <div class="row form-group">
            <label for="desc_col" class="col-md-4 control-label">{{ $obCategory->name }}</label>
            <div class="col-md-8">
                 {!! Form::textarea('category_rules['.$obCategory->id.']', Input::get('category_rules['.$obCategory->id.']', (isset($obItem)&&isset($obItem->category_rules[$obCategory->id]))?$obItem->category_rules[$obCategory->id]:''), array('class'=>'form-control', 'rows'=>2, 'placeholder'=>trans('mkeep.import_profile_category_rules_help'))) !!}
            </div>
        </div>
        @endforeach

        <div class="row form-group">
            <div class="col-md-4"></div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-btn fa-save"></i> {{ trans('mkeep.save') }}
                </button>
            </div>
        </div>
     {!! Form::close() !!}
