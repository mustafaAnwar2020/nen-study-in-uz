{{-- Must load after jQuery (uses $). Target div lives in app layout. --}}
<style>
    .goog-te-banner-frame,
    .goog-te-ftab,
    .goog-te-balloon-frame,
    .goog-te-menu-frame,
    .skiptranslate {
        display: none !important;
    }

    body {
        top: 0 !important;
    }

    .goog-tooltip,
    .goog-tooltip:hover {
        display: none !important;
    }

    .goog-text-highlight {
        background-color: transparent !important;
        box-shadow: none !important;
    }
</style>
<script>
    window.googleTranslateElementInit = function () {
        var el = document.getElementById('google_translate_element');
        if (!el || typeof google === 'undefined' || !google.translate) {
            return;
        }
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'ar,en,ru',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false
        }, 'google_translate_element');
    };
</script>
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async></script>
<script>
    $(document).ready(function () {
        function setTranslateCookie(language) {
            var expireDate = new Date();
            expireDate.setTime(expireDate.getTime() + (1 * 24 * 60 * 60 * 1000));
            var cookieValue = '/en/' + language;
            var domain = window.location.hostname;

            document.cookie = 'googtrans=' + cookieValue + '; expires=' + expireDate.toGMTString() + '; path=/';
            document.cookie = 'googtrans_global=' + cookieValue + '; expires=' + expireDate.toGMTString() + '; path=/';

            var domainParts = domain.split('.');
            for (var i = 0; i < domainParts.length; i++) {
                var currentDomain = domainParts.slice(i).join('.');
                if (currentDomain.indexOf('.') !== -1) {
                    document.cookie = 'googtrans=' + cookieValue + '; expires=' + expireDate.toGMTString() +
                        '; path=/; domain=' + currentDomain;
                    document.cookie = 'googtrans=' + cookieValue + '; expires=' + expireDate.toGMTString() +
                        '; path=/; domain=.' + currentDomain;
                    document.cookie = 'googtrans_global=' + cookieValue + '; expires=' + expireDate.toGMTString() +
                        '; path=/; domain=' + currentDomain;
                    document.cookie = 'googtrans_global=' + cookieValue + '; expires=' + expireDate.toGMTString() +
                        '; path=/; domain=.' + currentDomain;
                }
            }
        }

        function resetToOriginal() {
            var domain = window.location.hostname;
            var expireDate = 'Thu, 01 Jan 1970 00:00:00 GMT';

            document.cookie = 'googtrans=; expires=' + expireDate + '; path=/';
            document.cookie = 'googtrans_global=; expires=' + expireDate + '; path=/';

            var domainParts = domain.split('.');
            for (var i = 0; i < domainParts.length; i++) {
                var currentDomain = domainParts.slice(i).join('.');
                if (currentDomain.indexOf('.') !== -1) {
                    document.cookie = 'googtrans=; expires=' + expireDate + '; path=/; domain=' + currentDomain;
                    document.cookie = 'googtrans=; expires=' + expireDate + '; path=/; domain=.' + currentDomain;
                    document.cookie = 'googtrans_global=; expires=' + expireDate + '; path=/; domain=' + currentDomain;
                    document.cookie = 'googtrans_global=; expires=' + expireDate + '; path=/; domain=.' + currentDomain;
                }
            }

            if (typeof google !== 'undefined' && google.translate && google.translate.TranslateElement) {
                var selectElement = document.querySelector('.goog-te-combo');
                if (selectElement) {
                    selectElement.value = '';
                    selectElement.dispatchEvent(new Event('change'));
                }
            }
        }

        function changeLanguage(lang) {
            if (lang !== 'en' && (typeof google === 'undefined' || !google.translate)) {
                alert(
                    'Translation feature is blocked by your browser extension (e.g., AdBlocker) or network. Please disable it to switch languages.'
                );
                return;
            }

            if (lang === 'en') {
                resetToOriginal();
            } else {
                setTranslateCookie(lang);
            }

            setTimeout(function () {
                window.location.reload();
            }, 300);
        }

        $(document).on('click', '.dropdown-menu .translate-trigger', function (e) {
            e.preventDefault();
            var lang = $(this).data('lang');
            changeLanguage(lang);
        });

        function updateActiveLanguage() {
            var cookies = document.cookie.split(';');
            var targetCookie = null;

            for (var i = 0; i < cookies.length; i++) {
                var c = cookies[i].trim();
                if (c.indexOf('googtrans=') === 0) {
                    targetCookie = c.substring('googtrans='.length);
                    break;
                }
            }

            var activeLangCode = 'en';
            if (targetCookie && targetCookie !== '/en/en') {
                var parts = targetCookie.split('/');
                if (parts.length >= 3) {
                    activeLangCode = parts[2];
                }
            }

            $('.language-dropdown-toggle').each(function () {
                var $toggle = $(this);
                var $menu = $toggle.siblings('.dropdown-menu').first();
                if (!$menu.length) {
                    $menu = $toggle.closest('.dropdown, .nen-lang-switch, .nav-item').find('> .dropdown-menu').first();
                }

                var $activeItem = $menu.find('.translate-trigger[data-lang="' + activeLangCode + '"]').first();
                if (!$activeItem.length) {
                    return;
                }

                var $flag = $activeItem.find('.flag-icon').first().clone();
                var label = $activeItem.data('label') || $activeItem.clone().children().remove().end().text().trim();

                $toggle.empty().append($flag).append(document.createTextNode(' ' + label));
            });
        }

        updateActiveLanguage();
    });
</script>
