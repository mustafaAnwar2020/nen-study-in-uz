<header id="header" class="header d-flex align-items-center">

    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <a href="{{ route('site.index') }}" class="logo d-flex align-items-center">
            <img src="{{ asset($settings['media']->ets_logo) }}" alt="">
            <img src="{{ asset($settings['media']->logo) }}" style="margin-top: 12px;" alt="">
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ route('site.p.show', 'verification') }}"> <i class="bi bi-check-circle"></i>
                        Verification
                    </a></li>
                <li><a href="{{ route('site.p.show', 'testing-events') }}"> <i class="bi bi-list"></i> Testing events
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle"> <i class="bi bi-calendar-check"></i> Schedule Test </a>
                    <ul class="dropdown-menu">
                        @foreach ($headerProductTypes as $typeKey => $typeLabel)
                            <li>
                                <a href="{{ route('site.products', ['type' => $typeKey]) }}">
                                    {{ $typeLabel }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="{{ route('site.blogs') }}"><i class="bi bi-newspaper"></i> Blogs</a></li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle"> Register <i class="bi bi-person-plus"></i></a>
                    <ul class="dropdown-menu">
                        @foreach ($countries as $code => $country)
                            <li>
                                <a target="_blank" href="{{ $country['url'] }}">
                                    <span class="flag-icon {{ $country['flag_icon'] }}"></span>
                                    {{ ucfirst($country['name']) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle"> Payment <i class="bi bi-credit-card"></i></a>
                    <ul class="dropdown-menu">

                        <li>
                            <a target="_blank" href="https://nen-global.org/networkae">
                                <img src="{{ asset('site/images/credit.png') }}" width="20" class="me-2">
                                Credit Card
                            </a>
                        </li>
                        <li>
                            <a target="_blank" href="https://nen-global.org/paypalae">
                                <img src="{{ asset('site/images/paypal.png') }}" width="20" class="me-2">
                                PayPal
                            </a>
                        </li>
                        <li>
                            <a target="_blank" href="https://nen-global.org/paymeets">
                                <img src="{{ asset('site/images/payme.png') }}" width="20" class="me-2">
                                Payme
                            </a>
                        </li>


                    </ul>
                </li>

                @include('site.partials.language-switcher', ['switcherId' => 'languageDropdown', 'variant' => 'nav'])

            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

    </div>

</header>

<header id="header" class="header d-flex align-items-center border-top">

    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">


        <nav id="navmenu" style="padding-left:30px;!important" class="navmenu">
            <ul>
                <li class="{{ request()->is('/') ? 'active' : '' }}">
                    <a href="/" style="{{ request()->is('/') ? 'color: white !important;' : '' }}">
                        <i class="bi bi-house"></i>
                    </a>
                </li>
                <li><a href="/#nen"><i class="bi bi-building"></i> NEN</a></li>
                <li><a href="/#ets"><img src="{{ asset('site/images/nen-logo.png') }}" width="20"> ETS</a>
                </li>
                <li><a href="/#cefr"><i class="bi bi-graph-up"></i> CEFR </a></li>
                <li><a href="/#products"><i class="bi bi-box"></i> Products</a></li>
                <li><a href="/#offers"><i class="bi bi-tags"></i> Offers</a></li>
                <li><a href="/#test-day"><i class="bi bi-book"></i> Test Day</a></li>
                <li><a href="/#tabs"><i class="bi bi-people"></i> Partners </a></li>
                <li><a href="/#tpi-ad"><i class="bi bi-trophy"></i> Scholarship </a></li>
                <li><a href="/#network"><i class="bi bi-geo-alt"></i> Network </a></li>
                {{-- <li><a href="/#network"><i class="bi bi-person-badge"></i> Certified Trainers </a></li> --}}
                <li><a href="/#events"><i class="bi bi-calendar-event"></i> Events</a></li>
                <li><a href="/#library"><i class="bi bi-journal"></i> Library</a></li>
                {{-- <li><a href="{{route('protected-files.index')}}"><i class="bi bi-shield-lock"></i> Protected Files</a></li> --}}
                {{-- <li><a href="/#faq"><i class="bi bi-question-circle"></i> FAQ</a></li> --}}

            </ul>
        </nav>

    </div>

</header>
