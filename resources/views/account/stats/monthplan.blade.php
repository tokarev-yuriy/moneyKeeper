@extends('layouts.app')

@section('content')

    <ul class="nav nav-pills justify-content-center mt-3 mb-3">
      <li class="nav-item">
        <a class="nav-link" href="/account/stat/monthplan/{{ $prevPeriod }}"><i class="fa fa-arrow-left fa-lg" aria-hidden="true"></i></a>
      </li>
       <li class="nav-item">
        <a class="nav-link active" href="javascript: void(0);">{{ date("F Y", strtotime($period)) }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/account/stat/monthplan/{{ $nextPeriod }}"><i class="fa fa-arrow-right fa-lg" aria-hidden="true"></i></a>
      </li>
    </ul>
	
	<div class="container-fluid widget" id="totals-sum" data-url="/account/stat/totals/month/{{ $period }}" data-type="vue">
        План: @{{widget.plan}}
        <div class="progress total mb-2 mt-2" style="height: 2px;">
          <div class="progress-bar bg-info" role="progressbar" :aria-valuenow="widget.plan" aria-valuemin="0" :aria-valuemax="widget.max" :style="'width: '+widget.plan_percent+'%;'"></div>
        </div>
        Расходы: @{{widget.spend}}
        <div class="progress total mb-2 mt-2" style="height: 2px;">
          <div class="progress-bar bg-danger" role="progressbar" :aria-valuenow="widget.spend" aria-valuemin="0" :aria-valuemax="widget.max" :style="'width: '+widget.spend_percent+'%;'"></div>
        </div>
        Доход: @{{widget.income}}
        <div class="progress total mb-2 mt-2" style="height: 2px;">
          <div class="progress-bar bg-success" role="progressbar" :aria-valuenow="widget.income" aria-valuemin="0" :aria-valuemax="widget.max" :style="'width: '+widget.income_percent+'%;'"></div>
        </div>
      </div>

    <div class="container widget" id="categories-plan" data-url="/account/stat/progress/month/{{ $period }}"></div>
@endsection
