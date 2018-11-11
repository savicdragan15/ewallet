<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Bordered Table</h3>
                </div>
                <div class="box-body">
                    <button type="button" class="btn btn-primary" v-on:click="openModal">
                        Add new order
                    </button>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Order number</th>
                                <th>Wallet</th>
                                <th class="text-center">Location</th>
                                <th class="text-center">Flag</th>
                                <th class="text-center">Amount</th>
                                <th>Created at</th>
                            </tr>
                            <tr v-for="order in orders">
                                <td class="text-center">{{ order.id }}</td>
                                <td>{{ order.order_number }}</td>
                                <td>
                                    <span v-if="order.wallet">{{ order.wallet.name }} ({{ order.wallet.wallet_type.name }})</span>
                                </td>
                                <td class="text-center" >
                                    <span v-if="order.location">{{ order.location.name }}</span>
                                </td>
                                <td class="text-center">
                                    <lightboxComponent :thumbnail="order.flag" :images="[order.flag]">
                                        <lightbox-default-loader slot="loader"></lightbox-default-loader>
                                    </lightboxComponent>
                                </td>
                                <td class="text-center">{{ order.amount }} {{ currency }} </td>
                                <td>{{ order.created_at | moment("D.M.YYYY. H:m") }}</td>
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

        <bootstrapModal ref="modal" :need-header="true" :need-footer="false" :size="'large'" :opened="onOpenModal" :closed="onCloseModal">

            <div slot="title">
                {{ modal.title }}
            </div>

            <div slot="body">
                <div class="box-body">
                    <div class="form-group" v-bind:class="[errors.amount ? 'has-error' : '']">
                        <label for="name">Amount *</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter amount" v-model="order.amount">
                        <span class="help-block" v-if="errors.amount">{{ errors.amount[0]}}</span>
                    </div>
                </div>

                <div class="box-body">
                    <div class="form-group" v-bind:class="[errors.wallet_id ? 'has-error' : '']">
                        <label>Select wallet *</label>
                        <select class="form-control" v-model="order.wallet_id">
                            <option value="null">Select wallet</option>
                            <option v-for="wallet in wallets" v-bind:value="wallet.id">{{ wallet.name }} ({{ wallet.wallet_type.name }})</option>
                        </select>
                        <span class="help-block" v-if="errors.wallet_id">{{ errors.wallet_id[0]}}</span>
                    </div>
                </div>

                <div class="box-body">
                    <div class="form-group" v-bind:class="[errors.location_id ? 'has-error' : '']">
                        <label>Select location *</label>
                        <select class="form-control" v-model="order.location_id">
                            <option value="null">Select location</option>
                            <option v-for="location in locations" v-bind:value="location.id">{{ location.name }}</option>
                        </select>
                        <span class="help-block" v-if="errors.location_id">{{ errors.location_id[0]}}</span>
                    </div>
                </div>

                <div class="box-footer">
                    <button class="btn btn-primary" v-on:click="store">Add</button>
                </div>

            </div>

            <div slot="footer">
                Your footer here
            </div>



        </bootstrapModal>
    </div>
</template>

<script>
    import  pagination from '../Helpers/Pagintaion';
    import  loading from '../Helpers/LoadingComponent';
    import  bootstrapModal from 'vue2-bootstrap-modal';
    import  lightboxComponent from '../Helpers/LightboxComponent'

    export default {
        name: "OrderIndexComponent",
        components: {
            pagination,
            loading,
            bootstrapModal,
            lightboxComponent
        },
        mounted() {
            this.getOrders();
            this.order.user_id = this.user_id;
            this.updateFlag();
        },
        data() {
            return {
                loading : false,
                user_id : Laravel.user.id,
                modal: {
                    title: null,
                },
                currency : null,
                wallets : [],
                markets : [],
                locations : [],
                orders : [],
                order : {
                    id : null,
                    order_number : null,
                    wallet_id : null,
                    market_id : null,
                    user_id : null,
                    location_id : null,
                    address : null,
                    amount : null,
                    flag : null,
                },
                errors: [],
                paginationData: {},
            }
        },
        methods: {
            updateFlag: function () {
                this.flag = 'updated'
                this.$nextTick(function () {
                    this.$el.textContent // => 'updated'
                })
            },
            store() {
              console.log('store');
                this.order.user_id = this.user_id;
                axios.post(this.$root.$data.apiUrl + '/order',  this.order)
                    .then((response) => {
                        this.errors = [];
                        this.order = {};
                        this.order.wallet_id = null;
                        this.order.market_id= null;
                        this.getOrders(this.paginationData.current_page);
                        this.$refs.modal.close();
                        swal(response.data.message, '', 'success');
                    })
                    .catch((error) => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors;
                        }

                        if (error.response.status === 400) {
                            swal(error.response.data.message, '', 'error');
                        }
                    });
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
            },
            openModal() {
                this.modal.title = 'Add new order';
                this.$refs.modal.open();
            },
            onOpenModal() {
                this.getWallets();
                this.getMarkets();
                this.getLocations();
            },
            onCloseModal() {
                this.errors = [];
            },
            getWallets() {
                axios.get(this.$root.$data.apiUrl + '/wallet', {
                    headers : {
                        'user' : this.user_id
                    }
                })
                .then((response) => {
                    this.wallets = response.data.wallets.data;
                })
                .catch((error) => {
                    swal(error.response.data.message, '', 'error');
                });
            },
            getMarkets() {
                axios.get(this.$root.$data.apiUrl + '/markets', {
                    headers : {
                        'user' : this.user_id
                    }
                })
                .then((response) => {
                    this.markets = response.data.markets.data;
                })
                .catch((error) => {
                    swal(error.response.data.message, '', 'error');
                });
            },
            getLocations() {
                axios.get(this.$root.$data.apiUrl + '/location', {
                    headers : {
                        'user' : this.user_id
                    }
                })
                .then((response) => {
                    this.locations = response.data.locations.data;
                })
                .catch((error) => {
                    swal(error.response.data.message, '', 'error');
                });
            }
        }
    }
</script>
