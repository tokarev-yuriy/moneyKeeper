@extends('layouts.app')

@section('content')
    <h1><?=isset($obItem)?$titles['edit']:$titles['add'];?></h1>
    
    <?=$editForm?>
    
@endsection
