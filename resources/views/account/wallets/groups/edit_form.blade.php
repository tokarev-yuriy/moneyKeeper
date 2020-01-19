   {!! Form::open(array('url' => ((isset($obItem) && $obItem->id)?$paths['update'].'/'.$obItem->id:$paths['add']))) !!}

        <div class="row">
            <label for="name" class="col-md-4 control-label">{{ trans('mkeep.name') }}</label>
            <div class="col-md-6">
                {!! Form::text('name', Input::get('name', isset($obItem)?$obItem->name:''), array('class'=>(isset($errors) && $errors->has('name') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('name'))
                        <strong>{{ $errors->first('name') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
        <div class="row">
            <label for="sort" class="col-md-4 control-label">{{ trans('mkeep.sort') }}</label>
            <div class="col-md-6">
                {!! Form::text('sort', Input::get('sort', isset($obItem)?$obItem->sort:''), array('class'=>(isset($errors) && $errors->has('sort') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('sort'))
                        <strong>{{ $errors->first('sort') }}</strong>
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
