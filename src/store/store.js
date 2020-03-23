import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        status: '',
        token: localStorage.getItem('token') || '',
        user: {},
        files: []
    },
    mutations: {
        files_request(state) {
            state.status = 'loading';
        },
        files_success(state, files) {
            state.status = 'success';
            state.files = files;
        },
        files_error(state) {
            state.status = 'error';
        },
        auth_request(state) {
            state.status = 'loading';
        },
        auth_success(state, data) {
            state.status = 'success';
            state.token = data.token;
            state.user = data.user;
        },
        auth_error(state) {
            state.status = 'error';
        },
        logout(state) {
            state.status = '';
            state.token = '';
        },
    },
    actions: {
        getFiles({commit}, path) {
            return new Promise((resolve, reject) => {
                commit('files_request');
                axios({
                    url: '/API/get_files.php',
                    method: 'POST',
                    data: path
                })
                    .then(resp => {
                        const files = resp.data.files;
                        commit('files_success', files);
                        resolve(resp);
                    })
                    .catch(err => {
                        commit('files_error');
                        reject(err);
                    })
            })
        },
        login({commit}, user) {
            return new Promise((resolve, reject) => {
                commit('auth_request');
                axios({
                    url: '/API/login.php',
                    method: 'POST',
                    data: user,
                })
                    .then(resp => {
                        const token = resp.data.token;
                        const user = resp.data.user;
                        const data = {
                            token: token,
                            user: user
                        };
                        localStorage.setItem('token', token);
                        axios.defaults.headers.common['Authorization'] = token;
                        commit('auth_success', data);
                        resolve(resp);
                    })
                    .catch(err => {
                        commit('auth_error');
                        localStorage.removeItem('token');
                        reject(err);
                    })
            })
        },
        register({commit}, user) {
            return new Promise((resolve, reject) => {
                commit('auth_request');
                axios({
                    url: '/API/register.php',
                    data: user,
                    method: 'POST',
                })
                    .then(resp => {
                        const token = resp.data.token;
                        const user = resp.data.user;
                        const data = {
                            token: token,
                            user: user
                        };
                        localStorage.setItem('token', token);
                        axios.defaults.headers.common['Authorization'] = token;
                        commit('auth_success', data);
                        resolve(resp);
                    })
                    .catch(err => {
                        commit('auth_error', err);
                        localStorage.removeItem('token');
                        reject(err);
                    })
            })
        },
        logout({commit}) {
            return new Promise((resolve) => {
                commit('logout');
                localStorage.removeItem('token');
                delete axios.defaults.headers.common['Authorization'];
                resolve();
            })
        },
    },
    getters: {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status,
        getToken: state => state.token,
        getFiles: state => state.files
    },
});