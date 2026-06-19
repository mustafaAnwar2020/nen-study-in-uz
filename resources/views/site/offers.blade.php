@extends('site.layouts.app')

@push('styles')
    <style>
        /* This page stacks tall content; global main.css uses overflow: clip on .section which clips shadows & tall cards */
        section#services.services.section {
            overflow: visible;
        }

        .special-offers-region {
            margin-bottom: 3rem;
            padding-bottom: 0.5rem;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .special-offers-region .special-offer-card {
            max-width: none;
            width: 100%;
            min-height: 300px;
        }

        .special-offers-region .special-offer-card__inner {
            min-height: 300px;
        }

        .special-offers-region .special-offer-card__media {
            flex: 0 0 38%;
            max-width: 42%;
            min-height: 300px;
        }

        .special-offers-region .special-offer-card__body {
            padding: 1.5rem 2rem 1.35rem;
        }

        .special-offers-region .special-offer-card__desc-wrap {
            height: 10.5rem;
            max-height: 10.5rem;
            min-height: 10.5rem;
            margin-bottom: 0.75rem;
        }

        .special-offers-region .special-offer-card__desc {
            font-size: 1rem;
            line-height: 1.55;
        }

        .special-offers-region .special-offers-swiper-track {
            padding: 0 0.25rem;
        }

        .offers-page-main-title {
            position: relative;
            z-index: 2;
            background-color: var(--background-color, #fff);
            padding-top: 0.25rem;
        }

        .special-offers-swiper-track {
            position: relative;
            padding: 0 2.75rem;
            z-index: 3;
        }

        /* Swiper bundle sets .swiper { padding: 0 }, which clips autoHeight / tall slides; top pad stays on .swiper */
        .special-offers-swiper.swiper {
            padding: 0.75rem 0 0 !important;
            margin-bottom: 0;
        }

        .special-offers-swiper.swiper .swiper-wrapper {
            align-items: stretch;
        }

        .special-offers-swiper .swiper-slide {
            height: auto;
            box-sizing: border-box;
            min-width: 0;
        }

        .special-offers-swiper-track .swiper-button-prev,
        .special-offers-swiper-track .swiper-button-next {
            position: absolute;
            top: 50%;
            left: auto;
            right: auto;
            margin-top: 0;
            transform: translateY(-50%);
            z-index: 4;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: #fff;
            color: #212529;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .special-offers-swiper-track .swiper-button-prev {
            left: 0;
        }

        .special-offers-swiper-track .swiper-button-next {
            right: 0;
        }

        .special-offers-swiper-track .swiper-button-prev::after,
        .special-offers-swiper-track .swiper-button-next::after {
            font-size: 0.85rem;
            font-weight: 700;
        }

        .special-offers-swiper-track .swiper-button-prev:hover,
        .special-offers-swiper-track .swiper-button-next:hover {
            background: #f8f9fa;
            color: #000;
        }

        .special-offers-swiper-track .swiper-button-disabled {
            opacity: 0.35;
            pointer-events: none;
        }

        .special-offers-swiper-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 0.35rem;
            padding: 0 0.25rem 0.75rem;
            position: relative;
            z-index: 1;
        }

        .special-offers-swiper-controls .swiper-pagination {
            position: static;
            width: auto;
            margin: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.35rem;
        }

        .special-offers-swiper .swiper-pagination-bullet-active {
            background: #212529;
        }

        /* Match index / offers grid: global custom.css hides .counter below 991px */
        #services .counter {
            display: flex !important;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
            margin: 0.5rem 0;
        }

        @media (max-width: 991px) {
            #services .counter .time {
                font-size: 16px;
                padding: 5px 8px;
            }

            #services .counter span {
                font-size: 30px;
            }
        }

        .offers-grid .offers-page-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            border-radius: 1rem;
            border: 0;
            overflow: hidden;
        }

        .offers-grid .offers-page-card .card-body-wrap {
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            padding: 1rem 1rem 1.25rem;
            min-width: 0;
        }

        .offers-grid .offers-page-card h4 {
            overflow-wrap: anywhere;
            word-break: break-word;
            line-height: 1.35;
        }

        .offers-grid .offers-card-actions {
            width: 100%;
            margin-top: auto;
            padding-top: 0.75rem;
        }

        .offers-grid .offers-card-actions-inner {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            width: 100%;
            align-items: stretch;
        }

        .offers-grid .offers-card-actions-inner--single {
            grid-template-columns: 1fr;
        }

        .offers-grid .offers-card-action-cell {
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        .offers-grid .offers-card-action-cell .btn-group {
            flex: 1 1 auto;
            display: flex;
        }

        .offers-grid .offers-card-action-cell .dropdown {
            flex: 1 1 auto;
        }

        .special-offers-region .offer-site-media__pdf-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            margin-top: 0.6rem;
        }

        .special-offers-region .offer-site-media__pdf-actions .btn {
            margin-top: 0 !important;
        }

        .special-offers-region .special-offer-card,
        .special-offers-region .special-offer-card__inner,
        .special-offers-region .special-offer-card__body {
            overflow: visible;
        }

        .special-offers-region .special-offer-card__actions {
            position: relative;
            z-index: 6;
        }

        .special-offers-region .special-offer-card__actions .dropdown-menu {
            z-index: 1100;
            max-height: 16rem;
            overflow-y: auto;
        }

        /* Swiper needs overflow clipping for slides, but country dropdowns must escape while open */
        .special-offers-region .special-offers-swiper.swiper.special-offers-swiper--dropdown-open,
        .special-offers-region .special-offers-swiper.swiper.special-offers-swiper--dropdown-open .swiper-wrapper,
        .special-offers-region .special-offers-swiper.swiper.special-offers-swiper--dropdown-open .swiper-slide {
            overflow: visible;
        }

        /* Keep global floating social widgets from overlapping modal/content on this page */
        body.modal-open .s-soft,
        body.modal-open .floating-icons {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        @media (max-width: 991px) {
            .special-offers-region .special-offer-card__media {
                flex: none;
                max-width: none;
                min-height: 220px;
            }

            .special-offers-region .special-offer-card__desc-wrap {
                height: 9rem;
                max-height: 9rem;
                min-height: 9rem;
            }

            .special-offers-swiper-track {
                padding: 0 0.5rem;
            }

            .special-offers-swiper-track .swiper-button-prev,
            .special-offers-swiper-track .swiper-button-next {
                display: none;
            }

            .offers-page-main-title h2 {
                margin-bottom: 1rem;
                font-size: clamp(2rem, 8vw, 2.7rem);
            }

            .offers-page-main-title .row > [class*="col-"] {
                margin-bottom: 0.2rem;
            }

            .offers-page-main-title .col-md-6.col-lg-2.d-flex.align-items-end.flex-wrap {
                gap: 0.5rem;
            }

            .offers-page-main-title .col-md-6.col-lg-2.d-flex.align-items-end.flex-wrap .btn {
                flex: 1 1 auto;
                margin-right: 0 !important;
            }

            .offers-grid .offers-card-actions-inner {
                grid-template-columns: 1fr;
            }

            .offers-grid .offers-card-action-cell .btn-group,
            .offers-grid .offers-card-action-cell .btn,
            .offers-grid .offers-card-action-cell .dropdown {
                width: 100%;
            }

            .s-soft {
                display: none !important;
            }
        }

        @media (max-width: 575px) {
            .floating-icons {
                right: 0.5rem;
                bottom: 4.5rem;
                gap: 0.45rem;
            }

            .floating-icon {
                width: 44px;
                height: 44px;
                font-size: 20px;
            }

            .special-offers-region .special-offer-card__actions {
                gap: 0.5rem;
            }

            .special-offers-region .special-offer-card__actions .dropdown,
            .special-offers-region .special-offer-card__actions .btn {
                width: 100%;
            }

            .special-offers-region .special-offer-card__actions .special-offer-card__btn {
                display: flex;
                justify-content: center;
            }
        }

    </style>
@endpush

@section('content')
    <section id="services" class="services section">

        @if(isset($specialOffers) && $specialOffers->isNotEmpty())
            <div id="special-offers-anchor" class="container pt-4 special-offers-region">
                <div class="section-title aos-init aos-animate mb-3" data-aos="fade-up">
                    <h2 class="h3 mb-0">Special offers</h2>
                </div>
                <div class="special-offers-swiper-outer">
                    <div class="special-offers-swiper-track">
                        <button type="button" class="swiper-button-prev special-offers-nav-prev" aria-label="Previous offer"></button>
                        <div class="swiper special-offers-swiper">
                            <div class="swiper-wrapper">
                                @foreach($specialOffers as $offer)
                                    <div class="swiper-slide">
                                        <article class="special-offer-card">
                                            <div class="special-offer-card__inner" data-offer-site-media data-offer-id="{{ $offer->id }}">
                                                <div class="special-offer-card__media">
                                                    @include('site.helpers.offer-site-media', ['offer' => $offer, 'tabsPlacement' => 'body'])
                                                </div>
                                                <div class="special-offer-card__body">
                                                    <div class="special-offer-card__label">Details</div>
                                                    @if($offer->date)
                                                        <div class="special-offer-card__date">Expires on: {{ $offer->date }}</div>
                                                    @endif
                                                    <h3 class="special-offer-card__title">{{ $offer->name }}</h3>
                                                    <div
                                                        class="special-offer-card__desc-wrap{{ $offer->description ? '' : ' special-offer-card__desc-wrap--empty' }}"
                                                        @if(!$offer->description) aria-hidden="true" @endif
                                                    >
                                                        @if($offer->description)
                                                            <p class="special-offer-card__desc">{{ strip_tags($offer->description) }}</p>
                                                        @endif
                                                    </div>
                                                    @if($offer->date)
                                                        <div class="counter" data-date="{{ $offer->date }}">
                                                            <div class="time days"></div>
                                                            <span>:</span>
                                                            <div class="time hours"></div>
                                                            <span>:</span>
                                                            <div class="time minutes"></div>
                                                            <span>:</span>
                                                            <div class="time seconds"></div>
                                                        </div>
                                                    @endif
                                                    <div class="special-offer-card__actions">
                                                        @include('site.helpers.offer-book-now-button', [
                                                            'offer' => $offer,
                                                            'buttonClass' => 'btn btn-dark special-offer-card__btn',
                                                            'wrapperClass' => '',
                                                        ])
                                                        @include('site.helpers.offer-more-details-link', [
                                                            'offer' => $offer,
                                                            'linkClass' => 'btn btn-outline-dark special-offer-card__btn text-decoration-none',
                                                        ])
                                                    </div>
                                                    @include('site.helpers.special-offer-toolbar', ['offer' => $offer])
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="button" class="swiper-button-next special-offers-nav-next" aria-label="Next offer"></button>
                    </div>
                    <div class="special-offers-swiper-controls" aria-label="Special offers carousel">
                        <div class="swiper-pagination special-offers-pagination"></div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Section Title -->
        <div class="container section-title offers-page-main-title aos-init aos-animate" data-aos="fade-up">
            <h2>{{$pageTitle}}</h2>
            <form method="get">
                @if(request()->filled('special'))
                    <input type="hidden" name="special" value="{{ request()->query('special') }}">
                @endif
                <div class="row text-left gy-2">
                    <div class="col-md-6 col-lg-3">
                        <label for="offer-filter-valid-from">Valid from</label>
                        <input id="offer-filter-valid-from" type="date" value="{{ request()->input('valid_from') }}" name="valid_from" class="form-control">
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label for="offer-filter-valid-to">Valid to</label>
                        <input id="offer-filter-valid-to" type="date" value="{{ request()->input('valid_to') }}" name="valid_to" class="form-control">
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <label for="offer-filter-country">Country</label>
                        <select id="offer-filter-country" name="country_code" class="form-control">
                            <option value="">All</option>
                            @foreach($offerCountries as $country)
                                <option
                                        {{ request()->input('country_code') == $country['code'] ? 'selected' : '' }}
                                        value="{{ $country['code'] }}">{{ $country['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <label for="offer-filter-type">Type</label>
                        <select id="offer-filter-type" name="is_online" class="form-control">
                            <option value="">All</option>
                            <option {{ request()->input('is_online') == 'yes' ? 'selected' : '' }} value="yes">Is online</option>
                            <option {{ request()->input('is_online') == 'no' ? 'selected' : '' }} value="no">Is not online</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-2 d-flex align-items-end flex-wrap">
                        <button type="submit" class="btn btn-sm btn-dark me-2 mb-2">Filter</button>
                        @php
                            $offersResetQuery = [];
                            if (request()->filled('special')) {
                                $offersResetQuery['special'] = request()->query('special');
                            }
                        @endphp
                        <a href="{{ route('site.offers', $offersResetQuery) }}" class="btn btn-sm btn-outline-secondary text-decoration-none mb-2">Reset filters</a>
                    </div>
                </div>
            </form>
        </div>


        <div class="container">
            <div class="row gy-4 offers-grid">
                @forelse($rows as $offer)
                    <div class="col-md-4 d-flex">
                        <div class="card shadow position-relative offers-page-card w-100">
                            <div class="icon">
                                <img src="{{asset($offer->getImage())}}" alt="" class="img-fluid">
                            </div>
                            <div class="text-center card-body-wrap">
                                <h4 style="cursor: pointer"
                                    onclick="showOfferDetails(this, '{{$offer->id}}')">{{$offer->name}}</h4>
                                @if($offer->date)
                                    <div class="counter my-2" data-date="{{ $offer->date }}">
                                        <div class="time days"></div>
                                        <span>:</span>
                                        <div class="time hours"></div>
                                        <span>:</span>
                                        <div class="time minutes"></div>
                                        <span>:</span>
                                        <div class="time seconds"></div>
                                    </div>
                                @endif
                                @php
                                    $gridHasBookNow = ($offer->use_book_now && count($offer->getBookNowUrl())) || !empty($offer->book_now_url);
                                @endphp
                                <div class="offers-card-actions">
                                    <div class="offers-card-actions-inner{{ $gridHasBookNow ? '' : ' offers-card-actions-inner--single' }}">
                                        @if($gridHasBookNow)
                                            <div class="offers-card-action-cell">
                                                @include('site.helpers.offer-book-now-button', [
                                                    'offer' => $offer,
                                                    'buttonClass' => 'btn btn-dark',
                                                    'forBtnGroup' => true,
                                                    'fullWidth' => true,
                                                ])
                                            </div>
                                        @endif
                                        <div class="offers-card-action-cell">
                                            @include('site.helpers.offer-more-details-link', [
                                                'offer' => $offer,
                                                'linkClass' => 'btn btn-outline-dark',
                                                'fullWidth' => true,
                                            ])
                                            @if(!$offer->hasConfiguredMoreDetails())
                                                <button
                                                        type="button"
                                                        onclick="showOfferDetails(this, '{{$offer->id}}')"
                                                        class="btn btn-outline-dark w-100">
                                                    Show more
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                <div class="col-md-12">
                    <div class="shadow p-4 mt-5 mb-5 text-center">
                        There are no offers with these filters.
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    @if(isset($specialOffers) && $specialOffers->isNotEmpty())
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    if (typeof Swiper === 'undefined') {
                        return;
                    }
                    var root = document.querySelector('.special-offers-swiper');
                    if (!root) {
                        return;
                    }
                    var slides = root.querySelectorAll('.swiper-slide');
                    var multi = slides.length > 1;
                    var specialDeepLink = @json($specialOfferDeepLink ?? '');
                    var initialSlide = {{ (int)($specialOffersInitialSlide ?? 0) }};
                    /* Deep link: stable slide index; loop would remap indices */
                    var useLoop = slides.length > 2 && !specialDeepLink;
                    var controls = document.querySelector('.special-offers-swiper-controls');
                    if (!multi) {
                        if (controls) {
                            controls.hidden = true;
                        }
                        document.querySelectorAll('.special-offers-swiper-outer .special-offers-nav-prev, .special-offers-swiper-outer .special-offers-nav-next').forEach(function (btn) {
                            btn.hidden = true;
                        });
                    }
                    root.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function (toggle) {
                        toggle.addEventListener('show.bs.dropdown', function () {
                            root.classList.add('special-offers-swiper--dropdown-open');
                        });
                        toggle.addEventListener('hide.bs.dropdown', function () {
                            setTimeout(function () {
                                if (!root.querySelector('.dropdown-menu.show')) {
                                    root.classList.remove('special-offers-swiper--dropdown-open');
                                }
                            }, 0);
                        });
                    });
                    var swiper = new Swiper('.special-offers-swiper', {
                        slidesPerView: 1,
                        spaceBetween: 24,
                        autoHeight: true,
                        watchOverflow: true,
                        initialSlide: Math.min(initialSlide, Math.max(0, slides.length - 1)),
                        loop: useLoop,
                        autoplay: multi && !specialDeepLink ? {delay: 9000, disableOnInteraction: false} : false,
                        pagination: {
                            el: '.special-offers-swiper-outer .special-offers-pagination',
                            clickable: true,
                        },
                        navigation: {
                            nextEl: '.special-offers-swiper-outer .special-offers-nav-next',
                            prevEl: '.special-offers-swiper-outer .special-offers-nav-prev',
                        },
                    });
                    swiper.update();
                    if (specialDeepLink) {
                        var anchor = document.getElementById('special-offers-anchor');
                        if (anchor) {
                            setTimeout(function () {
                                anchor.scrollIntoView({behavior: 'smooth', block: 'start'});
                            }, 100);
                        }
                    }
                });
            </script>
        @endpush
    @endif
@stop
@include('site.assets')
