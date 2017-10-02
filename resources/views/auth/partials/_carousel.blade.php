<div class="col-xs-12 col-lg-6 push-lg-6 fixed-lg-right pr-0">
    <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselIndicators" data-slide-to="1"></li>
            <li data-target="#carouselIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">

            {{--Slide red--}}
            <div class="carousel-item bg-red active">
                <div class="carousel-slide carousel-slide-first d-flex flex-column justify-content-center align-items-center">
                    <img src="{{ asset('img/register/macbook.png') }}" alt="" class="img-carousel mb-5">
                    <div class="carousel-slide-content text-center">
                        <p class="lead">De nouvelles opportunités pour collaborer</p>
                        <p class="description">Un moyen facile pour gérer vos fichiers et vos commandes. Groupez et envoyez vos commandes où vous le voulez.</p>
                    </div>
                </div>
            </div>

            {{--Slide purple--}}
            <div class="carousel-item bg-purple">
                <div class="carousel-slide carousel-slide-second d-flex flex-column justify-content-center align-items-center">
                    <img src="{{ asset('img/register/macbook.png') }}" alt="" class="img-carousel mb-5">
                    <div class="carousel-slide-content text-center">
                        <p class="lead">Gérez vos commandes</p>
                        <p class="description">Personnalisez vos commandes de manière individuelle, choisissez le type de papier et la qualité de l'impression, lieu de livraison, etc.</p>
                    </div>
                </div>
            </div>

            {{--Slide orange--}}
            <div class="carousel-item bg-orange">
                <div class="carousel-slide carousel-slide-third d-flex flex-column justify-content-center align-items-center">
                    <img src="{{ asset('img/register/macbook.png') }}" alt="" class="img-carousel mb-5">
                    <div class="carousel-slide-content text-center">
                        <p class="lead">Vérifiez le statut de vos commandes</p>
                        <p class="description">Vérifier l'avancement de vos commandes est un jeu d'enfant.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>