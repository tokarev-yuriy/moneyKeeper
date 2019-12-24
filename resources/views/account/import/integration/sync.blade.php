@extends('layouts.app')

@section('content')
   <h1>{{ trans('mkeep.import') }}</h1>
   <br/>
   <div class="container">
    <h4>{{ trans('mkeep.import_check_items') }}</h4>
    {!! Form::open(array('url' => '/account/import/integration/sync/'.$syncId, 'files' => true)) !!}
        <input type="hidden" name="mode" value="save" />
        <input type="hidden" name="walletId" value="{{ $walletId }}" />
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
    </div>
@endsection