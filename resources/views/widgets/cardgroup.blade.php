    @php
      if(!isset($arActions) || !is_array($arActions)) {
          $arActions = array();
      }
      if(!isset($arFilters) || !is_array($arFilters)) {
          $arFilters = array();
      }
      $date = '';
    @endphp
    
    <div class="clearfix"></div>

    @if(count($arFilters)>0)
    {!! Form::open(array('class'=>'form-inline')) !!}
        <div class="card col filter p-2 rounded-top mt-2">
        <div class="filter">
        @foreach($arFilters as $code => $arFilterItem)
            <div class="filter-item">
            @switch($arFilterItem['type'])
                @case('period')
                        @php
                          $fieldFrom = $code.'_from';
                          $fieldFromValue = Input::get($fieldFrom, Session::get($fieldFrom, date('Y-m-01')));                        
                          echo Form::input( 'date', $fieldFrom , $fieldFromValue, array('class'=>'form-control'));
                          echo '&nbsp;&mdash;&nbsp;';
                          $fieldTo = $code.'_to';
                          $fieldToValue= Input::get($fieldTo, Session::get($fieldTo, date('Y-m-d')));
                          echo Form::input( 'date', $fieldTo , $fieldToValue, array('class'=>'form-control mr-2'));
                        @endphp
                    @break
                @case('list')
                    @php
                        echo \App\MoneyKeeper\Helpers\Form::dropdownSelect('category_id', $arFilterItem['values'], Input::get($code, Session::get($code)));
                    @endphp
                    @break
                @default
                        {!! Form::text($code, Input::get($code, Session::get($code,'')), array('class'=>'form-control mr-2')) !!}
                    @break
            @endswitch
            </div>
        @endforeach
        </div>
        
        <button type="submit" class="btn btn-info">
            <i class="fa fa-btn fa-filter"></i> {{ trans('mkeep_tablegrid.filter') }}
        </button>
        
        </div>
    {!! Form::close() !!}
    @endif
    
      @if(empty($arItems) || count($arItems)==0)
        <div class="card" style="border-radius: 0;">
            <div class="card-header"><h3>{{ trans('mkeep.no_data') }}</h3></div>
        </div>
      @endif
      @foreach($arItems as $obItem)
        <div class="card mb-0 
        @if($obItem->date!='' && $obItem->date!=$date)
          
        @else 
          mt-0
        @endif
        " style="border-radius: 0;">
            @if($obItem->date!='' && $obItem->date!=$date)
              <div class="card-header card-header-info" style="width: auto;">
                <h4 class="card-title" style="width: auto;">{{ date("d.m.Y", strtotime($obItem->date)) }}</h4>
              </div>
                @php 
                  $date = $obItem->date;
                @endphp
            @endif
            <div class="card-body bg-{{ $obItem->type }} p-2">
              <div class="col-12">
                <div class="card-btns pl-2">
                    @if(in_array('edit', $arActions))
                        @if(isset($obItem->editPath))
                        <a class="btn btn-info" data-btn-type="edit" href="{{ $obItem->editPath }}" data-title="{{ $obItem->editTitle }}"><i class="material-icons">edit</i></a>
                        @endif
                    @endif
                    @if(in_array('delete', $arActions))
                        @if(isset($obItem->deletePath))
                        <a class="btn btn-dark" data-btn-type="delete" href="{{ $obItem->deletePath }}" data-title="{{ $obItem->deleteTitle }}"><i class="material-icons">close</i></a>
                        @endif
                    @endif
                </div>
                <div class="row">
                  <div class="col-8">
                        @if(isset($arHeads['category_id']) && isset($arDictionaries['category_id'][$obItem->category_id]))
                            <div class="
                              @if($obItem->type=='spend')
                              bg-danger
                              @elseif($obItem->type=='income')
                              bg-success
                              @elseif($obItem->type=='transfer')
                              bg-secondary
                              @endif 
                              category-icon">
                                @if(isset($arDictionaries['category_icon'][$obItem->category_id]))
                                <img src="{{ $arDictionaries['category_icon'][$obItem->category_id] }}" alt="{{ $arDictionaries['category_id'][$obItem->category_id] }}">
                                @endif
                            </div>
                            <h4>{{ $arDictionaries['category_id'][$obItem->category_id] }}</h4>
                        @endif
                        @if(isset($arHeads['wallet']))
                            {!! $obItem->wallet !!}
                        @elseif(isset($arHeads['wallet_from_id']) && isset($arDictionaries['wallet_from_id'][$obItem->wallet_from_id]))
                            {!! $arDictionaries['wallet_from_id'][$obItem->wallet_from_id] !!}
                        @elseif(isset($arHeads['wallet_to_id']) && isset($arDictionaries['wallet_to_id'][$obItem->wallet_to_id]))
                            {!! $arDictionaries['wallet_to_id'][$obItem->wallet_to_id] !!}
                        @endif
                    </div>                    
                    <div class="col-4  text-right">
                      @if(isset($arHeads['value']))
                          <span class="h3 
                            @if($obItem->type=='spend')
                              text-danger
                            @elseif($obItem->type=='income')
                              text-success
                            @elseif($obItem->type=='transfer')
                              text-secondary
                            @endif
                          ">
                              @if($obItem->type=='spend')
                                -
                              @elseif($obItem->type=='income')
                                +
                              @endif
                              {{ Number::curf($obItem->value) }}
                          </span>
                      @endif
                      @if(isset($arHeads['comment']))
                          <div class="text-secondary card-comment">{{ $obItem->comment }}</div>
                      @endif                      
                    </div>
                </div>
            </div>
          </div>
        </div>
    @endforeach
    
    @if(method_exists($arItems, 'links'))
        <div class="clearfix mb-2"></div>
        <nav>{{ $arItems->links() }}</nav>
    @endif
    <div class="clearfix mb-2"></div>
    
    
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
