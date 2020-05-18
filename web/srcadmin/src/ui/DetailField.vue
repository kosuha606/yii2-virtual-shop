<template>
    <div>
        <component
                :is="component.component"
                :field="component.field"
                :props="component.props"
                :label="component.label"
                v-model="component.value"
        ></component>
    </div>
</template>

<script>
    export default {
        name: "DetailField",
        props: ['component'],
    }
</script>

<style scoped>

</style>