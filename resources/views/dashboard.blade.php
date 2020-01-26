@extends('layouts.app')

@section('content')
    
    <planstat-component></planstat-component>
    
    <plancategories-component></plancategories-component>
    
    <div id="operationsList">
        <operation-btns></operation-btns>
        <operation-list></operation-list>
        <operation-btns></operation-btns>
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
