<template>
    <div id="SignInComponent">
        <form class="login" @submit.prevent="auth">
            <h1>Авторизация</h1><br>
            <label for="login">Логин</label><br>
            <input id="login" required v-model="login" type="text" placeholder="Логин" /><br>
            <label for="password">Пароль</label><br>
            <input id="password" required v-model="password" type="password" placeholder="Пароль" /><br>
            <button type="submit">Войти</button><br>
            <span class="sign_up">Нет аккаунта? <router-link to="/register">Зарегистрироваться</router-link></span>
        </form>
    </div>
</template>

<script>
    export default {
        name: "SignInComponent",
        data () {
            return {
                login: '',
                password: ''
            }
        },
        methods: {
            auth () {
                const login = this.login;
                const password = this.password;
                this.$store.dispatch('login', {login, password})
                .then(() => this.$router.push('/'))
                .catch(err => console.log(err));
            }
        }
    }
</script>

<style scoped>
    input {
        margin-bottom: 20px;
        padding-left: 5px;
    }
    button {
        margin-bottom: 10px;
    }
</style>