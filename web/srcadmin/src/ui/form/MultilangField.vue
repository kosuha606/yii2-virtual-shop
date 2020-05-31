<template>
    <div style="margin-top: 10px;">

        <label for="">
            {{ label }}
        </label>

        <div>
            <div class="langs btn-group" role="group">
                <button @click="onChangeLang(langIndex)" :class="'btn btn-default'+(curLangIndex===langIndex ? ' active' : '')" v-for="(lang, langIndex) in props.langs">
                    {{ lang.code }}
                </button>
            </div>
        </div>

        <div v-for="(lang, langIndex) in props.langs">
            <template v-if="lang.is_default === '0'">
                <component
                        :key="'multiinput'+counter+field"
                        v-if="curLangIndex === langIndex"
                        :is="props.component"
                        :field="field"
                        :props="props"
                        :label="''"
                        v-model="langModel[lang.id]"
                        @input="test(lang.id, $event)"
                ></component>
            </template>
            <template v-else>
                <component
                        :key="'multiinput'+counter+field"
                        v-if="curLangIndex===langIndex"
                        :is="props.component"
                        :field="field"
                        :props="props"
                        :label="''"
                        v-model="mainModel"
                ></component>
            </template>
        </div>
    </div>
</template>

<script>
    import {each, clone} from 'lodash';

    export default {
        name: "MultilangField",
        props: ['value', 'label', 'props', 'field', 'additionalValues'],
        data() {
            return {
                counter: 1,
                mainModel: null,
                langModel: {},
                curLangIndex: 0,
            }
        },
        created() {
            this.mainModel = this.value;
        },
        mounted() {
            if (this.additionalValues) {
                each(this.additionalValues.items, (item) => {
                    let langId = 0;
                    let langValue = '';
                    each(item, (itemConfig) => {
                        if (itemConfig.field === 'lang_id') {
                            langId = itemConfig.value;
                        }
                        if (itemConfig.field === 'data') {
                            langValue = itemConfig.value;
                        }
                    });

                    this.langModel[langId] = clone(langValue);
                    this.$forceUpdate();
                    this.counter++;
                });
            }

            this.emitLangsChange();
        },
        watch: {
            mainModel(value) {
                this.onChange(value);
            },
        },
        methods: {
            test(langId, langValue) {
                this.langModel[langId] = langValue;
                this.$forceUpdate();
                this.emitLangsChange();
            },
            onChangeLang(langIndex) {
                this.curLangIndex = langIndex;
            },
            onChange(e) {
                this.$emit('input', e);
            },
            emitLangsChange() {
                let items = [];

                each(this.langModel, (item, index) => {
                    items.push([
                        {
                            field: 'entity_id',
                            value: this.props.entity_id,
                        },
                        {
                            field: 'entity_class',
                            value: this.props.entity_class,
                        },
                        {
                            field: 'lang_id',
                            value: index,
                        },
                        {
                            field: 'attribute',
                            value: this.field,
                        },
                        {
                            field: 'data',
                            value: clone(item),
                        }
                    ]);
                });

                this.$emit('additionalchange', {
                    items: items,
                    relationClass: this.props.relationClass,
                });
            }
        }
    }
</script>

<style scoped>

</style>