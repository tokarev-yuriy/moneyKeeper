<div class="owl-carousel owl-theme">
        @foreach($arItems as $obItem)
            @php
                $bgClass =  'info';
                if ($obItem->value > 0) {
                    $bgClass =  'info';
                } elseif($obItem->value < 0) {
                    $bgClass =  'danger';
                }
            @endphp
            <div class="bg-{{ $bgClass }} rounded-0 rounded-bottom" onclick="{{ url('/wallet/'.$obItem->id) }}">
              
                <div class="row">
                    <div class="col-5 align-middle text-center pr-0">
                      @if($obItem->icon)
                        <div class="rounded-circle wallet-icon  m-2 p-2" style="background-color: #{{ $obItem->color }}">
                            <img src="{{ $obItem->icon }}" alt="{{ $obItem->name }}">
                        </div>
                      @endif
                    </div>
                    <div class="col-7  align-middle text-nowrap text-white pl-1 pt-1">
                      <strong>{{ $obItem->name }}:</strong>
                      <br/>
                      <span class=" text-light">{{ number_format($obItem->value, 0, ',', ' ') }}</span>
                      <i class="fa fa-money" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        @endforeach
</div>
