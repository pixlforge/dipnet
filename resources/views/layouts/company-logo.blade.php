@if (env('APP_NAME') == 'Dipnet')
    <a href="{{ route('index') }}">
        <div class="company-logo-container company-logo-dip" aria-hidden="true"></div>
    </a>
@elseif (env('APP_NAME') == 'Multicop')
    <a href="{{ route('index') }}">
        <div class="company-logo-container company-logo-multicop" aria-hidden="true"></div>
    </a>
@endif