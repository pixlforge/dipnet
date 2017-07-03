@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">

            {{--Carousel pan--}}
            <div class="col-xs-12 col-lg-6 push-lg-6 fixed-lg-right no-padding">

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

            {{--Register pan--}}
            <div class="col-xs-12 col-lg-6 vh-100 d-flex align-items-center">
                <div class="col-xs-12 col-lg-8 offset-lg-2">

                    <register inline-template>
                        <form method="POST" action="{{ route('register') }}" id="register" role="form" @keydown="form.errors.clear($event.target.name)">
                            {{ csrf_field() }}

                            {{--Account section--}}
                            <div id="account">
                                <h4 class="text-center">Enregistrement</h4>

                                {{--Username--}}
                                <div class="form-group my-5{{ $errors->has('username') ? ' has-error' : '' }}">
                                    <label for="username">Nom d'utilisateur</label>
                                    <span class="required">requis</span>
                                    <input type="text" id="username" name="username" v-model="form.username" class="form-control" value="{{ old('username') }}" placeholder="e.g. John Doe"  autofocus>
                                    <div class="help-block" v-if="form.errors.has('username')" v-text="form.errors.get('username')"></div>
                                </div>

                                {{--Email--}}
                                <div class="form-group my-5{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">E-mail</label>
                                    <span class="required">requis</span>
                                    <input type="email" id="email" name="email" v-model="form.email" class="form-control" value="{{ old('email') }}" placeholder="e.g. votre@email.ch" >
                                    <div class="help-block" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></div>
                                </div>

                                {{--Password--}}
                                <div class="form-group my-5{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password">Mot de passe</label>
                                    <span class="required">requis</span>
                                    <input type="password" id="password" name="password" v-model="form.password" class="form-control" placeholder="Entre 6 et 45 caractères" >
                                    <div class="help-block" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></div>
                                </div>

                                {{--Password confirmation--}}
                                <div class="form-group my-5">
                                    <label for="password-confirm">Confirmation du mot de passe</label>
                                    <span class="required">requis</span>
                                    <input type="password" id="password-confirm" name="password_confirmation" v-model="form.password_confirmation" class="form-control" placeholder="Répétez votre mot de passe" >
                                </div>

                            </div>

                            {{--Contact section--}}
                            {{--<div id="contact" class="">--}}
                                {{--<h3 class="text-center my-6">Contact</h3>--}}

                                {{--Address line 1--}}
                                {{--<div class="form-group my-5{{ $errors->has('address_line1') ? ' has-error' : '' }}">--}}
                                    {{--<label for="address_line1">Adresse ligne 1</label>--}}
                                    {{--<input type="text" id="address_line1" name="address_line1" v-model="address_line1" class="form-control" value="{{ old('address_line1') }}" placeholder="Rue, n°" required>--}}
                                    {{--<span class="required"></span>--}}
                                    {{--@if ($errors->has('address_line1'))--}}
                                        {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('address_line1') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                                {{----}}
                                {{--Address line 2--}}
                                {{--<div class="form-group my-5{{ $errors->has('address_line2') ? ' has-error' : '' }}">--}}
                                    {{--<label for="address_line2">Adresse ligne 2</label>--}}
                                    {{--<input type="text" id="address_line2" name="address_line2" v-model="address_line2" class="form-control" value="{{ old('address_line2') }}" placeholder="Appartement, suite">--}}
                                    {{--<span class="required"></span>--}}
                                    {{--@if ($errors->has('address_line2'))--}}
                                        {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('address_line2') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                                {{----}}
                                {{--Zip--}}
                                {{--<div class="form-group my-5{{ $errors->has('zip') ? ' has-error' : '' }}">--}}
                                    {{--<label for="zip">Code postal</label>--}}
                                    {{--<input type="text" id="zip" name="zip" class="form-control" v-model="zip" value="{{ old('zip') }}" placeholder="e.g. 1002" required>--}}
                                    {{--<span class="required">requis</span>--}}
                                    {{--@if ($errors->has('zip'))--}}
                                        {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('zip') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                                {{----}}
                                {{--City--}}
                                {{--<div class="form-group my-5{{ $errors->has('city') ? ' has-error' : '' }}">--}}
                                    {{--<label for="city">Ville</label>--}}
                                    {{--<input type="text" id="city" name="city" v-model="city" class="form-control" value="{{ old('city') }}" placeholder="e.g. Lausanne" required>--}}
                                    {{--<span class="required">requis</span>--}}
                                    {{--@if ($errors->has('city'))--}}
                                        {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('city') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}

                                {{--Phone--}}
                                {{--<div class="form-group my-5{{ $errors->has('phone_number') ? ' has-error' : '' }}">--}}
                                    {{--<label for="phone_number">Téléphone</label>--}}
                                    {{--<input type="text" id="phone_number" name="phone_number" v-model="phone_number" class="form-control" value="{{ old('phone_number') }}" placeholder="e.g. +41 (0)12 345 67 89">--}}
                                    {{--@if ($errors->has('phone_number'))--}}
                                        {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('phone_number') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}

                                {{--Fax--}}
                                {{--<div class="form-group my-5{{ $errors->has('fax') ? ' has-error' : '' }}">--}}
                                    {{--<label for="fax">Fax</label>--}}
                                    {{--<input type="text" id="fax" name="fax" v-model="fax" class="form-control" value="{{ old('fax') }}" placeholder="e.g. +41 (0)12 345 67 90">--}}
                                    {{--@if ($errors->has('fax'))--}}
                                        {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('fax') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}

                            {{--</div>--}}

                            {{--Company section--}}
                            {{--<div id="company" class="">--}}
                                {{--<h3 class="text-center my-6">Société</h3>--}}

                                {{--Name--}}
                                {{--<div class="form-group my-5{{ $errors->has('name') ? ' has-error' : '' }}">--}}
                                    {{--<label for="name">Société</label>--}}
                                    {{--<input type="text" id="name" name="name" v-model="name" class="form-control"--}}
                                           {{--value="{{ old('name') }}" placeholder="e.g. Pantone">--}}
                                    {{--@if ($errors->has('name'))--}}
                                        {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('name') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}

                            {{--</div>--}}

                            {{--Submit--}}
                            <button class="btn btn-black btn-block mt-5" @click.prevent="onSubmit" :disabled="form.errors.any()">Créer le compte</button>

                            <moon-loader :loading="loading" :color="color" :size="size"></moon-loader>

                        </form>

                    </register>

                    <p class="text-small text-center mt-4">Vous disposez déjà d'un compte? <a href="{{ route('login') }}" class="ml-3">Connectez-vous</a></p>
                </div>
            </div>
        </div>
    </div>

@endsection
