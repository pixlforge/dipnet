@include('layouts.nav')

@extends('layouts.app')

@section('content')

    <div class="container-fluid my-5">
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="row">
                    <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only">

                        {{--Page title--}}
                        <h1 class="mt-5">
                            Contacts
                        </h1>

                        {{--Add contact vue component--}}
                        <add-contact v-cloak></add-contact>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-grey-light">
        <div class="row">
            <div class="col-10 mx-auto my-7">

                @foreach ($contacts as $contact)
                    <div class="card card-custom center-on-small-only">
                        
                        <div class="col col-lg-1 hidden-md-down">
                            <img src="{{ asset('img/placeholders/contact-bullet.jpg') }}" alt="Bullet" class="img-bullet">
                        </div>

                        <div class="col-12 col-lg-2">

                            {{--Name--}}
                            <h5 class="mb-0">
                                {{ $contact->name }}
                            </h5>
                        </div>

                        <div class="col-12 col-lg-2">

                            {{--Address line 1--}}
                            <div>
                                <span class="card-content">{{ $contact->address_line1 }}</span>
                            </div>

                            {{--Address line 2--}}
                            <div>
                                <span class="card-content">{{ $contact->address_line2 }}</span>
                            </div>

                            {{--Zip & City--}}
                            <div>
                                <span class="card-content">{{ $contact->zip }}</span>
                                <span class="card-content">{{ $contact->city }}</span>
                            </div>
                        </div>

                        <div class="col-12 col-lg-3">

                            {{--Phone--}}
                            <div>
                                <span class="card-content"><em>Tel:</em></span>
                                <span class="card-content ml-1">{{ $contact->phone_number }}</span>
                            </div>

                            {{--Fax--}}
                            @unless ($contact->company_id == null)
                                <div>
                                    <span class="card-content"><em>Fax:</em></span>
                                    <span class="card-content ml-1">{{ $contact->fax }}</span>
                                </div>
                            @endunless

                            {{--Email--}}
                            <div>
                                <span class="card-content"><em>Email:</em></span>
                                <span class="card-content ml-1">{{ $contact->email }}</span>
                            </div>
                        </div>

                        <div class="col-12 col-lg-3">

                            {{--Company--}}
                            @unless ($contact->company_id == null)
                                <div>
                                    <span class="card-content"><em>Société:</em></span>
                                    <span class="card-content ml-1">{{ $contact->company->name }}</span>
                                </div>
                            @endunless

                            {{--Created at--}}
                            <div>
                                <span class="card-content"><em>Créé:</em></span>
                                <span class="card-content ml-1">{{ $contact->created_at->formatLocalized('%d %B %Y') }}</span>
                            </div>

                            {{--Modified at--}}
                            <div>
                                <span class="card-content"><em>Modifié:</em></span>
                                <span class="card-content ml-1">{{ $contact->updated_at->formatLocalized('%d %B %Y') }}</span>
                            </div>

                            {{--Created by--}}
                            <div>
                                <span class="card-content"><em>Par:</em></span>
                                <span class="card-content ml-1">{{ $contact->created_by_username }}</span>
                            </div>
                        </div>

                        <div class="col-12 col-lg-1 center-on-small-only text-lg-right">

                            {{--Dropdown--}}
                            <div class="dropdown">
                                <a class="btn btn-transparent btn-sm" type="button" id="dropdownMenuLink"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right"
                                     aria-labelledby="dropdownMenuLink">
                                    @unless ($contact->deleted_at === null)
                                        <form method="POST"
                                              action="{{ url("/contacts/{$contact->id}/restore") }}">
                                            {{ method_field('PUT') }}
                                            {{ csrf_field() }}

                                            <button class="dropdown-item text-success" type="submit">
                                                <i class="fa fa-refresh"></i>
                                                <span class="ml-3">Restaurer</span>
                                            </button>
                                        </form>
                                    @else
                                        <a class="dropdown-item"
                                           href="{{ url("/contacts/{$contact->id}/edit") }}">
                                            <i class="fa fa-pencil"></i>
                                            <span class="ml-3">Modifier</span>
                                        </a>
                                        <form method="POST" action="{{ url("/contacts/{$contact->id}") }}">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button class="dropdown-item text-danger" type="submit">
                                                <i class="fa fa-trash"></i>
                                                <span class="ml-3">Supprimer</span>
                                            </button>
                                        </form>
                                    @endunless
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection