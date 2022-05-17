<template>
    <Card class="lg:min-w-min sm:min-w-full lg:max-w-30rem">
        <template #header>
            <div class="flex align-items-center justify-content-center">
                <File :reference="picture.file_reference"/>
            </div>
        </template>

        <template #title>
            <div class="p-3">
                {{ picture.author }}
            </div>
        </template>

        <template #content>
            <div class="p-3">
                {{ picture.description }}
            </div>
        </template>
    </Card>
</template>

<script>
    import Card from 'primevue/card/sfc';
    import File from "../../file/components/File";

    export default {
        name: "Picture",
        props: {
            picture: Object,
        },
        components: {
            Card,
            File,
        }
    }
</script>

<style scoped>

</style>