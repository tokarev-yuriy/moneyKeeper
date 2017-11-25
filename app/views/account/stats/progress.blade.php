        <div class="row">
        <?
            $totalSpend = 0;
            $totalPlan = 0;
        ?>
        <?foreach($arItems as $arItem):?>            
        <?
            $totalSpend += $arItem['sum'];
            $totalPlan += $arItem['plan'];
            $class="bg-success";
            if ($arItem['sum']>$arItem['plan']) {
                $class="bg-danger";
            }
        ?>
        <div class="categories-widget col">
            <div class="progress rounded-circle">
              <div class="progress-bar <?=$class?>" role="progressbar" aria-valuenow="<?=$arItem['sum']?>" aria-valuemin="0" aria-valuemax="<?=$arItem['plan']?>"  style="height: <?=$arItem['progress']?>%; margin-top: <?=100-$arItem['progress']?>%;">                
              </div>
              <div class="progress-text"><?=$arItem['sum']?><br/><span><?=$arItem['plan']?></span></div>
            </div>
            <?=$arItem['name']?>
        </div>
        <?endforeach?>
        </div>
        
        <?
            $progress = 100;
            if ($totalPlan>0) {
                $progress = 100 * $totalSpend / $totalPlan;
            }
            $class="bg-success";
            if ($totalSpend>$totalPlan) {
                $class="bg-danger";
            }
        ?>
        <div class="progress total mb-2 mt-2" style="height: 40px;">
          <div class="progress-bar <?=$class?>" role="progressbar" aria-valuenow="<?=$totalSpend?>" aria-valuemin="0" aria-valuemax="<?=$totalPlan?>"  style="height: 40px; width: <?=$progress?>%;">                
            <?=$totalSpend?> / <?=$totalPlan?>
          </div>          
        </div>