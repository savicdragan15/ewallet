<template>

<div>
    <div class="row">
        <div class="col-lg-3 col-xs-12 add-order-button">
            <a href="/order?openModal=true" class="btn btn-block btn-primary btn-sm"> <i class="fa fa-fw fa-barcode "></i> Add new Order</a>
        </div>
        <div class="col-lg-3 col-xs-12 add-order-button">
            <a href="/location?openModal=true" class="btn btn-block btn-primary btn-sm"> <i class="fa fa-fw fa-map "></i> Add new Location</a>
        </div>
    </div>

    <div class="row">
        <AllOrders :numberOfOrders="allOrders.numberOfOrders" :all-orders-url="allOrders.allOrdersUrl"></AllOrders>
        <SpentMoneyCurrentMonth :spent-money="spentMoneyCurrentMonth.spentMoney" :currency="spentMoneyCurrentMonth.currency"></SpentMoneyCurrentMonth>
        <SpentMoney :spent-money="spentMoney.spentMoney" :currency="spentMoney.currency"></SpentMoney>
    </div>
    <div class="row">
        <LatestOrders :orders="latestOrders.data" :currency="latestOrders.currency" :loading="latestOrders.loading"></LatestOrders>
    </div>
</div>
</template>

<script>
import AllOrders from "./AllOrdersComponent";
import SpentMoney from "./SpentMoneyComponent";
import LatestOrders from "./LatestOrdersComponent";
import SpentMoneyCurrentMonth from "./SpentMoneyCurrentMonthComponent";

export default {
    name: "DashboardComponent",
    components: {
        AllOrders,
        SpentMoney,
        LatestOrders,
        SpentMoneyCurrentMonth
    },
    data() {
        return {
            allOrders: {
                numberOfOrders: '<i class="fa fa-refresh fa-spin"></i>',
                allOrdersUrl: null
            },
            spentMoneyCurrentMonth: {
                spentMoney: '<i class="fa fa-refresh fa-spin"></i>',
                currency: this.$root.$data.currency
            },
            spentMoney: {
                spentMoney: '<i class="fa fa-refresh fa-spin"></i>',
                currency: this.$root.$data.currency
            },
            latestOrders: {
                loading: false,
                data: [],
                currency: this.$root.$data.currency
            }
        };
    },
    mounted() {
        this.getNumberOfOrders();
        this.getSpentMoneyCurrentMonth();
        this.getSpentMoney();
        this.getLatestOrders();
    },
    methods: {
        getNumberOfOrders() {
            axios
                .get(this.$root.$data.apiUrl + "/dashboard/getNumberOfOrders", {
                    headers: {
                        user: this.$root.$data.userId
                    }
                })
                .then(response => {
                    this.allOrders.numberOfOrders =
                        response.data.numberOfOrders;
                    this.allOrders.allOrdersUrl = response.data.allOrdersUrl;
                })
                .catch(error => {
                    swal(error.response.data.message, "", "error");
                });
        },
        getSpentMoneyCurrentMonth() {
            axios
                .get(this.$root.$data.apiUrl + "/dashboard/getSpentMoneyCurrentMonth", {
                    headers: {
                        user: this.$root.$data.userId
                    }
                })
                .then(response => {
                    this.spentMoneyCurrentMonth.spentMoney = response.data;
                })
                .catch(error => {
                    swal(error.response.data.message, "", "error");
                });
        },
        getSpentMoney() {
            axios
                .get(this.$root.$data.apiUrl + "/dashboard/getSpentMoney", {
                    headers: {
                        user: this.$root.$data.userId
                    }
                })
                .then(response => {
                    this.spentMoney.spentMoney = response.data;
                })
                .catch(error => {
                    swal(error.response.data.message, "", "error");
                });
        },
        getLatestOrders() {
            this.latestOrders.loading = true;
            axios
                .get(this.$root.$data.apiUrl + "/dashboard/getLatestOrders", {
                    headers: {
                        user: this.$root.$data.userId
                    }
                })
                .then(response => {
                    this.latestOrders.loading = false;
                    this.latestOrders.data = response.data;
                })
                .catch(error => {
                    this.latestOrders.loading = false;
                    swal(error.response.data.message, "", "error");
                });
        }
    }
};
</script>

<style scoped>
.add-order-button {
    margin-bottom: 15px;
}
</style>
