<template>
    <div class="overlay" v-if="loading">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
</template>

<script>
    export default {
        name: "LoadingComponent",
        props: ['loading']
    }
</script>

<style scoped>

</style>
