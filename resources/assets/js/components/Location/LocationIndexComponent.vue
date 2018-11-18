<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">

                <!--<div class="box-header with-border">-->
                    <!--<h3 class="box-title">Bordered Table</h3>-->
                <!--</div>-->
                <div class="box-body">
                    <button type="button" class="btn btn-primary" v-on:click="openModal">
                        Add new location
                    </button>
                </div>


                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Name</th>
                            <th class="text-center">Lat</th>
                            <th class="text-center">Lon</th>
                            <th class="text-center">Status</th>
                        </tr>
                        <tr v-for="location in locations">
                            <td class="text-center">{{ location.id }}</td>
                            <td>{{ location.name }}</td>
                            <td class="text-center">{{ location.latitude }}</td>
                            <td class="text-center">{{ location.longitude }}</td>
                            <td class="text-center">{{ location.active }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <loading :loading="loading"></loading>
                <div class="box-footer clearfix text-center">
                    <pagination :data="paginationData" @pagination-change-page="getLocations"></pagination>
                </div>

            </div>
        </div>



        <bootstrapModal ref="modal" :need-header="true" :need-footer="false" :size="'large'" :opened="onOpenModal" :closed="onCloseModal">
            <div slot="title">
                {{ modal.title }}
            </div>

            <div slot="body">

                <div class="box-body">
                    <div class="form-group" v-bind:class="[errors.name ? 'has-error' : '']">
                        <label for="name">Name *</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter name" v-model="location.name">
                        <span class="help-block" v-if="errors.name">{{ errors.name[0]}}</span>
                    </div>
                </div>

                <div class="box-body">
                    <div class="form-group" v-bind:class="[errors.latitude ? 'has-error' : '']">
                        <label for="name">Latitude *</label>
                        <input type="text" class="form-control" id="latitude" placeholder="Enter latitude" v-model="location.latitude">
                        <span class="help-block" v-if="errors.latitude">{{ errors.latitude[0]}}</span>
                    </div>
                </div>

                <div class="box-body">
                    <div class="form-group" v-bind:class="[errors.longitude ? 'has-error' : '']">
                        <label for="name">Longitude *</label>
                        <input type="text" class="form-control" id="longitude" placeholder="Enter longitude" v-model="location.longitude">
                        <span class="help-block" v-if="errors.longitude">{{ errors.longitude[0]}}</span>
                    </div>
                </div>

                <div class="box-footer">
                    <button class="btn btn-primary" v-on:click="store">Add</button>
                </div>

            </div>

        </bootstrapModal>
    </div>
</template>

<script>
    import  pagination from '../Helpers/Pagintaion';
    import  loading from '../Helpers/LoadingComponent';
    import  bootstrapModal from 'vue2-bootstrap-modal';

    export default {
        name: "LocationIndexComponent",
        components: {
            pagination,
            loading,
            bootstrapModal
        },
        mounted() {
            this.getLocations();
        },
        data() {
            return {
                loading: false,
                user_id: Laravel.user.id,
                modal: {
                    title: null,
                },
                location: {},
                locations: [],
                errors: [],
                paginationData: {},
            }
        },
        methods: {
            store() {
                this.location.user_id = this.user_id;
                axios.post(this.$root.$data.apiUrl + '/location',  this.location)
                    .then((response) => {
                        this.errors = [];
                        this.location = {};
                        this.getLocations(this.paginationData.current_page);
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
            getLocations(page = 1) {
                this.loading = true;

                axios.get(this.$root.$data.apiUrl + '/location?page=' + page, {
                    headers : {
                        'user' : this.user_id
                    }
                })
                .then((response) => {
                    this.loading = false;
                    this.locations = response.data.locations.data;
                    this.paginationData = response.data.locations;
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

            },
            onCloseModal() {
                this.errors = [];
            }
        }
    }
</script>

<style scoped>

</style>
