<template>
    <div class="FileViewerComponent">
        <div class="viewer_container">
            <div class="viewer_container--header">
                <span class="viewer_container--header_filename">{{ $route.params.name }}</span>
                <router-link to="/" class="back">Назад</router-link>
            </div>
            <div class="viewer_container--content">
                <p v-for="content in contents" v-bind:key="content"> {{ content }} </p>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "FileViewerComponent",
        data () {
            return {
                contents: ''
            }
        },
        mounted() {
            axios({
                url: '/API/get_file.php',
                method: 'POST',
                data: {
                    directory: 'files',
                    name: this.$route.params.name
                }
            })
                .then(resp => {
                    this.contents = resp.data.content;
                })
        }
    }
</script>

<style scoped>
    .back {
        margin-left: 20px;
    }
    .viewer_container {
        border: 1px solid #b5b5b5;
    }
    .viewer_container--header {
        border-bottom: 1px solid #b5b5b5;
        padding: 10px 20px;
    }
    .viewer_container--content {
        padding: 10px 20px;
        text-align: start;
    }
</style>