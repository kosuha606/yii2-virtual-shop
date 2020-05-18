<template>
    <div>
        <label for="">
            {{ label }}
        </label>
        <selectpicker
                :list="props.items"
                :multi="false"
                :tagged="false"
                :search="true"
                v-model="selectedValue"
                placeholder="Выберите значение"
                searchPlaceholder="Искать">
        </selectpicker>
    </div>
</template>

<script>
    export default {
        name: "SelectField",
        props: ['value', 'label', 'props'],
        data() {
            return {
                selectedValue: null
            }
        },
        mounted() {
            this.selectedValue = this.value;
        },
        watch: {
            selectedValue() {
                this.onChange();
            }
        },
        methods: {
            onChange() {
                this.$emit('input', this.selectedValue);
            }
        }
    }
</script>

<style scoped>

</style>
