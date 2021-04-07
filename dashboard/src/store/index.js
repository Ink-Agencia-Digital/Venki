import Vue from "vue";
import Vuex from "vuex";
import Axios from "axios";

Axios.defaults.withCredentials = true;

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        status: '',
        token: localStorage.getItem('token') || '',
        user: ''
    },
    getters: {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status,
    },
    mutations: {
        auth_request(state) {
          state.status = 'success'
        },
        logout(state) {
            state.status = ''
            state.token = ''
        },
        ser_user(state, user) {
            state.user = user;
        }
    },
    actions: {
        async login({ dispatch }, user) {
            Axios.post("/api/oauth/token",{
                    username: user.email,
                    password: user.password,
                    client_secret: process.env.VUE_APP_CLIENT_SECRET,
                    client_id: process.env.VUE_APP_CLIENT_ID,
                    grant_type: "password",
            }).then((response) => {
                localStorage.setItem(
                    'token',
                    response.data.access_token,
                )
                return dispatch("getUser");
            })
        },
        getUser({ commit }) {
            Axios
                .get("/api/user", {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(res => {
                    commit("ser_user", res.data);
                })
                .catch(() => {
                    commit("ser_user", null);
                });
        },
        logout({commit}) {
            return new Promise((resolve) => {
                commit('logout')
                localStorage.removeItem('token')
                delete Axios.defaults.headers.common['Authorization']
                resolve()
            })
        }
    },
    modules: {},
});
