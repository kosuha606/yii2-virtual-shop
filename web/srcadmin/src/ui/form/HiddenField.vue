<template>
    <div>
        <input class="form-control" :placeholder="props ? props.placeholder : ''" @keyup="onChange" type="hidden" :value="value">
    </div>
</template>

<script>
    export default {
        name: "HiddenField",
        props: ['value', 'label', 'props'],
        methods: {
            onChange(e) {
                this.$emit('input', e.target.value);
            }
        }
    }
</script>

<style scoped>

</style>
