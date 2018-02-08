@extends ('layouts.app')

@section ('title', 'Affaire ' . $business->name)

@section ('content')

  @include ('layouts.partials._nav')

  <app-show-business :data-business="{{ $business }}"
                     :data-contacts="{{ $contacts }}"
                     :data-user="{{ auth()->user() }}"
                     :data-orders="{{ $orders }}"
                     data-avatar-path="{{ auth()->user()->avatarPath() }}"
                     data-random-avatar="{{ 'img/placeholders/' . auth()->user()->randomAvatar() }}"
                     :data-comments="{{ $comments }}">
  </app-show-business>

@endsection