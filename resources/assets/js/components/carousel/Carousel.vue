<template>
  <div>
    <carousel :perPage="perPage"
              :autoplay="autoplay"
              :autoplayTimeout="autoplayTimeout"
              :loop="loop"
              :speed="speed"
              class="carousel">
      <slide class="carousel__slide carousel__slide--red">
        <div class="carousel__background carousel__background--red">
          <img src="/img/macbook.png" alt="Macbook Pro" class="carousel__macbook">
          <h1 class="carousel__title">De nouvelles opportunités pour collaborer</h1>
          <p class="carousel__lead">
            Un moyen facile pour gérer vos fichiers et vos commandes. Groupez et envoyez vos commandes où vous le voulez.
          </p>
        </div>
      </slide>
      <slide class="carousel__slide carousel__slide--purple">
        <div class="carousel__background carousel__background--purple">
          <img src="/img/macbook.png" alt="Macbook Pro" class="carousel__macbook">
          <h1 class="carousel__title">Gérez vos commandes</h1>
          <p class="carousel__lead">
            Personnalisez vos commandes de manière individuelle, choisissez le type de papier et la qualité de l'impression, lieu de livraison, etc.
          </p>
        </div>
      </slide>
      <slide class="carousel__slide carousel__slide--orange">
        <div class="carousel__background carousel__background--orange">
          <img src="/img/macbook.png" alt="Macbook Pro" class="carousel__macbook">
          <h1 class="carousel__title">Vérifiez le statut de vos commandes</h1>
          <p class="carousel__lead">
            Vérifier l'avancement de vos commandes est un jeu d'enfant.
          </p>
        </div>
      </slide>
    </carousel>
  </div>
</template>

<script>
  import { Carousel, Slide } from 'vue-carousel'

  export default {
    components: {
      Carousel,
      Slide
    },
    data() {
      return {
        perPage: 1,
        autoplay: true,
        autoplayTimeout: 4000,
        loop: true,
        speed: 750
      }
    }
  }
</script>