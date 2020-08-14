@extends('layouts.app')

@section('content')
    <planstat-component></planstat-component>
    
    <plancategories-component></plancategories-component>
    
    <div id="operationsList">
        <operation-list type="<?=htmlspecialchars($type)?>"></operation-list>
    </div>
@endsection