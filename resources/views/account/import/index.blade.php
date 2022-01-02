@extends('layouts.app')

@section('content')
   <h1>{{ trans('mkeep.import') }}</h1>
   <br/>
   <div class="container">
        <operation-import-list></operation-import-list>
   </div>
@endsection
