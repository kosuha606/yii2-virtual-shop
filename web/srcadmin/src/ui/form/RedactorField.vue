<template>
    <div>
        <label for="">
            {{ label }}
        </label>
        <ckeditor id="redactor" :config="editorConfig" :editor="editor" v-model="content"></ckeditor>
    </div>
</template>

<script>
    import CKEditor from '@ckeditor/ckeditor5-vue';
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import {clone} from 'lodash';

    export default {
        name: "RedactorField",
        props: ['value', 'label', 'props'],
        components: {
            ckeditor: CKEditor.component,
        },
        created() {
            if (this.value) {
                this.content = clone(this.value);
            }
        },
        watch: {
            content(value) {
                this.$emit('input', value);
            }
        },
        data() {
            return {
                content: '',
                editor: ClassicEditor,
                editorConfig: {
                    ckfinder: {
                        uploadName: 'test',
                        uploadUrl: '/file/ckeditor'
                    },
                    style: {
                        minHeight: '300px'
                    },
                    language: 'ru'
                }
            }
        },
    }
</script>

<style scoped>
</style>