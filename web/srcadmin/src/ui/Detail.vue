<template>
    <div>
        <div>
            <button @click="back" class="btn btn-default">
                <i class="fa fa-arrow-left"></i>
                Назад
            </button>
        </div>

        <hr>

        <div v-if="alertMessage" :class="{'alert': 1, 'alert-success': isSuccess, 'alert-danger': isError}">
            <div v-html="alertMessage"></div>
        </div>

        <p>&nbsp;</p>

        <div class="form">
            <slot v-bind:default="formData">
                <template v-for="(component, index) in formData">
                    <div class="form-row">
                        <detail-field
                                :component="component"
                        >
                        </detail-field>
                    </div>
                </template>
            </slot>
        </div>

        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <div>
            <button @click="save" class="btn btn-success">
                <i class="fa fa-save"></i>
                Сохранить
            </button>
            <button @click="apply" class="btn btn-primary">
                Применить
            </button>
            <button v-if="this.id" @click="deleteItem" class="btn btn-danger">
                Удалить
            </button>
        </div>

        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>

    </div>
</template>

<script>
    import {clone, each} from 'lodash';
    import DetailField from './DetailField';

    export default {
        name: "Detail",
        props: {
            id: [String, Number],
            defaultFormData: Object,
            saveUrl: String,
            detailComponents: Array,
            component: this,
            item: Object
        },
        components: {
            DetailField,
        },
        created() {
            each(this.detailComponents, (element) => {
                this.formData[element.field] = element;
            });
            this.$forceUpdate();
        },
        computed: {
            componentsIndex() {
                let result = {};
                each(this.detailComponents, (item) => {
                    result[item.field] = item;
                });

                return result;
            },
            listUrl() {
                return this.saveUrl.replace('detail', 'list');
            },
            deleteUrl() {
                return this.saveUrl.replace('detail', 'delete');
            }
        },
        data() {
            return {
                isSuccess: false,
                isError: false,
                alertMessage: '',
                formData: {}
            }
        },
        methods: {
            checkInput() {
                console.log('input');
            },
            back() {
                location.href=this.listUrl+'?list=on';
            },
            save() {
                this.uploadToServer(() => {
                    this.back();
                });
            },
            apply() {
                this.uploadToServer();
            },
            processError(errors) {
                let message = '';
                each(errors, (error) => {
                    message += error+"<br>";
                });
                this.alert(message, 'error');
            },
            deleteItem() {
                if (!confirm('Вы уверены?')) {
                    return;
                }

                this.$root.startProgress();
                $.ajax({
                    method: 'POST',
                    url: this.saveUrl,
                    data: {
                        id: this.id,
                        delete: true
                    }
                }).done((response) => {
                    if (response.result) {
                        this.back();
                    } else {
                        this.alert('Ошибка удаления', 'error');
                    }
                    this.$root.stopProgress();
                }).fail(() => {

                    this.$root.stopProgress();
                });
            },
            alert(message, type) {
                this.isError = false;
                this.isSuccess = false;

                if (type === 'success') {
                    this.isSuccess = true;
                } else {
                    this.isError = true;
                }

                this.alertMessage = message;
                this.$forceUpdate();
            },
            uploadToServer(afterSuccess) {
                this.$root.startProgress();
                var serverData = {};
                if (this.id) {
                    serverData.id = this.id;
                }
                each(this.formData, (item) => {
                    serverData[item.field] = item.value;
                });
                each(this.defaultFormData, (item, fieldName) => {
                    serverData[fieldName] = item
                });
                $.ajax({
                    method: 'POST',
                    url: this.saveUrl,
                    data: serverData
                }).done((response) => {
                    if (!response.result) {
                        this.processError(response.errors);
                    } else {
                        this.alert('Успешно сохранено', 'success');
                        if (afterSuccess) {
                            afterSuccess();
                        } else {
                            location.href = this.saveUrl + '?id='+response.model.id;
                        }
                    }
                    this.$root.stopProgress();
                }).fail(() => {

                    this.$root.stopProgress();
                });
            }
        }
    }
</script>

<style scoped>

</style>