<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Bordered Table</h3>
                </div>
                <div class="box-body">
                    <button type="button" class="btn btn-primary">
                        Add new order
                    </button>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Order number</th>
                                <th>Wallet</th>
                                <th class="text-center">Market</th>
                                <th class="text-center">Address</th>
                                <th class="text-center">Amount</th>
                                <th>Created at</th>
                            </tr>
                            <tr v-for="order in orders">
                                <td class="text-center">{{ order.id }}</td>
                                <td>{{ order.order_number }}</td>
                                <td>{{ order.wallet.name }} ({{ order.wallet.wallet_type.name }})</td>
                                <td class="text-center">{{ order.market.name }}</td>
                                <td class="text-center">{{ order.address }}</td>
                                <td class="text-center">{{ order.amount }} {{ currency }} </td>
                                <td>{{ order.created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <loading :loading="loading"></loading>
                <!-- /.box-body -->
                <div class="box-footer clearfix text-center">
                    <pagination :data="paginationData" @pagination-change-page="getOrders"></pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import pagination from '../Helpers/Pagintaion';
    import loading from '../Helpers/LoadingComponent';
    import bootstrapModal from 'vue2-bootstrap-modal';

    export default {
        name: "OrderIndexComponent",
        components: {
            pagination,
            loading
        },
        mounted() {
            this.getOrders();
        },
        data() {
            return {
                loading : false,
                user_id : Laravel.user.id,
                currency : null,
                orders : [],
                order : {},
                paginationData: {},
            }
        },
        methods: {
            index() {

            },
            store() {

            },
            getOrders(page = 1) {
                this.loading = true;

                axios.get(this.$root.$data.apiUrl + '/order?page=' + page, {
                    headers : {
                        'user' : this.user_id
                    }
                })
                .then((response) => {
                    this.loading = false;
                    this.orders = response.data.orders.data;
                    this.currency = response.data.currency;
                    this.paginationData = response.data.orders;
                })
                .catch((error) => {
                    this.loading = false;
                    swal(error.response.data.message, '', 'error');
                });
            }
        }
    }
</script>
