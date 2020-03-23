<template>
    <div id="DirectoryFilePreviewComponent">
        <div class="row_wrapper">
            <div class="file_info">
                <span class="title" v-on:click="showFile">{{ title }}</span>
                <span class="size">{{ size }} кб</span>
                <span class="upload_date">{{ uploadDate }}</span>
                <div class="action-buttons_container">
                    <a :href="'/API/files/' + title" download>Скачать</a>
                    <ButtonComponent @buttonEvent="deleteFile" title="Удалить" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ButtonComponent from "@/components/FileManagerComponents/FileManagerButtonsComponents/ButtonComponent";
    import axios from 'axios';

    export default {
        name: "DirectoryFilePreviewComponent",
        components: {
            ButtonComponent
        },
        props: {
            title: String,
            format: String,
            size: String,
            uploadDate: String
        },
        methods: {
            showFile () {
                this.$router.push('/files/' + this.title);
            },
            deleteFile () {
                axios({
                    url: '/API/delete_file.php',
                    method: 'POST',
                    data: {
                        directory: 'files',
                        name: this.title
                    }
                })
                    .then(() => {
                        this.$emit('fileEvent');
                    })
            }
        }
    }
</script>

<style scoped>
    .file_info {
        display: flex;
        width: 100%;
    }
    .title {
        width: 40%;
    }
    .title:hover {
        color: blue;
        cursor: pointer;
        text-decoration: underline;
    }
    .size {
        width: 10%;
    }
    .upload_date {
        width: 20%;
    }
    .action-buttons_container {
        display: flex;
        justify-content: space-evenly;
        width: 30%;
    }
</style>