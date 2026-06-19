@extends('site.layouts.app')

@push('styles')
    <style>
        section#services.services.section {
            overflow: visible;
        }

        .events-page-region .events-page-card {
            border-radius: 1rem;
            overflow: hidden;
        }

        .events-page-region .event-card__media {
            padding: 1rem 1rem 0;
        }

        .events-page-region .event-card__media img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 0.5rem;
        }

        .events-page-region .event-card__body {
            padding: 1rem 1.25rem 1.25rem;
        }

        .events-page-region .event-card-meta__place {
            display: inline-flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.35rem;
        }

        .events-page-region .fc-event {
            cursor: pointer;
        }

        body.modal-open .s-soft,
        body.modal-open .floating-icons {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
    </style>
@endpush

@section('content')
    <section id="services" class="services section events-page-region">

        <div class="container section-title aos-init aos-animate" data-aos="fade-up">
            <h2>{{ $pageTitle }}</h2>
            <form method="get" class="mt-3">
                <div class="row text-left g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="event-filter-date" class="form-label">Date</label>
                        <input id="event-filter-date" type="date" value="{{ request()->input('date') }}" name="date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="event-filter-country" class="form-label">Country</label>
                        <select id="event-filter-country" name="country_code" class="form-control">
                            <option value="">All countries</option>
                            @foreach(config('countries') as $key => $country)
                                <option
                                    {{ request()->input('country_code') == $key ? 'selected' : '' }}
                                    value="{{ $key }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="event-filter-type" class="form-label">Type</label>
                        <select id="event-filter-type" name="is_online" class="form-control">
                            <option value="">All types</option>
                            <option {{ request()->input('is_online') === 'yes' ? 'selected' : '' }} value="yes">Online</option>
                            <option {{ request()->input('is_online') === 'no' ? 'selected' : '' }} value="no">On-site</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-dark">Filter</button>
                        <a href="{{ route('site.events') }}" class="btn btn-outline-secondary text-decoration-none">Reset</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="container">
            <div class="row gy-4">
                @forelse($rows as $event)
                    <div class="col-md-6 col-lg-4 d-flex">
                        @include('site.helpers.event-grid-card', ['event' => $event])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="shadow p-4 mt-2 mb-2 text-center rounded-3">
                            There are no events with these filters.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

    </section>

    @include('site.helpers.events-calendar', [
        'calendarId' => 'events-calendar',
        'calendarEvents' => $eventsCalender,
        'calendarHeight' => '420px',
    ])
@stop

@include('site.assets')
