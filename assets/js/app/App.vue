<template>
    <div id="main-app">
        <MainContainer></MainContainer>
        <Toast></Toast>
    </div>
</template>

<script>
    import MainContainer from "./MainContainer";
    import Toast from 'primevue/toast';

    export default {
        name: "App",
        components: {
            MainContainer,
            Toast
        }
    }
</script>