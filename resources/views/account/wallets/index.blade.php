@extends('layouts.app')

@section('content')
    <h1><?=$titles['list']?></h1>
    
    <div id="walletList">
    <a href="<?=URL::to($paths['add'])?>" data-btn-type="add" class="btn btn-success float-right" data-title="<?=$titles['add']?>"><i class="fa fa-plus-square fa-lg"></i> <?=$titles['add']?></a>
    @include('widgets.tablegrid')
    <a href="<?=URL::to($paths['add'])?>" data-btn-type="add" class="btn btn-success float-right" data-title="<?=$titles['add']?>"><i class="fa fa-plus-square fa-lg"></i> <?=$titles['add']?></a>
    </div>
@endsection


@section('appjsfile')
    @parent
    <script type="text/javascript">
        var obWalletList;
        $(document).ready(function(){
            obWalletList = new ListAjaxEditor({
                'container': $('#walletList'),
                'afterShow': function(){
                    iconWalletSelectInit();
                    ColorSelectInit();
                }
            });
        });
    </script>
@stop
@section('appjsfile')
    @parent
    <script src="/js/list_edit.js?v=<?=time()?>"></script>
@stop
