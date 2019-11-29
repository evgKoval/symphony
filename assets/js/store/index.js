import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    user: null,
    token: null
  },
  mutations: {
    USER_LOGIN(state, user) {
      state.user = user;
      state.token = user.email;
      localStorage.setItem('token', user.email);
      localStorage.setItem('token_id', user.id);
    },
    LOGOUT(state) {
      state.token = null;
      localStorage.removeItem('token');
      localStorage.removeItem('token_id');
    },
    CHECK_TOKEN(state) {
      state.token = localStorage.getItem('token')
    }
  },
  actions: {
    login({ commit, dispatch }, form) {
      return new Promise((resolve, reject) => {
        axios.post('api/user', form)
          .then((user) => {
            if(Object.entries(user.data).length !== 0) {
              commit('USER_LOGIN', user.data);

              dispatch('addActivity', user.data.id);

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
    },
    addActivity({ commit }, userId) {
      const data = new FormData();

      data.set('user_id', userId);

      axios.post('api/activity', data)
    },
    getUserCreatedAt({}, userId) {
      return new Promise((resolve, reject) => {
        axios.get('api/user/' + userId)
          .then(res => resolve(res))
          .catch(e => reject(e))
      })
    },
    getCountOfUserVisit({}, date) {
      const userId = localStorage.getItem('token_id');

      return new Promise((resolve, reject) => {
        axios.get('api/activity/' + userId + '/' + date)
          .then(res => resolve(res))
          .catch(e => reject(e))
      })
    }
  },
  getters: {
    user(state) {
      return state.user
    },
    token(state) {
      return state.token
    }
  }
});