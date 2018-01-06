@extends('layouts.app')

@section('content')

    <ul class="nav nav-pills justify-content-center mt-3 mb-3">
      <li class="nav-item">
        <a class="nav-link" href="/account/stat/monthplan/<?=$prevPeriod?>"><i class="fa fa-arrow-left fa-lg" aria-hidden="true"></i></a>
      </li>
       <li class="nav-item">
        <a class="nav-link active" href="javascript: void(0);"><?=date("F Y", strtotime($period))?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/account/stat/monthplan/<?=$nextPeriod?>"><i class="fa fa-arrow-right fa-lg" aria-hidden="true"></i></a>
      </li>
    </ul>

    <div class="container widget" id="categories-plan" data-url="/account/stat/progress/month/<?=$period?>"></div>
@endsection