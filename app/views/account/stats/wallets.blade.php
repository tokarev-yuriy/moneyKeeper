<div class="owl-carousel owl-theme">
        <?foreach($arItems as $obItem):?>
            <?
                $txtClass =  'black';
                if ($obItem->value > 0) {
                    $txtClass =  'success';
                } elseif($obItem->value < 0) {
                    $txtClass =  'danger';
                }
            ?>
            <div class="bg-info rounded-0 rounded-bottom">
                <p class="text-nowrap text-white pb-2 pt-1 mb-0 pl-2">
                    <strong><?=$obItem->name?></strong>
                    <br/>
                    <span class=" text-light"><?=number_format($obItem->value, 0, ',', ' ')?></span>
                    <i class="fa fa-money" aria-hidden="true"></i>
                </p>
            </div>
        <?endforeach?>
</div>