@extends('layouts.app')

@section('content')
    <h2><?=trans('mkeep.total')?></h2>
    <div class="container widget" id="total-area" data-url="/account/stat/yeartotal" data-type="chart" data-chart-type="area" data-chart-stacktype="none" style="min-height: 500px;">
        <span class="graph" data-name="<?=trans('mkeep.spends')?>" data-field="type_spend" data-color="#ce0808"></span>
        <span class="graph" data-name="<?=trans('mkeep.incomes')?>" data-field="type_income" data-color="#0b9138"></span>
    </div>
    <h2><?=trans('mkeep.spends')?></h2>
    <div class="container widget" id="income-area" data-url="/account/stat/yearspend" data-type="chart" data-chart-type="area" style="min-height: 500px;">
        <?$arCategories = Operation::getTypeCategories('spend');?>
        <?foreach($arCategories as $id=>$name):?>
            <span class="graph" data-name="<?=$name?>" data-field="category_id_<?=$id?>"></span>
        <?endforeach;?>
    </div>
    <h2><?=trans('mkeep.incomes')?></h2>
    <div class="container widget" id="spend-area" data-url="/account/stat/yearincome" data-type="chart" data-chart-type="area" style="min-height: 500px;">
        <?$arCategories = Operation::getTypeCategories('income');?>
        <?foreach($arCategories as $id=>$name):?>
            <span class="graph" data-name="<?=$name?>" data-field="category_id_<?=$id?>"></span>
        <?endforeach;?>
    </div>
@endsection