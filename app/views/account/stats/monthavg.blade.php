@extends('layouts.app')

@section('content')
    <h2><?=trans('mkeep.spends')?> <?=trans('mkeep.in_month')?></h2>
    <div class="container widget" id="income-area" data-url="/account/stat/monthavgspend" data-type="chart" data-chart-type="pie" style="min-height: 500px;"></div>
    <h2><?=trans('mkeep.incomes')?> <?=trans('mkeep.in_month')?></h2>
    <div class="container widget" id="spend-area" data-url="/account/stat/monthavgincome" data-type="chart" data-chart-type="pie" style="min-height: 500px;"></div>
@endsection