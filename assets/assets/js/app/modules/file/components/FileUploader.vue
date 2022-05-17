<template>
    <div>
        <div class="field">
            <FileUpload
                ref="fu"
                mode="advanced"
                name="file"
                :url="path"
                accept="image/*"
                :max-FileSize="2000000"
                :fileLimit="1"
                invalid-file-size-message="{0}: Le fichier est trop gros, {1} maximum."
                invalid-file-type-message="{0}: Type de fichier invalide. Types autorisés: {1}."
                @select="onSelect" @upload="onUpload"
                :auto="auto" :chooseLabel="label" :showUploadButton="false" :showCancelButton="false"
            ></FileUpload>
            <small>Poids max: 2Mo</small>
        </div>
    </div>
</template>

<script>
    import FileUpload from 'primevue/fileupload/sfc';
    import Image from 'primevue/image/sfc';

    export default {
        name: "FileUploader",
        props: {
            label: String,
            auto: {
                type: Boolean,
                default: false,
            },
            type: String,
            fileStyle: {
                type: Object,
                default: {}
            },
            preview: String
        },
        data: function () {
            return {
                imagePreview: null,
                path: '/api/file',
                file: null,
            };
        },
        components: {
            Image,
            FileUpload,
        },
        methods: {
            onSelect(event) {
                this.imagePreview = event.files[0].objectURL;
                this.$emit('file-chosen', event.files[0]);
            },
            onUpload(event) {
                this.file = JSON.parse(event.xhr.response);
                this.imagePreview = null;

                this.$emit('file-uploaded', this.file);
                this.file = null;
            },
            upload() {
                this.$refs.fu.upload();
            }
        }
    }
</script>

<style scoped>

</style>