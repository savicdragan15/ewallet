<template>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3 v-html="numberOfOrders"></h3>
                <p>All Orders</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a v-bind:href="allOrdersUrl" class="small-box-footer">View all Orders <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</template>

<script>

    export default {
        name: "AllOrdersComponent",
        data() {
            return {
                loading: true,
                numberOfOrders: '<i class="fa fa-refresh fa-spin"></i>',
                allOrdersUrl: null
            }
        },
        mounted() {
          this.getNumberOfOrders();
        },
        methods: {
            getNumberOfOrders() {
                axios.get(this.$root.$data.apiUrl + '/dashboard/getNumberOfOrders', {
                    headers : {
                        'user' : this.$root.$data.userId
                    }
                })
                .then((response) => {
                    this.numberOfOrders = response.data.numberOfOrders;
                    this.allOrdersUrl = response.data.allOrdersUrl;
                })
                .catch((error) => {
                    swal(error.response.data.message, '', 'error');
                });
            }
        }
    }
</script>

<style scoped>

</style>
