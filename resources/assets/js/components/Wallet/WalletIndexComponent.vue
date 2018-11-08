<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Bordered Table</h3>
                </div>

                <div class="box-body">
                    <button type="button" class="btn btn-primary" v-on:click="addWallet">
                        Add new wallet
                    </button>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <tableComponent :statuses="statuses" :items="wallets" :currency="currency" :fields="fields"></tableComponent>
                </div>
                <loading :loading="loading"></loading>
                <!-- /.box-body -->
                <div class="box-footer clearfix text-center">
                    <pagination :data="paginationData" @pagination-change-page="getWallets"></pagination>
                </div>
            </div>
        </div>

            <bootstrapModal ref="modal" :need-header="true" :need-footer="false" :size="'large'" :opened="myOpenFunc">

            <div slot="title">
                {{ modal.title }}
            </div>

            <div slot="body">
                <!--<div class="box box-primary">-->
                    <!--<div class="box-header with-border">-->
                        <!--<h3 class="box-title">Quick Example</h3>-->
                    <!--</div>-->
                    <!-- /.box-header -->
                    <!-- form start -->
                        <div class="box-body">
                            <div class="form-group" v-bind:class="[errors.name ? 'has-error' : '']">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter name" v-model="wallet.name">
                                <span class="help-block" v-if="errors.name">{{ errors.name[0]}}</span>
                            </div>

                            <div class="form-group" v-bind:class="[errors.wallet_type_id ? 'has-error' : '']">
                                <label>Select</label>
                                <select class="form-control" v-model="wallet.wallet_type_id">
                                    <option value="null">Select wallet type</option>
                                    <option v-for="type in wallet_types" v-bind:value="type.id">{{ type.name }}</option>
                                </select>
                                <span class="help-block" v-if="errors.wallet_type_id">{{ errors.wallet_type_id[0]}}</span>
                            </div>

                            <div class="form-group" v-bind:class="[errors.amount ? 'has-error' : '']">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" id="amount" placeholder="Enter amount" v-model="wallet.amount">
                                <span class="help-block" v-if="errors.amount">{{ errors.amount[0]}}</span>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button class="btn btn-primary" v-on:click="store">Add</button>
                        </div>
                <!--</div>-->
            </div>

            <div slot="footer">
                Your footer here
            </div>
        </bootstrapModal>


    </div>
</template>

<script>
    import pagination from '../Helpers/Pagintaion';
    import loading from '../Helpers/LoadingComponent';
    import tableComponent from '../Helpers/TableComponent';
    import bootstrapModal from 'vue2-bootstrap-modal';

    export default {
        components: {
            'pagination': pagination,
            'loading': loading,
            'tableComponent': tableComponent,
             bootstrapModal
        },
        mounted() {
            this.getWallets();
        },
        created() {

        },
        data() {
            return {
                loading: false,
                currency: null,
                wallet: {
                    id: null,
                    name: null,
                    user_id: null,
                    wallet_type_id: null,
                    amount: null,
                    active: 1,
                },
                wallet_types: [],
                wallets: [],
                statuses: [
                    '<span class="label label-danger">Inactive</span>',
                    '<span class="label label-success">Active</span>'
                ],
                modal: {
                    title: null,
                },
                errors: [],
                paginationData: {},
                fields: [
                    {
                        display_name: 'ID',
                    },
                    {
                        display_name: 'Name',
                    },
                    {
                        display_name: 'Type',
                        classes: 'text-center',
                    },
                    {
                        display_name: 'Amount',
                        classes: 'text-center',
                    },
                    {
                        display_name: 'Status',
                        classes: 'text-center',
                    },
                    {
                        display_name: 'Actions',
                    },
                ],
            }
        },
        methods: {
            getWallets(page = 1) {
                this.loading = true;

                axios.get(this.$root.$data.apiUrl + '/wallet?page=' + page)
                    .then((response) => {
                        this.loading = false;
                        this.wallets = response.data.wallets.data;
                        this.currency = response.data.currency;
                        this.paginationData = response.data.wallets;
                    })
                    .catch((error) => {
                        this.loading = false;
                        swal(error.response.data.message, '', 'error');
                    });
            },
            destroy(index) {
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this wallet!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            let currentWallet =  this.wallets[index];
                            this.loading = true;
                            axios.post(this.$root.$data.apiUrl + '/wallet/' + currentWallet.id + '?_method=DELETE')
                                .then((response) => {
                                    this.loading = false;
                                    swal(response.data.message, '', 'success');
                                    this.$delete(this.wallets, index);

                                    if(this.wallets.length === 0) {
                                        this.getWallets(this.paginationData.current_page - 1);
                                    }
                                })
                                .catch((error) => {
                                    this.loading = false;
                                    if (error.response.status === 400) {
                                        swal(error.response.data.message, '', 'error');
                                    }
                                });
                        }
                    });
            },
            addWallet() {
                console.log('add wallet');
                this.modal.title = 'Add new wallet';
                this.$refs.modal.open();

                axios.get(this.$root.$data.apiUrl + '/walletType')
                    .then((response) => {
                        console.log(response.data.wallet_types);
                        this.wallet_types = response.data.wallet_types;
                    })
                    .catch((error) => {
                        swal(error.response.data.message, '', 'error');
                    });
            },
            myOpenFunc() {

            },
            store() {
                console.log('store')
                axios({
                    method: 'post',
                    url: this.$root.$data.apiUrl + '/wallet/',
                    data: this.wallet
                })
                // axios.post(this.$root.$data.apiUrl + '/wallet/' + '?_method=POST', this.wallet)
                //     .then((response) => {
                //         this.errors = [];
                //         this.wallet = {};
                //         this.wallet.wallet_type_id = null;
                //         this.getWallets(this.paginationData.current_page);
                //         swal(response.data.message, '', 'success');
                //     })
                //     .catch((error) => {
                //
                //         if (error.response.status === 422) {
                //             this.errors = error.response.data.errors;
                //         }
                //
                //         if (error.response.status === 400) {
                //             swal(error.response.data.message, '', 'error');
                //         }
                //     });
            }
        }

    }
</script>

