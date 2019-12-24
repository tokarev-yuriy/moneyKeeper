@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="btn-group" role="group">
          <a class="btn btn-secondary" href="{{ url('/account/stat/monthavg') }}">{{ trans('mkeep.per_month') }}</a>
          <a class="btn btn-dark" href="javascript: void();">{{ trans('mkeep.per_year') }}</a>
        </div>
    </div>
    <h2 class="text-center">{{ trans('mkeep.spends') }} {{ trans('mkeep.in_year') }}</h2>
    <div class="container widget" id="income-area" data-url="/account/stat/yearavgspend" data-type="chart" data-chart-type="pie"></div>
    <h2 class="text-center">{{ trans('mkeep.incomes') }} {{ trans('mkeep.in_year') }}</h2>
    <div class="container widget" id="spend-area" data-url="/account/stat/yearavgincome" data-type="chart" data-chart-type="pie"></div>
@endsection
