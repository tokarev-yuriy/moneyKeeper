@extends('layouts.app')

@section('content')
    <h1><?=$titles['list']?></h1>
    
    @php
        $btnClass = 'success';
        $iconClass = 'fa-long-arrow-left';
        switch($type) {
            case 'spend': $btnClass = 'danger'; $iconClass = 'fa-long-arrow-left'; break;
            case 'transfer': $btnClass = 'secondary'; $iconClass = 'fa-exchange'; break;
            case 'income': $btnClass = 'success'; $iconClass = 'fa-long-arrow-right'; break;
        }
    @endphp
    
    <div class="container widget" id="categories-summ" data-url="/account/stat/categories/<?=$type?>" data-type="chart" data-chart-type="pie"></div>
    
    <div id="operationsList">
        <a href="<?=URL::to($paths['add'])?>" data-btn-type="add" class="btn btn-{{ $btnClass }} float-right" data-title="<?=$titles['add']?>"><i class="fa {{ $iconClass }} fa-lg"></i> <?=$titles['add']?></a>
        @include('widgets.cardgroup')
        <a href="<?=URL::to($paths['add'])?>" data-btn-type="add" class="btn btn-{{ $btnClass }} float-right" data-title="<?=$titles['add']?>"><i class="fa {{ $iconClass }} fa-lg"></i> <?=$titles['add']?></a>
    </div>
@endsection

@section('appjsfile')
    @parent
    <script type="text/javascript">
        var obOperationList;
        $(document).ready(function(){
            obOperationList = new ListAjaxEditor({
                'container': $('#operationsList'),
                'afterShow': function(){
                    WalletColorsInit();
                }
            });
        });
    </script>
@stop
@section('appjsfile')
    @parent
    <script src="/js/list_edit.js?v=<?=time()?>"></script>
@stop
