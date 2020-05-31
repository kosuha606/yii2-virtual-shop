<template>
    <div style="margin-top: 10px;">

        <label for="">
            {{ label }}
        </label>

        <div class="langs">
            <button class="btn btn-default" v-for="lang in props.langs">
                {{ lang.code }}
            </button>
        </div>

        <component
                :is="props.component"
                :field="field"
                :props="props"
                :label="''"
                v-model="mainModel"
        ></component>
    </div>
</template>

<script>
    export default {
        name: "MultilangField",
        props: ['value', 'label', 'props', 'field'],
        data() {
            return {
                mainModel: null,
            }
        },
        created() {
            this.mainModel = this.value;
        },
        watch: {
            mainModel(value) {
                this.onChange(value);
            }
        },
        methods: {
            onChange(e) {
                this.$emit('input', e);
            }
        }
    }
</script>

<style scoped>

</style>