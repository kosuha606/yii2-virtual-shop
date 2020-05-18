<template>
    <div>
        <vue-table
                :id="id"
                :sync-url="fetchData"
                :cell-components="vueTableFields"
                :filter-components="filterComponents"
                :mass-operation-components="massOperationComponents"
        >
        </vue-table>
    </div>
</template>

<script>
    import {VueTable} from 'vue_table';

    export default {
        name: "List",
        props: {
            id: String,
            entityUrl: String,
            cellComponents: Array,
            filterComponents: Array,
            massOperationComponents: Array,
        },
        components: {
            VueTable
        },
        computed: {
            vueTableFields() {
                var vm = this;
                let result = [];
                this.cellComponents.forEach(function(i) {
                    var props = i.props ? i.props : {};
                    if (i.props && i.props.link) {
                        props.link = function(item) {
                            return vm.entityUrl+'/detail?id='+item.id;
                        };
                    }

                    if (i.props && i.props.url) {
                        var url = i.props.url;
                        props.url = function(item) {
                            return url.toString().replace('%id%', item.id);
                        };
                    }

                    result.push({
                        component: i.component,
                        field: i.field,
                        label: i.label,
                        props: props,
                    })
                });

                return result;
            }
        },
        methods: {
            fetchData(success, requestData) {
                var reqData = {};

                if (requestData) {
                    reqData = {};
                    reqData.page = requestData.pagination.page;
                    reqData.per_page = requestData.pagination.itemsPerPage;
                    reqData.sortField = requestData.sort.field;
                    reqData.sortDir = requestData.sort.direction;
                    reqData.filter = requestData.filters;
                }

                this.$root.startProgress();
                $.ajax({
                    method: 'GET',
                    url: this.entityUrl+'/list',
                    data: reqData
                }).done((response) => {
                    if (success) {
                        success({
                            data: {
                                items: response.models,
                                total: response.pagination.totals
                            }
                        })
                    }
                    this.$root.stopProgress();
                }).fail(() => {
                    alert('server error');
                    this.$root.stopProgress();
                })
            }
        }
    }
</script>

<style scoped>

</style>