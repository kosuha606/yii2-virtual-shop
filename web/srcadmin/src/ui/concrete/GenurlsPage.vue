<template>
    <div>
        <table style="width: 200px" class="table table-bordered">
            <tr>
                <td>
                    Кол-во url
                </td>
                <td>
                    {{ props.urlsCnt }}
                </td>
            </tr>
        </table>
        <button @click="onGenerate" class="btn btn-default">
            Генерировать
        </button>
    </div>
</template>

<script>
    import Request from '../../objects/Request';

    export default {
        name: "GenurlsPage",
        props: ['value', 'label', 'props'],
        methods: {
            onGenerate() {
                if (!confirm('Вы уверены?')) {
                    return;
                }

                Request.post('/admin/seo_url/regen', {}, () => {
                    console.log('ok');
                    window.location.reload();
                });
            }
        }
    }
</script>

<style scoped>

</style>