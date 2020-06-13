<template>
    <div>

        <div class="content-header">
        </div>

        <div class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>Динамика заказов</h3>
                            </div>
                            <div class="card-body">

                                <canvas id="myChart" width="400" height="150"></canvas>

                            </div>
                            <div class="card-footer clearfix">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Всего статей</h3>
                            </div>
                            <div class="card-body">
                                {{ $pluralize(props.articles_count, 'нет статей', '%d статья', '%d статьи', '%d статьей') }}
                            </div>
                            <div class="card-footer clearfix">
                                <a class="btn btn-primary" href="/admin/article/list">
                                    Статьи
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                            <h3>Всего заказов</h3>
                            </div>
                            <div class="card-body">
                                {{ $pluralize(props.orders_count, 'нет заказов', '%d заказ', '%d заказа', '%d заказов') }}
                            </div>
                            <div class="card-footer clearfix">
                                <a class="btn btn-primary" href="/admin/order/list">
                                    Заказы
                                </a>
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
                                {{ $pluralize(props.products_count, 'нет продуктов', '%d продукт', '%d продукта', '%d продуктов') }}
                            </div>
                            <div class="card-footer clearfix">
                                <a class="btn btn-primary" href="/admin/product/list">
                                    Продукты
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>В поиске</h3>
                            </div>
                            <div class="card-body">
                                {{ $pluralize(props.search_index_count, 'нет записей', '%d запись', '%d записи', '%d записей') }}
                            </div>
                            <div class="card-footer clearfix">
                                <a class="btn btn-primary" href="/admin/search/detail">
                                    Индекс
                                </a>
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
        mounted() {
            this.loadChart();
        },
        methods: {
            loadChart() {
                var ctx = document.getElementById('myChart');
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: this.props.orders_dynamic.dates,
                        datasets: [{
                            label: 'Кол-во заказов',
                            data: this.props.orders_dynamic.values,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>