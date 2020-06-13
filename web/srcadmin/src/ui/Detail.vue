<template>
    <div>
        <div v-if="!detailConfig.noback">
            <button @click="back" class="btn btn-default">
                <i class="fa fa-arrow-left"></i>
                Назад
            </button>
        </div>

        <hr>

        <div v-if="alertMessage" :class="{'alert': 1, 'alert-success': isSuccess, 'alert-danger': isError}">
            <div v-html="alertMessage"></div>
        </div>


        <ul v-if="!detailConfig.notabs" class="nav nav-tabs">
            <li class="nav-item active">
                <a class="nav-link active" data-toggle="tab" href="#description">Основное</a>
            </li>
            <template v-if="additionalComponents && item.id">
                <li v-for="component in additionalComponents" class="nav-item">
                    <a class="nav-link" data-toggle="tab" :href="'#'+component.tabLink">{{ component.tab }}</a>
                </li>
            </template>
        </ul>

        <div class="tab-content">
            <p>&nbsp;</p>

            <div class="tab-pane fade active show" id="description">
                <div class="form">
                    <slot v-bind:default="formData">
                        <template v-for="(component, index) in formData">
                            <div>
                                <detail-field
                                        :key="'main_data_field'+index"
                                        :component="component"
                                >
                                </detail-field>
                            </div>
                        </template>
                    </slot>
                </div>
            </div>


            <template v-if="additionalComponents && item.id">
                <div v-for="(component, additionalIndex) in additionalComponents" class="tab-pane fade" :id="component.tabLink">
                    <div v-if="component.type !== 'one.to.one'">

                        <div v-for="(dataComponent, dataIndex) in component.dataConfig">
                            <button v-if="!component.isViewOnly" @click="deleteAdditionalData(additionalIndex, dataIndex)" type="button" class="btn btn-danger">Удалить</button>
                            <template v-for="(inDataComponent, index) in dataComponent">
                                <div>
                                    <detail-field
                                            :key="'data_component'+index"
                                            :component="inDataComponent"
                                    >
                                    </detail-field>
                                </div>
                            </template>
                            <hr>
                        </div>
                        <button v-if="!component.isViewOnly" @click="addAdditionalData(additionalIndex, component.initialConfig)" type="button" class="btn btn-primary" style="margin-top: 10px;">Добавить</button>

                    </div>
                    <div v-else>
                        <div v-for="dataComponent in component.dataConfig">
                            <template v-for="(inDataComponent, index) in dataComponent">
                                <div>
                                    <detail-field
                                            :key="'data_component'+index"
                                            :component="inDataComponent"
                                    >
                                    </detail-field>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <p>&nbsp;</p>

        <div v-if="!detailConfig.nobuttons">
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

    </div>
</template>

<script>
    import {clone, cloneDeep, each} from 'lodash';
    import DetailField from './DetailField';

    export default {
        name: "Detail",
        props: {
            id: [String, Number],
            defaultFormData: Object,
            detailConfig: Object,
            saveUrl: String,
            detailComponents: Array,
            additionalComponents: Array,
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
        mounted() {
            $(document).ready(() => {
                let hash = window.location.hash;

                if (hash) {
                    hash = hash.replace('-tab', '');
                    $('[href="'+hash+'"]').trigger('click');
                }

                $('.nav-tabs a').on('shown.bs.tab', function (e) {
                    window.location.hash = e.target.hash+'-tab';
                })
            });
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
                $("html, body").animate({ scrollTop: 0 }, "slow");
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
            addAdditionalData(additionalIndex, data) {
                this.additionalComponents[additionalIndex]['dataConfig'].push(cloneDeep(data));
                this.$forceUpdate();
            },
            deleteAdditionalData(additionalIndex, dataIndex) {
                this.additionalComponents[additionalIndex]['dataConfig'].splice(dataIndex, 1);
                this.$forceUpdate();
            },
            appendAdditionalData(serverData) {
                var additionalServerData = {};

                each(this.additionalComponents, (item) => {
                    if (item.isViewOnly) {
                        return;
                    }

                    if (!additionalServerData[item.relationClass]) {
                        additionalServerData[item.relationClass] = [];
                    }

                    each(item.dataConfig, (dataItem) => {
                        var serverItem = {};

                        each(dataItem, (fieldItem) => {
                            serverItem[fieldItem.field] = fieldItem.value;
                        });

                        additionalServerData[item.relationClass].push(serverItem);
                    });
                });

                serverData.secondary_form = additionalServerData;

                return serverData;
            },
            appendAdditionalDataFromReqularComponents(formData, serverData)
            {
                each(formData, (item) => {
                    if (!item.additionalValues) {
                        return;
                    }

                    if (!serverData.secondary_form) {
                        return;
                    }

                    if (!serverData.secondary_form[item.additionalValues.relationClass]) {
                        serverData.secondary_form[item.additionalValues.relationClass] = [];
                    }

                    each(item.additionalValues.items, (dataItem) => {
                        var serverItem = {};

                        each(dataItem, (fieldItem) => {
                            serverItem[fieldItem.field] = fieldItem.value;
                        });

                        serverData.secondary_form[item.additionalValues.relationClass].push(serverItem);
                    });
                });

                return serverData;
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

                if (this.item.id) {
                    serverData = this.appendAdditionalData(serverData);
                }

                serverData = this.appendAdditionalDataFromReqularComponents(this.formData, serverData);
                if (this.additionalComponents) {
                    each(this.additionalComponents, (additionalComponentItems) => {
                        each(additionalComponentItems.dataConfig, (additionalComponentItem) => {
                            serverData = this.appendAdditionalDataFromReqularComponents(additionalComponentItem, serverData);
                        });
                    });
                }

                $.ajax({
                    method: 'POST',
                    url: this.saveUrl,
                    data: serverData
                }).done((response) => {
                    if (!response.result) {
                        this.processError(response.errors);
                    } else {
                        if (afterSuccess) {
                            afterSuccess();
                        } else {
                            let url = this.saveUrl + '?id='+response.model.id;
                            if (location.hash) {
                                url = url + '#' + location.hash;
                            }
                            location.reload();
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