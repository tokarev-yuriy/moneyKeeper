@extends('layouts.app')

@section('content')
    <h1><?=$titles['list']?></h1>
    
    <div class="container widget" id="categories-summ" data-url="/account/stat/monthavgspend" data-type="chart" data-chart-type="pie"></div>
    
    <div id="plansList">
        <a href="<?=URL::to($paths['add'])?>" data-btn-type="add" class="btn btn-info float-right mb-2" data-title="<?=$titles['add']?>"><i class="fa fa-check-square-o fa-lg"></i> <?=$titles['add']?></a>
        <div class="clearfix"></div>
    <?=$tablegrid?>
        <a href="<?=URL::to($paths['add'])?>" data-btn-type="add" class="btn btn-info float-right" data-title="<?=$titles['add']?>"><i class="fa fa-check-square-o fa-lg"></i> <?=$titles['add']?></a>
    </div>
@endsection

@section('appjsfile')
    @parent
    <script type="text/javascript">
        var obPlansList;
        $(document).ready(function(){
            obPlansList = new ListAjaxEditor({
                'container': $('#plansList')
            });
        });
    </script>
@stop
@section('appjsfile')
    @parent
    <script src="/js/list_edit.js?v=<?=time()?>"></script>
@stop