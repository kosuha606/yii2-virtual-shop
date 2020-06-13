<template>
    <div>

        <div class="content-header">
        </div>

        <div class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Всего статей</h3>
                            </div>
                            <div class="card-body">
                                {{ props.articles_count }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                            <h3>Всего заказов</h3>
                            </div>
                            <div class="card-body">
                            {{ props.orders_count }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Всего продуктов</h3>
                            </div>
                            <div class="card-body">
                                {{ props.products_count }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>В поиске</h3>
                            </div>
                            <div class="card-body">
                                {{ props.search_index_count }} записей
                            </div>
                        </div>
                    </div>
                </div>

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