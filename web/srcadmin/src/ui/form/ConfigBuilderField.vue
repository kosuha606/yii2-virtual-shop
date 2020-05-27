<template>
    <div>
        <label for="">
            {{ label }}
        </label>
        <div>
            <div class="constructor-wrapper" v-for="(item, itemIndex) in data">
                <button @click="deleteItem(itemIndex)" class="btn btn-danger">
                    &times;
                </button>
                <div class="constructor-field">
                    <input v-model="item.code" type="text" class="form-control">
                </div>
                <div class="constructor-field">
                    <select v-model="item.type" class="form-control">
                        <option value="" v-for="(type, index) in inputTypes" :value="type.type">{{ type.label }}</option>
                    </select>
                </div>
                <div class="constructor-field">
                    <component
                        v-if="item.type"
                        :is="item.type"
                        v-model="item.value"
                        :props="item.props"
                    >
                    </component>
                </div>
            </div>

            <div>
                <hr>
                <button @click="addItem" class="btn btn-primary">+</button>
            </div>
        </div>
    </div>
</template>

<script>
    import {each, cloneDeep} from 'lodash';

    export default {
        name: "ConfigBuilderField",
        props: ['value', 'label', 'props'],
        watch: {
            data: {
                handler() {
                    let result = cloneDeep(this.data);
                    each(result, (item) => {
                        delete(item.props);
                    });

                    this.$emit('input', JSON.stringify(result));
                },
                deep: true,
            }
        },
        created() {
            if (this.props && this.props.inputTypes) {
                this.defaultComponent = this.props.inputTypes[0].type;
                this.defaultProps = this.props.inputTypes[0].props;
                this.inputTypes = this.props.inputTypes;
            }

            try {
                this.data = JSON.parse(this.value);
            } catch (e) {
                if (typeof(this.value) === 'object') {
                    this.data = this.value;
                } else {
                    console.log('no data for constructor');
                }
            }

            each(this.data, (item) => {
                item.props = this.defaultProps;
            });

            if (this.data) {
                this.counter = this.data.length;
            }
        },
        data() {
            return {
                counter: 0,
                defaultComponent: 'InputField',
                defaultProps: {},
                data: [],
                // configTypes: {
                //     'value': 'Значение',
                //     'array': 'Массив',
                //     'object': 'Объект',
                // },
                inputTypes: [
                    {
                        type: 'InputField',
                        label: 'Текст строка',
                        props: {},
                    },
                    {
                        type: 'TextField',
                        label: 'Текст область',
                        props: {},
                    },
                    {
                        type: 'HtmlField',
                        label: 'HTML',
                        props: {},
                    },
                    {
                        type: 'RedactorField',
                        label: 'Редактор',
                        props: {},
                    },
                    {
                        type: 'ImageField',
                        label: 'Изображение',
                        props: {},
                    },
                    {
                        type: 'ConfigBuilderField',
                        label: 'Конфигуратор',
                        props: {},
                    },
                ]
            }
        },
        methods: {
            deleteItem(itemIndex) {
                try {
                    this.data.splice(itemIndex, 1);
                    this.$forceUpdate();
                } catch (e) {
                    this.data = [];
                }
            },
            addItem() {
                this.counter++;
                try {
                    this.data.push({
                        code: this.data.length+1,
                        type: this.defaultComponent,
                        value: '',
                        props: this.defaultProps,
                    });
                    this.$forceUpdate();
                } catch (e) {
                    this.data = [];
                    this.addItem();
                }
            },
            onChange(e) {
                this.$emit('input', e.target.value);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .constructor-wrapper {
        padding: 10px 10px 10px 20px;
        border: solid 1px #ccc;
        margin-bottom: 10px;

        &:last-child {
            margin-bottom: 0;
        }

        select {
            max-width: 400px;
        }

        label {
            display: none;
            height: 0;
            position: absolute;
        }

        .btn-danger,
        .constructor-field {
            margin-bottom: 10px;
        }

        .constructor-field:last-child {
            margin-bottom: 0;
        }
    }
</style>