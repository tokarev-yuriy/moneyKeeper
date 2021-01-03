@extends('layouts.app')

@section('content')
    
    <plan-stat :hideyear="true"></plan-stat>
    
    <div id="operationsList">
        <operation-list></operation-list>
    </div>
@endsection