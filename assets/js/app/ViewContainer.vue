<template>
    <div class="h-full bg-gray-100">
        <Home/>
    </div>
</template>

<script>
    import Home from "./components/View/Home";

    export default {
        name: "ViewContainer",
        components: {
            Home
        },
        data: function () {
            return {
                currentRoute: {name: "skeleton"}
            };
        },
        computed: {
            title: function () {
                return this.currentRoute.name;
            }
        },
        watch: {
            $route: function (to, from) {
                this.currentRoute = to;
            }
        }
    }
</script>