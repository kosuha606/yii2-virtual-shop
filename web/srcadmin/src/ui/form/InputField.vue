<template>
    <div>
        <label for="">
            {{ label }}
        </label>
        <input class="form-control" :placeholder="props ? props.placeholder : ''" @keyup="onChange" type="text" :value="value">
    </div>
</template>

<script>
    export default {
        name: "InputField",
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
