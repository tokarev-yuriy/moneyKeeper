   {!! Form::open(array('url' => ((isset($obItem) && $obItem->id)?$paths['update'].'/'.$obItem->id:$paths['add']))) !!}

        <div class="row">
            <label for="value" class="col-md-4 control-label">{{ trans('mkeep.summ') }}</label>
            <div class="col-md-6">
                {!! Form::number('value', Input::get('value', isset($obItem)?$obItem->value:''), array('class'=>(isset($errors) && $errors->has('value') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('value'))
                        <strong>{{ $errors->first('value') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
        <div class="row">
            <label for="category_id" class="col-md-4 control-label">{{ trans('mkeep.category') }}</label>
            <div class="col-md-6">
                {!!Form::select('category_id', \App\MoneyKeeper\Models\Operation::getTypeCategories('spend'), Input::get('category_id', isset($obItem)?$obItem->category_id:''), array('class'=>(isset($errors) && $errors->has('category_id') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('category_id'))
                        <strong>{{ $errors->first('category_id') }}</strong>
                @endif
                </span>
            </div>
        </div>
   
        <div class="row">
            <label for="comment" class="col-md-4 control-label">{{ trans('mkeep.comment') }}</label>
            <div class="col-md-6">
                {!! Form::text('comment', Input::get('comment', isset($obItem)?$obItem->comment:''), array('class'=>(isset($errors) && $errors->has('comment') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('comment'))
                        <strong>{{ $errors->first('comment') }}</strong>
                @endif
                </span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-btn fa-save"></i> {{ trans('mkeep.save') }}
                </button>
            </div>
        </div>
    {!! Form::close() !!}
