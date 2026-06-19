@php
    $calendarId = $calendarId ?? 'events-calendar';
    $calendarEvents = $calendarEvents ?? [];
    $calendarHeight = $calendarHeight ?? '400px';
@endphp
<section class="events-calendar-section section light-background pt-4 pb-5" aria-labelledby="events-calendar-heading">
    <div class="container">
        <div class="section-title text-center mb-3" data-aos="fade-up">
            <h2 id="events-calendar-heading" class="h3 mb-0">Event calendar</h2>
        </div>
        <div class="events-calendar-panel shadow-sm rounded-3 p-2 p-md-3 bg-white" data-aos="fade-up">
            <div id="{{ $calendarId }}" style="min-height: {{ $calendarHeight }};"></div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var $calendar = $('#{{ $calendarId }}');
            if (!$calendar.length || typeof $.fn.fullCalendar !== 'function') {
                return;
            }

            var events = @json($calendarEvents);

            $calendar.fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: events,
                locale: 'en',
                eventRender: function (event, element) {
                    if (event.country_code) {
                        var flagIcon = '<span class="flag-icon flag-icon-' + event.country_code.toLowerCase() + '"></span>';
                        element.find('.fc-title').prepend(flagIcon + ' ');
                    }
                },
                eventClick: function (calEvent, jsEvent) {
                    if (jsEvent && typeof jsEvent.preventDefault === 'function') {
                        jsEvent.preventDefault();
                    }
                    if (calEvent && calEvent.id && typeof showEventDetails === 'function') {
                        showEventDetails(null, String(calEvent.id));
                    }
                    return false;
                }
            });

            var eventDeepLink = @json(request()->query('event'));
            if (eventDeepLink && typeof showEventDetails === 'function') {
                showEventDetails(null, String(eventDeepLink));
            }
        });
    </script>
@endpush
