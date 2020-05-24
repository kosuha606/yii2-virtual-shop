<template>
    <div :class="className ? className : 'image-field'">
        <label for="">
            {{ label }}
        </label>
        <div class="image" v-if="!filePath">
            <label :for="'upload_doc_file'+_uid">
                <input @change="onUpload" :id="'upload_doc_file'+_uid" name="UploadImageForm[file]" type="file" :multiple="multiple">
            </label>
            <i class="fa fa-image"></i>
        </div>
        <div v-if="filePath">
            <img @click="onChangeImage" class="thumbnail" :src="'/'+filePath" alt="">
        </div>
    </div>
</template>

<script>
    import Request from '../../objects/Request';
    import {each} from 'lodash';

    export default {
        name: "UploadImage",
        props: ['multiple', 'label', 'value', 'className', 'props'],
        data() {
            return {
                filePath: null,
            };
        },
        mounted() {
            setTimeout(() => {
                if (this.value) {
                    this.filePath = this.value;
                }
            }, 100);
        },
        methods: {
            onChangeImage() {
                this.filePath = null;
            },
            onUpload(e) {
                const formData = new FormData();
                each($(e.target)[0].files, (file) => {
                    formData.append('file', file);
                });
                Request.file('/file/upload-image', formData, (response) => {
                    this.filePath = response.file;
                    this.$emit('input', this.filePath);
                });
            }
        }
    }

</script>

<style scoped>
    .image-field .image input {
        display: none;
    }
    .image-field .image {
        cursor: pointer;
        display: flex;
        height: 200px;
        align-items: center;
        width: 300px;
        justify-content: center;
        text-align: center;
        border-radius: 10px;
        background: #aaa;
    }
    .image-field {
        position: relative;
    }
    .image-field .image label {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    .image-field img {
        max-width: 300px;
    }
</style>