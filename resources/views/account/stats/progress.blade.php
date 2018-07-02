        <div class="row" id="progressWidget">
        @php
            $totalSpend = 0;
            $totalPlan = 0;
        @endphp
        
        @foreach($arItems as $categoryId=>$arItem)
          @php
            $totalSpend += $arItem['sum'];
            $totalPlan += $arItem['plan'];
            $class="success";
            if ($arItem['sum']>$arItem['plan']) {
                $class="danger";
            }
          @endphp
          <div class="categories-widget col">
              <a href="<?=URL::to('/account/operations/spend/add')?>?category_id={{ $categoryId }}" data-btn-type="add" data-title="{{ trans('mkeep.add_spend') }}">
              <span class="text-dark" style="white-space: nowrap; font-weight: bold;">{{ $arItem['name'] }}</span>
              <div class="progress rounded-circle">
                <div class="progress-bar bg-{{ $class }}" role="progressbar" aria-valuenow="{{ $arItem['sum'] }}" aria-valuemin="0" aria-valuemax="{{ $arItem['plan'] }}"  style="height: {{ $arItem['progress'] }}%; margin-top: {{ 100-$arItem['progress'] }}%;">                                
                </div>
                @if($arItem['icon'])
                  <div class="progress-icon"><img src="{{ $arItem['icon'] }}?v=4"></div>
                @endif
              </div>
              <div class="progress-text text-{{ $class }}">{{ $arItem['sum'] }}<br/><span class="text-secondary">{{ $arItem['plan'] }}</span></div>
              </a>
          </div>
        @endforeach
        </div>
        
        @php
            $progress = 100;
            if ($totalPlan>0) {
                $progress = 100 * $totalSpend / $totalPlan;
            }
            $class="bg-success";
            if ($totalSpend>$totalPlan) {
                $class="bg-danger";
            }
        @endphp
        <div class="progress total mb-2 mt-2" style="height: 40px;">
          <div class="progress-bar {{ $class }}" role="progressbar" aria-valuenow="{{ $totalSpend }}" aria-valuemin="0" aria-valuemax="{{ $totalPlan }}"  style="height: 40px; width: {{ $progress }}%;">                
            {{ $totalSpend }} / {{ $totalPlan }}
          </div>          
        </div>
        
        
        <script type="text/javascript">
            var obProgressWidget;
            $(document).ready(function(){
                obProgressWidget = new ListAjaxEditor({
                    'container': $('#progressWidget')
                });
            });
        </script>
