import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        status: '',
        token: localStorage.getItem('token') || '',
        user: '',
    },
    getters: {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status,
    },
    mutations: {
        auth_request(state){
            state.status = 'loading'
        },
        auth_success(state, token){
            state.status = 'success'
            state.token = token
        },
        auth_error(state){
            state.status = 'error'
        },
        logout(state){
            state.status = ''
            state.token = ''
        },
        set_user(state, user){
            state.user = user
        }
    },
    actions: {
        async login({ dispatch }, user){
            await axios({url: '/api/oauth/token', data: {
                    username: user.email,
                    password: user.password,
                    grant_type: "password",
                    client_id: process.env.VUE_APP_CLIENT_ID,
                    client_secret: process.env.VUE_APP_CLIENT_SECRET,
                }, method: 'POST'})
                .then((response) => {
                    localStorage.setItem(
                        'token',
                        response.data.access_token,
                    )
                })
            return dispatch("getUser");
        },
        getUser({ commit }) {
            axios.get('/api/user', {
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                }
            })
                .then(res => {
                    commit("set_user", res.data)
                })
                .catch(() => {
                    commit("set_user", null)
                })
        },
        logout({ commit }) {
            return new  Promise((resolve) => {
                commit('logout')
                localStorage.removeItem('token')
                delete axios.defaults.headers.common['Authorization']
                resolve()
            })
        },
    },
    modules: {},
});

