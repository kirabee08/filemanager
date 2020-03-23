<template>
    <div id="Home">
        <div class="user_container" v-if="isLoggedIn">
            <span>Пользователь: <strong> {{ user.login }} </strong></span>
            <a v-on:click="logout">Выход</a>
        </div>
        <DirectoryComponent/>
    </div>
</template>

<script>
    import DirectoryComponent from "@/components/FileManagerComponents/DirectoryComponent";
    import VueJwtDecode from 'vue-jwt-decode';

    export default {
        name: "Home",
        components: {
            DirectoryComponent
        },
        methods: {
            logout() {
                this.$store.dispatch('logout')
                    .then(() => {
                        this.$router.push('/login');
                    })
            }
        },
        computed: {
            user() {
                const decodedToken = VueJwtDecode.decode(this.$store.getters.getToken);
                return decodedToken.data;
            },
            isLoggedIn() {
                return this.$store.getters.isLoggedIn;
            }
        },
    }
</script>

<style scoped>
    a:hover {
        color: blue;
        cursor: pointer;
        text-decoration: underline;
    }
</style>