<template>
    <div class="float-right">
        <a href="<?=URL::to('/account/operations/spend/add')?>" data-btn-type="add" class="btn btn-danger" data-title="<?=trans('mkeep.add_spend')?>"><i class="fa fa-long-arrow-left fa-lg"></i> <?=trans('mkeep.add_spend')?></a>
        <a href="<?=URL::to('/account/operations/income/add')?>" data-btn-type="add" class="btn btn-success " data-title="<?=trans('mkeep.add_income')?>"><i class="fa fa-long-arrow-right fa-lg"></i> <?=trans('mkeep.add_income')?></a>
        <a href="<?=URL::to('/account/operations/transfer/add')?>" data-btn-type="add" class="btn btn-secondary" data-title="<?=trans('mkeep.add_transfer')?>"><i class="fa fa-exchange fa-lg"></i> <?=trans('mkeep.add_transfer')?></a>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
            };
        },
        mounted() {
            /**/
        },
        methods: {
            /**/
        }
    }
</script>
