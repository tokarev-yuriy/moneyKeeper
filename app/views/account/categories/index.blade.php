@extends('layouts.app')

@section('content')
    <h1><?=$titles['list']?></h1>
    
    <div id="categoryList">
    <a href="<?=URL::to($paths['add'])?>" data-btn-type="add" class="btn btn-success float-right" data-title="<?=$titles['add']?>"><i class="fa fa-plus-square fa-lg"></i> <?=$titles['add']?></a>
    <?=$tablegrid?>
    <a href="<?=URL::to($paths['add'])?>" data-btn-type="add" class="btn btn-success float-right" data-title="<?=$titles['add']?>"><i class="fa fa-plus-square fa-lg"></i> <?=$titles['add']?></a>
    </div>
@endsection

@section('appjsfile')
    @parent
    <script type="text/javascript">
        var obCategoryList;
        $(document).ready(function(){
            obCategoryList = new ListAjaxEditor({
                'container': $('#categoryList'),
                'afterShow': function(){
                    iconCategorySelectInit();
                }
            });
        });
    </script>
@stop
@section('appjsfile')
    @parent
    <script src="/js/list_edit.js?v=<?=time()?>"></script>
@stop