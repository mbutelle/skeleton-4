<template>
    <div>
        <Image style="text-align: center; overflow: hidden" :style="imageStyle" :imageStyle="imageStyle" v-if="file !== null && -1 < image_types.indexOf(type)" :src="file" preview></Image>
        <Button v-if="file !== null && -1 < pdf_types.indexOf(type)" class="p-button-text" @click="openFile()">{{ pdf_label }}</Button>
    </div>
</template>

<script>
    import Image from 'primevue/image/sfc';
    import Button from "primevue/button/sfc";

    export default {
        name: "File",
        components: {
            Image,
            Button
        },
        props: {
            reference: String,
            imageStyle: {
                type: Object,
                default: {},
            },
            pdf_label: {
                type: String,
                default: 'Téléchargez le PDF'
            },
            pdf_name: {
                type: String,
                default: 'fichier.pdf'
            }
        },
        data: function () {
            return {
                path: '/api/file',
                fileHeader: null,
                fileContent: null,
                type: null,
                image_types: ['image/jpeg', 'image/png'],
                pdf_types: ['application/pdf']
            };
        },
        watch: {
            reference: function (to, from) {
                if (to === from) {
                    return;
                }

                this.loadFile();
            }
        },
        computed: {
            file: function () {
                return this.fileHeader + this.fileContent;
            }
        },
        methods: {
            openFile: function () {
                let pdf = window.open("");
                pdf.document.write("<iframe width='100%' height='100%' src='" + this.fileHeader + encodeURI(this.fileContent) + "'></iframe>")
            },
            loadFile: function () {
                this.axios.get([this.path, this.reference].join('/'))
                    .then((response => {
                        this.type = response.data.mime_type;
                        this.fileHeader = 'data:' + response.data.mime_type + ';base64,';
                        this.fileContent = response.data.content;
                    }))
                ;
            }
        },
        mounted() {
            this.loadFile();
        }
    }
</script>

<style scoped>

</style>