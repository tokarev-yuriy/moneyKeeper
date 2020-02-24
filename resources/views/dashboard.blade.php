@extends('layouts.app')

@section('content')
    
    <planstat-component></planstat-component>
    
    <plancategories-component></plancategories-component>
    
    <div id="operationsList">
        <operation-list></operation-list>
    </div>
@endsection