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
    addDocument: (state, payload) => {
      state.documents.push(payload)
      const index = state.documents.findIndex(document => {
        if (document.id === payload.id) {
          return true
        }
      })
      Vue.set(state.documents[index], 'quantity', 1)
      Vue.set(state.documents[index], 'article_id', null)
      Vue.set(state.documents[index], 'articles', [])
    },
    updateDocument: (state, payload) => {
      const index = state.documents.findIndex(document => {
        if (document.id === payload.document.id) {
          return true
        }
      })
      state.documents[index].article_id = payload.document.article_id
      state.documents[index].finish = payload.document.finish
      state.documents[index].quantity = payload.document.quantity
      state.documents[index].articles = payload.options
      state.documents[index].width = payload.document.width
      state.documents[index].height = payload.document.height
      state.documents[index].nb_orig = payload.document.nb_orig
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
          document.article_id = payload.print
          document.finish = payload.finish
          document.quantity = payload.quantity
          document.articles = payload.optionModels
          document.width = payload.width
          document.height = payload.height
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
      window.console.log(payload);
      return new Promise((resolve, reject) => {
        commit('toggleLoader')
        window.axios.post(window.route('deliveries.store', [payload.reference])).then(response => {
          commit('addDelivery', response.data)
          commit('toggleLoader')
          resolve()
        }).catch(() => {
          commit('toggleLoader')
          reject()
        })
      })
    },
    removeDelivery: ({ commit }, payload) => {
      return new Promise((resolve, reject) => {
        commit('toggleLoader')
        window.axios.delete(window.route('deliveries.destroy', [payload.reference]), payload).then(() => {
          commit('removeDelivery', payload)
          commit('toggleLoader')
          resolve()
        }).catch(() => {
          commit('toggleLoader')
          reject()
        })
      })
    },
    hydrateDocuments: ({ commit }, payload) => {
      commit('hydrateDocuments', payload)
    },
    addDocument: ({ commit }, payload) => {
      commit('addDocument', payload)
    },
    updateDocument: ({ commit }, payload) => {
      commit('updateDocument', payload)
      return new Promise((resolve, reject) => {
        const endpoint = window.route('documents.update', [payload.orderReference, payload.deliveryReference, payload.document.id])
        window.axios.patch(endpoint, payload.document)
          .then(() => resolve())
          .catch(error => reject(error))
      })
    },
    removeDocument: ({ commit }, payload) => {
      commit('removeDocument', payload.document)
      return new Promise((resolve, reject) => {
        const endpoint = window.route('documents.destroy', [payload.orderReference, payload.deliveryReference, payload.document.id])
        window.axios.delete(endpoint, payload.document)
          .then(() => resolve())
          .catch(() => reject())
      })
    },
    cloneOptions: ({ commit }, payload) => {
      commit('toggleLoader')
      return new Promise((resolve, reject) => {
        const endpoint = window.route('documents.clone.options', [payload.orderReference, payload.deliveryReference])
        window.axios.post(endpoint, {
          print: payload.print,
          finish: payload.finish,
          quantity: payload.quantity,
          options: payload.options,
          width: payload.width,
          height: payload.height
        })
          .then(() => {
            commit('toggleLoader')
            commit('cloneOptions', {
              deliveryId: payload.deliveryId,
              print: payload.print,
              finish: payload.finish,
              quantity: payload.quantity,
              options: payload.options,
              optionModels: payload.optionModels,
              width: payload.width,
              height: payload.height
            })
            resolve()
          })
          .catch(() => {
            commit('toggleLoader')
            reject()
          })
      })
    },
  }
})
