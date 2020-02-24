<template>
    <div class="float-right">
        <a href="javascript: void(0);" class="btn btn-danger" @click="add('spend')"><i class="fa fa-long-arrow-left fa-lg"></i> mkeep.add_spend</a>
        <a href="javascript: void(0);" class="btn btn-success" @click="add('income')"><i class="fa fa-long-arrow-right fa-lg"></i> mkeep.add_income</a>
        <a href="javascript: void(0);" class="btn btn-secondary" @click="add('transfer')"><i class="fa fa-exchange fa-lg"></i> mkeep.add_transfer</a>
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
            /**
             *	клик на добавление
             */
            add: function(type) {
                this.$emit('addbtnclick', type);
            }
        }
    }
</script>
