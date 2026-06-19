@php
    /** @var \App\Models\Event $event */
    $stats = $event->getStatsItems();
@endphp
@if($event->shouldShowStatsSection())
    <section class="event-landing-stats" aria-label="Event statistics">
        <div class="container">
            <div class="event-landing-stats__bar">
                @foreach($stats as $stat)
                    <div class="event-landing-stats__item">
                        @php
                            $value = data_get($stat, 'value', '');
                            $valueParts = preg_split('/(\+)/', $value, -1, PREG_SPLIT_DELIM_CAPTURE);
                        @endphp
                        @if($value)
                            <span class="event-landing-stats__value">
                                @foreach($valueParts as $part)
                                    @if($part === '+')
                                        <span class="highlight">{{ $part }}</span>
                                    @else
                                        {{ $part }}
                                    @endif
                                @endforeach
                            </span>
                        @endif
                        @if(data_get($stat, 'label'))
                            <span class="event-landing-stats__label">{{ data_get($stat, 'label') }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
