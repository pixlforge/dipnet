@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-md-10 offset-md-1 my-5">
                <div class="card">
                    <div class="card-block">
                        <h2 class="text-center my-5">Modifier les informations de votre profil</h2>

                        <div class="col-xs-12 col-xl-8 offset-xl-2">
                            <form method="POST" action="{{ url("/profile/{$user->id}") }}" role="form">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}

                                {{--Username--}}
                                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                    <label for="username">Nom d'utilisateur</label>
                                    <input type="text" id="username" name="username" class="form-control" value="{{ $user->username }}" placeholder="e.g. John Doe" required autofocus>
                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Email--}}
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">E-mail</label>
                                    <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" placeholder="e.g. votre@email.ch" required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Password--}}
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password">Mot de passe</label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Entre 6 et 45 caractères">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Password confirm--}}
                                <div class="form-group">
                                    <label for="password-confirm">Confirmation du mot de passe</label>
                                    <input type="password" id="password-confirm" name="password_confirmation" class="form-control" placeholder="Répétez votre mot de passe">
                                </div>

                                {{--Contact--}}
                                <div class="form-group{{ $errors->has('contact_id') ? ' has-error' : '' }}">
                                    <label for="contact_id">Contact</label>
                                    <select name="contact_id" id="contact_id" class="custom-select form-control" required>
                                        <option selected disabled>Sélectionnez un contact</option>
                                        <option disabled>&mdash;&mdash;&mdash;&mdash;&mdash;</option>
                                        @forelse ($contacts as $contact)
                                            <option value="{{ $contact->id }}" {{ $user->contact_id == $contact->id ? 'selected' : '' }}>{{ $contact->name }}</option>
                                        @empty
                                            <option disabled>Aucune contact trouvé</option>
                                        @endforelse
                                    </select>
                                    @if ($errors->has('contact_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('contact_id') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Company--}}
                                <div class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">
                                    <label for="company_id">Société</label>
                                    <select name="company_id" id="company_id" class="custom-select form-control" required>
                                        <option selected disabled>Sélectionnez une société</option>
                                        <option disabled>&mdash;&mdash;&mdash;&mdash;&mdash;</option>
                                        @forelse ($companies as $company)
                                            <option value="{{ $company->id }}" {{ $user->company_id == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                        @empty
                                            <option disabled>Aucune contact trouvé</option>
                                        @endforelse
                                    </select>
                                    @if ($errors->has('company_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('company_id') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Submit--}}
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block mt-5">Modifier</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
