@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Deliveries</h1>
                <h2 class="text-muted">Ajouter un nouvelle livraison</h2>
            </div>
            <div class="col-xs-12 col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-block">
                        <h4 class="text-center my-3">Ajouter une livraison</h4>

                        <div class="col-xs-12 col-xl-8 offset-xl-2">
                            <form method="POST" action="{{ url("/deliveries") }}" role="form">
                                {{ csrf_field() }}

                                {{--Order--}}
                                <div class="form-group{{ $errors->has('order_id') ? ' has-error' : '' }}">
                                    <label for="order_id">Commande</label>
                                    <select name="order_id" id="order_id" class="custom-select form-control" required>
                                        <option selected>Sélectionnez une commande</option>
                                        <option disabled>&mdash;&mdash;&mdash;&mdash;&mdash;</option>
                                        @forelse ($orders as $order)
                                            <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>{{ $order->reference }}</option>
                                        @empty
                                            <option disabled>Aucune commande trouvée</option>
                                        @endforelse
                                    </select>
                                    @if ($errors->has('order_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('order_id') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Contact--}}
                                <div class="form-group{{ $errors->has('contact_id') ? ' has-error' : '' }}">
                                    <label for="contact_id">Contact pour la livraison</label>
                                    <select name="contact_id" id="contact_id" class="custom-select form-control" required>
                                        <option selected>Sélectionnez un contact</option>
                                        <option disabled>&mdash;&mdash;&mdash;&mdash;&mdash;</option>
                                        @forelse ($contacts as $contact)
                                            <option value="{{ $contact->id }}" {{ old('contact_id') == $contact->id ? 'selected' : '' }}>{{ "{$contact->company->name} / {$contact->name}" }}</option>
                                        @empty
                                            <option disabled>Aucun contact trouvé</option>
                                        @endforelse
                                    </select>
                                    @if ($errors->has('contact_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('contact_id') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Internal Comment--}}
                                <div class="form-group{{ $errors->has('internal_comment') ? ' has-error' : '' }}">
                                    <label for="internal_comment">Commentaire (interne seulement)</label>
                                    <input type="text" id="internal_comment" name="internal_comment" class="form-control"
                                           value="{{ old('internal_comment') }}" placeholder="Commentaire">
                                    @if ($errors->has('internal_comment'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('internal_comment') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group mt-4">
                                    <button class="btn btn-block btn-primary" type="submit">Créer</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
