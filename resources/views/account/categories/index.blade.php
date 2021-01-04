@extends('layouts.app')

@section('content')
    <h1><?=$titles['list']?></h1>
    
    <div id="categoryList">
    <categories-list></categories-list>
    </div>
@endsection