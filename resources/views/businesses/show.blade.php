@extends('layouts.app')

@section('title', 'Affaire "' . $business->name . '"')

@section('content')
  @include('layouts.partials._nav')
  <show-business
    :business="{{ $business }}"
    :contacts="{{ $contacts }}"
    :user="{{ auth()->user() }}"
    :orders="{{ $orders }}"
    avatar-path="{{ auth()->user()->avatarPath() }}"
    random-avatar="{{ 'img/placeholders/' . auth()->user()->randomAvatar() }}"
    :comments="{{ $comments }}"></show-business>
@endsection