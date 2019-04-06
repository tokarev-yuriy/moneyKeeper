<div class="owl-carousel owl-theme">
        @foreach($arItems as $obItem)
            @php
                $bgClass =  'info';
                if ($obItem->value > 0) {
                    $bgClass =  'success';
                } elseif($obItem->value < 0) {
                    $bgClass =  'danger';
                }
            @endphp
            <div class="" onclick="{{ url('/wallet/'.$obItem->id) }}">
              
                <div class="row">
                  <div class="card card-stats">
                      <span class="card-title text-nowrap">{{ $obItem->name }}</span>                        
                      @if($obItem->icon)
                      <div class="card-stats-img">
                          <img src="{{ $obItem->icon }}" alt="{{ $obItem->name }}">                              
                      </div>
                      @endif
                      <h3 class="card-title text-{{ $bgClass }}">{{ number_format($obItem->value, 0, ',', ' ') }}</h3>                        
                  </div>
                </div>
            </div>
        @endforeach
</div>
