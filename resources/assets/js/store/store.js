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
        finish: ""
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
    /**
     * Switch the loader state.
     */
    toggleLoader: state => {
      state.loader.show = !state.loader.show
    },
    /**
     * Hydrate the articles.
     */
    hydrateArticleTypes: (state, articles) => {
      const formattedArticles = articles.map(article => {
        return { value: article.id, label: article.description, type: article.type, greyscale: article.greyscale ? true : false };
      });

      formattedArticles.forEach(article => {
        if (article.type === 'impression') {
          state.articles.types.print.push(article)
        }
        if (article.type === 'option') {
          state.articles.types.option.push(article)
        }
      })
    },
    /**
     * Hydrate the businesses.
     */
    hydrateBusinesses: (state, businesses) => {
      state.businesses = businesses.map(business => {
        return { label: business.name, value: business.id };
      });
    },
    /**
     * Hydrate the contacts.
     */
    hydrateContacts: (state, contacts) => {
      state.contacts = contacts.map(contact => {
        return { label: contact.name, value: contact.id };
      });
    },
    /**
     * Add a new contact to the list.
     */
    addToContactsList: (state, contact) => {
      state.contacts.push({ label: contact.name, value: contact.id });
    },
    /**
     * Add a new business to the list.
     */
    addToBusinessesList: (state, business) => {
      state.businesses.push({ label: business.name, value: business.id });
    },
    /**
     * Hydrate the deliveries.
     */
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
    /**
     * Add a new contact.
     */
    addContact: ({ commit }, contact) => {
      commit('addToContactsList', contact)
    },
    /**
     * Add a new business.
     */
    addBusiness: ({ commit }, business) => {
      commit('addToBusinessesList', business)
    },
    hydrateDeliveries: ({ commit }, payload) => {
      commit('hydrateDeliveries', payload)
    },
    /**
     * Update an existing order.
     */
    async updateOrder({ commit }, order) {
      await window.axios.patch(window.route("orders.update", [order.reference]), {
        id: order.id,
        status: order.status,
        business_id: order.business.value,
        contact_id: order.contact.value,
      })
    },
    /**
     * Add a new delivery to the order.
     */
    async createDelivery({ commit }, orderReference) {
      try {
        commit('toggleLoader');
        let res = await window.axios.post(window.route('deliveries.store', [orderReference]));
        commit('addDelivery', res.data);
        commit('toggleLoader');
      } catch (err) {
        commit('toggleLoader');
      }
    },
    /**
     * Update an existing delivery.
     */
    async updateDelivery({ commit }, delivery) {
      await window.axios.patch(window.route('deliveries.update', [delivery.reference]), {
        id: delivery.id,
        reference: delivery.reference,
        note: delivery.note,
        admin_note: delivery.admin_note,
        to_deliver_at: delivery.to_deliver_at,
        order_id: delivery.order_id,
        contact_id: delivery.contact.value
      });
    },
    /**
     * Delete an existing delivery.
     */
    deleteDelivery({ commit }, delivery) {
      window.axios.delete(window.route('deliveries.destroy', [delivery.reference]));
      commit('removeDelivery', delivery);
    },
    hydrateDocuments: ({ commit }, payload) => {
      commit('hydrateDocuments', payload)
    },
    addDocument: ({ commit }, payload) => {
      commit('addDocument', payload)
    },
    /**
     * Update an existing document.
     */
    async updateDocument({ commit }, document) {
      await window.axios.patch(window.route("documents.update", [document.id]), {
        id: document.id,
        article_id: document.printType.value,
        finish: document.finish.label,
        quantity: document.quantity,
        options: document.options.map(option => {
          return { article_id: option.value }
        })
      });
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
  }
})
