<template>
    <div class="virtual-form-row">
        <component
                :is="component.component"
                :field="component.field"
                :props="component.props"
                :label="component.label"
                v-model="component.value"
                :additional-values="component.additionalValues"
                @additionalchange="onAdditionalChange"
        ></component>
    </div>
</template>

<script>
    export default {
        name: "DetailField",
        props: ['component'],
        methods: {
            onAdditionalChange(value) {
                this.component.additionalValues = value;
            }
        }
    }
</script>

<style scoped>

</style>