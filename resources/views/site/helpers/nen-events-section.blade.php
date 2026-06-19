<section class="nen-section" id="events" style="background: var(--nl-white);">
    <div class="nen-landing__container">

        <div class="nen-events-eyebrow">Events</div>
        <h2 class="nen-section__title">{{ $landing->highlights_title }}</h2>
        <p class="nen-section__subtitle" style="margin-bottom: .25rem;">{{ $landing->highlights_subtitle }}</p>
        <p class="nen-events-explore">
            <a href="{{ route('site.events') }}">Explore all events →</a>
        </p>

        <div class="nen-events-row">

            <div>
                @if($highlightEvents->isNotEmpty())
                    <div class="nen-ev-slider-wrap">
                        @if($highlightEvents->count() > 1)
                            <button type="button" class="nen-ev-arrow nen-ev-arrow--prev" aria-label="Previous event">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
                            </button>
                            <button type="button" class="nen-ev-arrow nen-ev-arrow--next" aria-label="Next event">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                        @endif

                        <div class="nen-ev-slider" id="nenEvSlider">
                        @foreach($highlightEvents as $i => $event)
                            @php
                                /** @var \App\Models\Event $event */
                                $isLive = $event->date && \Carbon\Carbon::parse($event->date)->isToday();
                                $timeLabel = $event->time ?: $event->getLandingTimeLabel();
                                $countryName = $event->getCountryName();
                                $description = strip_tags($event->getLandingDescription() ?? $event->description ?? '');
                            @endphp
                            <div class="nen-ev-slide" data-index="{{ $i }}" style="{{ $i === 0 ? '' : 'display:none' }}">
                                <div class="nen-ev-card">
                                    <div class="nen-ev-card__media">
                                        <img src="{{ $event->getImage() }}"
                                             alt="{{ $event->getLandingTitle() }}"
                                             loading="{{ $i === 0 ? 'eager' : 'lazy' }}">

                                        @if($isLive)
                                            <span class="nen-ev-card__live">
                                                <span class="nen-ev-card__live-dot" aria-hidden="true"></span>
                                                Live
                                            </span>
                                        @else
                                            <span class="nen-ev-card__live">
                                                <span class="nen-ev-card__live-dot" aria-hidden="true"></span>
                                                Upcoming
                                            </span>
                                        @endif

                                        @if($event->date)
                                            <span class="nen-ev-card__date-pill">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M19 4h-1V2h-2v2H8V2H6v2H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2zm0 16H5V9h14v11zM7 11h2v2H7zm4 0h2v2h-2zm4 0h2v2h-2z"/>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($event->date)->format('d-m-Y') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="nen-ev-card__body">
                                        @if($event->date)
                                            <div class="nen-ev-card__date-row">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M19 4h-1V2h-2v2H8V2H6v2H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2zm0 16H5V9h14v11z"/>
                                                </svg>
                                                {{ $event->date }}
                                                @if($timeLabel)
                                                    <span>· {{ $timeLabel }}</span>
                                                @endif
                                            </div>
                                        @endif

                                        <h3 class="nen-ev-card__title">{{ $event->getLandingTitle() }}</h3>

                                        @if($description)
                                            <p class="nen-ev-card__desc">
                                                {{ \Illuminate\Support\Str::limit($description, 140) }}
                                            </p>
                                        @endif

                                        <div class="nen-ev-card__meta">
                                            <span class="event-venue-badge {{ $event->getVenueTypeBadgeClass() }}">
                                                @if($event->isOnline())
                                                    <i class="bi bi-camera-video" aria-hidden="true"></i>
                                                @else
                                                    <i class="bi bi-building" aria-hidden="true"></i>
                                                @endif
                                                {{ $event->getVenueTypeLabel() }}
                                            </span>
                                        </div>

                                        @php
                                            $locationLabel = $event->getLandingLocationLabel();
                                            $showCountry = $countryName && (!$locationLabel || stripos($locationLabel, $countryName) === false);
                                        @endphp
                                        @if(!$event->isOnline() && ($locationLabel || $showCountry))
                                            <div class="nen-ev-card__loc">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/>
                                                </svg>
                                                <span class="nen-ev-card__loc-text">
                                                    @if($locationLabel)
                                                        <span>{{ $locationLabel }}</span>
                                                    @endif
                                                    @if($locationLabel && $showCountry)
                                                        <span class="nen-ev-card__loc-sep" aria-hidden="true">·</span>
                                                    @endif
                                                    @if($showCountry)
                                                        <span class="nen-ev-card__loc-country">
                                                            {{ $countryName }}
                                                            @if($event->country_code)
                                                                <span class="flag-icon flag-icon-{{ $event->country_code }}" aria-hidden="true"></span>
                                                            @endif
                                                        </span>
                                                    @endif
                                                </span>
                                            </div>
                                        @elseif($event->isOnline() && $countryName)
                                            <div class="nen-ev-card__loc">
                                                <span class="nen-ev-card__loc-country">
                                                    {{ $countryName }}
                                                    @if($event->country_code)
                                                        <span class="flag-icon flag-icon-{{ $event->country_code }}" aria-hidden="true"></span>
                                                    @endif
                                                </span>
                                            </div>
                                        @endif

                                        <div class="nen-ev-card__actions">
                                            @if($event->book_now_url)
                                                <a href="{{ $event->book_now_url }}"
                                                   class="nen-ev-card__btn nen-ev-card__btn--primary"
                                                   target="_blank"
                                                   rel="noopener noreferrer">
                                                    Book now
                                                </a>
                                            @endif
                                            <button type="button"
                                                    class="nen-ev-card__btn nen-ev-card__btn--secondary"
                                                    onclick="showEventDetails(this, '{{ $event->id }}')">
                                                Read more
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>

                        @if($highlightEvents->count() > 1)
                            <div class="nen-ev-dots" role="tablist" aria-label="Event slides">
                                @foreach($highlightEvents as $i => $event)
                                    <button
                                        type="button"
                                        class="nen-ev-dot {{ $i === 0 ? 'is-active' : '' }}"
                                        data-slide="{{ $i }}"
                                        role="tab"
                                        aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
                                        aria-label="Slide {{ $i + 1 }}: {{ $event->getLandingTitle() }}"
                                    ></button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <div class="nen-events-empty">No upcoming events at the moment.</div>
                @endif
            </div>

            <div class="nen-cal-panel">
                <div class="nen-cal__header">
                    <div class="nen-cal__nav">
                        <button type="button" class="nen-cal__nav-btn" id="nenCalPrev" aria-label="Previous month">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
                        </button>
                        <span class="nen-cal__month-label" id="nenCalMonthLabel"></span>
                        <button type="button" class="nen-cal__nav-btn" id="nenCalNext" aria-label="Next month">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
                        </button>
                    </div>
                    <button type="button" class="nen-cal__today-btn" id="nenCalToday">Today</button>
                </div>

                <div class="nen-cal__grid" id="nenCalGrid" role="grid" aria-label="Events calendar">
                    @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $dow)
                        <div class="nen-cal__dow" role="columnheader" aria-label="{{ $dow }}">{{ $dow }}</div>
                    @endforeach
                    <div id="nenCalDays" style="display:contents"></div>
                </div>

                <div class="nen-upcoming" id="nenUpcoming" aria-label="Upcoming events this month"></div>
            </div>

        </div>
    </div>
</section>

@push('scripts')
<script>
(function () {
    'use strict';

    var slides   = document.querySelectorAll('.nen-ev-slide');
    var dots     = document.querySelectorAll('.nen-ev-dot');
    var current  = 0;
    var autoTimer;
    var INTERVAL = 8000;

    function showSlide(idx) {
        slides.forEach(function (s, i) {
            s.style.display = i === idx ? '' : 'none';
        });
        dots.forEach(function (d, i) {
            d.classList.toggle('is-active', i === idx);
            d.setAttribute('aria-selected', i === idx ? 'true' : 'false');
        });
        current = idx;
    }

    function nextSlide() {
        showSlide((current + 1) % slides.length);
    }

    function prevSlide() {
        showSlide((current - 1 + slides.length) % slides.length);
    }

    function startAuto() {
        if (slides.length < 2) return;
        autoTimer = setInterval(nextSlide, INTERVAL);
    }

    function stopAuto() { clearInterval(autoTimer); }

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            stopAuto();
            showSlide(parseInt(this.dataset.slide, 10));
            startAuto();
        });
    });

    var prevArrow = document.querySelector('.nen-ev-arrow--prev');
    var nextArrow = document.querySelector('.nen-ev-arrow--next');

    if (prevArrow) {
        prevArrow.addEventListener('click', function () {
            stopAuto();
            prevSlide();
            startAuto();
        });
    }

    if (nextArrow) {
        nextArrow.addEventListener('click', function () {
            stopAuto();
            nextSlide();
            startAuto();
        });
    }

    if (slides.length) {
        startAuto();
    }

    var calendarEvents = @json($calendarEvents);

    var today      = new Date();
    var viewYear   = today.getFullYear();
    var viewMonth  = today.getMonth();

    var MONTHS = ['January','February','March','April','May','June',
                  'July','August','September','October','November','December'];

    var labelEl    = document.getElementById('nenCalMonthLabel');
    var daysEl     = document.getElementById('nenCalDays');
    var upcomingEl = document.getElementById('nenUpcoming');

    if (!labelEl || !daysEl || !upcomingEl) {
        return;
    }

    function openCalendarEvent(ev) {
        if (ev.url) {
            window.location.href = ev.url;
            return;
        }
        if (ev.id && typeof showEventDetails === 'function') {
            showEventDetails(null, String(ev.id));
        }
    }

    function buildEventMap(year, month) {
        var map = {};
        calendarEvents.forEach(function (ev) {
            if (!ev.start) return;
            var d = new Date(ev.start + 'T00:00:00');
            if (d.getFullYear() === year && d.getMonth() === month) {
                var key = d.getDate();
                if (!map[key]) map[key] = [];
                map[key].push(ev);
            }
        });
        return map;
    }

    function renderCalendar(year, month) {
        labelEl.textContent = MONTHS[month] + ' ' + year;

        var firstDay    = new Date(year, month, 1).getDay();
        var daysInMonth = new Date(year, month + 1, 0).getDate();
        var prevDays    = new Date(year, month, 0).getDate();
        var eventMap    = buildEventMap(year, month);

        daysEl.innerHTML = '';

        var totalCells = Math.ceil((firstDay + daysInMonth) / 7) * 7;

        for (var i = 0; i < totalCells; i++) {
            var cell = document.createElement('div');
            var num  = document.createElement('span');
            cell.className = 'nen-cal__day';
            cell.setAttribute('role', 'gridcell');

            var dayNum, isOther = false;

            if (i < firstDay) {
                dayNum = prevDays - firstDay + i + 1;
                isOther = true;
            } else if (i >= firstDay + daysInMonth) {
                dayNum = i - firstDay - daysInMonth + 1;
                isOther = true;
            } else {
                dayNum = i - firstDay + 1;
            }

            num.textContent = dayNum;
            cell.appendChild(num);

            if (isOther) {
                cell.classList.add('is-other');
            } else {
                if (year === today.getFullYear() && month === today.getMonth() && dayNum === today.getDate()) {
                    cell.classList.add('is-today');
                    cell.setAttribute('aria-current', 'date');
                }

                if (eventMap[dayNum]) {
                    cell.classList.add('has-event');
                    var dot = document.createElement('span');
                    dot.className = 'nen-cal__event-dot';
                    dot.setAttribute('aria-hidden', 'true');
                    cell.appendChild(dot);

                    var dayEvent = eventMap[dayNum][0];
                    cell.setAttribute('tabindex', '0');
                    cell.setAttribute('aria-label', 'Events on ' + MONTHS[month] + ' ' + dayNum);
                    cell.addEventListener('click', function () { openCalendarEvent(dayEvent); });
                    cell.addEventListener('keydown', function (e) {
                        if (e.key === 'Enter') openCalendarEvent(dayEvent);
                    });
                }
            }

            daysEl.appendChild(cell);
        }

        renderUpcoming(year, month);
    }

    function renderUpcoming(year, month) {
        var monthEvents = calendarEvents.filter(function (ev) {
            if (!ev.start) return false;
            var d = new Date(ev.start + 'T00:00:00');
            return d.getFullYear() === year && d.getMonth() === month;
        }).sort(function (a, b) { return a.start.localeCompare(b.start); });

        upcomingEl.innerHTML = '';

        if (!monthEvents.length) return;

        var label = document.createElement('div');
        label.className = 'nen-upcoming__label';
        label.textContent = 'Upcoming in ' + MONTHS[month];
        upcomingEl.appendChild(label);

        monthEvents.forEach(function (ev, idx) {
            var d   = new Date(ev.start + 'T00:00:00');
            var day = d.getDate();
            var mon = MONTHS[d.getMonth()].slice(0, 3);

            var item = document.createElement('a');
            item.href = ev.url || '#';
            item.className = 'nen-upcoming__item';
            if (!ev.url) {
                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    openCalendarEvent(ev);
                });
            }

            var stripe = document.createElement('div');
            stripe.className = 'nen-upcoming__stripe' + (idx % 2 === 1 ? ' nen-upcoming__stripe--alt' : '');

            var info = document.createElement('div');
            info.style.cssText = 'flex:1;min-width:0;';

            var name = document.createElement('div');
            name.className = 'nen-upcoming__name';
            name.textContent = ev.title || '';

            var meta = document.createElement('div');
            meta.className = 'nen-upcoming__meta';

            var flag = '';
            if (ev.country_code) {
                flag = '<span class="flag-icon flag-icon-' + ev.country_code + '" aria-hidden="true"></span> ';
            }

            var loc = ev.location ? ' · ' + ev.location : '';
            meta.innerHTML = flag + mon + ' ' + day + loc;

            info.appendChild(name);
            info.appendChild(meta);
            item.appendChild(stripe);
            item.appendChild(info);
            upcomingEl.appendChild(item);
        });
    }

    var prevBtn = document.getElementById('nenCalPrev');
    var nextBtn = document.getElementById('nenCalNext');
    var todayBtn = document.getElementById('nenCalToday');

    if (prevBtn) {
        prevBtn.addEventListener('click', function () {
            viewMonth--;
            if (viewMonth < 0) { viewMonth = 11; viewYear--; }
            renderCalendar(viewYear, viewMonth);
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function () {
            viewMonth++;
            if (viewMonth > 11) { viewMonth = 0; viewYear++; }
            renderCalendar(viewYear, viewMonth);
        });
    }

    if (todayBtn) {
        todayBtn.addEventListener('click', function () {
            viewYear  = today.getFullYear();
            viewMonth = today.getMonth();
            renderCalendar(viewYear, viewMonth);
        });
    }

    renderCalendar(viewYear, viewMonth);
})();
</script>
@endpush
