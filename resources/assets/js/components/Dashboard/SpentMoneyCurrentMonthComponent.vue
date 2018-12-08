<template>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3 v-html="spentMoney"></h3>

                <p>Current month in {{ currency }}</p>
            </div>
            <div class="icon">
                <i class="fa fa-money"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SpentMoneyCurrentMonthComponent",
        props: ["spentMoney", "currency"]
    }
</script>

<style scoped>

</style>
