<template>
    <div id="DirectoryComponent">
        <div class="main_container">
            <div class="main_container--header">
                <span class="main_container--header_filename">Наименование файла</span>
                <span class="main_container--header_filesize">Размер файла</span>
                <span class="main_container--header_filedate">Дата загрузки</span>
                <span class="main_container--header_fileactions"></span>
            </div>
            <div class="main_container--content">
                <DirectoryFilePreviewComponent v-for="file in files"
                                               v-bind:key="file.title"
                                               :title="file.title"
                                               :format="file.format"
                                               :size="file.size"
                                               :uploadDate="file.uploadDate"
                                               @fileEvent="getFiles"/>
            </div>
        </div>
    </div>
</template>

<script>
    import DirectoryFilePreviewComponent from "@/components/FileManagerComponents/DirectoryFilePreviewComponent";
    import axios from 'axios';

    export default {
        name: "DirectoryComponent",
        components: {
            DirectoryFilePreviewComponent
        },
        data() {
            return {
                files: []
            }
        },
        mounted() {
            this.getFiles();
        },
        methods: {
            getFiles() {
                axios({
                    url: '/API/get_files.php',
                    method: 'POST',
                    data: {
                        path: 'files'
                    }
                })
                    .then(resp => {
                        this.files = resp.data.files;
                    })
            }
        }
    }
</script>

<style scoped>
    .main_container {
        border: 1px solid #b5b5b5;
    }

    .main_container--header {
        border-bottom: 1px solid #b5b5b5;
        display: flex;
        padding: 5px 0;
        width: 100%;
    }

    .main_container--header_filename {
        width: 40%;
    }

    .main_container--header_filesize {
        width: 10%;
    }

    .main_container--header_filedate {
        width: 20%;
    }

    .main_container--header_fileactions {
        width: 30%;
    }

    .main_container--content {
        padding: 5px 0;
    }
</style>