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

                                <canvas id="myChart"></canvas>

                            </div>
                            <div class="card-footer clearfix">
                                <button @click="changeNowOffset(-7)" class="btn btn-primary">
                                    <i data-v-02c5127a="" class="fa fa-arrow-left"></i>
                                    Назад -7 дней
                                </button>
                                <button @click="changeNowOffset(+7)" class="btn btn-primary">
                                    Вперед +7 дней
                                    <i data-v-02c5127a="" class="fa fa-arrow-right"></i>
                                </button>
                                <b v-if="nowOffset !== 0">
                                    Смещение:
                                    {{ nowOffset }} дней
                                </b>
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
        data() {
            return {
                nowOffset: 0,
                orders_dynamic: this.props.orders_dynamic
            }
        },
        watch: {
            nowOffset(value) {
                Request.get('/admin/dashboard/orders_chart', {
                    now_offset: value
                }, (resp) => {
                    if (resp.result) {
                        this.orders_dynamic = resp.data;
                        this.$forceUpdate();
                        this.loadChart();
                    }
                });
            }
        },
        mounted() {
            this.loadChart();
        },
        methods: {
            changeNowOffset(value) {
                this.nowOffset = this.nowOffset+value;
            },
            loadChart() {
                var ctx = document.getElementById('myChart');
                ctx.height = 200;
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: this.orders_dynamic.dates,
                        datasets: [{
                            label: 'Кол-во заказов',
                            data: this.orders_dynamic.values,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
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