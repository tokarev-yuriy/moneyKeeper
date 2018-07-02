@extends('layouts.app')

@section('content')
    <h2>{{ trans('mkeep.spends') }} {{ trans('mkeep.in_year') }}</h2>
    <div class="container widget" id="income-area" data-url="/account/stat/yearavgspend" data-type="chart" data-chart-type="pie"></div>
    <h2>{{ trans('mkeep.incomes') }} {{ trans('mkeep.in_year') }}</h2>
    <div class="container widget" id="spend-area" data-url="/account/stat/yearavgincome" data-type="chart" data-chart-type="pie"></div>
@endsection
