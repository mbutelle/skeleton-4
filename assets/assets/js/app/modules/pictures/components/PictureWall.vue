<template>
    <div class="flex flex-wrap card-container gap-3 p-3 justify-content-around">
        <Picture v-for="picture in pictures" :picture="picture"/>
    </div>
</template>

<script>
    import Picture from "./Picture";
    import PictureService from "../services/PictureService";
    import Criteria from "../../../utils/query/Criteria";
    import Scroll from "../../../utils/scroll/Scroll";

    export default {
        name: "PictureWall",
        picture_service: null,
        components: {
            Picture
        },
        data: function () {
            return {
                current_offset: 0,
                limit: 10,
                is_ended: false,
                pictures: []
            };
        },
        methods: {
            loadPictures() {
                if (this.is_ended) {
                    return;
                }

                return this.picture_service.search(new Criteria({limit: this.limit, offset: this.current_offset, created_at_sort: -1})).then(response => {
                    if (0 === response.data.length) {
                        this.is_ended = true;

                        return;
                    }

                    this.pictures = this.pictures.concat(response.data);
                });
            },
            loadNextPictures() {
                this.current_offset += this.limit;
                this.loadPictures();
            },
            addPicture(picture) {
                this.pictures.unshift(picture);
            }
        },
        mounted() {
            this.loadPictures();
        },
        created() {
            this.picture_service = new PictureService(this.axios);
        }
    }
</script>

<style scoped>

</style>