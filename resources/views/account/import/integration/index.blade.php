@extends('layouts.app')

@section('content')
    <h1><?=$titles['list']?></h1>
    
    <div id="importIntegrationList">
    
    @foreach($arDictionaries['types'] as $type=>$arType)
        <div class="row form-group">
            <div class="col-md-8">
                 <a href="<?=URL::to($paths['add'])?>?type=<?=$type?>" data-btn-type="add" class="btn btn-success float-right" data-title="<?=$titles['add']?>"><i class="fa fa-plus-square fa-lg"></i> {{ $arType['name'] }}</a>
            </div>
        </div>
    @endforeach
    
    @include('widgets.tablegrid')
    
    
    
    </div>
@endsection

@section('appjsfile')
    @parent
    <script type="text/javascript">
        var obImportIntegrationList;
        $(document).ready(function(){
            obImportIntegrationList = new ListAjaxEditor({
                'container': $('#importIntegrationList')
            });
        });
    </script>
@stop
@section('appjsfile')
    @parent
    <script src="/js/list_edit.js?v=<?=time()?>"></script>
@stop
