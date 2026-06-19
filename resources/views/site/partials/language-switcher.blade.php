@php
    $switcherId = $switcherId ?? 'languageDropdown';
    $variant = $variant ?? 'nen';
    $toggleClass = $variant === 'nav'
        ? 'nav-link dropdown-toggle language-dropdown-toggle'
        : 'dropdown-toggle nen-lang-switch__toggle language-dropdown-toggle';
    $wrapperTag = $variant === 'nav' ? 'li' : 'div';
    $wrapperClass = $variant === 'nav' ? 'nav-item dropdown' : 'dropdown nen-lang-switch';
@endphp
<{{ $wrapperTag }} class="{{ $wrapperClass }}">
    <a class="{{ $toggleClass }}"
       href="#"
       id="{{ $switcherId }}"
       role="button"
       data-bs-toggle="dropdown"
       aria-expanded="false"
       aria-label="Select language">
        <i class="bi bi-globe" aria-hidden="true"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="{{ $switcherId }}">
        <li>
            <a class="dropdown-item translate-trigger" href="#" data-lang="en" data-label="EN">
                <span class="flag-icon flag-icon-us me-2"></span> English
            </a>
        </li>
        <li>
            <a class="dropdown-item translate-trigger" href="#" data-lang="ar" data-label="AR">
                <span class="flag-icon flag-icon-sa me-2"></span> العربية
            </a>
        </li>
        <li>
            <a class="dropdown-item translate-trigger" href="#" data-lang="ru" data-label="RU">
                <span class="flag-icon flag-icon-ru me-2"></span> Русский
            </a>
        </li>
    </ul>
</{{ $wrapperTag }}>
