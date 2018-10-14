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
    formats: [],
    businesses: [],
    contacts: [],
    rawContacts: [],
    deliveries: [],
    documents: [],
    loader: {
      show: false
    },
    validationErrors: {}
  },

  /**
   * Getters
   */
  getters: {
    loaderState: state => {
      return state.loader.show;
    },
    listArticlePrintTypes: state => {
      return state.articles.types.print;
    },
    listArticleOptionTypes: state => {
      return state.articles.types.option;
    },
    listFinishTypes: state => {
      return state.articles.types.finish;
    },
    listBusinesses: state => {
      return state.businesses;
    },
    listContacts: state => {
      return state.contacts;
    },
    listRawContacts: state => {
      return state.rawContacts;
    },
    listDeliveries: state => {
      return state.deliveries;
    },
    listDocuments: state => {
      return state.documents;
    },
    listFormats: state => {
      return state.formats;
    },
    getValidationErrors: state => {
      return state.validationErrors;
    }
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
     * Hydrate the formats.
     */
    hydrateFormats: (state, formats) => {
      state.formats = formats.map(format => {
        return {
          label: format.name,
          value: {
            width: format.width,
            height: format.height
          },
        }
      });
    },
    /**
     * Hydrate the contacts.
     */
    hydrateContacts: (state, contacts) => {
      state.contacts = contacts.map(contact => {
        return { label: contact.name, value: contact.id };
      });
      state.rawContacts = contacts;
    },
    /**
     * Add a new contact to the list.
     */
    addToContactsList: (state, contact) => {
      state.contacts.push({ label: contact.name, value: contact.id });
      state.rawContacts.push(contact);
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
    hydrateDeliveries: (state, deliveries) => {
      deliveries.forEach(delivery => {
        Vue.set(delivery, 'documents', []);
      });
      state.deliveries = deliveries;
    },
    /**
     * Add a delivery.
     */
    addDelivery: (state, payload) => {
      let delivery = payload;
      Vue.set(delivery, 'documents', [])
      state.deliveries.push(delivery)
    },
    updateDelivery(state, payload) {
      const index = state.deliveries.findIndex(delivery => {
        return delivery.id === payload.id;
      });
      state.deliveries[index] = payload;
    },
    removeDelivery: (state, payload) => {
      const index = state.deliveries.findIndex(delivery => {
        if (delivery.id === payload.id) {
          return true
        }
      })
      state.deliveries.splice(index, 1)
    },
    /**
     * Hydrate the delivery documents.
     */
    hydrateDocuments: (state, documents) => {
      state.documents = documents;
    },
    /**
     * Add a document.
     */
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
      // console.log(payload);
      const index = state.documents.findIndex(document => {
        return document.id === payload.id;
      });
      state.documents[index] = payload;
    },
    removeDocument: (state, document) => {
      const index = state.documents.findIndex(item => {
        return item.id === document.id;
      });
      state.documents.splice(index, 1)
    },
    mutateValidationErrors: (state, errors) => {
      state.validationErrors = errors;
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
    hydrateFormats({ commit }, formats) {
      commit('hydrateFormats', formats);
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
     * Set the validation errors.
     */
    setValidationErrors({ commit }, errors) {
      commit('mutateValidationErrors', errors);
    },
    /**
     * Complete the order.
     */
    async completeOrder({ commit }, order) {
      commit('toggleLoader');
      await window.axios.patch(window.route("orders.complete.update", [order.reference]), order)
        .catch(err => {
          commit('toggleLoader');
          return Promise.reject(err);
        });
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
    async updateDelivery({ commit }, payload) {
      const user = payload.user;
      const delivery = {
        id: payload.currentDelivery.id,
        reference: payload.currentDelivery.reference,
        note: payload.currentDelivery.note,
        admin_note: payload.currentDelivery.admin_note,
        to_deliver_at: payload.currentDelivery.to_deliver_at,
        order_id: payload.currentDelivery.order_id,
        contact_id: payload.currentDelivery.contact.value,
        pickup: payload.currentDelivery.pickup,
        express: payload.currentDelivery.express
      };
      commit('updateDelivery', delivery);
      try {
        if (user.role === 'administrateur') {
          await window.axios.patch(window.route('admin.deliveries.update', [delivery.reference]), delivery);
        } else {
          await window.axios.patch(window.route('deliveries.update', [delivery.reference]), delivery);
        }
      } catch (err) {
        throw err;
      }
    },
    /**
     * Delete an existing delivery.
     */
    deleteDelivery({ commit }, delivery) {
      window.axios.delete(window.route('deliveries.destroy', [delivery.reference]));
      commit('removeDelivery', delivery);
    },
    hydrateDocuments: ({ commit }, documents) => {
      commit('hydrateDocuments', documents)
    },
    /**
     * Add a document.
     */
    addDocument: ({ commit }, payload) => {
      commit('addDocument', payload)
    },
    /**
     * Update an existing document.
     */
    async updateDocument({ commit }, document) {
      commit('updateDocument', document);
      await window.axios.patch(window.route("documents.update", [document.id]), {
        id: document.id,
        article_id: document.printType.value,
        finish: document.finish.value,
        quantity: document.quantity,
        options: document.options.map(option => {
          return { article_id: option.value }
        }),
        nb_orig: document.nb_orig,
        width: document.width,
        height: document.height
      });
    },
    /**
     * Delete an existing document.
     */
    async deleteDocument({ commit }, document) {
      commit('removeDocument', document);
      await window.axios.delete(window.route('documents.destroy', [document.id]));
    },
  }
})
