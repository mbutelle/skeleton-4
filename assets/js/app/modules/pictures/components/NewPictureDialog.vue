<template>
    <Dialog header="J'envoie ma photo de légume" :style="{width: '80%', minWidth: '450px'}" v-model:visible="is_open" :modal="true">
        <div class="field text-center">
            <FileUploader ref="fu" :fileStyle="{'max-width': '200px', 'max-height': '200px'}" type="picture" label="Mon légume" :class="{'p-invalid': is_submitted && v$.picture.file.$error}" @fileChosen="onFileChosen" @fileUploaded="onFileUploaded"/>
            <span v-if="v$.picture.file.$error && is_submitted">
                <span id="picture-file-error" v-for="(error, index) of v$.picture.file.$errors" :key="index">
                    <small class="p-error">{{error.$message}}</small>
                </span>
            </span>
        </div>

        <div class="field">
            <label>Signature</label>
            <InputText v-model.trim="picture.author" class="text-base text-color surface-overlay p-2 border-1 border-solid border-round appearance-none outline-none focus:border-primary w-full" :class="{'p-invalid': is_submitted && v$.picture.author.$error}"/>
            <span v-if="v$.picture.author.$error && is_submitted">
                <span id="picture-author-error" v-for="(error, index) of v$.picture.author.$errors" :key="index">
                    <small class="p-error">{{error.$message}}</small>
                </span>
            </span>
        </div>

        <div class="field">
            <label>Description</label>
            <Textarea v-model.trim="picture.description" :autoResize="true" rows="5" class="text-base text-color surface-overlay p-2 border-1 border-solid border-round appearance-none outline-none focus:border-primary w-full"/>
        </div>

        <template #footer>
            <Button label="Annuler" class="p-button-danger" @click="close"/>
            <Button label="Envoyer" class="p-button-success" @click="save"/>
        </template>
    </Dialog>
</template>

<script>
    import Dialog from 'primevue/dialog/sfc';
    import Button from 'primevue/button/sfc';
    import InputText from 'primevue/inputtext/sfc';
    import Textarea from 'primevue/textarea/sfc';

    import PictureService from "../services/PictureService";
    import FileService from "../../file/services/FileService";
    import FileUploader from "../../file/components/FileUploader";

    import { required, helpers } from "@vuelidate/validators";
    import { useVuelidate } from "@vuelidate/core";

    export default {
        name: "NewPictureDialog",
        setup: () => ({ v$: useVuelidate() }),
        components: {
            FileUploader,
            Dialog,
            Button,
            InputText,
            Textarea,
        },
        file_service: null,
        picture_service: null,
        validations() {
            return {
                picture: {
                    file: {
                        required: helpers.withMessage('Le fichier est obligatoire', required),
                    },
                    author: {
                        required: helpers.withMessage('La signature est obligatoire', required),
                    },
                    description: {}
                }
            }
        },
        data: function () {
            return {
                is_submitted: false,
                is_open: false,
                picture: {

                }
            };
        },
        methods: {
            open() {
                if (this.is_open) {
                    return;
                }

                this.is_open = true;
            },
            close() {
                if (!this.is_open) {
                    return;
                }

                this.clear();
                this.is_open = false;
            },
            clear() {
                this.v$.$reset();
                this.is_submitted = false;
                this.picture = {};
            },
            onFileChosen(file) {
                this.picture.file = file;
            },
            save() {
                this.is_submitted = true;

                this.v$.$validate();
                if (this.v$.$invalid) {

                    return;
                }

                this.$refs.fu.upload();
            },
            onFileUploaded(file) {
                if (!this.is_submitted || this.v$.$invalid) {
                    return;
                }

                this.picture.file = file.reference;

                this.picture_service.save(this.picture).then(response => {
                    let picture = {...this.picture};
                    picture.reference = response.data.reference;
                    picture.file_reference = picture.file;

                    this.$emit('picture-saved', picture);
                    this.close();
                });
            }
        },
        created() {
            this.file_service = new FileService(this.axios);
            this.picture_service = new PictureService(this.axios);
        }
    }
</script>

<style scoped>

</style>