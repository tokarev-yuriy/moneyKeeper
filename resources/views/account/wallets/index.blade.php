@extends('layouts.app')

@section('content')
    <h1><?=$titles['list']?></h1>
    <div id="walletList">
        <wallets-list></wallets-list>
    </div>
@endsection
