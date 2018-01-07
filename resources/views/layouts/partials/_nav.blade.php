<header>
  <app-navbar data-app-name="{{ config('app.name') }}"
              data-route-name="{{ Route::currentRouteName() }}"
              data-avatar-path="{{ auth()->user()->avatarPath() }}"
              data-random-avatar="{{ 'img/placeholders/' . auth()->user()->randomAvatar() }}"
              data-user-name="{{ auth()->user()->username }}"
              data-user-role="{{ auth()->user()->role }}"
              data-user-company-name="{{ auth()->user()->company->name }}"
              data-user-company-id="{{ auth()->user()->company->id }}">
  </app-navbar>
</header>
