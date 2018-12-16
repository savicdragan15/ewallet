<template>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3 v-html="numberOfOrders"></h3>
                <p>All Orders</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <!--<a v-bind:href="allOrdersUrl" class="small-box-footer">View all Orders <i class="fa fa-arrow-circle-right"></i></a>-->
        </div>
    </div>
</template>

<script>
export default {
    name: "AllOrdersComponent",
    props: ["numberOfOrders", "allOrdersUrl"]
};
</script>

<style scoped>
</style>
