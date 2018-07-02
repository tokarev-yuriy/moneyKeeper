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
            <div class="bg-{{ $bgClass }} rounded-0 rounded-bottom">
                <p class="text-nowrap text-white pb-2 pt-1 mb-0 pl-2">
                    <a href="{{ url('/wallet/'.$obItem->id) }}" class="card-link text-white">
                        <strong>{{ $obItem->name }}</strong>
                        <br/>
                        <span class=" text-light">{{ number_format($obItem->value, 0, ',', ' ') }}</span>
                        <i class="fa fa-money" aria-hidden="true"></i>
                    </a>
                </p>
            </div>
        @endforeach
</div>
