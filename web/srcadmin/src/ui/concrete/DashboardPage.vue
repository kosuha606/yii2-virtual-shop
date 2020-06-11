<template>
    <div>
        <h1>Рабочий стол</h1>

        <hr>

        <div class="row">
            <div class="col-md-6">
                <h3>Кол-во статей</h3>
                {{ props.articles_count }}
            </div>
            <div class="col-md-6">
                <h3>Кол-во заказов</h3>
                {{ props.orders_count }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h3>Кол-во продуктов</h3>
                {{ props.products_count }}
            </div>
            <div class="col-md-6">
                <h3>В поиске</h3>
                {{ props.search_index_count }} записей
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "DashboardPage",
        props: ['props'],
    }
</script>

<style scoped>

</style>