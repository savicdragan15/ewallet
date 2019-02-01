<template>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Latest Orders</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="order in orders">
                            <td>{{ order.category.name }}</td>
                            <td>{{ order.amount }} {{ currency}}</td>
                            <td>{{ order.created_at | moment('DD.MM.Y. HH:mm')}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <loading :loading="loading"></loading>
            <!-- /.table-responsive -->
        </div>
    </div>
</template>

<script>
import loading from "../Helpers/LoadingComponent";

export default {
    name: "LatestOrdersComponent",
    props: ["orders", "currency", "loading"],
    components: {
        loading
    }
};
</script>

<style scoped>
</style>
