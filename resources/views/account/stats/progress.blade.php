        <div class="row  justify-content-center" id="progressWidget">
        @php
            $i = 0;
        @endphp
        @foreach($arItems as $categoryId=>$arItem)
          @php
            $hidden = "";
            $i++;
            if ($i>10) {
                //$hidden = 'display: none;';
            }
            $class="success";
            if ($arItem['sum']>$arItem['plan']) {
                $class="danger";
            }
          @endphp
          <div class="categories-widget card" style="{{ $hidden }}" data-href="<?=URL::to('/account/operations/spend/add')?>?category_id={{ $categoryId }}" data-btn-type="add" data-title="{{ trans('mkeep.add_spend') }}">
              @if($arItem['icon'])
                  <div class="categories-icon"><img src="{{ $arItem['icon'] }}?v=4"></div>
              @endif
              <div class="categories-info">
                <span class="text-dark">{{ $arItem['name'] }}</span>
                <br/>
                <span class="text-{{ $class }}">{{ $arItem['sum'] }} / <span class="text-secondary">{{ $arItem['plan'] }}</span></span>
              </div>
              
              <div class="progress total mb-2 mt-2" style="height: 2px;">
                <div class="progress-bar bg-{{ $class }}" role="progressbar" aria-valuenow="{{ $arItem['sum'] }}" aria-valuemin="0" aria-valuemax="{{ $arItem['plan'] }}"  style="width: {{ $arItem['progress'] }}%;">                                
                </div>                
              </div>
          </div>
        @endforeach
        </div>

        <script type="text/javascript">
            var obProgressWidget;
            $(document).ready(function(){
                obProgressWidget = new ListAjaxEditor({
                    'container': $('#progressWidget')
                });
            });
        </script>
