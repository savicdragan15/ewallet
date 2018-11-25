<template>

<div>
    <div class="row">
        <div class="col-lg-3 col-xs-12 add-order-button">
            <a href="/order?openModal=true" class="btn btn-block btn-primary btn-sm"> <i class="fa fa-fw fa-barcode "></i> Add new Order</a>
        </div>
    </div>

    <div class="row">
        <AllOrders></AllOrders>

        <SpentMoney></SpentMoney>
        <!--&lt;!&ndash; ./col &ndash;&gt;-->
        <!--<div class="col-lg-3 col-xs-6">-->
            <!--&lt;!&ndash; small box &ndash;&gt;-->
            <!--<div class="small-box bg-yellow">-->
                <!--<div class="inner">-->
                    <!--<h3>44</h3>-->

                    <!--<p>User Registrations</p>-->
                <!--</div>-->
                <!--<div class="icon">-->
                    <!--<i class="ion ion-person-add"></i>-->
                <!--</div>-->
                <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
            <!--</div>-->
        <!--</div>-->
        <!--&lt;!&ndash; ./col &ndash;&gt;-->
        <!--<div class="col-lg-3 col-xs-6">-->
            <!--&lt;!&ndash; small box &ndash;&gt;-->
            <!--<div class="small-box bg-red">-->
                <!--<div class="inner">-->
                    <!--<h3>65</h3>-->

                    <!--<p>Unique Visitors</p>-->
                <!--</div>-->
                <!--<div class="icon">-->
                    <!--<i class="ion ion-pie-graph"></i>-->
                <!--</div>-->
                <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
            <!--</div>-->
        <!--</div>-->
        <!--&lt;!&ndash; ./col &ndash;&gt;-->
    </div>
</div>
</template>

<script>
    import AllOrders from './AllOrdersComponent';
    import SpentMoney from './SpentMoneyComponent';

    export default {
        name: "DashboardComponent",
        components: {
            AllOrders,
            SpentMoney
        }
    }
</script>

<style scoped>
    .add-order-button {
        margin-bottom: 15px;
    }
</style>
