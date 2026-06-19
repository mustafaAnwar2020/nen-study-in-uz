<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>
<div class="floating-icons">
    {{-- WhatsApp --}}
    @php
        $whatsappData = $settings['social']->floating_whatsapp ?? $settings['social']->whatsapp;
        // Ensure we handle the case where it might be a single string (legacy or default)
        if (!is_array($whatsappData) && !is_object($whatsappData)) {
            // It's a string, wrap it to mimic object structure if you want, or just handle separately.
            // But strict logic: if array/object -> Dropdown. If string -> Direct Link.
        }
    @endphp

    @if (is_array($whatsappData) || is_object($whatsappData))
        <div class="btn-group dropup">
            <a href="#" class="floating-icon whatsapp" data-bs-toggle="dropdown" aria-expanded="false"
                style="display: flex; align-items: center; justify-content: center; text-decoration: none;">
                <i class="bi bi-whatsapp"></i>
            </a>
            <ul class="dropdown-menu">
                @foreach ($whatsappData as $wa)
                    @php $wa = (object)$wa; @endphp
                    @if (isset($wa->number))
                        <li><a class="dropdown-item" href="https://wa.me/{{ $wa->number }}"
                                target="_blank">{{ $wa->title ?? $wa->number }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
    @else
        <a href="https://wa.me/{{ $whatsappData }}" target="_blank" class="floating-icon whatsapp">
            <i class="bi bi-whatsapp"></i>
        </a>
    @endif

    {{-- Telegram --}}
    @php
        $telegramData = $settings['social']->floating_telegram ?? $settings['social']->telegram;
    @endphp

    @if (is_array($telegramData) || is_object($telegramData))
        <div class="btn-group dropup">
            <a href="#" class="floating-icon telegram" data-bs-toggle="dropdown" aria-expanded="false"
                style="display: flex; align-items: center; justify-content: center; text-decoration: none;">
                <i class="bi bi-telegram"></i>
            </a>
            <ul class="dropdown-menu">
                @foreach ($telegramData as $tg)
                    @php $tg = (object)$tg; @endphp
                    @if (isset($tg->username))
                        <li><a class="dropdown-item" href="https://t.me/{{ $tg->username }}"
                                target="_blank">{{ $tg->title ?? $tg->username }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
    @else
        <a href="https://t.me/{{ $telegramData }}" target="_blank" class="floating-icon telegram">
            <i class="bi bi-telegram"></i>
        </a>
    @endif

    <a href="/#faq" class="floating-icon faq">
        <i class="bi bi-question-circle"></i>
    </a>
</div>

<div class="s-soft">
    <a href="{{ $settings['social']->facebook }}" target="_blank" class="s-item facebook">
        <span class="fa fa-facebook"></span>
    </a>
    <a href="{{ $settings['social']->twitter }}" target="_blank" class="s-item twitter">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
        </svg>
    </a>
    <a href="{{ $settings['social']->linkedin }}" target="_blank" class="s-item linkedin">
        <span class="fa fa-linkedin"></span>
    </a>
    <a href="{{ $settings['social']->instagram }}" target="_blank" class="s-item instagram">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
        </svg>
    </a>
    <a href="{{ $settings['social']->tiktok }}" target="_blank" class="s-item tiktok">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z" />
        </svg>
    </a>
    <a href="https://www.youtube.com/@nenglobal" target="_blank" class="s-item youtube">
        <span class="fa fa-youtube"></span>
    </a>
    {{--   <a id="so-close" class="s-item print" style="cursor: pointer">
           <span class="fa fa-arrow-right"></span>
       </a> --}}
</div>

<footer id="footer" class="footer dark-background p-2 footer-wrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 footer-about d-flex flex-column flex-lg-row justify-content-between">
                <p class="p-0 m-0 w-100 text-center text-lg-start mb-2 mb-lg-0">
                    <img src="{{ asset('site/images/footer-logo.png') }}" width="50" alt="">
                    Copyright &copy; 2004 - {{ date('Y') }} <a href="/">NEN - National Education Network</a>
                </p>
                <p class="p-0 m-0 w-100 text-center text-lg-end">
                    @if ($settings['general']->phone)
                        {{ $settings['general']->phone }} |
                    @endif
                    @if ($settings['general']->email)
                        <i class="bi bi-envelope"></i> {{ $settings['general']->email }}
                    @endif
                </p>
            </div>
        </div>
    </div>

</footer>


@include('site.partials.google-translate')
<script src="{{ asset('site/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('site/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('site/glightbox.min.js') }}"></script>
<script src="{{ asset('site/isotope.pkgd.min.js') }}"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="{{ asset('site/main.js') }}{{ assetVersion() }}"></script>
@include('includes.toastr')
<script>
    // Offer countdown (initial page + dynamically loaded offer modals)
    window.initOfferCountdowns = function (root) {
        root = root || document;
        const countdownElements = root.querySelectorAll('.counter:not([data-offer-countdown-init])');

        countdownElements.forEach((counter) => {
            counter.setAttribute('data-offer-countdown-init', '1');

            const daysElement = counter.querySelector('.time.days');
            const hoursElement = counter.querySelector('.time.hours');
            const minutesElement = counter.querySelector('.time.minutes');
            const secondsElement = counter.querySelector('.time.seconds');

            if (!daysElement || !hoursElement || !minutesElement || !secondsElement) {
                return;
            }

            const rawDate = counter.getAttribute('data-date');
            const targetDate = rawDate ? new Date(rawDate).getTime() : NaN;
            if (Number.isNaN(targetDate)) {
                return;
            }

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = targetDate - now;

                if (distance < 0) {
                    counter.classList.add('counter-expired');
                    counter.textContent = 'Expired';
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                daysElement.textContent = days + ' d';
                hoursElement.textContent = hours + ' h';
                minutesElement.textContent = minutes + ' m';
                secondsElement.textContent = seconds + ' s';
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    };

    document.addEventListener('DOMContentLoaded', function () {
        window.initOfferCountdowns(document);
    });


    function showOfferDetails(ele, offer) {
        $(ele).attr('disabled', true);
        const originalContent = $(ele).html();
        $(ele).html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

        $.ajax({
            url: '{{ route('ajax.get-offer-details') }}',
            method: 'POST',
            data: {
                offer_id: offer,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#offerDetails' + offer).remove();
                $('body').append(response);
                var modalEl = document.getElementById('offerDetails' + offer);
                $('#offerDetails' + offer).modal('show');
                if (modalEl && typeof window.initOfferCountdowns === 'function') {
                    window.initOfferCountdowns(modalEl);
                }
            },
            error: function(xhr) {
                console.error('Error fetching offer details:', xhr.responseText);
            },
            complete: function() {
                $(ele).html(originalContent);
                $(ele).attr('disabled', false);
            }
        });
    }


    function showEventDetails(ele, eventId) {
        var $trigger = ele ? $(ele) : $();
        var originalContent = null;

        if ($trigger.length && ($trigger.is('button') || $trigger.is('a'))) {
            originalContent = $trigger.html();
            $trigger.prop('disabled', true);
            if ($trigger.is('button')) {
                $trigger.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            }
        }

        $('#eventDetails' + eventId).remove();

        $.ajax({
            url: '{{ route('ajax.get-event-details') }}',
            method: 'POST',
            data: {
                event_id: eventId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('body').append(response);
                var modalEl = document.getElementById('eventDetails' + eventId);
                if (!modalEl) {
                    return;
                }
                var $modal = $(modalEl);
                $modal.on('hidden.bs.modal', function() {
                    $modal.remove();
                });
                if (typeof bootstrap !== 'undefined') {
                    bootstrap.Modal.getOrCreateInstance(modalEl).show();
                } else {
                    $modal.modal('show');
                }
            },
            error: function(xhr) {
                console.error('Error fetching event details:', xhr.responseText);
            },
            complete: function() {
                if ($trigger.length && originalContent !== null) {
                    $trigger.html(originalContent);
                    $trigger.prop('disabled', false);
                }
            }
        });
    }

    $(document).ready(function() {
        $('#so-close').click(function() {
            $('.s-soft').addClass('so-collapse');
            $('#so-open').delay(300).css('left', '0');
        });

        $('#so-open').click(function() {
            $('#so-open').css('left', '-60px');
            $('.s-soft').removeClass('so-collapse');
        });


        $(document).on('click', '.clickable-image', function() {
            var $img = $(this);
            $('#modalImage').attr('src', $img.attr('src') || '').attr('alt', $img.attr('alt') || '');
        });

        (function () {
            var offerHtml5VideoModal = document.getElementById('offerHtml5VideoModal');
            var offerHtml5VideoPlayer = document.getElementById('offerHtml5VideoModalPlayer');
            var offerHtml5VideoTitle = document.getElementById('offerHtml5VideoModalLabel');
            var defaultOfferVideoTitle = @json(__('Video'));
            if (!offerHtml5VideoModal || !offerHtml5VideoPlayer) {
                return;
            }
            offerHtml5VideoModal.addEventListener('show.bs.modal', function (event) {
                var trigger = event.relatedTarget;
                var src = trigger && trigger.getAttribute('data-video-src');
                if (src) {
                    offerHtml5VideoPlayer.src = src;
                }
                if (offerHtml5VideoTitle && trigger) {
                    var title = trigger.getAttribute('data-video-title');
                    offerHtml5VideoTitle.textContent = title || defaultOfferVideoTitle;
                }
                document.querySelectorAll('[data-offer-site-media] video').forEach(function (v) {
                    v.pause();
                });
            });
            offerHtml5VideoModal.addEventListener('hidden.bs.modal', function () {
                offerHtml5VideoPlayer.pause();
                offerHtml5VideoPlayer.removeAttribute('src');
                offerHtml5VideoPlayer.load();
            });
        })();

        $(document).on('click', '.event-pdf-preview-btn', function () {
            var url = $(this).data('pdf-url');
            var $frame = $(this).closest('.offer-site-media__pdf-panel').find('.event-pdf-preview-frame');
            if (!url || !$frame.length) {
                return;
            }
            $frame.removeAttr('hidden').html(
                '<iframe title="Event PDF preview" class="w-100 border-0" style="min-height: 220px; height: 42vh;" src="' + url + '#view=FitH"></iframe>'
            );
        });

        $(document).on('click', '[data-offer-site-media] [data-media-tab-btn]', function () {
            var $btn = $(this);
            var $wrap = $btn.closest('[data-offer-site-media]');
            var key = $btn.data('media-tab-btn');
            $wrap.find('[data-media-tab-btn]').removeClass('active').attr('aria-selected', 'false');
            $btn.addClass('active').attr('aria-selected', 'true');
            $wrap.find('[data-media-pane]').removeClass('is-active');
            $wrap.find('[data-media-pane="' + key + '"]').addClass('is-active');

            if (key === 'video') {
                var src = $btn.attr('data-video-src');
                if (src && typeof bootstrap !== 'undefined') {
                    var modalEl = document.getElementById('offerHtml5VideoModal');
                    var player = document.getElementById('offerHtml5VideoModalPlayer');
                    var titleEl = document.getElementById('offerHtml5VideoModalLabel');
                    var defaultOfferVideoTitle = @json(__('Video'));
                    if (modalEl && player) {
                        var title = $btn.attr('data-video-title');
                        player.src = src;
                        if (titleEl) {
                            titleEl.textContent = title || defaultOfferVideoTitle;
                        }
                        document.querySelectorAll('[data-offer-site-media] video').forEach(function (v) {
                            v.pause();
                        });
                        bootstrap.Modal.getOrCreateInstance(modalEl).show();
                    }
                }
            }
        });

    });
</script>
