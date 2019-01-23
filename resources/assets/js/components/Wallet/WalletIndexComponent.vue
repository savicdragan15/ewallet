<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <!--<div class="box-header with-border">-->
                    <!--<h3 class="box-title">Bordered Table</h3>-->
                <!--</div>-->

                <div class="box-body">
                    <button type="button" class="btn btn-sm btn-primary" v-on:click="addWallet">
                        <i class="fa fa-fw fa-plus"></i> Add new wallet
                    </button>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <tableComponent :statuses="statuses" :items="wallets" :currency="currency" :fields="fields"></tableComponent>
                </div>
                <loading :loading="loading"></loading>
                <!-- /.box-body -->
                <div class="clearfix text-center">
                    <pagination :data="paginationData" @pagination-change-page="getWallets"></pagination>
                </div>
            </div>
        </div>

            <bootstrapModal ref="modal" :need-header="true" :need-footer="false" :size="'large'" :closed="onCloseModal">
            <div slot="title">
                {{ modal.title }}
            </div>
            <div slot="body">
                        <div class="box-body">
                            <div class="form-group" v-bind:class="[errors.name ? 'has-error' : '']">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter name" v-model="wallet.name">
                                <span class="help-block" v-if="errors.name">{{ errors.name[0]}}</span>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button class="btn btn-primary btn-sm" v-on:click="store" v-if="!editMode">
                                <i class="fa fa-fw fa-plus"></i>Add
                            </button>
                            <button class="btn btn-primary btn-sm" v-on:click="update" v-if="editMode">
                                <i class="fa fa-fw fa-pencil-square-o"></i>Edit
                            </button>
                        </div>
            </div>

            <div slot="footer">
                Your footer here
            </div>
        </bootstrapModal>


    </div>
</template>

<script>
import pagination from "../Helpers/Pagintaion";
import loading from "../Helpers/LoadingComponent";
import tableComponent from "../Helpers/TableComponent";
import bootstrapModal from "vue2-bootstrap-modal";
import WalletApi from "../Api/WalletApi";
import {getCall} from "../Api/utils/Endpoint";
import {postCall} from "../Api/utils/Endpoint";

export default {
    components: {
        pagination: pagination,
        loading: loading,
        tableComponent: tableComponent,
        bootstrapModal
    },
    mounted() {
        this.getWallets();
        this.currency = this.$root.$data.currency;
    },
    created() {},
    data() {
        return {
            loading: false,
            currency: null,
            user_id: Laravel.user.id,
            editMode: false,
            wallet: {
                id: null,
                name: null,
                user_id: null,
                active: 1
            },
            wallet_types: [],
            wallets: [],
            statuses: [
                '<span class="label label-danger">Inactive</span>',
                '<span class="label label-success">Active</span>'
            ],
            modal: {
                title: null
            },
            errors: [],
            paginationData: {},
            fields: [
                {
                    display_name: "Name"
                },
                // {
                //     display_name: "Status",
                //     classes: "text-center"
                // },
                {
                    display_name: "Actions"
                }
            ]
        };
    },
    methods: {
        onCloseModal() {
            this.errors = [];
            this.editMode = false;
            this.wallet.name = null;
        },
        getWallets(page = 1) {
            this.loading = true;

            axios
                .get(this.$root.$data.apiUrl + "/wallets?page=" + page, {
                    headers: {
                        user: this.user_id
                    }
                })
                .then(response => {
                    this.loading = false;
                    this.wallets = response.data.wallets.data;
                    // this.currency = response.data.currency;
                    this.paginationData = response.data.wallets;
                })
                .catch(error => {
                    this.loading = false;
                    swal(error.response.data.message, "", "error");
                });
        },
        destroy(index) {
            swal({
                title: "Are you sure?",
                text:
                    "Once deleted, you will not be able to recover this wallet!",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then(willDelete => {
                if (willDelete) {
                    let currentWallet = this.wallets[index];
                    this.loading = true;
                    axios
                        .post(
                            this.$root.$data.apiUrl +
                                "/wallets/" +
                                currentWallet.id +
                                "?_method=DELETE"
                        )
                        .then(response => {
                            this.loading = false;
                            swal(response.data.message, "", "success");
                            this.$delete(this.wallets, index);

                            if (this.wallets.length === 0) {
                                this.getWallets(
                                    this.paginationData.current_page - 1
                                );
                            }
                        })
                        .catch(error => {
                            this.loading = false;
                            if (error.response.status === 400) {
                                swal(error.response.data.message, "", "error");
                            }
                        });
                }
            });
        },
        addWallet() {
            this.modal.title = "Add new wallet";
            this.$refs.modal.open();
        },
        store() {
            this.wallet.user_id = this.user_id;
            axios
                .post(this.$root.$data.apiUrl + "/wallets", this.wallet)
                .then(response => {
                    this.errors = [];
                    this.wallet = {};
                    this.getWallets(this.paginationData.current_page);
                    this.$refs.modal.close();
                    swal(response.data.message, "", "success");
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }

                    if (error.response.status === 400) {
                        swal(error.response.data.message, "", "error");
                    }
                });
        },
        edit(id) {
          getCall(this.$root.$data.apiUrl + WalletApi.index + '/' + id)
            .then(response => {
              this.editMode = true;
              this.wallet = response.data;
              this.modal.title = "Edit wallet - " + this.wallet.name;
              this.$refs.modal.open();
            })
            .catch(error => {
              swal(error.response.data.message, "", "error");
            })
        },
      update() {
        postCall(this.$root.$data.apiUrl + WalletApi.index + '/' + this.wallet.id + "?_method=PATCH", this.wallet)
          .then(response => {
            this.loading = false;
            this.errors = [];
            this.getWallets(this.paginationData.current_page);
            this.$refs.modal.close();
            swal(response.data.message, "", "success");
          })
          .catch(error => {
            this.loading = false;
            this.errors = [];

            if (error.response.status === 422) {
              this.errors = error.response.data.errors;
            }

            if (error.response.status === 400) {
              swal(response.data.message, "", "error");
            }
          });
      }
    }
};
</script>
