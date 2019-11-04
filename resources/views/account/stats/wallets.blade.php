<div class="owl-carousel owl-theme">
    @foreach($arItems as $arItem)
    <div class="card">
        <h3 class="group-title text-nowrap">
            {{$arItem['name']}} 
            @php
                $bgClass =  'info';
                if ($arItem['summ'] > 0) {
                    $bgClass =  'success';
                } elseif($arItem['summ'] < 0) {
                    $bgClass =  'danger';
                }
            @endphp
            <span class="group-summ text-{{ $bgClass }}">{{ number_format($arItem['summ'], 0, ',', ' ') }}</span>
        </h3>
        @foreach($arItem['items'] as $obItem)
        <div class="wallet" onclick="document.location='/wallet/{{ $obItem->id }}';">
          @if($obItem->icon)
          <div class="wallet-img">
              <img src="{{ $obItem->icon }}" alt="{{ $obItem->name }}">                              
          </div>
          @endif
          @php
            $bgClass =  'info';
            if ($obItem->value > 0) {
                $bgClass =  'success';
            } elseif($obItem->value < 0) {
                $bgClass =  'danger';
            }
          @endphp
          <span class="wallet-title text-nowrap">{{ $obItem->name }}</span>
          <span class="wallet-summ text-{{ $bgClass }}">{{ number_format($obItem->value, 0, ',', ' ') }}</span>
        </div>
        @endforeach
    </div>
    @endforeach
</div>
