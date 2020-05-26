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
                        <option value="" v-for="(type, index) in inputTypes" :value="index">{{ type }}</option>
                    </select>
                </div>
                <div class="constructor-field">
                    <component
                        v-if="item.type"
                        :is="item.type"
                        v-model="item.value"
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
    export default {
        name: "ConfigBuilderField",
        props: ['value', 'label', 'props'],
        watch: {
            data: {
                handler() {
                    this.$emit('input', JSON.stringify(this.data));
                },
                deep: true,
            }
        },
        mounted() {
            try {
                this.data = JSON.parse(this.value);
            } catch (e) {
                console.log('no data for constructor');
            }
        },
        data() {
            return {
                data: [],
                // configTypes: {
                //     'value': 'Значение',
                //     'array': 'Массив',
                //     'object': 'Объект',
                // },
                inputTypes: {
                    'InputField': 'Текст строка',
                    'TextField': 'Текст область',
                    'HtmlField': 'HTML',
                    'RedactorField': 'Редактор',
                    'ImageField': 'Изображение',
                    'ConfigBuilderField': 'Конфигуратор',
                }
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
                try {
                    this.data.push({
                        code: 'new',
                        type: 'InputField',
                        value: '',
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