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
                        <a class="d-flex align-items-center checklist-item checklist-item-done link-unstyled">
                            <span class="badge badge-white mx-4"><i class="fa fa-check"></i></span>
                            <span>Contact</span>
                        </a>
                        <a class="d-flex align-items-center checklist-item checklist-item-active link-unstyled">
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

                    <company-details inline-template>
                        <form method="POST" action="{{ route('companyDetailsStore') }}" id="details" role="form" @keydown="form.errors.clear($event.target.name)">
                            {{ csrf_field() }}

                            {{--Company section--}}
                            <div id="company">
                                <h3 class="text-center mt-5">Société</h3>

                                {{--Name--}}
                                <div class="form-group my-5{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Société</label>
                                    <input type="text" id="name" name="name" v-model="form.name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Pantone">
                                    <div class="help-block" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></div>
                                </div>

                            </div>

                            {{--Submit--}}
                            <button class="btn btn-black btn-block my-5" @click.prevent="onSubmit" :disabled="form.errors.any()">Terminer</button>

                            <moon-loader :loading="loading" :color="color" :size="size"></moon-loader>
                        </form>
                    </company-details>

                    <p class="text-small text-center"><a href="{{ route('index') }}">Passer cette étape</a></p>

                </div>
            </div>
        </div>
    </div>

@endsection