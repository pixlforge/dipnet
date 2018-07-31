<header>
  <navbar app-name="{{ config('app.name') }}"
          route-name="{{ Route::currentRouteName() }}"
          avatar-path="{{ auth()->user()->avatarPath() }}"
          random-avatar="{{ 'img/placeholders/' . auth()->user()->randomAvatar() }}"
          user-name="{{ auth()->user()->username }}"
          user-role="{{ auth()->user()->role }}"
          user-company-name="{{ auth()->user()->company->name }}"
          user-company-slug="{{ auth()->user()->company->slug }}"></navbar>
</header>
