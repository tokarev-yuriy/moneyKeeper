@extends('layouts.app')

@section('content')
    <h1><?=isset($obItem)?$titles['add']:$titles['edit'];?></h1>    
    <?=$editForm?>
    
@endsection
