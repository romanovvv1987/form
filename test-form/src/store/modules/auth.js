import authApi from '@/api/auth'

const state = {
  isSubmitting: false,
  validationErrors: null
}

export const mutationTypes = {
  registerStart: '[auth] Register start',
  registerSuccess: '[auth] Register success',
  registerFailure: '[auth] Register failure',
}

export const actionTypes = {
  register: '[auth] Register'
}

export const getterTypes = {
}

const getters = {
}

const mutations = {
  [mutationTypes.registerStart](state) {
    state.isSubmitting = true
    state.validationErrors = null
  },
  [mutationTypes.registerSuccess](state) {
    state.isSubmitting = false
  },
  [mutationTypes.registerFailure](state, payload) {
    state.isSubmitting = false
    state.validationErrors = payload
  }
}

const actions = {
  [actionTypes.register](context, credentials) {
    return new Promise(resolve => {
      context.commit(mutationTypes.registerStart)
      authApi
        .register(credentials)
        .then(response => {
          context.commit(mutationTypes.registerSuccess, response)
          resolve(response)
        })
        .catch(result => {
          context.commit(
            mutationTypes.registerFailure,
            result.response.errors
          )
        })
    })
  },
}

export default {
  state,
  actions,
  mutations,
  getters
}
