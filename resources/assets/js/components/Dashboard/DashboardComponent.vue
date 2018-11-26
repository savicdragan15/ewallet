<template>

<div>
    <div class="row">
        <div class="col-lg-3 col-xs-12 add-order-button">
            <a href="/order?openModal=true" class="btn btn-block btn-primary btn-sm"> <i class="fa fa-fw fa-barcode "></i> Add new Order</a>
        </div>
    </div>

    <div class="row">
        <AllOrders :numberOfOrders="allOrders.numberOfOrders" :all-orders-url="allOrders.allOrdersUrl"></AllOrders>
        <SpentMoney :spent-money="spentMoney.spentMoney" :currency="spentMoney.currency"></SpentMoney>
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
        },
        data() {
            return {
                allOrders: {
                    numberOfOrders: '<i class="fa fa-refresh fa-spin"></i>',
                    allOrdersUrl: null
                },
                spentMoney: {
                    spentMoney: '<i class="fa fa-refresh fa-spin"></i>',
                    currency:  this.$root.$data.currency
                }
            }
        },
        mounted() {
            this.getNumberOfOrders();
            this.getSpentMoney();
        },
        methods: {
            getNumberOfOrders() {
                axios.get(this.$root.$data.apiUrl + '/dashboard/getNumberOfOrders', {
                    headers : {
                        'user' : this.$root.$data.userId
                    }
                })
                .then((response) => {
                    this.allOrders.numberOfOrders = response.data.numberOfOrders;
                    this.allOrders.allOrdersUrl = response.data.allOrdersUrl;
                })
                .catch((error) => {
                    swal(error.response.data.message, '', 'error');
                });
            },
            getSpentMoney() {
                axios.get(this.$root.$data.apiUrl + '/dashboard/getSpentMoney', {
                    headers : {
                        'user' : this.$root.$data.userId
                    }
                })
                .then((response) => {
                    this.spentMoney.spentMoney = response.data;
                })
                .catch((error) => {
                    swal(error.response.data.message, '', 'error');
                });
            }
        }
    }
</script>

<style scoped>
    .add-order-button {
        margin-bottom: 15px;
    }
</style>
