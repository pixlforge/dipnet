import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export const store = new Vuex.Store({
  /**
   * State
   */
  state: {
    articles: {
      types: {
        print: [],
        option: [],
        finish: [
          { name: 'roulé' },
          { name: 'plié' }
        ]
      }
    },
    businesses: [],
    contacts: [],
    deliveries: [],
    documents: [],
    loader: {
      show: false
    },
  },

  /**
   * Getters
   */
  getters: {
    loaderState: state => {
      return state.loader.show
    },

    listArticlePrintTypes: state => {
      return state.articles.types.print
    },

    listArticleOptionTypes: state => {
      return state.articles.types.option
    },

    listFinishTypes: state => {
      return state.articles.types.finish
    },

    listBusinesses: state => {
      return state.businesses
    },

    listContacts: state => {
      return state.contacts
    },

    listDeliveries: state => {
      return state.deliveries
    },

    listDocuments: state => {
      return state.documents
    },

    listSelectedOptions: state => {
      let articles = []
      state.documents.forEach(document => {
        articles.push(document.articles)
      })
      return articles
    }
  },

  /**
   * Mutations
   */
  mutations: {
    toggleLoader: state => {
      state.loader.show = !state.loader.show
    },

    hydrateArticleTypes: (state, payload) => {
      payload.forEach(article => {
        if (article.type === 'impression') {
          state.articles.types.print.push(article)
        }

        if (article.type === 'option') {
          state.articles.types.option.push(article)
        }
      })
    },

    hydrateBusinesses: (state, payload) => {
      state.businesses = payload
    },

    hydrateContacts: (state, payload) => {
      state.contacts = payload
    },

    addContact: (state, payload) => {
      state.contacts.push(payload)
    },

    hydrateDeliveries: (state, payload) => {
      state.deliveries = payload
    },

    addDelivery: (state, payload) => {
      state.deliveries.push(payload)
    },

    removeDelivery: (state, payload) => {
      const index = state.deliveries.findIndex(delivery => {
        if (delivery.id === payload.id) {
          return true
        }
      })
      state.deliveries.splice(index, 1)
    },

    hydrateDocuments: (state, payload) => {
      state.documents = payload
    },

    removeDocument: (state, payload) => {
      const index = state.documents.findIndex(document => {
        if (document.id === payload.id) {
          return true
        }
      })
      state.documents.splice(index, 1)
    },

    cloneOptions: (state, payload) => {
      state.documents.forEach(document => {
        if (document.delivery_id === payload.deliveryId) {
          document.articles = payload.optionModels
        }
      })
    },
  },

  /**
   * Actions
   */
  actions: {
    toggleLoader: ({ commit }) => {
      commit('toggleLoader')
    },

    hydrateArticleTypes: ({ commit }, payload) => {
      commit('hydrateArticleTypes', payload)
    },

    hydrateBusinesses: ({ commit }, payload) => {
      commit('hydrateBusinesses', payload)
    },

    hydrateContacts: ({ commit }, payload) => {
      commit('hydrateContacts', payload)
    },

    addContact: ({ commit }, payload) => {
      commit('addContact', payload)
    },

    hydrateDeliveries: ({ commit }, payload) => {
      commit('hydrateDeliveries', payload)
    },

    addDelivery: ({ commit }, payload) => {
      const orderId = {
        order_id: payload.id
      }

      return new Promise((resolve, reject) => {
        commit('toggleLoader')
        axios.post(route('deliveries.store'), orderId)
          .then(response => {
            commit('addDelivery', response.data)
            commit('toggleLoader')
            resolve()
          })
          .catch(error => {
            commit('toggleLoader')
            reject()
          })
      })
    },

    removeDelivery: ({ commit }, payload) => {
      return new Promise((resolve, reject) => {
        commit('toggleLoader')
        axios.delete(route('deliveries.destroy', [payload.reference]), payload)
          .then(() => {
            commit('removeDelivery', payload)
            commit('toggleLoader')
            resolve()
          })
          .catch(error => {
            commit('toggleLoader')
            reject()
          })
      })
    },

    hydrateDocuments: ({ commit }, payload) => {
      commit('hydrateDocuments', payload)
    },

    updateDocument: ({ commit }, payload) => {
      return new Promise((resolve, reject) => {
        const endpoint = route('documents.update', [payload.orderReference, payload.deliveryReference, payload.document.id])
        axios.patch(endpoint, payload.document)
          .then(() => {
            resolve()
          })
          .catch(error => {
            reject(error)
          })
      })
    },

    removeDocument: ({ commit }, payload) => {
      return new Promise((resolve, reject) => {
        const endpoint = route('documents.destroy', [payload.orderReference, payload.deliveryReference, payload.document.id])
        axios.delete(endpoint, payload.document)
          .then(() => {
            commit('removeDocument', payload.document)
            resolve()
          })
          .catch(error => {
            reject()
          })
      })
    },

    cloneOptions: ({ commit }, payload) => {
      commit('toggleLoader')
      return new Promise((resolve, reject) => {
        const endpoint = route('documents.clone.options', [payload.orderReference, payload.deliveryReference])
        axios.post(endpoint, {
          options: payload.options
        }).then(() => {
          commit('toggleLoader')
          commit('cloneOptions', {
            deliveryId: payload.deliveryId,
            options: payload.options,
            optionModels: payload.optionModels
          })
          resolve()
        }).catch(error => {
          commit('toggleLoader')
          reject()
        })
      })
    },
  }
})
