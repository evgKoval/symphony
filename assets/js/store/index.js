import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    user: null
  },
  mutations: {
    USER_LOGIN(state, user) {
      state.user = user;
      localStorage.setItem('token', user.email);
    }
  },
  actions: {
    login({ commit }, form) {
      return new Promise((resolve, reject) => {
        axios.post('api/user', form)
          .then((user) => {
            if(Object.entries(user.data).length !== 0) {
              commit('USER_LOGIN', user.data);
              resolve();
            } else {
              reject('User doesn\'t exist');
            }
          })
      })
    },
    register({ commit }, form) {
      return new Promise((resolve, reject) => {
        axios.post('api/users', form)
          .then(() => resolve())
          .catch(() => reject());
      })
    }
  },
  getters: {
    auth(state) {
      return state.user
    }
  }
});