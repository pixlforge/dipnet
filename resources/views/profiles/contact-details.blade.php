@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">

            {{--Checklist pan--}}
            <div class="col-xs-12 col-lg-6 fixed-lg-left bg-shapes-red no-padding">

                @include('layouts.company-logo-white')

                <div class="col-xs-12 col-md-5 offset-md-5 mt-md-checklist no-padding">
                    <div class="d-flex flex-column justify-content-center checklist">
                        <a class="d-flex align-items-center checklist-item checklist-item-done link-unstyled">
                            <span class="badge badge-white mx-4"><i class="fa fa-check"></i></span>
                            <span>Enregistrement</span>
                        </a>
                        <a class="d-flex align-items-center checklist-item checklist-item-active link-unstyled">
                            <span class="badge badge-white mx-4">2</span>
                            <span>Contact</span>
                        </a>
                        <a class="d-flex align-items-center checklist-item link-unstyled">
                            <span class="badge badge-white mx-4">3</span>
                            <span>Société</span>
                        </a>
                        <a class="d-flex align-items-center checklist-item link-unstyled">
                            <span class="badge badge-white mx-4">4</span>
                            <span>Prêt</span>
                        </a>
                    </div>
                </div>
            </div>

            {{--Contact pan--}}
            <div class="col-xs-12 col-lg-6 push-lg-6 vh-100 d-flex align-items-center">
                <div class="col-xs-12 col-lg-8 offset-lg-2">

                    <contact-details inline-template>
                        <form method="POST" action="{{ route('contactDetailsStore') }}" id="details" role="form" @keydown="form.errors.clear($event.target.name)">
                            {{ csrf_field() }}

                            {{--Contact section--}}
                            <div id="contact">
                                <h4 class="text-center mt-5">Contact</h4>

                                {{--Address line 1--}}
                                <div class="form-group my-5{{ $errors->has('address_line1') ? ' has-error' : '' }}">
                                    <label for="address_line1">Adresse ligne 1</label>
                                    <span class="required">requis</span>
                                    <input type="text" id="address_line1" name="address_line1" v-model="form.address_line1" class="form-control" value="{{ old('address_line1') }}" placeholder="Rue, n°" autofocus>
                                    <div class="help-block" v-if="form.errors.has('address_line1')" v-text="form.errors.get('address_line1')"></div>
                                </div>

                                {{--Address line 2--}}
                                <div class="form-group my-5{{ $errors->has('address_line2') ? ' has-error' : '' }}">
                                    <label for="address_line2">Adresse ligne 2</label>
                                    <span class="required">requis</span>
                                    <input type="text" id="address_line2" name="address_line2" v-model="form.address_line2" class="form-control" value="{{ old('address_line2') }}" placeholder="Appartement, suite">
                                    <div class="help-block" v-if="form.errors.has('address_line2')" v-text="form.errors.get('address_line2')"></div>
                                </div>

                                {{--Zip--}}
                                <div class="form-group my-5{{ $errors->has('zip') ? ' has-error' : '' }}">
                                    <label for="zip">Code postal</label>
                                    <span class="required">requis</span>
                                    <input type="text" id="zip" name="zip" class="form-control" v-model="form.zip" value="{{ old('zip') }}" placeholder="e.g. 1002">
                                    <div class="help-block" v-if="form.errors.has('zip')" v-text="form.errors.get('zip')"></div>
                                </div>

                                {{--City--}}
                                <div class="form-group my-5{{ $errors->has('city') ? ' has-error' : '' }}">
                                    <label for="city">Ville</label>
                                    <span class="required">requis</span>
                                    <input type="text" id="city" name="city" v-model="form.city" class="form-control" value="{{ old('city') }}" placeholder="e.g. Lausanne">
                                    <div class="help-block" v-if="form.errors.has('city')" v-text="form.errors.get('city')"></div>
                                </div>

                                {{--Phone--}}
                                <div class="form-group my-5{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                                    <label for="phone_number">Téléphone</label>
                                    <input type="text" id="phone_number" name="phone_number" v-model="form.phone_number" class="form-control" value="{{ old('phone_number') }}" placeholder="e.g. +41 (0)12 345 67 89">
                                    <div class="help-block" v-if="form.errors.has('phone_number')" v-text="form.errors.get('phone_number')"></div>
                                </div>

                                {{--Fax--}}
                                <div class="form-group my-5{{ $errors->has('fax') ? ' has-error' : '' }}">
                                    <label for="fax">Fax</label>
                                    <input type="text" id="fax" name="fax" v-model="form.fax" class="form-control" value="{{ old('fax') }}" placeholder="e.g. +41 (0)12 345 67 90">
                                    <div class="help-block" v-if="form.errors.has('fax')" v-text="form.errors.get('fax')"></div>
                                </div>

                            </div>

                            {{--Submit--}}
                            <button class="btn btn-black btn-block my-5" @click.prevent="onSubmit" :disabled="form.errors.any()">Ajouter</button>

                            <moon-loader :loading="loading" :color="color" :size="size"></moon-loader>
                        </form>
                    </contact-details>
                </div>
            </div>
        </div>
    </div>

@endsection