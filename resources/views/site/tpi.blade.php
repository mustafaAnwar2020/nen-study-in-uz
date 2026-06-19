@extends('site.layouts.app')

@section('content')
    <main class="main">
        <!-- Hero Section (dynamic from admin) -->
        @if ($tpiHeroSection)
            <section id="hero" class="hero section dark-background">
                <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
                    <div class="carousel-item active">
                        <img src="{{ $tpiHeroSection->getImage() }}" alt="{{ $tpiHeroSection->title }}"
                            class="carousel-image">
                        <div class="carousel-container">
                            <h2>{{ $tpiHeroSection->title }}</h2>
                            <p>{{ $tpiHeroSection->subtitle }}</p>
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <div class="dropdown">
                                    <button class="btn btn-custom-danger dropdown-toggle" type="button"
                                        id="tpiHeroRegisterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ $tpiHeroSection->apply_btn_text }}
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark shadow border-0"
                                        aria-labelledby="tpiHeroRegisterDropdown">
                                        @foreach ($tpiHeroSection->getCountriesList() as $countryData)
                                            <li>
                                                <a class="dropdown-item" target="_blank"
                                                    href="{{ $countryData['url'] ?? '#' }}">
                                                    <span class="flag-icon {{ $countryData['flag'] ?? '' }}"></span>
                                                    {{ $countryData['name'] ?? '' }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <a href="{{ $tpiHeroSection->nearest_center_url ?? '#authorized-centers' }}"
                                    class="btn btn-outline-light">
                                    {{ $tpiHeroSection->nearest_center_text ?? 'Nearest Center' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <!-- Overview Section (dynamic from admin) -->
        @if ($tpiOverviewSection)
            <section id="overview" class="section">
                <div class="container">
                    <div class="section-title">
                        <h2>{{ $tpiOverviewSection->section_title }}</h2>
                    </div>

                    <div class="intro-box">
                        <div class="row align-items-center">
                            <div class="col-lg-6 mb-4 mb-lg-0 order-lg-2">
                                <p class="lead">{{ $tpiOverviewSection->lead }}</p>
                                <p>{{ $tpiOverviewSection->intro_paragraph }}</p>

                                <div class="benefits-grid">
                                    @foreach ($tpiOverviewSection->getBenefitsList() as $benefit)
                                        <div class="benefit-item">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>{{ $benefit }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-6 order-lg-1">
                                <img src="{{ $tpiOverviewSection->getStudentImage() }}"
                                    alt="Students celebrating TOEFL success" class="student-image">
                            </div>
                        </div>
                    </div>

                    <!-- Feature Cards -->
                    <div class="row gy-3 mt-4 features-row">
                        @foreach ($tpiOverviewSection->getFeaturesList() as $feature)
                            @php $feature = (array) $feature; @endphp
                            <div class="col-lg col-md-4 col-sm-6">
                                <div class="feature-card">
                                    <i
                                        class="bi {{ $feature['icon'] ?? 'bi-check-circle' }} {{ $feature['icon_class'] ?? '' }}"></i>
                                    <h5>{{ $feature['title'] ?? '' }}</h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- How It Works Section -->
        <section id="how-it-works" class="section">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>How It Works</h2>
                </div>
                <div class="row">
                    <div class="col-12" data-aos="fade-up" data-aos-delay="100">
                        <div class="text-center">
                            <img src="{{ asset('site/images/how-it-works-infographic.png') }}"
                                alt="How It Works - TOEFL IBT Practice Scholarship" class="img-fluid rounded" height="750"
                                width="auto">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Key Benefits Section (dynamic from admin) -->
        @if ($tpiKeyBenefitsSection)
            <section id="key-benefits" class="section">
                <div class="container">
                    <div class="section-title">
                        <h2>{{ $tpiKeyBenefitsSection->section_title }}</h2>
                    </div>
                    <div class="row gy-4">
                        @foreach ($tpiKeyBenefitsSection->getItemsList() as $item)
                            @php $item = (array) $item; @endphp
                            <div class="col-lg-4 col-md-6">
                                <div class="benefit-card">
                                    <div class="icon-wrapper">
                                        <i
                                            class="bi {{ $item['icon'] ?? 'bi-check-circle' }} {{ $item['icon_class'] ?? '' }}"></i>
                                    </div>
                                    <h5>{{ $item['title'] ?? '' }}</h5>
                                    <p>{{ $item['description'] ?? '' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Authorized Centers Section -->
        <section id="authorized-centers" class="section">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>TOEFL Preparation Centers</h2>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-8">
                        <ul class="nav nav-tabs custom-tabs" id="tpiTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="test-sites-tab" data-bs-toggle="tab" href="#tpi-test-sites"
                                    role="tab" aria-controls="tpi-test-sites" aria-selected="true">Preparation
                                    Centers</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="trainers-tab" data-bs-toggle="tab" href="#tpi-trainers"
                                    role="tab" aria-controls="tpi-trainers" aria-selected="false">Mentors</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input id="tpi-country" class="form-control" name="country" placeholder="Search...">
                        </div>
                    </div>
                </div>

                <!-- Tabs Content -->
                <div class="tab-content" id="tpiTabsContent">
                    <!-- Test Sites Tab -->
                    <div class="tab-pane fade show active" id="tpi-test-sites" role="tabpanel"
                        aria-labelledby="test-sites-tab">
                        <div class="centers-card">
                            @if (isset($testSites) && $testSites->isNotEmpty())
                                <?php
                                $headers = $testSites->first();
                                $rows = $testSites->slice(1);
                                ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                @foreach ($headers as $index => $header)
                                                    @if (in_array($index, [0, 1,6,10,11]))
                                                        @continue
                                                    @endif
                                                    <th style="text-align:center">{{ $header }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>    
                                        <tbody>
                                            @foreach ($rows as $row)
                                                <tr>
                                                    @foreach ($row as $colIndex => $cell)
                                                        @if (in_array($colIndex, [0, 1,6,10,11]))
                                                            @continue
                                                        @endif

                                                        @if ($colIndex === 2)
                                                            @php
                                                                $countryCode = strtolower(trim($row[0] ?? ''));
                                                                $countryName = trim($cell);
                                                            @endphp
                                                            <td>
                                                                @if ($countryCode)
                                                                    <span
                                                                        class="flag-icon flag-icon-{{ $countryCode }}"></span>
                                                                @endif
                                                                {{ $countryName }}
                                                            </td>
                                                        @elseif ($colIndex == 10)
                                                            <td><span
                                                                    class="{{ $cell == 'Inactive' ? 'text-danger' : '' }}">{{ $cell }}</span>
                                                            </td>
                                                        @else
                                                            <td>{{ $cell }}</td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info mt-4">
                                    No test sites data available at the moment.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Mentors Tab -->
                    <div class="tab-pane fade" id="tpi-trainers" role="tabpanel" aria-labelledby="trainers-tab">
                        <div class="centers-card">
                            @if (isset($trainers) && $trainers->isNotEmpty())
                                <?php
                                $headers = $trainers->first();
                                $rows = $trainers->slice(1);
                                ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                @foreach ($headers as $index => $header)
                                                    @if (in_array($index, [0, 7,8, 9]))
                                                        @continue
                                                    @endif
                                                    <th style="text-align:center">{{ $header }}</th>
                                                @endforeach
                                                <th style="text-align:center">Contact</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rows as $rowIndex => $row)
                                                <tr>
                                                    @foreach ($row as $colIndex => $cell)
                                                        @if (in_array($colIndex, [0, 7,8, 9]))
                                                            @continue
                                                        @endif
                                                        @if ($colIndex == 1)
                                                            @php
                                                                $countryCode = strtolower(trim($row[0] ?? ''));
                                                                $countryName = trim($cell);
                                                            @endphp
                                                            <td>
                                                                @if ($countryCode)
                                                                    <span
                                                                        class="flag-icon flag-icon-{{ $countryCode }}"></span>
                                                                @endif
                                                                {{ $countryName }}
                                                            </td>
                                                        @else
                                                            <td>{{ filter_var($cell, FILTER_VALIDATE_EMAIL) ? '-' : $cell }}
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#tpiContactModal"
                                                            data-trainer-index="{{ $rowIndex }}"
                                                            data-trainer-name="{{ $row[1] ?? 'Trainer' }}">
                                                            <i class="bi bi-envelope"></i> Contact
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info mt-4">
                                    No trainers data available at the moment.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Join as Partner Section (dynamic from admin) -->
        @if ($tpiJoinPartnerSection)
            <section id="join-partner" class="section">
                <div class="container">
                    <div class="section-title" data-aos="fade-up">
                        <h2>{{ $tpiJoinPartnerSection->section_title }}</h2>
                    </div>
                    <div class="row gy-4">
                        @foreach ($tpiJoinPartnerSection->getItemsList() as $idx => $item)
                            @php $item = (array) $item; @endphp
                            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ ($idx + 1) * 100 }}">
                                <div class="benefit-card">
                                    <div class="icon-wrapper">
                                        <i
                                            class="bi {{ $item['icon'] ?? 'bi-building' }} {{ $item['icon_class'] ?? '' }}"></i>
                                    </div>
                                    <h5>{{ $item['title'] ?? '' }}</h5>
                                    <p>{{ $item['description'] ?? '' }}</p>
                                    @if (!empty($item['button_text']) && !empty($item['button_url']))
                                        <a href="{{ $item['button_url'] }}" class="btn btn-custom-danger mt-3"
                                            target="_blank">{{ $item['button_text'] }}</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        <!-- Refund & Rewards Section -->
        <section id="refund-rewards" class="section">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Refund & Rewards</h2>
                    <p class="text-muted">Recover Your Deposit Or Choose a Reward</p>
                </div>
                <div class="row gy-4">
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="benefit-card">
                            <div class="icon-wrapper">
                                <i class="bi bi-cash-coin icon-success"></i>
                            </div>
                            <h5>Full refund of deposit</h5>
                            <p>Get your complete deposit back after completing the program</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="benefit-card">
                            <div class="icon-wrapper">
                                <i class="bi bi-award icon-primary"></i>
                            </div>
                            <h5>Certificate of Attendance</h5>
                            <p>Receive an official certificate upon program completion</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="benefit-card">
                            <div class="icon-wrapper">
                                <i class="bi bi-tag icon-info"></i>
                            </div>
                            <h5>$30 discount on TOEFL exam fee</h5>
                            <p>Save money on your official TOEFL exam registration</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="benefit-card">
                            <div class="icon-wrapper">
                                <i class="bi bi-people icon-purple"></i>
                            </div>
                            <h5>$50 cashback when booking TOEFL for a friend</h5>
                            <p>Earn rewards by referring friends to the TOEFL program</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if ($tpiCtaSection)
            <section id="register" class="section">
                <div class="container">
                    <div class="row gy-4 align-items-center">
                        <div class="col-lg-6 text-center" data-aos="fade-up" data-aos-delay="100">
                            <img src="{{ $tpiCtaSection->getImage() }}" alt="{{ $tpiCtaSection->title }}"
                                class="img-fluid rounded">
                        </div>
                        <div class="col-lg-6 text-center" data-aos="fade-up" data-aos-delay="200">
                            <h2 class="mb-3">{{ $tpiCtaSection->title }}</h2>
                            <p class="lead mb-4">{{ $tpiCtaSection->lead }}</p>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-custom-danger dropdown-toggle" type="button" id="payNowDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-credit-card me-2"></i>{{ $tpiCtaSection->pay_btn_text }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="payNowDropdown">
                                    @foreach ($tpiCtaSection->getPaymentOptionsList() as $option)
                                        <li>
                                            <a class="dropdown-item" target="_blank" href="{{ $option['url'] ?? '#' }}">
                                                @if (!empty($option['icon']))
                                                    <i class="flag-icon {{ $option['icon'] }} me-2"></i>
                                                @endif
                                                {{ $option['label'] ?? '' }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <!-- FAQ Section (dynamic from admin) -->
        @if ($tpiFaqs->isNotEmpty())
            <section id="faq" class="section">
                <div class="container">
                    <div class="section-title" data-aos="fade-up">
                        <h2>Frequently Asked Questions</h2>
                    </div>
                    <div class="row gy-4">
                        @foreach ($tpiFaqs as $idx => $faq)
                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ (($idx % 4) + 1) * 100 }}">
                                <div class="faq-container">
                                    <div class="faq-item ">
                                        <h3>
                                            <span class="num">{{ $loop->iteration }}.</span>
                                            <span>{{ $faq->question }}</span>
                                        </h3>
                                        <div class="faq-content">
                                            <p>{!! nl2br(e($faq->answer)) !!}</p>
                                        </div>
                                        <i class="faq-toggle bi bi-chevron-right"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif



        <!-- Contact Trainer Modal -->
        <div class="modal fade" id="tpiContactModal" tabindex="-1" aria-labelledby="tpiContactModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tpiContactModalLabel">Contact Mentor: <span
                                id="tpiTrainerNameDisplay"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="tpiContactTrainerForm">
                        <input type="hidden" id="tpiTrainerIndex" name="trainer_index">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="contactName" class="form-label">Residence Country</label>
                                <select class="form-control" id="contactCountry">
                                    <option value="">Select Country</option>
                                    @foreach (config('countries') as $code => $country)
                                        <option value="{{ $code }}">{{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="contactOrganization" class="form-label">Organization</label>
                                <input type="text" class="form-control" placeholder="organization name"
                                    id="contactOrganization" required>
                            </div>
                            <div class="mb-3">
                                <label for="tpiContactName" class="form-label">Name</label>
                                <input type="text" class="form-control" placeholder="full name"
                                    id="tpiContactName" required>
                            </div>
                            <div class="mb-3">
                                <label for="contactPhone" class="form-label">Phone</label>
                                <input type="text" class="form-control" placeholder="phone number"
                                    id="contactPhone" required>
                            </div>
                            <div class="mb-3">
                                <label for="tpiContactEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="email address"
                                    id="tpiContactEmail" required>
                            </div>
                            <div class="mb-3">
                                <label for="tpiContactSubject" class="form-label">Subject</label>
                                <input type="text" class="form-control" placeholder="message subject"
                                    id="tpiContactSubject" required>
                            </div>
                            <div class="mb-3">
                                <label for="tpiContactMessage" class="form-label">Message</label>
                                <textarea class="form-control" placeholder="Type your message here..." id="tpiContactMessage" rows="4"
                                    required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contact Us Section (dynamic from admin) -->
        @if ($tpiContactSection)
            <section id="contact-us" class="section dark-background">
                <div class="container">
                    <div class="section-title">
                        <h2 class="text-white">{{ $tpiContactSection->section_title }} @if ($tpiContactSection->title_highlight)
                                <span class="text-danger">{{ $tpiContactSection->title_highlight }}</span>
                            @endif
                        </h2>
                    </div>

                    <div class="row gy-4 mb-4">
                        <div class="col-lg-12">
                            <div class="row gy-3">
                                @foreach ($tpiContactSection->getPhoneCardsList() as $card)
                                    @php $card = (array) $card; @endphp
                                    <div class="col-md-3">
                                        <div class="contact-card">
                                            <div class="contact-header">
                                                <i class="bi {{ $card['icon'] ?? 'bi-headset' }}"></i>
                                                <span class="flag-icon {{ $card['flag'] ?? '' }}"></span>
                                                <span class="lang-tag">{{ $card['lang_tag'] ?? '' }}</span>
                                            </div>
                                            <div class="contact-body">
                                                <a href="tel:{{ preg_replace('/\s+/', '', $card['phone_number'] ?? '') }}"
                                                    class="phone-link">{{ $card['phone_display'] ?? ($card['phone_number'] ?? '') }}</a>
                                                @if (!empty($card['whatsapp']) || !empty($card['telegram']))
                                                    <div class="d-flex justify-content-center gap-2 mt-3">
                                                        @if (!empty($card['whatsapp']))
                                                            <a href="{{ $card['whatsapp'] }}" target="_blank"
                                                                class="btn btn-sm btn-success rounded-pill px-2">
                                                                <i class="bi bi-whatsapp"></i> WhatsApp
                                                            </a>
                                                        @endif
                                                        @if (!empty($card['telegram']))
                                                            <a href="{{ $card['telegram'] }}" target="_blank"
                                                                class="btn btn-sm btn-info rounded-pill px-2 text-white">
                                                                <i class="bi bi-telegram"></i> Telegram
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @php $social = $tpiContactSection->getSocialCard(); @endphp
                                @if (!empty($social['title']) && !empty($social['links']))
                                    <div class="col-md-3">
                                        <div class="contact-card">
                                            <div class="contact-header">
                                                <i class="bi {{ $social['icon'] ?? 'bi-chat-dots' }}"></i>
                                                <h5>{{ $social['title'] }}</h5>
                                            </div>
                                            <div class="contact-body">
                                                <div class="social-links">
                                                    @foreach ($social['links'] as $link)
                                                        @php $link = (array) $link; @endphp
                                                        <a href="{{ $link['url'] ?? '#' }}" target="_blank"
                                                            class="social-link {{ $link['icon_class'] ?? '' }}"
                                                            title="{{ $link['label'] ?? '' }}">
                                                            <i class="bi {{ $link['bi_icon'] ?? 'bi-link-45deg' }}"></i>
                                                            <span>{{ $link['label'] ?? '' }}</span>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row gy-4">
                        <div class="col-lg-12">
                            <div class="row gy-3">
                                @foreach ($tpiContactSection->getEmailCardsList() as $card)
                                    @php $card = (array) $card; @endphp
                                    <div class="col-md-3">
                                        <div class="contact-card">
                                            <div class="contact-header">
                                                <i class="bi {{ $card['icon'] ?? 'bi-envelope' }}"></i>
                                                <h5>{{ $card['title'] ?? '' }}</h5>
                                            </div>
                                            <div class="contact-body">
                                                <a href="mailto:{{ $card['email'] ?? '' }}" class="email-link">
                                                    <i class="bi bi-envelope"></i>
                                                    {{ $card['email'] ?? '' }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

    </main>
@stop

@push('styles')
    <style>
        .icon-box {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .icon-box i {
            font-size: 24px;
            margin-top: 5px;
            flex-shrink: 0;
        }

        .icon-box h4 {
            margin: 0;
        }

        .badge {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        /* Hero Section Styles */
        .hero {
            position: relative;
            overflow: visible;
            z-index: 10;
        }

        .hero #hero-carousel {
            height: 100vh;
            min-height: 600px;
            overflow: visible;
        }

        .hero .carousel-item {
            position: relative;
            height: 100%;
            overflow: visible;
        }

        .hero .carousel-item .carousel-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .hero .carousel-container {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            z-index: 2;
        }

        .hero .carousel-container h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            white-space: nowrap;
        }

        .hero .carousel-container p {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        /* Dropdown Menu Fix - Ensure it displays completely */
        .hero .dropdown-menu {
            max-height: 60vh;
            overflow-y: auto;
            scrollbar-width: thin;
            z-index: 9999;

        }

        .hero .dropdown {
            position: relative;
        }

        /* Ensure dropdown items are visible */
        .dropdown-menu .dropdown-item {
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-menu .flag-icon {
            margin-right: 8px;
        }

        #tpi-hero h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        #tpi-hero .dropdown-toggle::after {
            margin-left: 0.5rem;
        }

        :root {
            --primary-color: #2563eb;
            --secondary-color: #7c3aed;
            --success-color: #10b981;
            --info-color: #06b6d4;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .section {
            background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
        }

        .section-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
            position: relative;
            padding-bottom: 20px;
        }



        .intro-box {
            background: white;
            border-radius: 20px;
            padding: 30px 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .intro-box .lead {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .intro-box p {
            font-size: 1rem;
            color: #475569;
            margin-bottom: 20px;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 20px;
            margin-bottom: 0;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            padding: 12px 18px;
            border-radius: 10px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .benefit-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.15);
            border-color: var(--primary-color);
        }

        .benefit-item i {
            font-size: 1.3rem;
            color: var(--success-color);
            margin-right: 10px;
            flex-shrink: 0;
        }

        .benefit-item span {
            font-weight: 500;
            color: #1e293b;
            font-size: 0.95rem;
        }

        .feature-card {
            background: white;
            border-radius: 12px;
            padding: 20px 15px;
            text-align: center;
            height: 100%;
            transition: all 0.3s ease;
            border: 2px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
            border-color: var(--primary-color);
        }

        .feature-card i {
            font-size: 2.5rem;
            margin-bottom: 12px;
            display: block;
            transition: transform 0.3s ease;
        }

        .feature-card:hover i {
            transform: scale(1.1);
        }

        .feature-card h5 {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
            line-height: 1.3;
        }

        /* Features Row - 5 Cards in One Row */
        .features-row {
            margin-top: 20px !important;
        }

        .features-row .feature-card {
            padding: 15px 10px;
            min-height: 120px;
        }

        .features-row .feature-card i {
            font-size: 2rem;
            margin-bottom: 8px;
        }

        .features-row .feature-card h5 {
            font-size: 0.85rem;
            line-height: 1.2;
        }

        .icon-primary {
            color: var(--primary-color);
        }

        .icon-success {
            color: var(--success-color);
        }

        .icon-info {
            color: var(--info-color);
        }

        .icon-warning {
            color: var(--warning-color);
        }

        .icon-danger {
            color: var(--danger-color);
        }

        .icon-purple {
            color: #8b5cf6;
        }

        .icon-pink {
            color: #ec4899;
        }

        .icon-teal {
            color: #14b8a6;
        }

        .student-image {
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .features-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 60px 0 40px 0;
            position: relative;
        }

        .features-title::before {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 2px;
        }


        :root {
            --primary-color: #2563eb;
            --success-color: #10b981;
            --accent-1: #06b6d4;
            --accent-2: #8b5cf6;
            --accent-3: #f59e0b;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
        }

        .section {
            background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%);
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
            position: relative;
            padding-bottom: 20px;
        }



        .benefit-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            height: 100%;
            text-align: center;
            transition: all 0.4s ease;
            border: 2px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }

        .benefit-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--accent-2));
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .benefit-card:hover::before {
            transform: scaleX(1);
        }

        .benefit-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 50px rgba(37, 99, 235, 0.2);
            border-color: var(--primary-color);
        }

        .icon-wrapper {
            width: 80px;
            height: 80px;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            transition: all 0.4s ease;
            position: relative;
        }

        .benefit-card:hover .icon-wrapper {
            transform: scale(1.1) rotate(5deg);
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-2) 100%);
        }

        .icon-wrapper i {
            font-size: 2.5rem;
            transition: all 0.4s ease;
        }

        .benefit-card:hover .icon-wrapper i {
            color: white !important;
        }

        .benefit-card h5 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
            line-height: 1.5;
            transition: color 0.3s ease;
        }

        .benefit-card:hover h5 {
            color: var(--primary-color);
        }

        .benefit-card p {
            font-size: 0.95rem;
            color: #64748b;
            margin-top: 15px;
            margin-bottom: 0;
            line-height: 1.6;
        }

        .benefit-card .btn {
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .benefit-card .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* Different colored icons for variety */
        .icon-success {
            color: var(--success-color);
        }

        .icon-primary {
            color: var(--primary-color);
        }

        .icon-info {
            color: var(--accent-1);
        }

        .icon-purple {
            color: var(--accent-2);
        }

        .icon-warning {
            color: var(--accent-3);
        }

        @media (max-width: 768px) {
            .hero #hero-carousel {
                height: 70vh;
                min-height: 500px;
            }

            .hero .carousel-item {
                height: 100%;
            }

            .hero .carousel-container h2 {
                font-size: 1.8rem;
            }

            .hero .carousel-container p {
                font-size: 1rem;
            }

            .section {
                padding: 50px 0;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .section-title {
                margin-bottom: 40px;
            }

            .benefit-card {
                padding: 35px 25px;
            }

            .icon-wrapper {
                width: 70px;
                height: 70px;
            }

            .icon-wrapper i {
                font-size: 2rem;
            }

            /* Hero section responsive */
            .hero .carousel-container h2 {
                font-size: 1.8rem;
                white-space: normal;
                line-height: 1.3;
            }

            .hero .carousel-container p {
                font-size: 1rem;
            }
        }

        @media (max-width: 992px) {
            .benefits-grid {
                grid-template-columns: 1fr;
            }

            .intro-box {
                padding: 40px 30px;
            }
        }

        @media (max-width: 768px) {
            .section {
                padding: 50px 0;
            }

            .section-title h2 {
                font-size: 1.8rem;
            }

            .intro-box .lead {
                font-size: 1.2rem;
            }

            .intro-box p {
                font-size: 1rem;
            }

            .features-title {
                font-size: 1.6rem;
                margin: 40px 0 30px 0;
            }

            .feature-card {
                padding: 18px 15px;
            }

            .feature-card i {
                font-size: 2.2rem;
            }
        }

        /* Authorized Centers Section Styles */
        .centers-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 2px solid #e2e8f0;
        }

        .custom-tabs {
            border-bottom: 2px solid #e2e8f0;
        }

        .custom-tabs .nav-link {
            color: #64748b;
            font-weight: 500;
            padding: 12px 24px;
            border: none;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
            background: transparent;
        }

        .custom-tabs .nav-link:hover {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        .custom-tabs .nav-link.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
            background: transparent;
        }

        .centers-card .table {
            margin-bottom: 0;
        }

        .centers-card .table-responsive {
            max-height: 500px;
            overflow-y: auto;
        }

        .centers-card .table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            color: #1e293b;
            font-weight: 600;
            border: none;
            padding: 15px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .centers-card .table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #e2e8f0;
        }

        .centers-card .table tbody tr:hover {
            background: #f8fafc;
            transform: translateX(5px);
        }

        .centers-card .table tbody td {
            padding: 15px;
            vertical-align: middle;
            color: #475569;
        }

        .centers-card .form-control {
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .centers-card .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        @media (max-width: 768px) {
            .centers-card {
                padding: 20px;
            }

            .custom-tabs .nav-link {
                padding: 10px 16px;
                font-size: 0.9rem;
            }
        }

        /* FAQ Section Styles */
        .faq-container {
            margin-bottom: 20px;
        }


        .faq-item {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            border: 2px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .faq-item:hover {
            border-color: var(--primary-color);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.15);
            transform: translateY(-3px);
        }

        .faq-item.faq-active {
            border-color: var(--primary-color);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.2);
        }

        .faq-item h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 15px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .faq-item h3 .num {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.2rem;
        }

        .faq-item .faq-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
            padding: 0;
        }

        .faq-item.faq-active .faq-content {
            max-height: 500px;
            padding-top: 15px;
        }

        .faq-item .faq-content p {
            color: #64748b;
            margin: 0;
            line-height: 1.6;
        }

        .faq-item .faq-toggle {
            position: absolute;
            right: 25px;
            top: 25px;
            font-size: 1.2rem;
            color: var(--primary-color);
            transition: transform 0.3s ease;
        }

        .faq-item.faq-active .faq-toggle {
            transform: rotate(90deg);
        }

        @media (max-width: 768px) {
            .faq-item {
                padding: 20px;
            }

            .faq-item h3 {
                font-size: 1rem;
                padding-right: 30px;
            }

            .faq-item .faq-toggle {
                right: 20px;
                top: 20px;
            }
        }

        /* Contact Us Section Styles */
        #contact-us {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            position: relative;
        }

        #contact-us .section-title h2::after {
            background: linear-gradient(to right, #dc2626, #ef4444);
        }

        .contact-card {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 25px 20px;
            height: 100%;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .contact-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--danger-color);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.3);
        }

        .contact-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .contact-header i {
            font-size: 1.5rem;
            color: var(--danger-color);
        }

        .contact-header h5 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: white;
        }

        .contact-body {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .flag-phone {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 5px;
        }

        .flag-phone .flag-icon {
            font-size: 1.5rem;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .lang-tag {
            background: rgba(255, 255, 255, 0.1);
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            color: #e2e8f0;
            font-weight: 600;
        }

        .phone-link,
        .email-link {
            color: #e2e8f0;
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .phone-link:hover,
        .email-link:hover {
            color: var(--danger-color);
            transform: translateX(5px);
        }

        .email-link i {
            font-size: 1.1rem;
            color: var(--danger-color);
        }

        /* Social Media Links */
        .social-links {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .social-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            color: #cbd5e1;
        }

        .social-link:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
        }

        .social-link.whatsapp {
            background: rgba(37, 211, 102, 0.1);
            color: #25d366;
            border-color: rgba(37, 211, 102, 0.3);
        }

        .social-link.whatsapp:hover {
            background: #25d366;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(37, 211, 102, 0.4);
        }

        .social-link.telegram {
            background: rgba(36, 161, 222, 0.1);
            color: #24a1de;
            border-color: rgba(36, 161, 222, 0.3);
        }

        .social-link.telegram:hover {
            background: #24a1de;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(36, 161, 222, 0.4);
        }

        .social-link.instagram {
            background: rgba(225, 48, 108, 0.1);
            color: #E1306C;
            border-color: rgba(225, 48, 108, 0.3);
        }

        .social-link.instagram:hover {
            background: #E1306C;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(225, 48, 108, 0.4);
        }

        .social-link.facebook {
            background: rgba(24, 119, 242, 0.1);
            color: #1877F2;
            border-color: rgba(24, 119, 242, 0.3);
        }

        .social-link.facebook:hover {
            background: #1877F2;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(24, 119, 242, 0.4);
        }

        .social-link.linkedin {
            background: rgba(0, 119, 181, 0.1);
            color: #0077b5;
            border-color: rgba(0, 119, 181, 0.3);
        }

        .social-link.linkedin:hover {
            background: #0077b5;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 119, 181, 0.4);
        }

        .social-link i {
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .contact-card {
                padding: 20px 15px;
            }

            .contact-header h5 {
                font-size: 0.9rem;
            }

            .phone-link,
            .email-link {
                font-size: 0.85rem;
            }

            .social-link {
                font-size: 0.8rem;
                padding: 6px 10px;
            }
        }
    </style>
    <style>
        /* Make dropdown hover color more visible in CTA section */
        #register .dropdown-item:hover,
        #register .dropdown-item:focus {
            background-color: var(--primary-color) !important;
            color: #ffffff !important;
        }

        /* Ensure icon/link inside dropdown also turns white on hover */
        #register .dropdown-item:hover i,
        #register .dropdown-item:focus i {
            color: #ffffff !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contactModal = document.getElementById('tpiContactModal');
            const contactForm = document.getElementById('tpiContactTrainerForm');
            const trainerNameDisplay = document.getElementById('tpiTrainerNameDisplay');
            const trainerIndexInput = document.getElementById('tpiTrainerIndex');
            const nameInput = document.getElementById('tpiContactName');
            const emailInput = document.getElementById('tpiContactEmail');
            const subjectInput = document.getElementById('tpiContactSubject');
            const messageInput = document.getElementById('tpiContactMessage');
            const countrySearchInput = document.getElementById('tpi-country');

            // Handle modal opening
            if (contactModal) {
                contactModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const trainerName = button.getAttribute('data-trainer-name');
                    const trainerIndex = button.getAttribute('data-trainer-index');

                    // Set trainer name in the modal header
                    trainerNameDisplay.textContent = trainerName;
                    trainerIndexInput.value = trainerIndex;

                    // Clear previous form data
                    nameInput.value = '';
                    emailInput.value = '';
                    subjectInput.value = '';
                    messageInput.value = '';

                    // Set focus to name field
                    setTimeout(() => {
                        nameInput.focus();
                    }, 500);
                });
            }

            // Handle form submission
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Get form data
                    const formData = new FormData();
                    formData.append('trainer_index', trainerIndexInput.value);
                    formData.append('name', nameInput.value);
                    formData.append('email', emailInput.value);
                    formData.append('subject', subjectInput.value);
                    formData.append('message', messageInput.value);
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content'));

                    // Disable submit button and show loading state
                    const submitButton = contactForm.querySelector('button[type="submit"]');
                    const originalText = submitButton.textContent;
                    submitButton.disabled = true;
                    submitButton.textContent = 'Sending...';

                    // Send AJAX request
                    fetch('{{ route('site.contact.trainer') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                alert(
                                    'Message sent successfully! The trainer will receive your message and can reply directly to your email.'
                                );

                                // Close the modal
                                const modal = bootstrap.Modal.getInstance(contactModal);
                                modal.hide();

                                // Reset form
                                contactForm.reset();
                            } else {
                                // Show error message
                                alert('Error: ' + (data.message ||
                                    'Failed to send message. Please try again.'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while sending the message. Please try again.');
                        })
                        .finally(() => {
                            // Re-enable submit button
                            submitButton.disabled = false;
                            submitButton.textContent = originalText;
                        });
                });
            }

            // Country search functionality (search first 5 columns)
            if (countrySearchInput) {
                countrySearchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();

                    // Filter Test Sites table (search first 5 columns)
                    const testSitesTable = document.querySelector('#tpi-test-sites .table tbody');
                    if (testSitesTable) {
                        const testSitesRows = testSitesTable.querySelectorAll('tr');
                        testSitesRows.forEach(row => {
                            const cells = row.querySelectorAll('td:nth-child(-n+5)');
                            let matches = searchTerm === '';
                            if (!matches && cells.length) {
                                matches = Array.from(cells).some(cell =>
                                    cell.textContent.toLowerCase().trim().includes(searchTerm)
                                );
                            }
                            row.style.display = matches ? '' : 'none';
                        });
                    }

                    // Filter Trainers table (search first 5 columns)
                    const trainersTable = document.querySelector('#tpi-trainers .table tbody');
                    if (trainersTable) {
                        const trainersRows = trainersTable.querySelectorAll('tr');
                        trainersRows.forEach(row => {
                            const cells = row.querySelectorAll('td:nth-child(-n+5)');
                            let matches = searchTerm === '';
                            if (!matches && cells.length) {
                                matches = Array.from(cells).some(cell =>
                                    cell.textContent.toLowerCase().trim().includes(searchTerm)
                                );
                            }
                            row.style.display = matches ? '' : 'none';
                        });
                    }
                });
            }

            // FAQ Toggle functionality
            const faqItems = document.querySelectorAll('.faq-item');
            faqItems.forEach(item => {
                item.addEventListener('click', function() {
                    const isActive = this.classList.contains('faq-active');

                    // Close all FAQ items
                    faqItems.forEach(faq => {
                        faq.classList.remove('faq-active');
                    });

                    // Toggle the clicked item
                    if (!isActive) {
                        this.classList.add('faq-active');
                    }
                });
            });
        });
    </script>
@endpush
