@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Orders</h1>
                <h2 class="text-muted">Modifier la commande {{ $order->reference }}</h2>
            </div>
            <div class="col-xs-12 col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-block">
                        <h4 class="text-center my-3">Modifier une commande</h4>

                        <div class="col-xs-12 col-xl-8 offset-xl-2">
                            <form method="POST" action="{{ url("/orders/{$order->id}") }}" role="form">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}

                                {{--Reference--}}
                                <div class="form-group{{ $errors->has('reference') ? ' has-error' : '' }}">
                                    <label for="reference">Référence</label>
                                    <input type="text" id="reference" name="reference" class="form-control"
                                           value="{{ $order->reference }}" placeholder="A34F123.00" required autofocus>
                                    @if ($errors->has('reference'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('reference') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Status--}}
                                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="custom-select form-control" required>
                                        <option selected>Sélectionnez un status</option>
                                        <option disabled>&mdash;&mdash;&mdash;&mdash;&mdash;</option>
                                        <option value="ok" {{ $order->status == 'ok' ? 'selected' : '' }}>Ok</option>
                                        <option value="nok" {{ $order->status == 'nok' ? 'selected' : '' }}>Nok</option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Business--}}
                                <div class="form-group{{ $errors->has('business_id') ? ' has-error' : '' }}">
                                    <label for="business_id">Affaire</label>
                                    <select name="business_id" id="business_id" class="custom-select form-control" required>
                                        <option selected>Sélectionnez une affaire</option>
                                        <option disabled>&mdash;&mdash;&mdash;&mdash;&mdash;</option>
                                        @forelse ($businesses as $business)
                                            <option value="{{ $business->id }}" {{ $order->business_id == $business->id ? 'selected' : '' }}>{{ "{$business->company->name} / {$business->name}" }}</option>
                                        @empty
                                            <option disabled>Aucune affaire trouvée</option>
                                        @endforelse
                                    </select>
                                    @if ($errors->has('business_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('business_id') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--Contact--}}
                                <div class="form-group{{ $errors->has('contact_id') ? ' has-error' : '' }}">
                                    <label for="contact_id">Contact</label>
                                    <select name="contact_id" id="contact_id" class="custom-select form-control" required>
                                        <option selected>Sélectionnez un contact</option>
                                        <option disabled>&mdash;&mdash;&mdash;&mdash;&mdash;</option>
                                        @forelse ($contacts as $contact)
                                            <option value="{{ $contact->id }}" {{ $order->contact_id == $contact->id ? 'selected' : '' }}>{{ "{$contact->company->name} / {$contact->name}" }}</option>
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

                                {{--Submit--}}
                                <div class="form-group mt-4">
                                    <button class="btn btn-block btn-primary" type="submit">Mettre à jour</button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
