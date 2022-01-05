import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios'

Vue.use(Vuex);

const state = {
    status: '',
    token: localStorage.getItem('token') || '',
    user : {},
    setting: {}
}

const getters = {
    isLoggedIn: state => !!state.token,
    authStatus: state => state.status,
    setting: state => state.setting
}

const actions = {
    user(context, user){
        context.commit('user', user)
        context.commit('isLoggedIn', true)
    },
    login({commit}, user){
        return new Promise((resolve, reject) => {
          commit('auth_request')
          axios({url: '/api/login', data: user, method: 'POST' })
          .then(resp => {
            const token = resp.data.token
            const user = resp.data.user
            localStorage.setItem('token', token)
            axios.defaults.headers.common['Authorization'] = token
            commit('auth_success', token, user)
            resolve(resp)
          })
          .catch(err => {
            commit('auth_error')
            localStorage.removeItem('token')
            reject(err)
          })
        })
    },
    logout({commit}){
        return new Promise((resolve, reject) => {
          commit('logout')
          localStorage.removeItem('token')
          delete axios.defaults.headers.common['Authorization']
          resolve()
        })
    },
    async getSetting({commit}){
        const response = await axios.get('/api/get/settings')
        commit('setSetting', response.data.results)
    }
}

const mutations = {
    auth_request(state){
        state.status = 'loading'
    },
    auth_success(state, token, user){
        state.status = 'success'
        state.token = token
        state.user = user
    },
    auth_error(state){
        state.status = 'error'
    },
    logout(state){
        state.status = ''
        state.token = ''
    },
    setSetting(state, data) {
        state.setting = data
    }
}

export default new Vuex.Store({
    state,
    getters,
    mutations,
    actions
})