@extends('site.layouts.app')

@section('body_class', 'nen-landing-body')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('site/home/css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('site/home/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('site/home/css/home.css') }}">
    <style>
        /* Hide default site chrome */
        body.nen-landing-body>header.header,
        body.nen-landing-body #footer.footer,
        body.nen-landing-body .floating-icons,
        body.nen-landing-body .s-soft,
        body.nen-landing-body #preloader {
            display: none !important;
        }

        /* Body acts as the home.css body container */
        body.nen-landing-body {
            container: body / inline-size;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            gap: 80px;
            font-family: 'Manrope', sans-serif;
            text-align: center;
            background-color: var(--screen-basics-bg-web);
            padding-top: 24px;
            overflow: auto;
            margin: 0;
            /* Neutralise main.min.css CSS variable overrides that bleed into home.css.
               main.min.css sets --heading-color:#384f4b (NEN teal), --heading-font:Roboto,
               --default-color:#444, and --default-font:Roboto on :root, which home.css
               does not define. Overriding them here means the element-level rules
               (h1..h6{color/font-family}, body{color/font-family}) resolve correctly. */
            --heading-color: inherit;
            --heading-font: 'Manrope', sans-serif;
            --default-color: inherit;
            --default-font: 'Manrope', sans-serif;
        }

        /* Language / Register in the floating nav */
        .nen-lang-dropdown {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .nen-lang-dropdown__toggle {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #000;
            font-size: 16px;
            font-weight: 400;
            letter-spacing: -0.32px;
            cursor: pointer;
            background: none;
            border: 0;
            padding: 0;
        }

        .nen-lang-dropdown__menu {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .1);
            min-width: 160px;
            padding: 6px 0;
            z-index: 1000;
        }

        .nen-lang-dropdown__menu.open {
            display: block;
        }

        .nen-lang-dropdown__item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 16px;
            font-size: 14px;
            color: #000;
            cursor: pointer;
            text-decoration: none;
        }

        .nen-lang-dropdown__item:hover {
            background: #f5f5f5;
        }

        .nen-lang-dropdown__item .flag-icon {
            width: 1.1em;
        }


        /* ── Override Bootstrap / main.min.css conflicts ── */

        /* Reset Bootstrap heading margins only — do NOT override font-size
           so that home.css fluid-font classes (.column-subtitle1, .subtitle1 etc.) work correctly */
        body.nen-landing-body h1,
        body.nen-landing-body h2,
        body.nen-landing-body h3,
        body.nen-landing-body h4,
        body.nen-landing-body h5,
        body.nen-landing-body h6 {
            margin: 0;
            padding: 0;
        }

        /* Reset Bootstrap / main.css link color inside nen landing */
        body.nen-landing-body a {
            /* color: inherit; */
            text-decoration: none;
            transition: none;
        }

        /* Reset Bootstrap body background override */
        body.nen-landing-body {
            background-color: var(--screen-basics-bg-web) !important;
        }

        /* ── Neutralise Bootstrap .container conflict ──
           Bootstrap sets max-width, padding, margin on .container which breaks home.css layout.
           Use !important to win over Bootstrap's media-query rules (specificity 0,1,0). */
        body.nen-landing-body .container {
            max-width: none !important;
            width: auto !important;
            padding-right: 0 !important;
            padding-left: 0 !important;
            margin-right: unset !important;
            margin-left: unset !important;
        }

        /* Prevent hero title from wrapping — matches home.html visual */
        body.nen-landing-body .subtitle1 {
            white-space: nowrap;
            font-size: clamp(38px, 4.5vw, 65px) !important;
        }

        /* ── FAQ section ── */
        /* Top-align the two columns (home.css uses center, which floats a shorter
           column to the middle and looks broken; flex-start keeps them aligned and
           avoids jumps when an accordion answer expands). */
        body.nen-landing-body #faq .row20 {
            align-items: flex-start !important;
        }

        body.nen-landing-body #faq .faq-btn-d {
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .faq-btn-d.active {
            background-color: var(--neutrals-neutrals-2);
        }

        /* Rotate the + icon to an x when its item is open */
        body.nen-landing-body #faq .faq-btn-d.active .btn-icon-add {
            transform: rotate(45deg);
            transition: transform 0.2s ease;
        }

        body.nen-landing-body #faq .btn-icon-add {
            transition: transform 0.2s ease;
        }

        .faq-answer {
            display: none;
            text-align: left;
            padding: 4px 34px 20px;
            margin-top: -12px;
            font-size: 14.83px;
            line-height: 1.6;
            font-weight: 400;
            color: #3e3c36;
        }

        .faq-answer.open {
            display: block;
        }

        /* ── Agency horizontal scroll carousel ──
           Use a .nen-scroll-wrap with overflow-x:hidden as the scrollport.
           native scrollLeft on the wrap is the simplest reliable approach.
           home.css container queries that stack row15/row19 vertically are
           neutralised with !important below. */

        .nen-scroll-wrap {
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        /* Translation carousel: group-bottom1 has no max-width and lives inside the
           full-bleed col12 (margin:0 -78px), so on wide screens it stretches wider
           than its 4 cards → nothing overflows → arrows have nothing to scroll.
           Constrain + center it (like its header row-top8 and like group5) so the
           cards reliably overflow and the carousel scrolls. */
        body.nen-landing-body #translation-agencies .group-bottom1 {
            align-self: center;
            width: 90%;
            max-width: 1299px;
            margin-left: auto;
            margin-right: auto;
        }

        /* row15/row19 are position:absolute in home.css — reset to normal flow,
           expand to full content width, never wrap, and animate via transform. */
        body.nen-landing-body .nen-scroll-wrap .row15,
        body.nen-landing-body .nen-scroll-wrap .row19 {
            position: static !important;
            top: auto !important;
            left: auto !important;
            width: max-content !important;
            max-width: none !important;
            display: flex !important;
            flex-wrap: nowrap !important;
            flex-direction: row !important;
            align-items: flex-start !important;
            gap: 16px !important;
            transition: transform 0.6s cubic-bezier(0.22, 0.61, 0.36, 1);
            will-change: transform;
        }

        /* Prevent home.css container queries from re-stacking the rows to column */
        @container group-bottom1 (width < 1429px) {
            body.nen-landing-body .nen-scroll-wrap .row15 {
                flex-direction: row !important;
                align-items: flex-start !important;
            }

            body.nen-landing-body .nen-scroll-wrap .row15>* {
                text-align: left !important;
            }
        }

        @container group5 (width < 1383px) {
            body.nen-landing-body .nen-scroll-wrap .row19 {
                flex-direction: row !important;
                align-items: flex-start !important;
            }

            body.nen-landing-body .nen-scroll-wrap .row19>* {
                text-align: left !important;
                width: auto !important;
                align-items: unset !important;
            }
        }

        /* Trusted Agencies header: center & constrain it like the Translation
           header (row-top8) instead of the default full-width 70px padding. */
        body.nen-landing-body #trusted-agencies .row-top9 {
            width: 90%;
            max-width: 1299px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        body.nen-landing-body #trusted-agencies .row-top9 .row-col2 {
            width: 694px;
            flex-shrink: 0;
        }

        body.nen-landing-body #trusted-agencies .row-top9 .row-text-bottom {
            width: 100%;
            max-width: 448px;
        }

        /* Trusted Agency cards: home.css gives card-c width:100% + flex-grow:1, so
           they stretch to unequal widths. Pin them to a fixed equal size. */
        body.nen-landing-body .nen-scroll-wrap .row19>.card-c {
            flex: 0 0 340px !important;
            width: 340px !important;
            min-width: 340px !important;
            padding: 18px 16px !important;
            min-height: 240px !important;
        }

        /* The carousel is sized in JS to fit whole cards, so the decorative edge
           fades are no longer needed and would overlap cards — hide them. */
        body.nen-landing-body #translation-agencies .rect-a,
        body.nen-landing-body #trusted-agencies .rect-a {
            display: none !important;
        }

        /* Keep contact info (location / phone) on a single line so that varying
           number lengths can't reflow the card and break the fixed layout. The
           home.css fixed widths (.card-col / .frame-col-bottom = 131px) are too
           narrow for longer numbers and force an ugly wrap. */
        body.nen-landing-body .nen-scroll-wrap .row19 .card-col {
            width: 100% !important;
        }

        body.nen-landing-body .nen-scroll-wrap .frame-c .frame-col-bottom {
            width: auto !important;
        }

        body.nen-landing-body .nen-scroll-wrap .row-e .row-text3 {
            white-space: nowrap !important;
        }

        /* Navigation circles */
        body.nen-landing-body .row-circle-black-left,
        body.nen-landing-body .row-circle-black-right {
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
        }

        body.nen-landing-body .row-circle-black-left:hover,
        body.nen-landing-body .row-circle-black-right:hover {
            transform: scale(1.08);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.28);
        }

        body.nen-landing-body .row-circle-black-left:active,
        body.nen-landing-body .row-circle-black-right:active {
            opacity: 0.85;
        }

        /* Card hover polish for both agency carousels */
        body.nen-landing-body .nen-scroll-wrap .frame-c,
        body.nen-landing-body .nen-scroll-wrap .card-c {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        body.nen-landing-body .nen-scroll-wrap .frame-c:hover,
        body.nen-landing-body .nen-scroll-wrap .card-c:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 30px -12px rgba(0, 0, 0, 0.28);
        }

        /* ── Success Partners infinite marquee ──
           Two rows scroll in opposite directions. The track holds the logo set
           twice; translating by -50% (or 0..-50%) loops seamlessly because every
           logo carries an equal right-margin, so both copies tile identically. */
        .nen-marquee {
            position: relative;
            overflow: hidden;
            width: 100%;
            align-self: stretch;
            -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 7%, #000 93%, transparent 100%);
            mask-image: linear-gradient(90deg, transparent 0, #000 7%, #000 93%, transparent 100%);
        }

        .nen-marquee__track {
            display: flex;
            align-items: center;
            width: max-content;
        }

        body.nen-landing-body .nen-marquee__track .mask-group {
            margin-right: 39px;
            flex-shrink: 0;
        }

        .nen-marquee--left .nen-marquee__track {
            animation: nen-marquee-left 45s linear infinite;
        }

        .nen-marquee--right .nen-marquee__track {
            animation: nen-marquee-right 45s linear infinite;
        }

        .nen-marquee:hover .nen-marquee__track {
            animation-play-state: paused;
        }

        @keyframes nen-marquee-left {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        @keyframes nen-marquee-right {
            from {
                transform: translateX(-50%);
            }

            to {
                transform: translateX(0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .nen-marquee__track {
                animation: none !important;
            }
        }

    /* Fallback when few/no partners: clean centered static row (no animation) */
    .nen-partners-static {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 39px;
        padding: 0 24px;
    }

    /* ── About section ── */
    /* Scroll-reveal: each word starts dimmed and darkens as the paragraph
       scrolls through the viewport (driven by JS toggling .is-lit). */
    body.nen-landing-body #about .subtitle2.nen-reveal {
        color: #cfcfcf;
    }
    body.nen-landing-body #about .subtitle2.nen-reveal .nen-word {
        color: #cfcfcf;
        transition: color 0.35s ease;
    }
    body.nen-landing-body #about .subtitle2.nen-reveal .nen-word.is-lit {
        color: #232323;
    }
    @media (prefers-reduced-motion: reduce) {
        body.nen-landing-body #about .subtitle2.nen-reveal .nen-word { color: #232323; }
    }

    /* ── Required Documents: uniform card grid + scroll-in animation ── */
    /* Equal width: every card flexes to an identical basis within its row. */
    body.nen-landing-body #documents .row-f {
        align-items: stretch !important;
    }
    body.nen-landing-body #documents .card-b {
        flex: 1 1 0 !important;
        width: 0 !important;
        min-width: 0 !important;
        /* Equal height regardless of one- vs two-line titles. */
        min-height: 104px !important;
        height: 104px !important;
        align-items: center !important;
        gap: 14px !important;
        padding: 12px 16px !important;
    }
    /* Uniform square thumbnails so differing image ratios don't skew cards. */
    body.nen-landing-body #documents .card-b .card-img {
        width: 76px !important;
        height: 76px !important;
        object-fit: cover !important;
        border-radius: 8px !important;
        flex-shrink: 0 !important;
    }
    body.nen-landing-body #documents .card-b .card-text2 {
        flex: 1 1 auto !important;
        text-align: left !important;
        font-size: 16px !important;
        line-height: 1.35 !important;
        margin: 0 !important;
    }
    /* Entrance animation (only when JS marks the section ready, so no-JS still shows cards). */
    body.nen-landing-body #documents.nen-anim-ready .card-b {
        opacity: 0;
        transform: translateY(22px);
        transition: opacity 0.55s ease, transform 0.55s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }
    body.nen-landing-body #documents.nen-anim-ready .card-b.is-in {
        opacity: 1;
        transform: translateY(0);
    }
    body.nen-landing-body #documents .card-b:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 26px rgba(0, 0, 0, 0.09);
        border-color: #2c6e63 !important;
    }
    @media (prefers-reduced-motion: reduce) {
        body.nen-landing-body #documents.nen-anim-ready .card-b {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }
    }

    /* ── How It Works: numbered "journey" flip cards ── */
    body.nen-landing-body .nen-steps {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    body.nen-landing-body .nen-steps-row {
        display: flex;
        align-items: stretch;
        gap: 16px;
    }
    body.nen-landing-body .nen-step {
        flex: 1 1 0;
        min-width: 0;
        perspective: 1600px;
        outline: none;
        cursor: pointer;
    }
    /* Entrance (staggered) — only active once JS marks the group ready. */
    body.nen-landing-body .nen-steps.nen-anim-ready .nen-step {
        opacity: 0;
        transform: translateY(24px);
        transition: opacity 0.55s ease, transform 0.55s ease;
        transition-delay: var(--nen-step-delay, 0ms);
    }
    body.nen-landing-body .nen-steps.nen-anim-ready .nen-step.is-in {
        opacity: 1;
        transform: none;
    }
    body.nen-landing-body .nen-step__inner {
        position: relative;
        width: 100%;
        min-height: 300px;
        height: 100%;
        transform-style: preserve-3d;
        transition: transform 0.75s cubic-bezier(0.22, 0.61, 0.36, 1);
    }
    body.nen-landing-body .nen-step:hover .nen-step__inner,
    body.nen-landing-body .nen-step:focus-visible .nen-step__inner,
    body.nen-landing-body .nen-step.is-flipped .nen-step__inner {
        transform: rotateY(180deg);
    }
    body.nen-landing-body .nen-step__face {
        position: absolute;
        inset: 0;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
        padding: 28px 30px;
        border-radius: 16px;
        overflow: hidden;
    }
    body.nen-landing-body .nen-step__front {
        gap: 20px;
        background: #fff;
        border: 1px solid #e6e6e6;
    }
    /* Flip-hint glyph in the corner of the front face. */
    body.nen-landing-body .nen-step__front::after {
        content: "\21BB";
        position: absolute;
        right: 18px;
        bottom: 16px;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: #6b7a76;
        background: #f1f3f2;
        border-radius: 50%;
        transition: background 0.25s ease, color 0.25s ease;
    }
    body.nen-landing-body .nen-step:hover .nen-step__front::after {
        background: #243b37;
        color: #fff;
    }
    body.nen-landing-body .nen-step__back {
        transform: rotateY(180deg);
        gap: 12px;
        color: #1c1c1c;
        background: #fff;
        border: 1px solid #e6e6e6;
        justify-content: flex-start;
    }
    body.nen-landing-body .nen-step__num {
        margin: 0;
        font-size: 52px;
        font-weight: 800;
        line-height: 1;
        letter-spacing: -1px;
        color: #e7eae9;
    }
    body.nen-landing-body .nen-step__num--back {
        color: #e7eae9;
    }
    body.nen-landing-body .nen-step__icon {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f3f2;
        border-radius: 12px;
        flex-shrink: 0;
    }
    body.nen-landing-body .nen-step__icon img {
        width: 26px;
        height: 26px;
        object-fit: contain;
    }
    body.nen-landing-body .nen-step__icon--back {
        background: #f1f3f2;
    }
    body.nen-landing-body .nen-step__title {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        line-height: 1.25;
        color: #1c1c1c;
    }
    body.nen-landing-body .nen-step__title--back {
        color: #1c1c1c;
        font-size: 20px;
    }
    body.nen-landing-body .nen-step__desc {
        margin: 0;
        font-size: 15px;
        line-height: 1.5;
        color: #6b7a76;
    }
    @media (max-width: 820px) {
        body.nen-landing-body .nen-steps-row {
            flex-direction: column;
        }
    }
    @media (prefers-reduced-motion: reduce) {
        body.nen-landing-body .nen-steps.nen-anim-ready .nen-step {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }
        body.nen-landing-body .nen-step__inner {
            transition: none !important;
        }
    }
    /* CTA buttons: equal height (stretch to the tallest) with centered labels. */
    body.nen-landing-body #about .row-bottom4 {
        align-items: stretch;
    }
    body.nen-landing-body #about .row-bottom4 .frame-b {
        display: flex;
        align-items: center;
    }
</style>
@endpush

@section('content')

    {{-- ===================== HERO ===================== --}}
    @if ($landing->show_hero ?? true)
        <div class="col-top1" id="hero">
            <img src="{{ asset('site/home/assets/img1.png') }}" class="img1" alt="Study in Uzbekistan" />

            <div class="row-top4">
                <div class="row-a row1">
                    @for ($i = 1; $i <= 12; $i++)
                        <div class="row-circle row-circle{{ $i }}"></div>
                    @endfor
                </div>

                {{-- Floating Navigation Bar --}}
                <div class="row2">
                    <img src="{{ asset('site/home/assets/nen.png') }}" class="nen" alt="NEN" />

                    <div class="row3">
                        <div class="col-left1">
                            <a href="#hero" class="text-home">Home</a>
                            <div class="circle-black-bottom"></div>
                        </div>
                        <a href="{{ $landing->nav_about_url ?? '#about' }}" class="text-about-program">About Program</a>
                        <a href="{{ $landing->nav_events_url ?? '#why-uzbekistan' }}"
                            class="text-why-uzbekistan-question">Why Uzbekistan?</a>
                        <a href="{{ $landing->nav_partners_url ?? '#how-it-works' }}" class="text-about-nen">About NEN</a>
                        <a href="{{ $landing->nav_contact_url ?? '#faq' }}" class="text-right">FAQ</a>
                    </div>

                    <div class="row-right2">
                        {{-- Language Switcher --}}
                        <div class="nen-lang-dropdown">
                            <button class="nen-lang-dropdown__toggle" id="nenLangBtn" type="button">
                                <img src="{{ asset('site/home/assets/globe.png') }}" class="globe" alt="Language" />
                                <span id="nenCurrentLang">EN</span>
                            </button>
                            <div class="nen-lang-dropdown__menu" id="nenLangMenu">
                                <a class="nen-lang-dropdown__item translate-trigger" href="#" data-lang="en"
                                    data-label="EN">
                                    <span class="flag-icon flag-icon-us"></span> English
                                </a>
                                <a class="nen-lang-dropdown__item translate-trigger" href="#" data-lang="ar"
                                    data-label="AR">
                                    <span class="flag-icon flag-icon-sa"></span> العربية
                                </a>
                                <a class="nen-lang-dropdown__item translate-trigger" href="#" data-lang="ru"
                                    data-label="RU">
                                    <span class="flag-icon flag-icon-ru"></span> Русский
                                </a>
                            </div>
                        </div>

                        {{-- Apply / Register Button --}}
                        @if ($landing->header_register_url)
                            <a href="{{ $landing->header_register_url }}" class="card5">
                                <img src="{{ asset('site/home/assets/card-img.png') }}" class="card-img2" />
                                <p class="card-text-left1">{{ $landing->header_register_text ?? 'Apply Now' }}</p>
                                <img src="{{ asset('site/home/assets/card-lucide-arrow.png') }}"
                                    class="card-lucide-arrow1" />
                            </a>
                        @endif
                    </div>
                </div>

                <div class="row-a row4">
                    @for ($i = 1; $i <= 12; $i++)
                        <div class="row-circle row-circle{{ $i }}"></div>
                    @endfor
                </div>
            </div>

            <div class="row5">
                <div class="row-a row6">
                    @for ($i = 1; $i <= 12; $i++)
                        <div class="row-circle row-circle{{ $i }}"></div>
                    @endfor
                </div>
                <div class="row-a row7">
                    @for ($i = 1; $i <= 12; $i++)
                        <div class="row-circle row-circle{{ $i }}"></div>
                    @endfor
                </div>
                <div class="row-a row8">
                    @for ($i = 1; $i <= 12; $i++)
                        <div class="row-circle row-circle{{ $i }}"></div>
                    @endfor
                </div>
                <div class="col1">
                    <div class="col2">
                        <h2 class="subtitle1">
                            <span class="sub-text-text-title">Study in
                            </span>{{ $landing->hero_product_title ?? 'Uzbekistan.' }}
                        </h2>
                        <p class="text-join-the-ultimate">
                            {{ $landing->hero_subtitle ?? 'Join the ultimate educational network where students, top universities, and world-class programs come together!' }}
                        </p>
                    </div>

                    <a href="{{ $landing->hero_btn_url ?? '#collection-point' }}" class="frame-a frame-bottom">
                        <p>{{ $landing->hero_btn_text ?? 'Find a collection point' }}</p>
                        <img src="{{ asset('site/home/assets/card-img.png') }}" class="frame-img1" />
                    </a>
                </div>
            </div>

            <div class="row-a row9">
                @for ($i = 1; $i <= 12; $i++)
                    <div class="row-circle row-circle{{ $i }}"></div>
                @endfor
            </div>
            <div class="row-a row10">
                @for ($i = 1; $i <= 12; $i++)
                    <div class="row-circle row-circle{{ $i }}"></div>
                @endfor
            </div>
            {{-- Partner Logos Row --}}
            <div class="row-bottom3">
                <div class="row-a row11">
                    @for ($i = 1; $i <= 12; $i++)
                        <div class="row-circle row-circle{{ $i }}"></div>
                    @endfor
                </div>

                <div class="row12">
                    <div class="row-b row13">
                        <img src="{{ asset('site/home/assets/row/row-img1.png') }}" class="row-img1" alt="Ministry" />
                        <div class="row-col1">
                            <p class="row-text1">Ministry of Higher Education</p>
                            <p class="row-text-republic-of">Republic of Uzbekistan</p>
                        </div>
                    </div>

                    <div class="line line1"></div>

                    <div class="row-b row14">
                        <img src="{{ asset('site/home/assets/row/row-img2.png') }}" class="row-img1"
                            alt="Prime Minister" />
                        <div class="row-col1">
                            <p class="row-text1">Prime Minister's Office</p>
                            <p class="row-text-republic-of">Republic of Uzbekistan</p>
                        </div>
                    </div>

                    <div class="line line2"></div>

                    <div class="col-right1">
                        <img src="{{ asset('site/home/assets/img2.png') }}" class="img2" alt="Official Partner" />
                        <p>Official Partner</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ===================== ABOUT PROGRAM ===================== --}}
    @if ($landing->show_about ?? true)
        <div class="col3" id="about">
            <div class="column-a col-top2">
                <button class="btn-a column-btn1 hover-dark">{{ $landing->about_label ?? 'About Program' }}</button>
                <h2 class="column-subtitle1">{{ $landing->about_title ?? 'About Study In Uzbekistan?' }}</h2>
            </div>

            <div class="col4">
                <div class="group-top">
                    <div class="group1">
                        <img src="{{ asset('site/home/assets/group1.png') }}" class="group2" alt="" />
                        <button class="btn-b btn1 hover-bright">Official Initiative</button>
                    </div>

                    <img src="{{ $landing->about_image_main ? asset($landing->about_image_main) : asset('site/home/assets/img3.png') }}"
                        class="img3" alt="{{ $landing->about_title }}" />

                    <div class="group3">
                        <img src="{{ asset('site/home/assets/group2.png') }}" class="group4" alt="" />
                        <button class="btn-b btn-world-class hover-bright">World-Class</button>
                    </div>
                </div>

                <div class="col-bottom1">
                    {{-- Text starts dimmed and "lights up" word-by-word as it scrolls into view (JS-driven) --}}
                    <h2 class="subtitle2 nen-reveal" data-reveal>{{ $landing->about_description ?? 'Study in Uzbekistan is an official initiative of the Ministry of Higher Education to attract international students to world-class universities. Through the official portal, you can explore programs, requirements, and scholarship opportunities.' }}</h2>

                    <div class="row-bottom4">
                        <a href="{{ $landing->footer_collaboration_url ?? 'https://studyin-uzbekistan.uz' }}"
                            class="frame-b frame-left">
                            <p>Visit Official Portal</p>
                            <img src="{{ asset('site/home/assets/card-img.png') }}" class="frame-img2" />
                        </a>

                        <a href="#how-it-works" class="frame-b frame-right1">
                            <p>Life in Uzbekistan</p>
                            <img src="{{ asset('site/home/assets/card-img.png') }}" class="frame-img2" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ===================== WHY UZBEKISTAN (FEATURE CARDS) ===================== --}}
    @if ($landing->show_features ?? true)
        <div class="col5 section" id="why-uzbekistan">
            <div class="col6">
                <div class="column-a col-top3">
                    <button class="btn-a column-btn1 hover-dark">Why Uzbekistan?</button>
                    <h2 class="column-subtitle1">{{ $landing->features_title ?? 'Why Study In Uzbekistan?' }}</h2>
                </div>

                <div class="container">
                    <div class="container-container1">
                        @php
                            $fc = $featureCards ?? collect();
                            $fcArr = $fc->values();
                            $card0 = $fcArr->get(0);
                            $card1 = $fcArr->get(1);
                            $card2 = $fcArr->get(2);
                            $card3 = $fcArr->get(3);
                            $cardIcons = [
                                asset('site/home/assets/row/row-group1.png'),
                                asset('site/home/assets/row/row-group2.png'),
                                asset('site/home/assets/row/row-group3.png'),
                                asset('site/home/assets/row/row-group4.png'),
                            ];
                        @endphp

                        <div class="container-row-top">
                            {{-- Card 1 (card6 style - larger) --}}
                            <div class="card6">
                                <div class="row-c row-top5">
                                    <p class="row-text2">{{ $card0->title ?? 'Quality Education' }}</p>
                                    <img src="{{ $card0 && $card0->image ? asset($card0->image) : $cardIcons[0] }}"
                                        class="row-group" alt="" />
                                </div>
                                <div class="card-container3">
                                    <h2 class="card-subtitle2">{{ $card0->stat_value ?? '100+' }}</h2>
                                    <p class="card-text4">
                                        {{ $card0->description ?? 'Internationally recognized universities with modern campuses and English-taught programs.' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Card 2 (card7 style) --}}
                            <div class="card-a card7">
                                <div class="row-c row-top1">
                                    <p class="row-text2">{{ $card1->title ?? 'Affordable Costs' }}</p>
                                    <img src="{{ $card1 && $card1->image ? asset($card1->image) : $cardIcons[1] }}"
                                        class="row-group" alt="" />
                                </div>
                                <div class="card-container1">
                                    <div class="card-container2">
                                        <h2>{{ $card1->stat_value ?? '50%' }}</h2>
                                    </div>
                                    <p class="card-text1">
                                        {{ $card1->description ?? 'Students can save up to 50% on tuition and living expenses compared to other countries.' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="container-container2">
                            <div class="container-row">
                                {{-- Card 3 (card8 style) --}}
                                <div class="card-a card8">
                                    <div class="row-c row-top1">
                                        <p class="row-text2">{{ $card2->title ?? 'Safe & Welcoming' }}</p>
                                        <img src="{{ $card2 && $card2->image ? asset($card2->image) : $cardIcons[2] }}"
                                            class="row-group" alt="" />
                                    </div>
                                    <div class="card-container1">
                                        <div class="card-container2">
                                            <h2>{{ $card2->stat_value ?? '100%' }}</h2>
                                        </div>
                                        <p class="card-text1">
                                            {{ $card2->description ?? 'A safe and welcoming country with a rich cultural heritage for international students.' }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Card 4 (card9 style) --}}
                                <div class="card-a card9">
                                    <div class="row-c row-top1">
                                        <p class="row-text2">{{ $card3->title ?? 'International Environment' }}</p>
                                        <img src="{{ $card3 && $card3->image ? asset($card3->image) : $cardIcons[3] }}"
                                            class="row-group" alt="" />
                                    </div>
                                    <div class="card-container1">
                                        <div class="card-container2">
                                            <h2>{{ $card3->stat_value ?? '50+' }}</h2>
                                        </div>
                                        <p class="card-text1">
                                            {{ $card3->description ?? 'Welcoming international student community and a growing number of programs in English.' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-frame-right">
                        <a href="{{ $landing->footer_collaboration_url ?? 'https://studyin-uzbekistan.uz' }}"
                            class="card10">
                            <img src="{{ asset('site/home/assets/card-img.png') }}" class="card-img3" />
                            <p class="card-text-left2">Explore University</p>
                            <img src="{{ asset('site/home/assets/card-lucide-arrow.png') }}"
                                class="card-lucide-arrow2" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ===================== HOW IT WORKS ===================== --}}
    @if ($landing->show_how_it_works ?? true)
        <div class="col7" id="how-it-works">
            <div class="row-top6">
                <div class="col-left2">
                    <button class="btn-a btn2 hover-dark">Your Path</button>
                    <h2 class="subtitle-we-re-not-just-about">{{ $landing->how_it_works_title ?? 'How It Works' }}</h2>
                    <p class="text">
                        {{ $landing->how_it_works_subtitle ?? 'Simple steps from application to arrival. Fast admission, certified future.' }}
                    </p>
                </div>

                <a href="{{ $landing->how_it_works_btn_url ?? '#collection-point' }}" class="frame-a frame-right2">
                    <p>{{ $landing->how_it_works_btn_text ?? 'Apply for a student visa' }}</p>
                    <img src="{{ asset('site/home/assets/card-img.png') }}" class="frame-img1" />
                </a>
            </div>

            @php
                $steps = $howItWorksSteps ?? collect();
                $stepsArr = $steps->values();
                $stepComponents = [
                    asset('site/home/assets/component/component-presentation.png'),
                    asset('site/home/assets/component/component-university.png'),
                    asset('site/home/assets/component/component-files.png'),
                    asset('site/home/assets/component/component-map-pinpoint.png'),
                    asset('site/home/assets/component/component-checkmark.png'),
                    asset('site/home/assets/component/component-folder-view.png'),
                ];
                $stepTitles = [
                    'Register Online',
                    'Choose University',
                    'Prepare Documents',
                    'Visit a Collection Point',
                    'Verify',
                    'Admission Follow-Up',
                ];
                $stepDescs = [
                    'Create your account on the Study in Uzbekistan portal.',
                    'Explore universities and programmes on the portal and select up to 5 universities and programmes.',
                    'Prepare and submit the required documents through NEN collection points.',
                    'NEN verifies your documents and coordinates with the relevant authorities.',
                    'Receive admission updates and application support.',
                    'Complete your visa application and prepare for your study journey.',
                ];
                $topRowIdxs = [0, 1, 2];
                $botRowIdxs = [3, 4, 5];
            @endphp

            <div class="col8 nen-steps">
                @foreach ([[0, 1, 2], [3, 4, 5]] as $row)
                    <div class="nen-steps-row">
                        @foreach ($row as $idx)
                            @php
                                $step = $stepsArr->get($idx);
                                $icon = $step && $step->image ? asset($step->image) : ($stepComponents[$idx] ?? '');
                                $title = $step ? $step->title : ($stepTitles[$idx] ?? '');
                                $desc = $step ? $step->description : ($stepDescs[$idx] ?? '');
                                $num = str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT);
                            @endphp
                            <div class="nen-step" tabindex="0" role="button"
                                aria-label="{{ $title }} — step {{ $idx + 1 }}"
                                style="--nen-step-delay: {{ $idx * 90 }}ms">
                                <div class="nen-step__inner">
                                    <div class="nen-step__face nen-step__front">
                                        <span class="nen-step__num">{{ $num }}.</span>
                                        <div class="nen-step__icon">
                                            <img src="{{ $icon }}" alt="{{ $title }}" />
                                        </div>
                                        <h3 class="nen-step__title">{{ $title }}</h3>
                                    </div>
                                    <div class="nen-step__face nen-step__back">
                                        <span class="nen-step__num nen-step__num--back">{{ $num }}.</span>
                                        <div class="nen-step__icon nen-step__icon--back">
                                            <img src="{{ $icon }}" alt="" aria-hidden="true" />
                                        </div>
                                        <h3 class="nen-step__title nen-step__title--back">{{ $title }}</h3>
                                        <p class="nen-step__desc">{{ $desc }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ===================== NEN MILESTONES / TESTIMONIALS ===================== --}}
    @if ($landing->show_milestones ?? true)
        <div class="tesrimonials" id="about-nen">
            <div class="tesrimonials-col-left">
                <a href="{{ $landing->milestones_cta_url ?? '#collection-point' }}"
                    class="btn-c tesrimonials-btn hover-bright">
                    {{ $landing->milestones_cta_text ?? 'Find collection point' }}
                </a>

                <div class="tesrimonials-col1">
                    <div class="tesrimonials-col2">
                        <h2 class="tesrimonials-subtitle-national">
                            {{ $landing->milestones_title ?? 'National Education Network Global Learning Portal' }}</h2>
                        <p class="text tesrimonials-text-an-international">
                            {{ $landing->milestones_subtitle ?? 'An international education network providing top services in university partnerships, student recruitment, and certified academic projects worldwide.' }}
                        </p>
                    </div>

                    <div class="tesrimonials-col-bottom">
                        <h2 class="tesrimonials-subtitle-key-milestones">Key Milestones</h2>

                        <div class="tesrimonials-row">
                            <div class="column-b">
                                <h2 class="column-subtitle2">{{ $landing->about_stat_value ?? '15+' }}</h2>
                                <p class="column-text">{{ $landing->about_stat_label ?? 'Years of Experience' }}</p>
                            </div>
                            <div class="line tesrimonials-line1"></div>
                            <div class="column-b">
                                <h2 class="column-subtitle2">{{ $landing->about_metric1_value ?? '100+' }}</h2>
                                <p class="column-text">{{ $landing->about_metric1_label ?? 'Global Universities' }}</p>
                            </div>
                            <div class="line tesrimonials-line2"></div>
                            <div class="column-b">
                                <h2 class="column-subtitle2">{{ $landing->about_metric2_value ?? '29' }}</h2>
                                <p class="column-text">{{ $landing->about_metric2_label ?? 'Countries Worldwide' }}</p>
                            </div>
                        </div>

                        <p class="text tesrimonials-text-bottom">
                            {{ $landing->milestones_description ?? 'Our mission is making international education more accessible. Join a thriving global academic community with verified university programs, direct admissions, and guidance led by experienced mentors.' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="tesrimonials-group-right">
                <img src="{{ asset('site/home/assets/tesrimonials-group2.png') }}" class="tesrimonials-group1"
                    alt="" />
                <img src="{{ asset('site/home/assets/tesrimonials-group3.png') }}" class="tesrimonials-group2"
                    alt="" />
                <img src="{{ asset('site/home/assets/tesrimonials-group3.png') }}" class="tesrimonials-group3"
                    alt="" />
                <img src="{{ asset('site/home/assets/tesrimonials-group3.png') }}" class="tesrimonials-group4"
                    alt="" />
            </div>
        </div>
    @endif

    {{-- ===================== CERTIFIED TRANSLATION AGENCIES ===================== --}}
    @if (($landing->show_agencies ?? true) && isset($translationAgencies) && $translationAgencies->count())
        <div class="col12" id="translation-agencies">
            <div class="row-d row-top8">
                <div class="row-col2">
                    <button class="btn-c row-btn hover-dark">Certified Agencies</button>
                    <h2 class="row-subtitle">{{ $landing->agencies_title ?? 'Certified Translation Agencies' }}</h2>
                    <p class="text row-text-bottom">
                        {{ $landing->agencies_subtitle ?? 'Translate your official documents quickly and securely through our network of trusted, certified translation offices.' }}
                    </p>
                </div>

                <div class="row-row-right">
                    <div class="row-circle-black-left circle-black hover-bright" id="transAgencyPrev">
                        <img src="{{ asset('site/home/assets/row-circle-black/row-lucide-arrow.png') }}"
                            alt="Previous" />
                        <img src="{{ asset('site/home/assets/row-circle-black/row-img.png') }}" class="row-img2" />
                    </div>
                    <div class="row-circle-black-right circle-black hover-bright" id="transAgencyNext">
                        <img src="{{ asset('site/home/assets/row-circle-black/row-lucide-arrow.png') }}"
                            alt="Next" />
                        <img src="{{ asset('site/home/assets/row-circle-black/row-img2.png') }}" class="row-img3" />
                    </div>
                </div>
            </div>

            <div class="group-bottom1">
                <div class="nen-scroll-wrap" id="transAgencyTrack">
                    <div class="row15" id="transAgencyInner">
                        @foreach ($translationAgencies as $i => $agency)
                            <div class="frame-c frame{{ $i + 1 }}">
                                <img src="{{ $agency->image ? asset($agency->image) : asset('site/home/assets/frame/frame-img' . (($i % 4) + 5) . '.png') }}"
                                    class="frame-img3 input" alt="{{ $agency->name }}" />
                                <div class="frame-col">
                                    <div class="frame-col-top">
                                        <p class="frame-text3">{{ $agency->name }}</p>
                                        <p class="frame-text4">{{ $agency->service_description }}</p>
                                    </div>
                                    <div class="frame-col-bottom">
                                        @if ($agency->location)
                                            <div class="row-e row-top2">
                                                <img src="{{ asset('site/home/assets/row/row-location.png') }}"
                                                    class="row-smart-phone row-location" alt="Location" />
                                                <p class="row-text3">{{ $agency->location }}</p>
                                            </div>
                                        @endif
                                        @if ($agency->phone)
                                            <div class="row-e row-bottom1">
                                                <img src="{{ asset('site/home/assets/row/row-smart-phone.png') }}"
                                                    class="row-smart-phone" alt="Phone" />
                                                <p class="row-text3">{{ $agency->phone }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>{{-- /.nen-scroll-wrap --}}
                <div class="rect-a rect1"></div>
            </div>
        </div>
    @endif

    {{-- ===================== REQUIRED DOCUMENTS ===================== --}}
    @if (($landing->show_documents ?? true) && isset($applicationDocuments) && $applicationDocuments->count())
        <div class="col13 section" id="documents">
            <div class="col14">
                <div class="column-c col-top4">
                    <button class="btn-a column-btn2 hover-dark">Application Prep</button>
                    <h2 class="column-subtitle3">{{ $landing->documents_title ?? 'Required Application Documents' }}</h2>
                    <p class="column-text-bottom">
                        {{ $landing->documents_subtitle ?? 'Prepare your official papers to complete your university application smoothly.' }}
                    </p>
                </div>

                <div class="col15">
                    @php
                        $docs = $applicationDocuments->values();
                        $rows = $docs->chunk(3);
                        $rowNums = ['row16', 'row17', 'row18'];
                    @endphp
                    @foreach ($rows as $rowIdx => $rowDocs)
                        <div class="row-f {{ $rowNums[$rowIdx] ?? 'row-f' }}">
                            @foreach ($rowDocs as $dIdx => $doc)
                                @php
                                    $cardClass = $dIdx === 0 ? '' : ($dIdx === 1 ? 'card3' : 'card4');
                                @endphp
                                <div class="card-b {{ $cardClass }}">
                                    <img src="{{ $doc->image ? asset($doc->image) : asset('site/home/assets/card/card-img' . (($docs->search($doc) % 9) + 1) . '.png') }}"
                                        class="card-img input" alt="{{ $doc->title }}" />
                                    <p class="card-text2">{!! nl2br(e($doc->title)) !!}</p>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- ===================== TRUSTED STUDY ABROAD AGENCIES ===================== --}}
    @if (($landing->show_trusted_agencies ?? true) && isset($trustedAgencies) && $trustedAgencies->count())
        <div class="col16" id="trusted-agencies">
            <div class="col17">
                <div class="row-d row-top9">
                    <div class="row-col2">
                        <button class="btn-c row-btn hover-dark">Trusted Agencies</button>
                        <h2 class="row-subtitle">
                            {{ $landing->trusted_agencies_title ?? 'Trusted Study Abroad Agencies' }}</h2>
                        <p class="text row-text-bottom">
                            {{ $landing->trusted_agencies_subtitle ?? 'Connect with certified consultants to simplify your university admission.' }}
                        </p>
                    </div>

                    <div class="row-row-right">
                        <div class="row-circle-black-left circle-black hover-bright" id="trustedAgencyPrev">
                            <img src="{{ asset('site/home/assets/row-circle-black/row-lucide-arrow.png') }}"
                                alt="Previous" />
                            <img src="{{ asset('site/home/assets/row-circle-black/row-img.png') }}" class="row-img2" />
                        </div>
                        <div class="row-circle-black-right circle-black hover-bright" id="trustedAgencyNext">
                            <img src="{{ asset('site/home/assets/row-circle-black/row-lucide-arrow.png') }}"
                                alt="Next" />
                            <img src="{{ asset('site/home/assets/row-circle-black/row-img2.png') }}" class="row-img3" />
                        </div>
                    </div>
                </div>

                <div class="col-bottom2">
                    <div class="group5">
                        <div class="nen-scroll-wrap" id="trustedAgencyTrack">
                            <div class="row19" id="trustedAgencyInner">
                                @foreach ($trustedAgencies as $i => $agency)
                                    @php $cardNum = $i + 11; @endphp
                                    <div class="card-c card{{ $cardNum }}">
                                        @if ($agency->whatsapp_url)
                                            <a href="{{ $agency->whatsapp_url }}" target="_blank" rel="noopener">
                                                <img src="{{ $agency->image ? asset($agency->image) : asset('site/home/assets/card/card-whats-app.png') }}"
                                                    class="card-whats-app" alt="WhatsApp" />
                                            </a>
                                        @else
                                            <img src="{{ $agency->image ? asset($agency->image) : asset('site/home/assets/card/card-whats-app.png') }}"
                                                class="card-whats-app" alt="{{ $agency->name }}" />
                                        @endif
                                        <div class="card-col-bottom">
                                            <p class="card-text3">{{ $agency->name }}</p>
                                            <div class="card-col">
                                                @if ($agency->location)
                                                    <div class="row-e row-top3">
                                                        <img src="{{ asset('site/home/assets/row/row-location.png') }}"
                                                            class="row-smart-phone row-location" alt="Location" />
                                                        <p class="row-text3">{{ $agency->location }}</p>
                                                    </div>
                                                @endif
                                                @if ($agency->phone)
                                                    <div class="row-e row-bottom2">
                                                        <img src="{{ asset('site/home/assets/row/row-smart-phone.png') }}"
                                                            class="row-smart-phone" alt="Phone" />
                                                        <p class="row-text3">{{ $agency->phone }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>{{-- /.nen-scroll-wrap --}}
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ===================== FAQ ===================== --}}
    @if ($landing->show_faq ?? true)
        <div class="col18 section" id="faq">
            <div class="col19">
                <div class="column-c col-top5">
                    <button class="btn-a column-btn2 hover-dark">FAQ</button>
                    <h2 class="column-subtitle3">{{ $landing->faq_title ?? 'Frequently Asked Questions' }}</h2>
                    <p class="column-text-bottom">Quick answers to common questions, all in one place</p>
                </div>

                @php
                    $allFaqs = ($faqs ?? collect())->values();
                    $leftCount = (int) ceil($allFaqs->count() / 2);
                    $leftFaqs = $allFaqs->slice(0, $leftCount)->values();
                    $rightFaqs = $allFaqs->slice($leftCount)->values();
                    $expandedFaq = $rightFaqs->first();
                    $restRightFaqs = $rightFaqs->skip(1);
                @endphp

                <div class="row20">
                    <div class="col-left3">
                        @foreach ($leftFaqs as $faq)
                            <button class="btn-d faq-btn-d hover-zoom" data-faq="{{ $faq->id }}" type="button">
                                <p class="btn-label">{{ $faq->question }}</p>
                                <img src="{{ asset('site/home/assets/btn/btn-icon.png') }}"
                                    class="btn-icon-add btn-icon" alt="+" />
                            </button>
                            @if ($faq->answer)
                                <div class="faq-answer" data-answer="{{ $faq->id }}">{{ $faq->answer }}</div>
                            @endif
                        @endforeach
                    </div>

                    <div class="col-right2">
                        @if ($expandedFaq)
                            <div class="card19">
                                <div class="card-container4">
                                    <p class="card-text-paragraph1">{{ $expandedFaq->question }}</p>
                                    <img src="{{ asset('site/home/assets/card-minus-sign.png') }}"
                                        class="card-minus-sign" alt="-" />
                                </div>
                                @if ($expandedFaq->answer)
                                    <p class="card-text-paragraph2">{{ $expandedFaq->answer }}</p>
                                @endif
                            </div>
                        @endif

                        @foreach ($restRightFaqs as $faq)
                            <button class="btn-d faq-btn-d hover-zoom" data-faq="{{ $faq->id }}" type="button">
                                <p class="btn-label">{{ $faq->question }}</p>
                                <img src="{{ asset('site/home/assets/btn/btn-icon.png') }}"
                                    class="btn-icon-add btn-icon" alt="+" />
                            </button>
                            @if ($faq->answer)
                                <div class="faq-answer" data-answer="{{ $faq->id }}">{{ $faq->answer }}</div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ===================== SUCCESS PARTNERS (UNIVERSITY LOGOS) ===================== --}}
    @if ($landing->show_university_logos ?? true)
        <div class="col20" id="success-partners">
            <button class="btn-a btn9 hover-dark">{{ $landing->university_logos_title ?? 'Success Partners' }}</button>

            @php
                $logos = ($universityLogos ?? collect())->values();
                $count = $logos->count();
                $placeholder = asset('site/home/assets/mask-group.png');
                $MIN_SLIDER = 6; /* need a reasonable number before two animated rows look good */

                /* Repeat a set until it has at least $min items, so a single marquee
 copy is wide enough to fill the viewport without visible gaps. */
                $fill = function ($set, $min = 8) {
                    $out = collect();
                    if ($set->isEmpty()) {
                        return $out;
                    }
                    while ($out->count() < $min) {
                        $out = $out->concat($set);
                    }
                    return $out->values();
                };

                $useSlider = $count >= $MIN_SLIDER;
                if ($useSlider) {
                    $mid = (int) ceil($count / 2);
                    $halfA = $logos->slice(0, $mid)->values();
                    $halfB = $logos->slice($mid)->values();
                    if ($halfB->isEmpty()) {
                        $halfB = $halfA;
                    }
                    $rowTop = $fill($halfA);
                    $rowBot = $fill($halfB)->reverse()->values();
                }
            @endphp

            <div class="col21">
                @if ($useSlider)
                    {{-- Row 1 — slides to the right --}}
                    <div class="nen-marquee nen-marquee--right">
                        <div class="nen-marquee__track">
                            @foreach ($rowTop->concat($rowTop) as $logo)
                                <a href="{{ $logo->url ?? '#' }}" title="{{ $logo->name }}"
                                    aria-hidden="{{ $loop->index >= $rowTop->count() ? 'true' : 'false' }}">
                                    <img src="{{ $logo->image ? asset($logo->image) : $placeholder }}"
                                        class="mask-group" alt="{{ $logo->name }}" />
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Row 2 — slides to the left --}}
                    <div class="nen-marquee nen-marquee--left">
                        <div class="nen-marquee__track">
                            @foreach ($rowBot->concat($rowBot) as $logo)
                                <a href="{{ $logo->url ?? '#' }}" title="{{ $logo->name }}"
                                    aria-hidden="{{ $loop->index >= $rowBot->count() ? 'true' : 'false' }}">
                                    <img src="{{ $logo->image ? asset($logo->image) : $placeholder }}"
                                        class="mask-group" alt="{{ $logo->name }}" />
                                </a>
                            @endforeach
                        </div>
                    </div>
                @elseif($count > 0)
                    {{-- Few partners: a clean centered static row (no awkward looping) --}}
                    <div class="nen-partners-static">
                        @foreach ($logos as $logo)
                            <a href="{{ $logo->url ?? '#' }}" title="{{ $logo->name }}">
                                <img src="{{ $logo->image ? asset($logo->image) : $placeholder }}" class="mask-group"
                                    alt="{{ $logo->name }}" />
                            </a>
                        @endforeach
                    </div>
                @else
                    {{-- No partners uploaded yet: placeholders so the section stays intentional --}}
                    <div class="nen-partners-static">
                        @for ($i = 0; $i < 6; $i++)
                            <img src="{{ $placeholder }}" class="mask-group" alt="University Partner" />
                        @endfor
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- ===================== FOOTER ===================== --}}
    <footer class="footer">
        <div class="footer-row-top">
            <img src="{{ asset('site/home/assets/footer-nen.png') }}" class="footer-nen" alt="NEN" />

            <div class="footer-col-left">
                <p class="footer-text-important-links">IMPORTANT LINKS</p>
                <div class="footer-col1">
                    <a href="https://studyin-uzbekistan.uz" target="_blank" rel="noopener"
                        class="footer-text">studyin-uzbekistan.uz</a>
                    <a href="https://edu.uz" target="_blank" rel="noopener" class="footer-text">Ministry of Higher
                        Education (Uzbekistan)</a>
                    <a href="#" class="footer-text">Embassy of Uzbekistan in Egypt</a>
                </div>
            </div>

            <div class="footer-col2">
                <p class="footer-text-contact-us">CONTACT US</p>
                <div class="footer-col3">
                    <div class="row-g row23">
                        <img src="{{ asset('site/home/assets/row/row-mail.png') }}" class="row-globe row-mail"
                            alt="Email" />
                        <p class="row-text4">{{ $landing->contact_email ?? 'admissions@nen-global.org' }}</p>
                    </div>

                    <div class="row-h row24">
                        <div class="row-group-left">
                            <div class="headphones row-headphones">AR</div>
                            <img src="{{ asset('site/home/assets/row-group/row-img.png') }}" class="row-img4"
                                alt="" />
                        </div>
                        <p class="text-plus">{{ $landing->footer_phone ?? '+20 10 6160 0400' }}</p>
                        <div class="row-i row-right">
                            <img src="{{ asset('site/home/assets/row/row-whatsapp.png') }}" class="row-whatsapp"
                                alt="WhatsApp" />
                            <div class="circle-telegram">
                                <img src="{{ asset('site/home/assets/circle-telegram/circle-telegram-img.png') }}"
                                    class="circle-telegram-img" alt="Telegram" />
                            </div>
                        </div>
                    </div>

                    <div class="footer-row">
                        <div class="footer-group-left">
                            <div class="headphones footer-headphones">EN</div>
                            <img src="{{ asset('site/home/assets/row-group/row-img.png') }}" class="footer-img"
                                alt="" />
                        </div>
                        <p class="text-plus">{{ $landing->footer_phone ?? '+20 10 6160 0400' }}</p>
                        <div class="row-i row-right3">
                            <img src="{{ asset('site/home/assets/row/row-whatsapp.png') }}" class="row-whatsapp"
                                alt="WhatsApp" />
                            <div class="circle-telegram">
                                <img src="{{ asset('site/home/assets/circle-telegram/circle-telegram-img.png') }}"
                                    class="circle-telegram-img" alt="Telegram" />
                            </div>
                        </div>
                    </div>

                    <div class="row-g row26">
                        <img src="{{ asset('site/home/assets/row/row-globe.png') }}" class="row-globe row-mail"
                            alt="Website" />
                        <a href="{{ $landing->footer_collaboration_url ?? 'https://nen-global.org/contacts' }}"
                            class="row-text4" target="_blank" rel="noopener">nen-global.org/contacts</a>
                    </div>
                </div>
            </div>

            <div class="footer-col-right">
                <p class="footer-text">FOLLOW US</p>
                <div class="footer-row-bottom">
                    <a href="#" class="circle circle1">
                        <img src="{{ asset('site/home/assets/circle/circle-facebook.png') }}" class="circle-youtube"
                            alt="Facebook" />
                    </a>
                    <a href="#" class="circle circle2">
                        <img src="{{ asset('site/home/assets/circle/circle-instagram.png') }}" class="circle-youtube"
                            alt="Instagram" />
                    </a>
                    <a href="#" class="circle circle3">
                        <img src="{{ asset('site/home/assets/circle/circle-whatsapp.png') }}" class="circle-youtube"
                            alt="WhatsApp" />
                    </a>
                    <a href="#" class="circle circle4">
                        <img src="{{ asset('site/home/assets/circle/circle-linkedin.png') }}" class="circle-youtube"
                            alt="LinkedIn" />
                    </a>
                    <a href="#" class="circle circle5">
                        <img src="{{ asset('site/home/assets/circle/circle-youtube.png') }}" class="circle-youtube"
                            alt="YouTube" />
                    </a>
                </div>
            </div>
        </div>

        <h1 class="footer-title">
            <span class="sub-text-brand-brand-main">Apply</span> For Future
        </h1>
        <div class="footer-footer">
            {{ $landing->footer_copyright ?? '© ' . date('Y') . ' NEN | National Education Network. All Rights Reserved.' }}
        </div>
    </footer>

@endsection

@push('scripts')
    <script>
        (function() {
            /* ── Language dropdown ── */
            const langBtn = document.getElementById('nenLangBtn');
            const langMenu = document.getElementById('nenLangMenu');
            const langLabel = document.getElementById('nenCurrentLang');
            if (langBtn && langMenu) {
                langBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    langMenu.classList.toggle('open');
                });
            }
            langMenu && langMenu.querySelectorAll('.translate-trigger').forEach(function(a) {
                a.addEventListener('click', function() {
                    if (langLabel) langLabel.textContent = a.dataset.label || 'EN';
                    langMenu.classList.remove('open');
                });
            });

            /* Close language dropdown on outside click */
            document.addEventListener('click', function() {
                if (langMenu) langMenu.classList.remove('open');
            });

            /* ── FAQ accordion ── */
            document.querySelectorAll('.faq-btn-d').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const idx = btn.dataset.faq;
                    const answer = document.querySelector('.faq-answer[data-answer="' + idx + '"]');
                    if (!answer) return;
                    const isOpen = answer.classList.contains('open');
                    /* Close all */
                    document.querySelectorAll('.faq-answer').forEach(function(a) {
                        a.classList.remove('open');
                    });
                    document.querySelectorAll('.faq-btn-d').forEach(function(b) {
                        b.classList.remove('active');
                    });
                    /* Toggle the clicked one */
                    if (!isOpen) {
                        answer.classList.add('open');
                        btn.classList.add('active');
                    }
                });
            });

            /* ── Agency auto-sliders ──
               The .nen-scroll-wrap clips (overflow:hidden); we translate the inner row.
               Auto-advances one card every 10s, loops to start at the end, pauses on
               hover, and resets the timer on manual navigation. */
            function makeScroller(wrapId, innerId, prevId, nextId) {
                const wrap = document.getElementById(wrapId);
                const inner = document.getElementById(innerId);
                const prev = document.getElementById(prevId);
                const next = document.getElementById(nextId);
                if (!wrap || !inner || !prev || !next) return;

                let offset = 0;
                const INTERVAL = 10000;
                let timer = null;

                function gapPx() {
                    return parseFloat(getComputedStyle(inner).columnGap) || 16;
                }

                function cardWidth() {
                    const card = inner.firstElementChild;
                    return card ? card.getBoundingClientRect().width : 0;
                }

                function step() {
                    /* one card width + the flex gap, measured live */
                    const cw = cardWidth();
                    return cw ? cw + gapPx() : 403;
                }
                /* Size the visible viewport so it shows only WHOLE cards (no half card). */
                function fit() {
                    const cw = cardWidth();
                    if (!cw) return;
                    const gap = gapPx();
                    const avail = wrap.parentElement.clientWidth;
                    const count = Math.max(1, Math.floor((avail + gap) / (cw + gap)));
                    wrap.style.width = (count * (cw + gap) - gap) + 'px';
                    wrap.style.maxWidth = '100%';
                    wrap.style.marginLeft = 'auto';
                    wrap.style.marginRight = 'auto';
                }

                function maxOffset() {
                    return Math.max(0, inner.scrollWidth - wrap.clientWidth);
                }

                function apply() {
                    offset = Math.max(0, Math.min(offset, maxOffset()));
                    inner.style.transform = 'translateX(-' + offset + 'px)';
                }

                function advance() {
                    /* loop back to the start once the end is reached */
                    if (offset >= maxOffset() - 1) {
                        offset = 0;
                    } else {
                        offset += step();
                    }
                    apply();
                }

                function start() {
                    stop();
                    timer = setInterval(advance, INTERVAL);
                }

                function stop() {
                    if (timer) {
                        clearInterval(timer);
                        timer = null;
                    }
                }

                prev.addEventListener('click', function(e) {
                    e.preventDefault();
                    offset -= step();
                    apply();
                    start();
                });
                next.addEventListener('click', function(e) {
                    e.preventDefault();
                    advance();
                    start();
                });
                wrap.addEventListener('mouseenter', stop);
                wrap.addEventListener('mouseleave', start);
                window.addEventListener('resize', function() {
                    fit();
                    apply();
                });

                fit();
                apply();
                start();
            }

            makeScroller('transAgencyTrack', 'transAgencyInner', 'transAgencyPrev', 'transAgencyNext');
            makeScroller('trustedAgencyTrack', 'trustedAgencyInner', 'trustedAgencyPrev', 'trustedAgencyNext');

            /* ── About text scroll-reveal ──
               Split the paragraph into word spans and "light them up" from
               dimmed grey to dark based on how far the text has scrolled
               through the viewport. */
            (function () {
                const el = document.querySelector('#about .nen-reveal');
                if (!el) return;
                const text = (el.textContent || '').replace(/\s+/g, ' ').trim();
                if (!text) return;

                el.textContent = '';
                const words = text.split(' ').map(function (word) {
                    const span = document.createElement('span');
                    span.className = 'nen-word';
                    span.textContent = word;
                    el.appendChild(span);
                    el.appendChild(document.createTextNode(' '));
                    return span;
                });

                let ticking = false;
                function update() {
                    ticking = false;
                    const rect = el.getBoundingClientRect();
                    const vh = window.innerHeight || document.documentElement.clientHeight;
                    /* Begin revealing when the text enters the lower 85% of the
                       viewport, finish by the time it reaches 40% up. */
                    const start = vh * 0.85;
                    const end = vh * 0.40;
                    let progress = (start - rect.top) / (start - end);
                    progress = Math.max(0, Math.min(1, progress));
                    const lit = Math.round(progress * words.length);
                    words.forEach(function (w, i) { w.classList.toggle('is-lit', i < lit); });
                }
                function onScroll() {
                    if (!ticking) { ticking = true; window.requestAnimationFrame(update); }
                }
                update();
                window.addEventListener('scroll', onScroll, { passive: true });
                window.addEventListener('resize', onScroll);
            })();

            /* ── Required Documents: staggered fade/slide-in on scroll ── */
            (function () {
                const section = document.getElementById('documents');
                if (!section) return;
                const cards = section.querySelectorAll('.card-b');
                if (!cards.length) return;

                section.classList.add('nen-anim-ready');
                cards.forEach(function (card, i) {
                    card.style.transitionDelay = (i * 70) + 'ms';
                });

                if (!('IntersectionObserver' in window)) {
                    cards.forEach(function (card) { card.classList.add('is-in'); });
                    return;
                }
                const io = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-in');
                            io.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.15 });
                cards.forEach(function (card) { io.observe(card); });
            })();

            /* ── How It Works: flip cards (tap/keyboard) + staggered entrance ── */
            (function () {
                const group = document.querySelector('.nen-steps');
                if (!group) return;
                const steps = group.querySelectorAll('.nen-step');
                if (!steps.length) return;

                group.classList.add('nen-anim-ready');

                steps.forEach(function (step) {
                    /* Tap toggles the flip (hover handles it on pointer devices). */
                    step.addEventListener('click', function () {
                        step.classList.toggle('is-flipped');
                    });
                    step.addEventListener('keydown', function (e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            step.classList.toggle('is-flipped');
                        }
                    });
                });

                if (!('IntersectionObserver' in window)) {
                    steps.forEach(function (step) { step.classList.add('is-in'); });
                    return;
                }
                const stepIo = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-in');
                            stepIo.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.2 });
                steps.forEach(function (step) { stepIo.observe(step); });
            })();
        })();
    </script>
@endpush
