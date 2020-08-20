@extends('layouts.app')

@section('content')

    <planstat-component></planstat-component>
    <plancategories-component></plancategories-component>
    <div id="operationsList">
        <h1>{{ trans('mkeep.import') }}</h1>
        <h4>{{ trans('mkeep.import_check_items') }}</h4>
        <operation-sync-list wallet="<?=htmlspecialchars($walletId)?>" id="<?=htmlspecialchars($syncId)?>"></operation-sync-list>
    </div>
@endsection