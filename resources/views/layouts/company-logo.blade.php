@if (env('APP_NAME') == 'Dipnet')
    <div class="company-logo-container company-logo-dip" aria-hidden="true"></div>
@elseif (env('APP_NAME') == 'Multicop')
    <div class="company-logo-container company-logo-multicop" aria-hidden="true"></div>
@endif