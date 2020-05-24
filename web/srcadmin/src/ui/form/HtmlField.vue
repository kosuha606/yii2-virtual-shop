<template>
    <div>
        <label for="">
            {{ label }}
        </label>
        <editor v-model="content" @init="editorInit" lang="html" theme="chrome" width="600" height="400"></editor>
    </div>
</template>

<script>
    export default {
        name: "HtmlField",
        props: ['value', 'label', 'props'],
        components: {
            editor: require('vue2-ace-editor'),
        },
        watch: {
            content(value) {
                this.$emit('input', value);
            }
        },
        data() {
            return {
                content: '',
            }
        },
        mounted() {
            this.content = this.value;
        },
        methods: {
            editorInit: function () {
                require('brace/ext/language_tools') //language extension prerequsite...
                require('brace/mode/html')
                // require('brace/mode/javascript')
                // require('brace/mode/less')
                require('brace/theme/chrome')
                // require('brace/snippets/javascript')
            }
        }
    }
</script>

<style scoped>

</style>