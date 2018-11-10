<template>
    <div class="row">
        <div class="col-md-3">
            <!-- Profile image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" :src="user.avatar" alt="User profile picture">

                    <h3 class="profile-username text-center">{{ user.name }}</h3>

                    <p class="text-muted text-center">{{ user.email }}</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Followers</b> <a class="pull-right">1,322</a>
                        </li>
                        <li class="list-group-item">
                            <b>Following</b> <a class="pull-right">543</a>
                        </li>
                        <li class="list-group-item">
                            <b>Friends</b> <a class="pull-right">13,287</a>
                        </li>
                    </ul>
                    <div class="overlay" v-if="loading">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <!--<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>-->
                </div>
            </div>
            <!-- / Profile image -->
        </div>

        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Profile information</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group" v-bind:class="[errors.name ? 'has-error' : '']">
                            <label for="name" class="col-sm-2 control-label">Name *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" placeholder="Name" v-model="user.name">
                                <span class="help-block" v-if="errors.name">{{ errors.name[0]}}</span>
                            </div>

                        </div>
                        <div class="form-group" v-bind:class="[errors.email ? 'has-error' : '']">
                            <label for="email" class="col-sm-2 control-label">Email *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email" placeholder="Email" v-model="user.email">
                                <span class="help-block" v-if="errors.email">{{ errors.email[0]}}</span>
                            </div>
                        </div>

                        <div class="form-group" v-bind:class="[errors.gender ? 'has-error' : '']">
                            <label for="email" class="col-sm-2 control-label">Gender</label>

                            <div class="col-sm-10">
                                <select class="form-control" v-model="user.gender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <span class="help-block" v-if="errors.gender">{{ errors.gender[0]}}</span>
                            </div>
                        </div>

                        <!--<div class="form-group">-->
                            <!--<label for="avatar" class="col-sm-2 control-label">Avatar</label>-->

                            <!--<div class="col-sm-10">-->
                                <!--<input type="file" id="avatar" ref="file" accept="image/*" v-on:change="setAvatar">-->
                                <!--<p class="help-block">Change avatar</p>-->
                            <!--</div>-->

                        <!--</div>-->

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-danger" v-on:click="update">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="overlay" v-if="loading">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import swal from 'sweetalert';

    export default {
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            this.user = Laravel.user;
        },
        data() {
            return {
                loading: false,
                new_avatar: null,
                user : {
                    id: null,
                    avatar: null,
                    name: null,
                    email: null,
                    gender: null,
                },
                errors: [],
            }
        },
        methods: {
            update() {
                this.loading = true;
                axios.post(this.$root.$data.apiUrl + '/profile/' + this.user.id + '?_method=PATCH', this.user)
                    .then((response) => {
                        this.loading = false;
                        this.errors = [];
                        swal(response.data.message, '', 'success');

                    })
                    .catch((error) => {
                        this.loading = false;
                        this.errors = [];

                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors;
                        }

                        if (error.response.status === 400) {
                            swal(response.data.message, '', 'error');
                        }

                    });
            }
        }

    }
</script>

