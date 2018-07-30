<template>
  <div>
    <h2 class="modal__title">Avatar</h2>

    <div class="modal__group">
      <label
        for="avatar"
        class="btn btn--red">
        <i class="fal fa-folder-open"/>
        Sélectionner une image
      </label>
      <input
        id="avatar"
        type="file"
        name="avatar"
        class="v-hidden"
        @change="fileChange">
      <div
        v-if="errors.length"
        class="modal__alert">
        {{ errors[0] }}
      </div>
    </div>

    <div class="modal__group">
      <img
        v-if="newAvatar.path"
        :src="newAvatar.path"
        class="avatar__img"
        alt="Avatar à modifier">

      <img
        v-if="avatar && !newAvatar.path"
        :src="avatar"
        class="avatar__img"
        alt="Avatar actuel">

      <img
        v-if="!newAvatar.path && !avatar"
        :src="randomAvatarPath"
        alt="Avatar par défaut"
        style="width: 200px;">
    </div>

    <div
      v-if="newAvatar.id"
      class="modal__buttons modal__buttons--avatar">
      <button
        class="btn btn--red"
        role="button"
        @click.prevent="update">
        <i class="fal fa-upload"/>
        Mettre à jour l'avatar
      </button>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
  props: {
    avatar: {
      type: String,
      required: true
    },
    randomAvatar: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      newAvatar: {
        id: null,
        path: this.avatar
      },
      endpoint: "/profile/avatar",
      errors: {},
      sendAs: "avatar"
    };
  },
  computed: {
    randomAvatarPath() {
      return "img/placeholders/" + this.randomAvatar;
    }
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    fileChange(event) {
      this.upload(event);
    },
    async upload(event) {
      this.toggleLoader();
      try {
        let res = await window.axios.post(
          this.endpoint,
          this.packageUploads(event)
        );
        this.toggleLoader();
        this.newAvatar = res.data;
        window.flash({
          message:
            "Avatar valide. Vous pouvez sauver cette image en tant qu'avatar personnel.",
          level: "success"
        });
      } catch (err) {
        this.toggleLoader();
      }
    },
    packageUploads(event) {
      const fileData = new FormData();
      fileData.append(this.sendAs, event.target.files[0]);
      return fileData;
    },
    async update() {
      this.toggleLoader();
      try {
        await window.axios.patch("/profile/avatar", {
          avatar: { id: this.newAvatar.id }
        });
        this.toggleLoader();
        window.flash({
          message: "Votre avatar a bien été mis à jour.",
          level: "success"
        });
        setTimeout(() => {
          window.location = window.route("profile.index");
        }, 500);
      } catch (err) {
        this.toggleLoader();
        window.flash({
          message:
            "Il y a eu un problème, votre compte n'a pas été mis à jour.",
          level: "danger"
        });
      }
    }
  }
};
</script>
