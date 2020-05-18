<template>
    <div>
        <label for="">
            {{ label }}
        </label>
        <textarea rows="10" class="form-control" :placeholder="props ? props.placeholder : ''" @keyup="onChange" >{{ value }}</textarea>
    </div>
</template>

<script>
    export default {
        name: "TextField",
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