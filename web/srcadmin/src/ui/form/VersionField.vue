<template>
    <div>
        <div>
            Версия {{ value }}
        </div>
        <div>
            <button @click="onRestore" class="btn btn-default">
                Восстановить
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "VersionField",
        props: ['value', 'label', 'props'],
        methods: {
            onRestore() {
                $.ajax({
                    method: 'POST',
                    url: '/admin/version-restore',
                    data: {
                        id: this.props.id
                    },
                    success(resp) {
                        if (resp.result) {
                            alert('Успешно восстановлено');
                            window.location.reload();
                        } else {
                            alert('Ошибка восстановления');
                        }

                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>