@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-1">Users</h1>
                <h2 class="text-muted">Liste de tous les utilisateurs</h2>
            </div>
            <div class="col-12">
                <p class="text-center mb-5">Il existe actuellement <strong>{{ $users->count() }}</strong> utilisateurs au total.</p>
                <div class="card-columns">
                    @foreach ($users as $user)
                        <a class="link-unstyled" href="{{ url('/users/' . $user->username) }}">
                            <div class="card">
                                <div class="card-block">
                                    <h3 class="card-title">{{ $user->username }}</h3>
                                    <ul class="list-unstyled">
                                        <li><em>Role</em>: {{ $user->role }}</li>
                                        <li><em>Email</em>: {{ $user->email }}</li>
                                        @unless ($user->contact_id === null)
                                            <li><em>Contact principal</em>: {{ $user->contact->name }}</li>
                                        @endunless
                                        @unless ($user->company_id === null)
                                            <li><em>Société</em>: {{ $user->company->name }}</li>
                                        @endunless
                                        <li>
                                            <em>Created at</em>: {{ $user->created_at->format('d M Y') }}
                                            <small>{{ $user->created_at->diffForHumans() }}</small>
                                        </li>
                                        <li>
                                            <em>Updated at</em>: {{ $user->updated_at->format('d M Y') }}
                                            <small>{{ $user->updated_at->diffForHumans() }}</small>
                                        </li>
                                        @unless($user->deleted_at === null)
                                            <li>
                                                <div class="bg-danger text-white">
                                                    <em>Deleted at</em>: {{ $user->deleted_at->format('d M Y') }}
                                                    <small>{{ $user->deleted_at->diffForHumans() }}</small>
                                                </div>
                                            </li>
                                        @endunless
                                    </ul>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
