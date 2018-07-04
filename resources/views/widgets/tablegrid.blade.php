    @php
      if(!isset($arActions) || !is_array($arActions)) {
          $arActions = array();
      }
      if(!isset($arFilters) || !is_array($arFilters)) {
          $arFilters = array();
      }
    @endphp
    <div class="clearfix"></div>

    @if(count($arFilters)>0)
    <div class="filter bg-light p-2 border border-2 border-bottom-0 border-dark rounded-top mt-2">
        {!! Form::open(array('class'=>'form-inline')) !!}
        @foreach($arFilters as $code => $arFilterItem)
            <div class="form-group">
            @switch($arFilterItem['type'])
                @case('period')
                      @php
                        $fieldFrom = $code . '_from';
                        $fieldTo = $code . '_to';
                        echo Form::input( 'date', $fieldFrom, Input::get($fieldFrom, date('Y-m-01')), array('class'=>'form-control'));
                        echo '&nbsp;&mdash;&nbsp;';
                        echo Form::input( 'date', $fieldTo, Input::get($fieldTo, date('Y-m-d')), array('class'=>'form-control mr-2'));
                      @endphp
                    @break
                @case('list')
                      @php
                        echo Form::select($code, $arFilterItem['values'], Input::get($code), array('class'=>'form-control mr-2'));
                      @endphp
                    @break
                @default
                      @php
                        echo Form::text($code, Input::get($code, ''), array('class'=>'form-control mr-2'));
                      @endphp
                    @break
            @endswitch
            </div>
        @endforeach
        
        <button type="submit" class="btn btn-info">
            <i class="fa fa-btn fa-filter"></i> <?echo trans('mkeep_tablegrid.filter')?>
        </button>
        
        {!! Form::close() !!}
    </div>
    @endif
    
    
    <table class="table mt-3 table-striped table-sm">
      <thead class="thead-inverse">
        <tr>                          
        @foreach($arHeads as $column)
          @php 
            if(!is_array($column)) $column = array('title'=>$column);
          @endphp
          <th 
          @if(isset($column['style']))
            style="<?echo $column['style']?>"
          @endif
          >{{$column['title']}}</th>
        @endforeach
        @if(count($arActions)>0)
          <th colspan="{{ count($arActions) }}" width="1%">{{ trans('mkeep_tablegrid.actions') }}</th>
        @endif
        </tr>
      </thead>
      <tbody>
      @foreach($arItems as $obItem)
        <tr>
        @foreach($arHeads as $code => $column)
          @php 
            if(!is_array($column)) $column = array('title'=>$column);
          @endphp
          <td 
          @if(isset($column['style']))
            style="{{ $column['style'] }}"
          @endif
          >
            @php
                $value = $obItem->{$code};
                if(isset($arDictionaries) && is_array($arDictionaries) && isset($arDictionaries[$code])) {
                    if(isset($arDictionaries[$code][$value])) $value = $arDictionaries[$code][$value];
                }
            @endphp
            @if(isset($column['type']) && $column['type']=='image')
                @if($value!='')
                <img src="{{ $value }}" style="width: 30px; height: 30px;">
                @endif
            @elseif(isset($column['type']) && $column['type']=='color')
                @if($value!='')
                <div style="width: 30px; height: 30px; background-color: #{{ $value }}">&nbsp;</div>
                @endif
            @else
                {{ $value }}
            @endif
          </td>
        @endforeach
        @if(in_array('edit', $arActions))
          <td>
            @if(isset($obItem->editPath))
            <a class="btn btn-info d-none d-md-block" data-btn-type="edit" href="{{ $obItem->editPath }}" data-title="{{ $obItem->editTitle }}"><i class="fa fa-pencil fa-lg"></i> {{ trans('mkeep_tablegrid.edit') }}</a>
            <a class="btn btn-info d-md-none" data-btn-type="edit" href="{{ $obItem->editPath }}" data-title="{{ $obItem->editTitle }}"><i class="fa fa-pencil fa-lg"></i></a>
            @endif
          </td>
        @endif
        @if(in_array('delete', $arActions))
          <td>
            @if(isset($obItem->deletePath))
            <a class="btn btn-dark d-none d-md-block" data-btn-type="delete" href="{{ $obItem->deletePath }}" data-title="{{ $obItem->deleteTitle }}"><i class="fa fa-remove fa-lg"></i> {{ trans('mkeep_tablegrid.delete') }}</a>
            <a class="btn btn-dark d-md-none" data-btn-type="delete" href="{{ $obItem->deletePath }}" data-title="{{ $obItem->deleteTitle }}"><i class="fa fa-remove fa-lg"></i></a>
            @endif
          </td>
        @endif
        </tr>
      @endforeach
     </tbody>
    </table>
    
    @if(method_exists($arItems, 'links'))
        <nav>{{ $arItems->links() }}</nav>
    @endif
    
    
    <div class="modal fade" id="editModalBlock" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('mkeep_tablegrid.close') }}">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body"></div>
        </div>
      </div>
    </div>
    
    
    <div class="modal fade" id="deleteModalBlock" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">{{ trans('mkeep_tablegrid.delete_item') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('mkeep_tablegrid.close') }}">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">{{ trans('mkeep_tablegrid.sure') }}</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('mkeep_tablegrid.no') }}</button>
            <a class="btn btn-danger delete-btn" href="javascript: void(0);">{{ trans('mkeep_tablegrid.delete') }}</a>
          </div>
        </div>
      </div>
    </div>
