<template>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3 v-html="spentMoney"></h3>

                <p>Spent money in {{ currency }}</p>
            </div>
            <div class="icon">
                <!--<i class="ion ion-stats-bars"></i>-->
                <i class="fa fa-money"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</template>

<script>
export default {
    name: "SpentMoneyComponent",
    props: ["spentMoney", "currency"]
};
</script>

<style scoped>
</style>
