<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">{{ contact.name }}</h1>
    </div>
    <div class="profile__container">
      <div class="profile__box">

        <div class="profile__box-item">
          <div class="profile__avatar">
            <IllustrationAddress/>
          </div>
        </div>

        <div class="profile__box-item">

          <!-- Address line 1 -->
          <div class="profile__item">
            <h3>Adresse ligne 1</h3>
            <p>{{ contact.address_line1 }}</p>
          </div>

          <!-- Address line 2 -->
          <div class="profile__item">
            <h3>Adresse ligne 2</h3>
            <p>{{ contact.address_line2 ? contact.address_line2 : 'Aucune' }}</p>
          </div>

          <!-- Zip & City -->
          <div class="profile__item">
            <h3>Localité</h3>
            <p>{{ contact.zip }} {{ contact.city | capitalize }}</p>
          </div>

          <!-- Phone number -->
          <div class="profile__item">
            <h3>Téléphone</h3>
            <p>{{ contact.phone_number ? contact.phone_number : 'Aucun' }}</p>
          </div>

          <!-- Fax -->
          <div class="profile__item">
            <h3>Fax</h3>
            <p>{{ contact.fax ? contact.fax : 'Aucun' }}</p>
          </div>

          <!-- Email -->
          <div class="profile__item">
            <h3>Adresse e-mail</h3>
            <p>{{ contact.email }}</p>
          </div>
        </div>

        <div class="profile__box-item">

          <!-- User -->
          <div class="profile__item">
            <h3>Créé par</h3>
            <p>{{ contact.user.username }}</p>
          </div>

          <!-- Created at -->
          <div class="profile__item">
            <h3>Création du contact</h3>
            <p>{{ getDate(contact.created_at) }}</p>
          </div>

          <!-- Updated at -->
          <div class="profile__item">
            <h3>Dernière mise à jour</h3>
            <p>{{ getDate(contact.updated_at) }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import IllustrationAddress from "../illustrations/IllustrationAddress";

import { dates, filters } from "../../mixins";

export default {
  components: {
    IllustrationAddress
  },
  mixins: [dates, filters],
  props: {
    contact: {
      type: Object,
      required: true
    }
  }
};
</script>

