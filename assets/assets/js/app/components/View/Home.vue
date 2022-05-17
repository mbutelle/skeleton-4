<template>
    <div class="home page min-h-screen">
        <div class="bg-white flex flex-column w-full h-15rem justify-content-around align-items-center shadow-1 text-center">
            <h1>{{ $filters.translate('wording.header.title') }}</h1>
            <Button :label="button_label" @click="$refs.npd.open();"/>
        </div>

        <div class="min-h-screen">
            <PictureWall ref="pw"/>
        </div>

        <Button v-if="current_position > 240" icon="pi pi-plus" class="fixed bottom-0 right-0 mb-5 mr-5 p-button-rounded p-button-lg" @click="$refs.npd.open();"/>

        <NewPictureDialog ref="npd" @pictureSaved="$refs.pw.addPicture($event)"/>
    </div>
</template>

<script>
    import Button from 'primevue/button/sfc';

    import PictureWall from "../../modules/pictures/components/PictureWall";
    import NewPictureDialog from "../../modules/pictures/components/NewPictureDialog";
    import Scroll from "../../utils/scroll/Scroll";

    export default {
        name: "Home",
        components: {
            Button,
            NewPictureDialog,
            PictureWall,
        },
        data: function () {
            return {
                current_position: 0,
            };
        },
        computed: {
            button_label: () => {
                return this.$filters.translate('wording.header.button');
            }
        },
        created() {
            let scroll = new Scroll();
            this.current_position = scroll.currentPosition();

            scroll.onScroll((position) => {
                this.current_position = position;
            });

            scroll.whenReachBottom(() => {
                this.$refs.pw.loadNextPictures();
            })
        }
    }
</script>

<style scoped>
</style>