<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <!--<div class="box-header with-border">-->
                    <!--<h3 class="box-title">Bordered Table</h3>-->
                <!--</div>-->
                <div class="box-body">
                    <button type="button" class="btn btn-sm btn-primary" v-on:click="openModal('Add new Order')">
                        <i class="fa fa-fw fa-plus"></i> Add new order
                    </button>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Order number</th>
                                <th class="text-center">Category</th>
                                <th>Location</th>
                                <th class="text-center">Amount</th>
                                <th>Created at</th>
                                <th>Wallet</th>
                                <th>Actions</th>
                            </tr>
                            <tr v-for="order in orders">
                                <td>{{ order.order_number }}</td>
                                <td class="text-center">
                                    <span v-if="order.category">{{ order.category.name }}</span>
                                </td>
                                <td>
                                    <span v-if="order.location">{{ order.location.name }}</span>
                                </td>
                                <td class="text-center">{{ order.amount }} {{ currency }} </td>
                                <td>{{ order.created_at | moment("D.M.YYYY. HH:mm") }}</td>
                                <td>
                                     <span v-if="order.wallet">{{ order.wallet.name }} ({{ order.wallet.wallet_type.name }})</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-xs" title="Edit" v-on:click="edit(order.id)">
                                        <i class="fa fa-fw fa-pencil-square-o"></i>
                                    </button>
                                </td>
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

        <editModal></editModal>

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
                    <div class="form-group" v-bind:class="[errors.category_id ? 'has-error' : '']">
                        <label>Select category *</label>
                        <select class="form-control" v-model="order.category_id">
                            <option value="">Select category</option>
                            <option v-for="category in categories" v-bind:value="category.id">{{ category.name }}</option>
                        </select>
                        <span class="help-block" v-if="errors.category_id">{{ errors.category_id[0]}}</span>
                    </div>
                </div>

                <div class="box-body">
                    <div class="form-group" v-bind:class="[errors.wallet_id ? 'has-error' : '']">
                        <label>Select wallet *</label>
                        <select class="form-control" v-model="order.wallet_id">
                            <option value="">Select wallet</option>
                            <option v-for="wallet in wallets" v-bind:value="wallet.id">{{ wallet.name }} ({{ wallet.wallet_type.name }})</option>
                        </select>
                        <span class="help-block" v-if="errors.wallet_id">{{ errors.wallet_id[0]}}</span>
                    </div>
                </div>

                <div class="box-body">
                    <div class="form-group" v-bind:class="[errors.location_id ? 'has-error' : '']">
                        <label>Select location *</label>
                        <select class="form-control" v-model="order.location_id">
                            <option value="">Select location</option>
                            <option v-for="location in locations" v-bind:value="location.id">{{ location.name }}</option>
                        </select>
                        <span class="help-block" v-if="errors.location_id">{{ errors.location_id[0]}}</span>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary btn-sm"  v-if="!editMode" v-on:click="store">
                        <i class="fa fa-fw fa-plus"></i> Add
                    </button>
                    <button class="btn btn-danger btn-sm"  v-if="editMode" v-on:click="update(order.id)">
                        <i class="fa fa-fw fa-save"></i> Edit
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
import bootstrapModal from "vue2-bootstrap-modal";
import lightboxComponent from "../Helpers/LightboxComponent";
import editModal from "../Order/EditModalComponent";

export default {
    name: "OrderIndexComponent",
    components: {
        pagination,
        loading,
        bootstrapModal,
        lightboxComponent,
        editModal
    },
    mounted() {
        if (this.$root.getUrlParam("openModal")) {
            this.openModal("Add new order");
        }

        this.currency = this.$root.$data.currency;
        this.order.user_id = this.user_id;
        this.getOrders();
        this.updateFlag();
    },
    data() {
        return {
            loading: false,
            editMode: false,
            user_id: Laravel.user.id,
            modal: {
                title: null
            },
            currency: null,
            wallets: [],
            categories: [],
            markets: [],
            locations: [],
            orders: [],
            order: {
                id: null,
                order_number: null,
                wallet_id: '',
                market_id: null,
                user_id: null,
                location_id: '',
                category_id: '',
                address: null,
                amount: null,
                flag: null
            },
            errors: [],
            paginationData: {}
        };
    },
    methods: {
        updateFlag: function() {
            this.flag = "updated";
            this.$nextTick(function() {
                this.$el.textContent; // => 'updated'
            });
        },
        store() {
            this.order.user_id = this.user_id;
            axios
                .post(this.$root.$data.apiUrl + "/orders", this.order)
                .then(response => {
                    this.errors = [];
                    this.order = {};
                    this.order.wallet_id = null;
                    this.order.market_id = null;
                    this.order.location_id = null;
                    this.getOrders(this.paginationData.current_page);
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
            this.editMode = true;
            this.loading = true;
            axios
                .get(this.$root.$data.apiUrl + "/orders/" + id, {
                    headers: {
                        user: this.user_id
                    }
                })
                .then(response => {
                    this.order = response.data;
                    this.openModal("Edit order - " + this.order.order_number);
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                    swal(error.response.data.message, "", "error");
                });
        },
        update(id) {
            this.loading = true;
            axios
                .post(
                    this.$root.$data.apiUrl + "/orders/" + this.order.id + "?_method=PATCH", this.order
                )
                .then(response => {
                    this.loading = false;
                    this.errors = [];
                    this.getOrders(this.paginationData.current_page);
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
        },
        getOrders(page = 1) {
            this.loading = true;

            axios
                .get(this.$root.$data.apiUrl + "/orders?page=" + page, {
                    headers: {
                        user: this.user_id
                    }
                })
                .then(response => {
                    this.loading = false;
                    this.orders = response.data.orders.data;
                    this.paginationData = response.data.orders;
                })
                .catch(error => {
                    this.loading = false;
                    swal(error.response.data.message, "", "error");
                });
        },
        openModal(title) {
            this.modal.title = title;
            this.$refs.modal.open();
        },
        onOpenModal() {
            this.getWallets();
            this.getLocations();
            this.getCategories();
        },
        onCloseModal() {
            this.editMode = false;
            this.order = {
                user_id: this.user_id,
                category_id: '',
                location_id: '',
                wallet_id: '',
            };
            this.errors = [];
        },
        getWallets() {
            if (this.wallets.length) {
                return false;
            }
            axios
                .get(this.$root.$data.apiUrl + "/wallets", {
                    headers: {
                        user: this.user_id
                    }
                })
                .then(response => {
                    this.wallets = response.data.wallets.data;
                })
                .catch(error => {
                    swal(error.response.data.message, "", "error");
                });
        },
        getCategories() {
            if (this.categories.length) {
                return false;
            }
            axios
                .get(this.$root.$data.apiUrl + "/categories", {
                    headers: {
                        user: this.user_id,
                        all: true
                    }
                })
                .then(response => {
                    this.categories = response.data.categories;
                })
                .catch(error => {
                    swal(error.response.data.message, "", "error");
                });
        },
        getLocations() {
            if (this.locations.length) {
                return false;
            }
            axios
                .get(this.$root.$data.apiUrl + "/locations", {
                    headers: {
                        user: this.user_id,
                        all: true
                    }
                })
                .then(response => {
                    this.locations = response.data.locations;
                })
                .catch(error => {
                    swal(error.response.data.message, "", "error");
                });
        }
    }
};
</script>
