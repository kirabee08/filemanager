<template>
    <div id="SignUpComponent">
        <form @submit.prevent="register">
            <h1>Регистрация</h1><br>
            <label for="login">Логин</label><br>
            <input id="login" type="text" v-model="login" placeholder="Логин" required autofocus /><br>
            <label for="password">Пароль</label><br>
            <input id="password" type="password" v-model="password" placeholder="Пароль" required /><br>
            <button type="submit">Зарегистрироваться</button><br>
            <span class="sign_in">Уже есть аккаунт? <router-link to="/login">Войти</router-link></span>
        </form>
    </div>
</template>

<script>
    export default {
        name: "SignUpComponent",
        data () {
            return {
                login: '',
                password: ''
            }
        },
        methods: {
            register () {
                const data = {
                    login: this.login,
                    password: this.password
                };
                this.$store.dispatch('register', data)
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