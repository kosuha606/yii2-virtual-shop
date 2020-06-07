<template>
    <div>
        <h1>Настройки</h1>

        <hr>

        <ul class="nav nav-tabs">
            <li :class="'nav-item '+(tab === 'Основные' ? 'active' : '')" v-for="(item, tab) in props.settingsData">
                <a class="nav-link active" data-toggle="tab" :href="'#'+tab">{{ tab }}</a>
            </li>
        </ul>

        <div class="tab-content">
            <p>&nbsp;</p>

            <div :class="'tab-pane fade '+(tab === 'Основные' ? 'active in' : '')"
                 :id="tab"
                 v-for="(item, tab) in props.settingsData"
            >
                <template v-for="(field, index) in item">
                    <div class="form-row">
                        <detail-field
                                :key="'data_component'+index"
                                :component="field"
                        >
                        </detail-field>
                    </div>
                </template>
            </div>

        </div>



        <p>&nbsp;</p>
        <div>
            <button @click="onSave" class="btn btn-primary">Сохранить настройки</button>
        </div>
    </div>
</template>

<script>
    import Request from '../../objects/Request';

    export default {
        name: "SettingsPage",
        props: ['value', 'label', 'props'],
        methods: {
            onSave() {
                Request.post('/admin/settings/save', {
                    data: this.props.settingsData
                }, () => {
                    console.log('ok');
                    window.location.reload();
                });
            }
        }
    }
</script>

<style scoped>

</style>