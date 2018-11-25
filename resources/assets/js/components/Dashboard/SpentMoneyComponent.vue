<template>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3 v-html="spentMoney"></h3>

                <p>Spent money</p>
            </div>
            <div class="icon">
                <!--<i class="ion ion-stats-bars"></i>-->
                <i class="fa fa-money"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SpentMoneyComponent",
        data() {
            return {
                spentMoney: '<i class="fa fa-refresh fa-spin"></i>',
            }
        },
        mounted() {
            this.getSpentMoney();
        },
        methods: {
            getSpentMoney() {
                axios.get(this.$root.$data.apiUrl + '/dashboard/getSpentMoney', {
                    headers : {
                        'user' : this.$root.$data.userId
                    }
                })
                .then((response) => {
                    this.spentMoney = response.data + ' ' + this.$root.$data.currency;
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
