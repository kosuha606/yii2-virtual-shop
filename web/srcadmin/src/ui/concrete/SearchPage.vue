<template>
    <div>
        <p>
            На этой странице можно выполнить настройки поискового механизма
        </p>
        <table class="table table-bordered table-striped" style="width: 200px">
            <tr>
                <th>
                    Документов в индексе
                </th>
                <td>
                    {{ docsCount }}
                </td>
            </tr>
        </table>
        <div>
            <button class="btn btn-default" @click="onReindex">
                Переиндексировать
            </button>
        </div>
    </div>
</template>

<script>
    import Request from '../../objects/Request';

    export default {
        name: "SearchPage",
        props: ['value', 'label', 'props'],
        data() {
            return {
                docsCount: 0,
            }
        },
        mounted() {
            this.docsCount = this.props.numDocs;
        },
        methods: {
            onReindex() {
                if (!confirm('Вы уверены?')) {
                    return;
                }

                Request.post('/admin/search/reindex', {}, () => {
                    console.log('ok');
                    window.location.reload();
                });
            }
        }
    }
</script>

<style scoped>

</style>