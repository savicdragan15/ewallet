<template>
    <div class="row">
        <div class="col-sm-12">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Bordered Table</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered ">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Status</th>
                            <th>Actions</th>
                        </tr>
                        <tr v-for="(wallet, index) in wallets">
                            <td>{{ wallet.id }}</td>
                            <td>{{ wallet.name }}</td>
                            <td class="text-center">{{ wallet.wallet_type.name }}</td>
                            <td class="text-center">{{ wallet.amount }} {{ currency}}</td>
                            <td class="text-center" v-html="statuses[wallet.active]"></td>
                            <td>
                                <button type="button" class="btn btn-primary btn-xs" title="Edit">
                                    <i class="fa fa-fw fa-pencil-square-o"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-xs" title="Delete" v-on:click="destroy(index)">
                                    <i class="fa fa-fw fa-trash-o"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="overlay" v-if="loading">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix text-center">
                    <pagination :data="paginationData" @pagination-change-page="getWallets"></pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import pagination from '../Helpers/Pagintaion';

    export default {
        components: {
            'pagination': pagination
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
                wallets: [],
                statuses: [
                    '<span class="label label-danger">Inactive</span>',
                    '<span class="label label-success">Active</span>'
                ],
                paginationData: {},
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
                    });
            },
            destroy(index) {
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
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
                                    this.$delete(this.wallets, index)

                                })
                                .catch((error) => {
                                    this.loading = false;
                                    if (error.response.status === 400) {
                                        swal(error.response.data.message, '', 'error');
                                    }
                                });
                        }
                    });
            }
        }

    }
</script>

