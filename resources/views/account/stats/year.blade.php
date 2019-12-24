@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="btn-group" role="group">
          <a class="btn btn-secondary" href="{{ url('/account/stat/month') }}">{{ trans('mkeep.per_month') }}</a>
          <a class="btn btn-dark" href="javascript: void();">{{ trans('mkeep.per_year') }}</a>
        </div>
    </div>
    <h2 class="text-center">{{ trans('mkeep.total') }}</h2>
    <div class="container widget" id="total-area" data-url="/account/stat/yeartotal" data-type="chart" data-chart-type="area" data-chart-stacktype="none" data-chart-format="YYYY">
        <span class="graph" data-name="{{ trans('mkeep.spends') }}" data-field="type_spend" data-color="#ce0808"></span>
        <span class="graph" data-name="{{ trans('mkeep.incomes') }}" data-field="type_income" data-color="#0b9138"></span>
    </div>
    <h2 class="text-center">{{ trans('mkeep.spends') }}</h2>
    <div class="container widget" id="income-area" data-url="/account/stat/yearspend" data-type="chart" data-chart-type="area" data-chart-format="YYYY">
        @php
          $arCategories = \App\MoneyKeeper\Models\Operation::getTypeCategories('spend');
        @endphp
        @foreach($arCategories as $id=>$name)
            <span class="graph" data-name="{{ $name }}" data-field="category_id_{{ $id }}"></span>
        @endforeach
    </div>
    <h2 class="text-center">{{ trans('mkeep.incomes') }}</h2>
    <div class="container widget" id="spend-area" data-url="/account/stat/yearincome" data-type="chart" data-chart-type="area" data-chart-format="YYYY">
        @php
          $arCategories = \App\MoneyKeeper\Models\Operation::getTypeCategories('income');
        @endphp
        @foreach($arCategories as $id=>$name)
            <span class="graph" data-name="{{ $name }}" data-field="category_id_{{ $id }}"></span>
        @endforeach
    </div>
@endsection
