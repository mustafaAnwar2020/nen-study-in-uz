@extends('site.layouts.app')

@section('body_class', 'nen-landing-body')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('site/home/css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('site/home/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('site/home/css/home.css') }}">
    @if($isRtl ?? is_rtl())
        <link rel="stylesheet" href="{{ asset('site/home/css/nen-rtl.css') }}">
    @endif
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" crossorigin="">
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
            overflow-x: hidden;
            overflow-y: auto;
            max-width: 100%;
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
            z-index: 30;
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
            z-index: 1001;
        }

        /* Hero: clean grid layout (replaces broken absolute canvas) */
        body.nen-landing-body #hero.col-top1 {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(280px, 592px);
            grid-template-areas:
                "nav nav"
                "content image"
                "partners partners";
            gap: 28px 40px;
            padding: 20px 24px 24px;
            min-height: 0;
            overflow: hidden;
        }

        body.nen-landing-body #hero .row-top4,
        body.nen-landing-body #hero > .row-a,
        body.nen-landing-body #hero .row-a {
            display: none !important;
        }

        body.nen-landing-body #hero .nen-hero-header {
            grid-area: nav;
            display: flex;
            align-items: center;
            gap: clamp(20px, 3vw, 40px);
            width: 100%;
            max-width: 100%;
            justify-self: stretch;
            min-width: 0;
        }
        body.nen-landing-body #hero .nen-hero-logo {
            width: auto;
            max-width: clamp(130px, 14vw, 180px);
            height: clamp(56px, 6vw, 76px);
            object-fit: contain;
            object-position: left center;
            flex-shrink: 0;
        }
        body.nen-landing-body #hero .nen-hero-nav {
            flex: 1;
            min-width: 0;
            position: relative !important;
            top: auto !important;
            left: auto !important;
            z-index: 5 !important;
            justify-self: auto;
            width: auto !important;
            max-width: 100%;
        }
        body.nen-landing-body #hero .nen-hero-nav .text-home {
            margin-top: 0;
        }
        body.nen-landing-body #hero .nen-hero-nav a.card5:hover,
        body.nen-landing-body #hero .nen-hero-nav a.card5:hover .card-text-left1 {
            color: #fff;
        }
        body.nen-landing-body #hero .nen-hero-nav a.card5:hover {
            background-color: #017785;
            box-shadow: inset 0 0 1px 0 rgba(235, 235, 235, 0.5), 0 6px 16px rgba(1, 119, 133, 0.35);
        }
        body.nen-landing-body #hero .nen-hero-nav .row3 a:hover {
            color: #017785;
        }
        body.nen-landing-body #hero .row2.nen-hero-nav {
            gap: clamp(16px, 2vw, 28px);
            padding: 12px 18px 12px 20px;
            max-width: none;
            width: 100%;
            justify-content: space-between;
            flex-direction: row !important;
            align-items: center !important;
            flex-wrap: nowrap;
        }
        body.nen-landing-body #hero .nen-hero-nav .row3.nen-nav-links {
            gap: clamp(10px, 1.1vw, 18px);
            flex-wrap: nowrap;
            justify-content: flex-start;
            flex: 1 1 auto;
            min-width: 0;
            padding-right: 0;
        }
        body.nen-landing-body #hero .nen-hero-nav .row3.nen-nav-links a {
            font-size: clamp(12px, 0.92vw, 15px);
            letter-spacing: -0.02em;
            white-space: nowrap;
            flex-shrink: 0;
            margin-left: 0 !important;
        }
        body.nen-landing-body #hero .row-right2 {
            overflow: visible;
            gap: clamp(12px, 1.2vw, 18px) !important;
            flex-shrink: 0;
        }
        body.nen-landing-body #hero .nen-hero-nav .card5 {
            padding: 12px 14px;
            gap: 8px;
            min-width: 0;
            width: auto;
            max-width: none;
            flex-shrink: 0;
        }
        body.nen-landing-body #hero .nen-hero-nav .card-text-left1 {
            font-size: clamp(13px, 0.95vw, 15px);
        }
        body.nen-landing-body #hero .nen-hero-nav .card-lucide-arrow1 {
            width: 18px;
        }

        /* Russian: longer labels — compact nav + room for language switcher and CTA */
        @media (min-width: 769px) {
            html[lang="ru"] body.nen-landing-body #hero .row2.nen-hero-nav {
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                row-gap: 10px;
                column-gap: 14px;
                padding: 12px 16px 12px 20px;
                border-radius: 24px;
            }

            html[lang="ru"] body.nen-landing-body #hero .nen-hero-nav .row3.nen-nav-links {
                flex: 1 1 auto;
                min-width: 0;
                max-width: calc(100% - 220px);
                flex-wrap: wrap;
                justify-content: flex-start;
                gap: 6px 14px;
                row-gap: 6px;
            }

            html[lang="ru"] body.nen-landing-body #hero .nen-hero-nav .row3.nen-nav-links a {
                font-size: clamp(13px, 0.95vw, 15px);
                letter-spacing: -0.01em;
                white-space: nowrap;
            }

            html[lang="ru"] body.nen-landing-body #hero .row-right2 {
                flex: 0 0 auto;
                margin-left: auto;
                gap: 12px !important;
            }

            html[lang="ru"] body.nen-landing-body #hero .nen-hero-nav .card5 {
                width: auto;
                min-width: 0;
                max-width: 180px;
                padding: 12px 14px;
                gap: 8px;
            }

            html[lang="ru"] body.nen-landing-body #hero .nen-hero-nav .card-img2 {
                display: none;
            }

            html[lang="ru"] body.nen-landing-body #hero .nen-hero-nav .card-text-left1 {
                font-size: clamp(12px, 0.9vw, 14px);
                line-height: 1.3;
                white-space: normal;
                text-align: center;
            }

            html[lang="ru"] body.nen-landing-body #hero .nen-hero-nav .card-lucide-arrow1 {
                width: 16px;
                flex-shrink: 0;
            }

            html[lang="ru"] body.nen-landing-body #hero .nen-lang-dropdown__toggle {
                font-size: 14px;
            }
        }

        @media (min-width: 769px) and (max-width: 1280px) {
            html[lang="ru"] body.nen-landing-body #hero .nen-hero-nav .row3.nen-nav-links {
                flex: 1 1 100%;
                max-width: 100%;
                order: 2;
                justify-content: center;
            }

            html[lang="ru"] body.nen-landing-body #hero .row-right2 {
                order: 1;
                width: 100%;
                justify-content: flex-end;
            }
        }

        /* English: spread nav links across the bar — larger type, wider gaps */
        @media (min-width: 769px) {
            html[lang="en"] body.nen-landing-body #hero .nen-hero-nav .row3.nen-nav-links {
                justify-content: space-between;
                gap: clamp(14px, 1.6vw, 28px);
                flex: 1 1 auto;
                min-width: 0;
                padding-inline: clamp(16px, 2vw, 36px);
            }

            html[lang="en"] body.nen-landing-body #hero .nen-hero-nav .row3.nen-nav-links a {
                font-size: clamp(14px, 1.08vw, 17px);
                letter-spacing: -0.02em;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            html[lang="en"] body.nen-landing-body #hero .nen-hero-nav .row3.nen-nav-links a {
                font-size: clamp(13px, 1.15vw, 16px);
            }

            html[lang="en"] body.nen-landing-body #hero .nen-hero-nav .row3.nen-nav-links {
                gap: clamp(10px, 1.3vw, 18px);
                padding-inline: clamp(10px, 1.5vw, 20px);
            }
        }

        /* home.css @container row-top4 stacks .row2 vertically — keep hero nav horizontal */
        @container row-top4 (width < 1028px) {
            body.nen-landing-body #hero .row2.nen-hero-nav {
                flex-direction: row !important;
                align-items: center !important;
                gap: clamp(12px, 2vw, 20px) !important;
                padding: 12px 16px !important;
            }
            body.nen-landing-body #hero .row2.nen-hero-nav > * {
                margin-left: unset !important;
                margin-top: unset !important;
                text-align: unset !important;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            body.nen-landing-body #hero .nen-hero-logo {
                max-width: 120px;
                height: 52px;
            }
            body.nen-landing-body #hero .nen-hero-header {
                gap: 16px;
            }
            html:not([lang="en"]) body.nen-landing-body #hero .nen-hero-nav .row3.nen-nav-links a {
                font-size: 12px;
            }
            html:not([lang="en"]) body.nen-landing-body #hero .nen-hero-nav .row3.nen-nav-links {
                gap: 8px;
            }
        }
        body.nen-landing-body .nen-agencies-group {
            display: flex;
            flex-direction: column;
            gap: 80px;
            width: 100%;
        }

        body.nen-landing-body #hero .row5 {
            grid-area: content;
            position: relative !important;
            z-index: 2 !important;
            margin: 0 !important;
            padding: 8px 0 0 !important;
            align-self: center;
        }

        body.nen-landing-body #hero .col1 {
            position: relative !important;
            top: auto !important;
            left: auto !important;
            z-index: 2 !important;
            width: 100% !important;
            max-width: none !important;
            padding: 0 !important;
        }

        body.nen-landing-body #hero .img1 {
            grid-area: image;
            position: relative !important;
            top: auto !important;
            left: auto !important;
            z-index: 1 !important;
            width: 100% !important;
            max-width: 100% !important;
            align-self: center;
        }

        body.nen-landing-body #hero .row-bottom3 {
            grid-area: partners;
            position: relative !important;
            z-index: 2 !important;
            padding: 18px 0 0 !important;
            margin: 0 !important;
            border-top: 1px solid rgba(0, 0, 0, 0.07);
        }

        body.nen-landing-body #hero .nen-hero-title {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
            white-space: normal !important;
            line-height: 1.02 !important;
            letter-spacing: -2px !important;
            color: inherit !important;
            font-size: inherit !important;
        }

        body.nen-landing-body #hero .nen-hero-title__study,
        body.nen-landing-body #hero .nen-hero-title__country {
            display: block;
            font-size: clamp(44px, 5.2vw, 72px) !important;
            font-weight: 700;
            line-height: 1.02;
        }

        body.nen-landing-body #hero .nen-hero-title__study {
            color: var(--text-title);
        }

        body.nen-landing-body #hero .nen-hero-title__country {
            color: var(--brand-brand-main);
        }

        body.nen-landing-body #hero .nen-lang-dropdown__toggle {
            font-size: clamp(14px, 1vw, 16px);
            gap: 6px;
            flex-shrink: 0;
        }

        @media (min-width: 769px) and (max-width: 1100px) {
            body.nen-landing-body #hero.col-top1 {
                grid-template-columns: 1fr;
                grid-template-areas:
                    "nav"
                    "content"
                    "image"
                    "partners";
                gap: 20px;
            }
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

        /* Prevent hero title from wrapping — matches home.html visual (desktop only) */
        body.nen-landing-body .subtitle1:not(.nen-hero-title) {
            white-space: nowrap;
            font-size: clamp(38px, 4.5vw, 65px) !important;
        }

        /* home.css sets line-height:0.7 which makes multi-line headings overlap */
        body.nen-landing-body .column-subtitle1 {
            line-height: 1.12 !important;
        }
        body.nen-landing-body .subtitle-we-re-not-just-about {
            line-height: 1.12 !important;
        }

        /* Readable Arabic / multi-line body copy */
        body.nen-landing-body .card-text1,
        body.nen-landing-body .card-text4,
        body.nen-landing-body .text,
        body.nen-landing-body .faq-answer {
            line-height: 1.65;
        }
        body.nen-landing-body .card-subtitle2 {
            line-height: 1.15 !important;
        }
        body.nen-landing-body .row-c,
        body.nen-landing-body .row-text2 {
            line-height: 1.35;
        }
        body.nen-landing-body .row-text2 {
            text-align: start;
        }
        body.nen-landing-body .faq-answer {
            text-align: start;
        }

        /* Mobile nav toggle (hidden on desktop) */
        body.nen-landing-body .nen-nav-toggle {
            display: none;
        }

        /* ── FAQ section ── */
        body.nen-landing-body #faq .row20.nen-faq-grid {
            display: flex !important;
            flex-direction: column;
            gap: 24px;
            align-items: stretch !important;
            align-self: stretch;
            width: 100%;
        }

        body.nen-landing-body #faq .nen-faq-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 24px;
            align-items: start;
            width: 100%;
        }

        body.nen-landing-body #faq .nen-faq-item {
            display: flex;
            flex-direction: column;
            min-width: 0;
            height: auto;
            overflow: visible;
        }

        body.nen-landing-body #faq .nen-faq-item .faq-btn-d {
            flex: 0 0 auto;
            width: 100%;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            min-height: 96px;
            padding: 22px 28px;
            text-align: start;
            background: #fff;
        }

        body.nen-landing-body #faq .nen-faq-item .faq-answer {
            flex: 0 0 auto;
            width: 100%;
            box-sizing: border-box;
        }

        body.nen-landing-body #faq .faq-btn-d .btn-label {
            flex: 1;
            min-width: 0;
            margin: 0;
            line-height: 1.45;
        }

        body.nen-landing-body #faq .faq-btn-d .btn-icon-add {
            flex-shrink: 0;
            align-self: center;
        }

        @container col19 (width < 900px) {
            body.nen-landing-body #faq .nen-faq-row {
                grid-template-columns: 1fr;
                gap: 12px;
            }
        }

        body.nen-landing-body #faq .faq-btn-d {
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        body.nen-landing-body #faq .faq-btn-d.active {
            background-color: var(--neutrals-neutrals-2);
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            border-bottom-color: transparent;
        }

        /* Rotate the + icon to an x when its item is open */
        body.nen-landing-body #faq .faq-btn-d.active .btn-icon-add {
            transform: rotate(45deg);
            transition: transform 0.2s ease;
        }

        body.nen-landing-body #faq .btn-icon-add {
            transition: transform 0.2s ease;
        }

        body.nen-landing-body .faq-answer {
            display: none;
            text-align: start;
            padding: 18px 28px 22px;
            margin: 0;
            font-size: 14.83px;
            line-height: 1.7;
            font-weight: 400;
            color: #3e3c36;
            border: 0.2px solid #8e8e8e;
            border-top: none;
            border-radius: 0 0 16px 16px;
            background: var(--neutrals-neutrals-2, #f5f5f5);
            overflow: visible;
        }

        body.nen-landing-body .faq-answer.open {
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
            width: 100% !important;
        }

        body.nen-landing-body .nen-scroll-wrap .frame-c {
            gap: 14px;
            padding: 10px 12px 10px 10px;
            align-items: stretch;
        }

        body.nen-landing-body .nen-scroll-wrap .frame-c .frame-col {
            flex: 1;
            min-width: 0;
            gap: 16px;
        }

        body.nen-landing-body .nen-scroll-wrap .frame-c .frame-col-top {
            width: auto;
            flex: 1;
            min-width: 0;
        }

        body.nen-landing-body .nen-scroll-wrap .frame-c .frame-img3 {
            border-radius: 8px;
            object-fit: cover;
            align-self: stretch;
            height: auto;
            max-height: 154px;
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

        /* ── Agency cards RTL ── */
        html[dir="rtl"] body.nen-landing-body #study-agencies .nen-scroll-wrap .row19,
        html[dir="rtl"] body.nen-landing-body #translation-agencies .nen-scroll-wrap .row15 {
            direction: rtl;
        }

        html[dir="rtl"] body.nen-landing-body #study-agencies .nen-scroll-wrap .card-c {
            align-items: flex-start;
            text-align: right;
            padding: 18px 16px !important;
        }

        html[dir="rtl"] body.nen-landing-body #study-agencies .nen-scroll-wrap .card-col-bottom,
        html[dir="rtl"] body.nen-landing-body #study-agencies .nen-scroll-wrap .card-col {
            align-items: flex-start;
            align-self: stretch;
            width: 100%;
            margin-left: 0;
            margin-right: 0;
            gap: 12px;
        }

        html[dir="rtl"] body.nen-landing-body #study-agencies .nen-scroll-wrap .card-text3 {
            text-align: right;
            width: 100%;
        }

        html[dir="rtl"] body.nen-landing-body .nen-agency-contact {
            display: flex !important;
            flex-direction: row !important;
            direction: rtl !important;
            justify-content: flex-start !important;
            align-items: center !important;
            align-self: stretch !important;
            width: 100% !important;
            gap: 8px !important;
        }

        html[dir="rtl"] body.nen-landing-body .nen-agency-contact .row-text3 {
            text-align: right !important;
            margin: 0 !important;
        }

        html[dir="rtl"] body.nen-landing-body .nen-agency-contact--phone .row-text3 {
            direction: ltr !important;
            unicode-bidi: embed !important;
            text-align: right !important;
        }

        /* Translation cards: keep image on the left, right-align text block */
        html[dir="rtl"] body.nen-landing-body #translation-agencies .nen-scroll-wrap .frame-c {
            direction: ltr;
            text-align: right;
        }

        html[dir="rtl"] body.nen-landing-body #translation-agencies .nen-scroll-wrap .frame-col {
            direction: rtl;
            align-items: flex-start;
            text-align: right;
        }

        html[dir="rtl"] body.nen-landing-body #translation-agencies .nen-scroll-wrap .frame-col-top,
        html[dir="rtl"] body.nen-landing-body #translation-agencies .nen-scroll-wrap .frame-col-bottom {
            width: 100%;
            align-items: flex-start;
            align-self: stretch;
        }

        html[dir="rtl"] body.nen-landing-body #translation-agencies .nen-scroll-wrap .frame-col-top {
            gap: 8px;
        }

        html[dir="rtl"] body.nen-landing-body #translation-agencies .nen-scroll-wrap .frame-col-bottom {
            gap: 10px;
            width: 100% !important;
            max-width: none !important;
            align-items: flex-start !important;
            align-self: stretch !important;
        }

        html[dir="rtl"] body.nen-landing-body #translation-agencies .nen-scroll-wrap .frame-text3,
        html[dir="rtl"] body.nen-landing-body #translation-agencies .nen-scroll-wrap .frame-text4 {
            text-align: right;
            width: 100%;
        }

        html[dir="rtl"] body.nen-landing-body #study-agencies .row-top9 .row-col2,
        html[dir="rtl"] body.nen-landing-body #translation-agencies .row-top8 .row-col2 {
            text-align: right;
            align-items: flex-start;
        }

        html[dir="rtl"] body.nen-landing-body #documents .col-top4 .column-subtitle3,
        html[dir="rtl"] body.nen-landing-body #documents .col-top4 .column-text-bottom,
        html[dir="rtl"] body.nen-landing-body #trusted-agencies .row-subtitle,
        html[dir="rtl"] body.nen-landing-body #trusted-agencies .row-text-bottom,
        html[dir="rtl"] body.nen-landing-body #translation-agencies .row-subtitle,
        html[dir="rtl"] body.nen-landing-body #translation-agencies .row-text-bottom {
            white-space: nowrap;
            max-width: none;
            width: auto;
        }

        html[dir="rtl"] body.nen-landing-body #translation-agencies .row-top8 .row-text-bottom,
        html[dir="rtl"] body.nen-landing-body #trusted-agencies .row-text-bottom,
        html[dir="rtl"] body.nen-landing-body #documents .col-top4 .column-text-bottom {
            font-size: clamp(13px, 1.05vw, 15px);
        }

        @container group-bottom1 (width < 1429px) {
            html[dir="rtl"] body.nen-landing-body .nen-scroll-wrap .row15 > * {
                text-align: right !important;
            }
        }

        @container group5 (width < 1383px) {
            html[dir="rtl"] body.nen-landing-body .nen-scroll-wrap .row19 > * {
                text-align: right !important;
            }
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

    /* ── Documents & FAQ: centered section titles ── */
    body.nen-landing-body #documents .col-top4,
    body.nen-landing-body #faq .col-top5 {
        width: auto;
        max-width: none;
        margin-left: auto !important;
        margin-right: auto !important;
        align-self: center;
        align-items: center;
        text-align: center;
    }

    body.nen-landing-body #faq .col-top5 {
        width: 100%;
        max-width: 644px;
    }

    body.nen-landing-body #documents .col15 {
        width: 100%;
        align-self: stretch;
    }

    body.nen-landing-body #documents .col-top4 .column-subtitle3,
    body.nen-landing-body #documents .col-top4 .column-text-bottom {
        width: auto;
        max-width: none;
        text-align: center;
        white-space: nowrap;
    }

    body.nen-landing-body #faq .col-top5 .column-subtitle3,
    body.nen-landing-body #faq .col-top5 .column-text-bottom {
        width: 100%;
        text-align: center;
    }

    body.nen-landing-body #documents .col-top4 .column-text-bottom {
        font-size: clamp(13px, 1.05vw, 16px);
    }

    /* Agency section headers: title + subtitle each on one line */
    body.nen-landing-body #trusted-agencies .row-top9 .row-col2,
    body.nen-landing-body #translation-agencies .row-top8 .row-col2 {
        width: auto;
        max-width: none;
    }

    body.nen-landing-body #trusted-agencies .row-subtitle,
    body.nen-landing-body #translation-agencies .row-subtitle,
    body.nen-landing-body #trusted-agencies .row-text-bottom,
    body.nen-landing-body #translation-agencies .row-text-bottom {
        white-space: nowrap;
        max-width: none;
        width: auto;
    }

    body.nen-landing-body #trusted-agencies .row-text-bottom,
    body.nen-landing-body #translation-agencies .row-text-bottom {
        font-size: clamp(13px, 1.05vw, 16px);
    }

    html[dir="rtl"] body.nen-landing-body #documents .col-top4,
    html[dir="rtl"] body.nen-landing-body #faq .col-top5,
    html[dir="rtl"] body.nen-landing-body #documents .col-top4 .column-subtitle3,
    html[dir="rtl"] body.nen-landing-body #documents .col-top4 .column-text-bottom,
    html[dir="rtl"] body.nen-landing-body #faq .col-top5 .column-subtitle3,
    html[dir="rtl"] body.nen-landing-body #faq .col-top5 .column-text-bottom {
        text-align: center;
        align-items: center;
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

    /* ── How It Works: numbered journey cards with drawer reveal ── */
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
        outline: none;
        cursor: pointer;
    }
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
    body.nen-landing-body .nen-step__card {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
        min-height: 300px;
        height: 100%;
        padding: 28px 30px 56px;
        border-radius: 16px;
        background: #fff;
        border: 1px solid #e6e6e6;
        overflow: hidden;
        transition: border-color 0.35s ease, box-shadow 0.35s ease, transform 0.35s ease;
    }
    body.nen-landing-body .nen-step__accent {
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 0;
        background: linear-gradient(180deg, #243b37 0%, #017785 100%);
        border-radius: 0 0 4px 4px;
        transition: height 0.45s cubic-bezier(0.22, 0.61, 0.36, 1);
    }
    body.nen-landing-body .nen-step.is-open .nen-step__card,
    body.nen-landing-body .nen-step:focus-visible .nen-step__card {
        border-color: #017785;
        box-shadow: 0 16px 36px rgba(1, 119, 133, 0.18);
        transform: translateY(-4px);
    }
    body.nen-landing-body .nen-step.is-open .nen-step__accent,
    body.nen-landing-body .nen-step:focus-visible .nen-step__accent {
        height: 100%;
    }
    @media (hover: hover) {
        body.nen-landing-body .nen-step:hover .nen-step__card {
            border-color: #017785;
            box-shadow: 0 16px 36px rgba(1, 119, 133, 0.18);
            transform: translateY(-4px);
        }
        body.nen-landing-body .nen-step:hover .nen-step__accent {
            height: 100%;
        }
    }
    body.nen-landing-body .nen-step__num {
        margin: 0 0 18px;
        font-size: 52px;
        font-weight: 800;
        line-height: 1;
        letter-spacing: -1px;
        color: #e7eae9;
        transition: color 0.35s ease, transform 0.35s ease;
    }
    body.nen-landing-body .nen-step.is-open .nen-step__num,
    body.nen-landing-body .nen-step:focus-visible .nen-step__num {
        color: #d4e8ea;
        transform: scale(1.04);
    }
    @media (hover: hover) {
        body.nen-landing-body .nen-step:hover .nen-step__num {
            color: #d4e8ea;
            transform: scale(1.04);
        }
    }
    body.nen-landing-body .nen-step__head {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
        position: relative;
        z-index: 2;
        transition: transform 0.4s ease, opacity 0.35s ease;
    }
    body.nen-landing-body .nen-step.is-open .nen-step__head,
    body.nen-landing-body .nen-step:focus-visible .nen-step__head {
        transform: translateY(-6px);
        opacity: 0.92;
    }
    @media (hover: hover) {
        body.nen-landing-body .nen-step:hover .nen-step__head {
            transform: translateY(-6px);
            opacity: 0.92;
        }
    }
    body.nen-landing-body .nen-step__icon {
        width: 72px;
        height: 72px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f3f2;
        border-radius: 16px;
        flex-shrink: 0;
        color: #017785;
        transition: background 0.35s ease, color 0.35s ease;
    }
    body.nen-landing-body .nen-step.is-open .nen-step__icon,
    body.nen-landing-body .nen-step:focus-visible .nen-step__icon {
        background: rgba(1, 119, 133, 0.12);
    }
    @media (hover: hover) {
        body.nen-landing-body .nen-step:hover .nen-step__icon {
            background: rgba(1, 119, 133, 0.12);
        }
    }
    body.nen-landing-body .nen-step__icon img,
    body.nen-landing-body .nen-step__icon .nen-step__svg {
        width: 44px;
        height: 44px;
        object-fit: contain;
        flex-shrink: 0;
    }
    body.nen-landing-body .nen-step__title {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        line-height: 1.25;
        color: #1c1c1c;
    }
    body.nen-landing-body .nen-step__hint {
        margin: 10px 0 0;
        font-size: 13px;
        line-height: 1.4;
        color: #6b7a76;
        position: relative;
        z-index: 2;
        transition: opacity 0.3s ease;
    }
    body.nen-landing-body .nen-step.is-open .nen-step__hint,
    body.nen-landing-body .nen-step:focus-visible .nen-step__hint {
        opacity: 0;
    }
    @media (hover: hover) {
        body.nen-landing-body .nen-step:hover .nen-step__hint {
            opacity: 0;
        }
    }
    body.nen-landing-body .nen-step__drawer {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1;
        display: flex;
        align-items: flex-end;
        padding: 0 30px;
        max-height: 0;
        background: linear-gradient(145deg, #243b37 0%, #017785 100%);
        transition: max-height 0.5s cubic-bezier(0.22, 0.61, 0.36, 1), padding 0.5s cubic-bezier(0.22, 0.61, 0.36, 1);
    }
    body.nen-landing-body .nen-step.is-open .nen-step__drawer,
    body.nen-landing-body .nen-step:focus-visible .nen-step__drawer {
        max-height: 58%;
        padding: 28px 30px 30px;
    }
    @media (hover: hover) {
        body.nen-landing-body .nen-step:hover .nen-step__drawer {
            max-height: 58%;
            padding: 28px 30px 30px;
        }
    }
    body.nen-landing-body .nen-step__desc {
        margin: 0;
        font-size: 15px;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.94);
        opacity: 0;
        transform: translateY(16px);
        transition: opacity 0.35s ease 0.08s, transform 0.4s ease 0.08s;
    }
    body.nen-landing-body .nen-step.is-open .nen-step__desc,
    body.nen-landing-body .nen-step:focus-visible .nen-step__desc {
        opacity: 1;
        transform: none;
    }
    @media (hover: hover) {
        body.nen-landing-body .nen-step:hover .nen-step__desc {
            opacity: 1;
            transform: none;
        }
    }
    body.nen-landing-body .nen-step__chev {
        position: absolute;
        right: 20px;
        bottom: 18px;
        z-index: 3;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f1f3f2;
        color: #6b7a76;
        transition: transform 0.35s ease, background 0.35s ease, color 0.35s ease;
    }
    body.nen-landing-body .nen-step__chev::before {
        content: "";
        position: absolute;
        top: 11px;
        left: 50%;
        width: 8px;
        height: 8px;
        margin-left: -4px;
        border-right: 2px solid currentColor;
        border-bottom: 2px solid currentColor;
        transform: rotate(45deg);
        transition: transform 0.35s ease;
    }
    body.nen-landing-body .nen-step.is-open .nen-step__chev,
    body.nen-landing-body .nen-step:focus-visible .nen-step__chev {
        background: #243b37;
        color: #fff;
    }
    body.nen-landing-body .nen-step.is-open .nen-step__chev::before,
    body.nen-landing-body .nen-step:focus-visible .nen-step__chev::before {
        transform: rotate(-135deg);
        top: 13px;
    }
    @media (hover: hover) {
        body.nen-landing-body .nen-step:hover .nen-step__chev {
            background: #243b37;
            color: #fff;
        }
        body.nen-landing-body .nen-step:hover .nen-step__chev::before {
            transform: rotate(-135deg);
            top: 13px;
        }
    }
    @media (max-width: 820px) {
        body.nen-landing-body .nen-steps-row {
            flex-direction: column;
        }
        body.nen-landing-body .nen-step__icon {
            width: 64px;
            height: 64px;
            border-radius: 14px;
        }
        body.nen-landing-body .nen-step__icon img,
        body.nen-landing-body .nen-step__icon .nen-step__svg {
            width: 40px;
            height: 40px;
        }
    }
    @media (prefers-reduced-motion: reduce) {
        body.nen-landing-body .nen-steps.nen-anim-ready .nen-step {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }
        body.nen-landing-body .nen-step__card,
        body.nen-landing-body .nen-step__drawer,
        body.nen-landing-body .nen-step__desc,
        body.nen-landing-body .nen-step__accent,
        body.nen-landing-body .nen-step__chev {
            transition: none !important;
        }
    }
    /* CTA buttons: equal height, single-line labels */
    body.nen-landing-body #about .row-bottom4 {
        align-items: stretch;
        flex-wrap: wrap;
    }
    body.nen-landing-body #about .row-bottom4 .frame-b {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: auto;
        min-width: 175px;
        white-space: nowrap;
    }
    body.nen-landing-body #about .row-bottom4 .frame-b p {
        margin: 0;
        white-space: nowrap;
    }
    /* CTA pills: override main.css red link hover */
    body.nen-landing-body a.frame-a:hover,
    body.nen-landing-body a.frame-a:hover p,
    body.nen-landing-body a.frame-b.frame-left:hover,
    body.nen-landing-body a.frame-b.frame-left:hover p {
        color: #fff;
    }
    body.nen-landing-body a.frame-a:hover,
    body.nen-landing-body a.frame-b.frame-left:hover {
        background-color: #017785;
        box-shadow: inset 0 0 7px 0 #ebebeb, 0 12px 28px -11px rgba(1, 119, 133, 0.35);
    }
    body.nen-landing-body a.frame-b.frame-right1:hover,
    body.nen-landing-body a.frame-b.frame-right1:hover p {
        color: #017785;
    }
    body.nen-landing-body a.frame-b.frame-right1:hover {
        background-color: #d4ecef;
    }

    /* ── Why Uzbekistan: compact 2×2 grid aligned to image height (desktop) ── */
    @media (min-width: 769px) {
        body.nen-landing-body #why-uzbekistan .container {
            align-items: stretch;
            gap: 16px;
            min-height: 552px;
            max-height: 580px;
        }
        body.nen-landing-body #why-uzbekistan .container-container1 {
            width: auto !important;
            flex: 1 1 0;
            min-width: 0;
            max-width: 58%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 16px;
            overflow: visible;
        }
        body.nen-landing-body #why-uzbekistan .container-row-top,
        body.nen-landing-body #why-uzbekistan .container-container2,
        body.nen-landing-body #why-uzbekistan .container-row {
            display: contents;
        }
        body.nen-landing-body #why-uzbekistan .card6,
        body.nen-landing-body #why-uzbekistan .card-a {
            min-height: 0 !important;
            height: 100%;
            gap: 16px;
            padding: 22px 24px !important;
            justify-content: flex-start;
            align-items: flex-start !important;
            text-align: start;
        }
        body.nen-landing-body #why-uzbekistan .card-container3,
        body.nen-landing-body #why-uzbekistan .card-container1 {
            padding-top: 6px !important;
            gap: 8px;
            max-width: none;
            width: 100%;
            align-items: flex-start !important;
            text-align: start;
        }
        body.nen-landing-body #why-uzbekistan .card-subtitle2,
        body.nen-landing-body #why-uzbekistan .card-container2 h2 {
            font-size: 36px;
            line-height: 1;
            text-align: start;
        }
        body.nen-landing-body #why-uzbekistan .card-text4,
        body.nen-landing-body #why-uzbekistan .card-text1 {
            font-size: 13px;
            line-height: 1.38;
            text-align: start;
        }
        body.nen-landing-body #why-uzbekistan .row-top5,
        body.nen-landing-body #why-uzbekistan .card7 .row-top1,
        body.nen-landing-body #why-uzbekistan .card8 .row-top1,
        body.nen-landing-body #why-uzbekistan .card9 .row-top1 {
            margin: 0;
            width: 100%;
        }
        body.nen-landing-body #why-uzbekistan .container-frame-right {
            flex: 0 0 calc(42% - 8px);
            width: calc(42% - 8px) !important;
            max-width: none;
            margin-bottom: 0;
            padding: 22px 24px !important;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: flex-end;
            align-self: stretch;
            min-height: 0;
            background: linear-gradient(172deg, rgba(255, 255, 255, 0) 31%, rgba(255, 255, 255, 0.88) 107%) bottom left / auto auto no-repeat,
                url('{{ asset('site/home/assets/container-frame.png') }}') center / cover no-repeat;
        }
    }

    /* ── Hero partner strip ── */
    body.nen-landing-body #hero .row12 {
        position: relative !important;
        top: auto !important;
        left: auto !important;
        width: 100% !important;
        max-width: none !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
    }
    body.nen-landing-body .nen-hero-partners {
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
        flex: 1 1 auto;
    }
    body.nen-landing-body .nen-hero-partner {
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    body.nen-landing-body .nen-hero-partner .row-img1 {
        width: 55px;
        height: auto;
        object-fit: contain;
        flex-shrink: 0;
    }
    body.nen-landing-body .nen-hero-divider {
        height: 67px;
        border-left: 0.5px solid #9e9e9e;
    }
    body.nen-landing-body #hero .row12 .col-right1 {
        margin-left: auto;
        flex-shrink: 0;
        width: auto;
        max-width: none;
        align-items: flex-end;
    }
    body.nen-landing-body #hero .row12 .img2 {
        width: 188px;
        max-width: min(188px, 38vw);
        height: auto;
        object-fit: contain;
        flex-shrink: 0;
    }

    /* ── Footer (redesigned) ── */
    body.nen-landing-body .nen-foot {
        background: #fff;
        color: #232323;
        text-align: left;
        letter-spacing: normal;
        border-top: 1px solid #ececec;
        max-width: 100%;
        overflow-x: hidden;
    }
    body.nen-landing-body .nen-foot__top {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1.2fr;
        gap: 56px;
        max-width: 1240px;
        margin: 0 auto;
        padding: 64px 40px 56px;
    }
    body.nen-landing-body .nen-foot__brand,
    body.nen-landing-body .nen-foot__col {
        min-width: 0;
    }
    body.nen-landing-body .nen-foot__logo {
        width: auto;
        max-width: 140px;
        height: 64px;
        object-fit: contain;
        object-position: left center;
        margin-bottom: 18px;
    }
    body.nen-landing-body .nen-foot__tagline {
        margin: 0 0 22px;
        max-width: 420px;
        font-size: 15px;
        line-height: 1.65;
        color: #6b7a76;
    }
    body.nen-landing-body .nen-foot__socials {
        display: flex;
        gap: 10px;
    }
    body.nen-landing-body .nen-foot__social {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e2e2;
        border-radius: 50%;
        background: #fff;
        transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }
    body.nen-landing-body .nen-foot__social img {
        width: 18px;
        height: 18px;
        object-fit: contain;
        transition: filter 0.2s ease;
    }
    body.nen-landing-body .nen-foot__social:hover {
        transform: translateY(-3px);
    }
    body.nen-landing-body .nen-foot__social--facebook:hover {
        background: #1877f2;
        border-color: #1877f2;
        box-shadow: 0 10px 20px rgba(24, 119, 242, 0.35);
    }
    body.nen-landing-body .nen-foot__social--instagram:hover {
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        border-color: #dc2743;
        box-shadow: 0 10px 20px rgba(220, 39, 67, 0.35);
    }
    body.nen-landing-body .nen-foot__social--whatsapp:hover {
        background: #25d366;
        border-color: #25d366;
        box-shadow: 0 10px 20px rgba(37, 211, 102, 0.35);
    }
    body.nen-landing-body .nen-foot__social--linkedin:hover {
        background: #0a66c2;
        border-color: #0a66c2;
        box-shadow: 0 10px 20px rgba(10, 102, 194, 0.35);
    }
    body.nen-landing-body .nen-foot__social--youtube:hover {
        background: #ff0000;
        border-color: #ff0000;
        box-shadow: 0 10px 20px rgba(255, 0, 0, 0.3);
    }
    body.nen-landing-body .nen-foot__social--facebook:hover img,
    body.nen-landing-body .nen-foot__social--instagram:hover img,
    body.nen-landing-body .nen-foot__social--whatsapp:hover img,
    body.nen-landing-body .nen-foot__social--linkedin:hover img,
    body.nen-landing-body .nen-foot__social--youtube:hover img {
        filter: brightness(0) invert(1);
    }
    body.nen-landing-body .nen-foot__heading {
        margin: 0 0 20px;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        color: #017785;
    }
    body.nen-landing-body .nen-foot__links,
    body.nen-landing-body .nen-foot__contacts {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    body.nen-landing-body .nen-foot__links a {
        color: #5b5b5b;
        font-size: 15px;
        line-height: 1.4;
        transition: color 0.2s ease, padding-left 0.2s ease;
    }
    body.nen-landing-body .nen-foot__links a:hover {
        color: #017785;
        padding-left: 5px;
    }
    body.nen-landing-body .nen-foot__contact {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 15px;
        color: #5b5b5b;
    }
    body.nen-landing-body .nen-foot__contact a {
        color: #5b5b5b;
        transition: color 0.2s ease;
        min-width: 0;
        overflow-wrap: anywhere;
    }
    body.nen-landing-body .nen-foot__contact a:hover {
        color: #017785;
    }
    body.nen-landing-body .nen-foot__cicon {
        width: 18px;
        height: 18px;
        object-fit: contain;
        flex-shrink: 0;
    }
    body.nen-landing-body .nen-foot__lang {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 700;
        color: #017785;
        background: #e6f1f3;
        border-radius: 8px;
        padding: 4px 9px;
        flex-shrink: 0;
        line-height: 1;
    }
    body.nen-landing-body .nen-foot__lang .bi-headset {
        font-size: 14px;
        line-height: 1;
    }
    body.nen-landing-body .nen-foot__lang-text {
        letter-spacing: 0.3px;
    }
    body.nen-landing-body .nen-foot__contact--phone {
        flex-wrap: wrap;
        gap: 8px;
        max-width: 100%;
    }
    body.nen-landing-body .nen-foot__chat {
        display: inline-flex;
        gap: 6px;
        flex-shrink: 0;
    }
    body.nen-landing-body .nen-foot__chat a {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f1f3f2;
        transition: transform 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
    }
    body.nen-landing-body .nen-foot__chat a:hover {
        transform: scale(1.12);
    }
    body.nen-landing-body .nen-foot__chat a.nen-foot__chat-link--whatsapp:hover {
        background: #25d366;
        box-shadow: 0 6px 14px rgba(37, 211, 102, 0.35);
    }
    body.nen-landing-body .nen-foot__chat a.nen-foot__chat-link--telegram {
        background: #e8f4fc;
    }
    body.nen-landing-body .nen-foot__chat a.nen-foot__chat-link--telegram img {
        filter: brightness(0) saturate(100%) invert(48%) sepia(79%) saturate(2476%) hue-rotate(176deg) brightness(96%) contrast(92%);
    }
    body.nen-landing-body .nen-foot__chat a.nen-foot__chat-link--telegram:hover {
        background: #24a1de;
        box-shadow: 0 6px 14px rgba(36, 161, 222, 0.35);
    }
    body.nen-landing-body .nen-foot__chat a.nen-foot__chat-link--whatsapp:hover img,
    body.nen-landing-body .nen-foot__chat a.nen-foot__chat-link--telegram:hover img {
        filter: brightness(0) invert(1);
    }
    body.nen-landing-body .nen-foot__chat img {
        width: 16px;
        height: 16px;
        object-fit: contain;
    }
    /* Big brand CTA line */
    body.nen-landing-body .nen-foot__cta {
        border-top: 1px solid #ececec;
        background: #fff;
        text-align: center;
        padding: 20px 32px 16px;
        overflow-x: hidden;
        max-width: 100%;
    }
    body.nen-landing-body .nen-foot__cta-title {
        margin: 0 auto;
        color: #111;
        font-weight: 800;
        text-transform: none;
        font-size: clamp(28px, 4vw, 56px);
        line-height: 1.2;
        letter-spacing: -0.03em;
        max-width: min(100%, 1100px);
        overflow-wrap: break-word;
        word-break: break-word;
    }
    html[dir="rtl"] body.nen-landing-body .nen-foot__cta-title {
        text-transform: none;
        letter-spacing: 0;
        line-height: 1.35;
        font-size: clamp(26px, 3.6vw, 50px);
        word-spacing: 0.02em;
    }
    body.nen-landing-body .nen-foot__cta-title span {
        color: #017785;
    }
    /* Bottom bar */
    body.nen-landing-body .nen-foot__bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        max-width: 1240px;
        margin: 0 auto;
        padding: 26px 40px;
        border-top: 1px solid #ececec;
        font-size: 14px;
        color: #6b7a76;
    }
    body.nen-landing-body .nen-foot__copy {
        margin: 0;
    }
    body.nen-landing-body .nen-foot__bottom-links {
        display: flex;
        gap: 22px;
    }
    body.nen-landing-body .nen-foot__bottom-links a {
        color: #6b7a76;
        transition: color 0.2s ease;
    }
    body.nen-landing-body .nen-foot__bottom-links a:hover {
        color: #017785;
    }
    @media (max-width: 900px) {
        body.nen-landing-body .nen-foot__top {
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }
        body.nen-landing-body .nen-foot__brand {
            grid-column: 1 / -1;
        }
    }
    @media (max-width: 600px) {
        body.nen-landing-body .nen-foot__top {
            grid-template-columns: 1fr 1fr;
            gap: 24px 16px;
            padding: 24px 18px 20px;
        }
        body.nen-landing-body .nen-foot__brand {
            grid-column: 1 / -1;
        }
        body.nen-landing-body .nen-foot__tagline {
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 14px;
        }
        body.nen-landing-body .nen-foot__heading {
            margin-bottom: 10px;
            font-size: 11px;
        }
        body.nen-landing-body .nen-foot__links,
        body.nen-landing-body .nen-foot__contacts {
            gap: 10px;
        }
        body.nen-landing-body .nen-foot__links a,
        body.nen-landing-body .nen-foot__contact {
            font-size: 13px;
        }
        body.nen-landing-body .nen-foot__bottom {
            padding: 16px 18px;
            justify-content: center;
            text-align: center;
        }
    }

    /* ============================================================
       MOBILE RESPONSIVE FIXES
       The home.css hero is a fixed desktop "canvas": the nav, hero
       text, image and partner strip are all position:absolute, while
       only decorative circle rows sit in the flow. That overflows and
       overlaps on small screens. Below we convert the hero into a
       normal vertical stack and stop horizontal scrolling.
       ============================================================ */
    @media (max-width: 768px) {
        html,
        body.nen-landing-body {
            overflow-x: hidden;
            max-width: 100%;
        }
        body.nen-landing-body {
            gap: 48px;
            padding-top: 12px;
        }
        body.nen-landing-body img {
            max-width: 100%;
            height: auto;
        }
        /* Leaflet tiles/markers break when global img rules apply (mobile map stays blank) */
        body.nen-landing-body .leaflet-container img.leaflet-tile,
        body.nen-landing-body .leaflet-container img.leaflet-marker-icon,
        body.nen-landing-body .leaflet-container img.leaflet-marker-shadow,
        body.nen-landing-body .leaflet-container img.leaflet-image-layer {
            max-width: none !important;
            width: auto;
            height: auto;
        }

        /* Decorative dot rows break the mobile layout — hide them */
        body.nen-landing-body #hero .row-a {
            display: none !important;
        }

        /* Hero wrapper → vertical stack (text then image, like design intent) */
        body.nen-landing-body .col-top1 {
            display: flex;
            flex-direction: column;
            max-width: 100%;
            padding: 12px 14px 20px;
            gap: 16px;
            border-radius: 20px;
        }
        body.nen-landing-body #hero.col-top1 {
            display: flex;
            flex-direction: column;
        }
        body.nen-landing-body .col-top1 > .row-top4 { order: 0; display: none !important; }
        body.nen-landing-body .col-top1 > .nen-hero-header { order: 1; }
        body.nen-landing-body .col-top1 > .row5 { order: 2; }
        body.nen-landing-body .col-top1 > .row9,
        body.nen-landing-body .col-top1 > .row10 { order: 0; display: none !important; }
        body.nen-landing-body .col-top1 > .img1 { order: 3; }
        body.nen-landing-body .col-top1 > .row-bottom3 { order: 4; }

        body.nen-landing-body #hero .img1 {
            position: static !important;
            top: auto !important;
            left: auto !important;
            z-index: auto !important;
            width: 100% !important;
            max-width: 100% !important;
            max-height: 220px;
            object-fit: cover;
            object-position: center top;
            margin: 0 !important;
            border-radius: 16px;
        }

        /* Nav: logo outside pill + compact bar + hamburger */
        body.nen-landing-body #hero .nen-hero-header {
            align-items: center;
            gap: 12px;
        }
        body.nen-landing-body #hero .nen-hero-logo {
            max-width: 120px;
            height: 52px;
        }
        body.nen-landing-body #hero .row-top4 {
            position: static !important;
            padding-top: 0 !important;
        }
        body.nen-landing-body #hero .row2,
        body.nen-landing-body #hero .nen-hero-nav {
            position: relative !important;
            top: auto !important;
            left: auto !important;
            z-index: 30 !important;
            flex: 1;
            min-width: 0;
            width: auto !important;
            display: grid !important;
            grid-template-columns: minmax(0, 1fr) auto;
            grid-template-rows: auto auto;
            align-items: center;
            gap: 0 10px;
            box-shadow: -4px 4px 20px rgba(0, 0, 0, 0.08) !important;
            background: #fff !important;
            padding: 10px 12px !important;
            border-radius: 24px;
            overflow: visible;
        }
        body.nen-landing-body #hero .row5,
        body.nen-landing-body #hero .row9,
        body.nen-landing-body #hero .row10,
        body.nen-landing-body #hero .row-bottom3 {
            z-index: auto !important;
        }
        body.nen-landing-body #hero .col1 {
            z-index: auto !important;
        }
        body.nen-landing-body .nen-nav-toggle {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 5px;
            grid-column: 2;
            grid-row: 1;
            width: 36px;
            height: 36px;
            padding: 6px;
            margin-left: auto;
            background: none;
            border: 0;
            cursor: pointer;
        }
        body.nen-landing-body .nen-nav-toggle__bar {
            display: block;
            width: 100%;
            height: 2px;
            background: #111;
            border-radius: 2px;
            transition: transform 0.25s ease, opacity 0.25s ease;
        }
        body.nen-landing-body .row2.is-open .nen-nav-toggle__bar:nth-child(1) {
            transform: translateY(7px) rotate(45deg);
        }
        body.nen-landing-body .row2.is-open .nen-nav-toggle__bar:nth-child(2) {
            opacity: 0;
        }
        body.nen-landing-body .row2.is-open .nen-nav-toggle__bar:nth-child(3) {
            transform: translateY(-7px) rotate(-45deg);
        }
        body.nen-landing-body .row-right2 {
            grid-column: 1;
            grid-row: 1;
            justify-content: flex-end;
            gap: 10px !important;
            min-width: 0;
            overflow: visible;
        }
        body.nen-landing-body #hero .nen-lang-dropdown {
            position: relative;
            z-index: 40;
            flex-shrink: 0;
        }
        body.nen-landing-body #hero .nen-lang-dropdown__menu {
            left: 50%;
            right: auto;
            transform: translateX(-50%);
            min-width: 148px;
        }
        body.nen-landing-body #hero .nen-lang-dropdown__toggle {
            font-size: 14px;
            gap: 4px;
        }
        body.nen-landing-body #hero .nen-hero-nav .card5 {
            width: auto;
            min-width: 0;
            max-width: 118px;
            padding: 8px 10px;
            gap: 6px;
        }
        body.nen-landing-body #hero .nen-hero-nav .card-text-left1 {
            font-size: 12px;
            white-space: nowrap;
        }
        body.nen-landing-body #hero .nen-hero-nav .card-lucide-arrow1 {
            width: 14px;
            height: auto;
        }
        body.nen-landing-body .row3.nen-nav-links {
            display: none;
            grid-column: 1 / -1;
            grid-row: 2;
            flex-direction: column;
            align-items: stretch;
            gap: 4px !important;
            width: 100%;
            padding: 10px 4px 4px;
            margin-top: 6px;
            border-top: 1px solid #eee;
        }
        body.nen-landing-body .row2.is-open .row3.nen-nav-links {
            display: flex;
        }
        body.nen-landing-body .row3.nen-nav-links a {
            padding: 10px 12px;
            border-radius: 10px;
            text-align: left;
        }
        body.nen-landing-body .row3.nen-nav-links a:active {
            background: #f5f5f5;
        }

        /* Hero text */
        body.nen-landing-body #hero .row5 {
            position: static !important;
            display: block !important;
            align-self: stretch !important;
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0;
            margin-top: 0 !important;
            padding: 0 !important;
        }
        body.nen-landing-body #hero .col1 {
            position: static !important;
            top: auto !important;
            left: auto !important;
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0;
            align-items: flex-start !important;
            align-self: stretch !important;
            text-align: start;
            gap: 18px;
        }
        body.nen-landing-body #hero .col2 {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0;
            align-self: stretch !important;
            text-align: start;
            gap: 16px;
        }
        body.nen-landing-body .subtitle1:not(.nen-hero-title) {
            white-space: normal !important;
            font-size: clamp(32px, 8.5vw, 48px) !important;
            letter-spacing: -1px !important;
            line-height: 1.15 !important;
        }
        body.nen-landing-body #hero .text-join-the-ultimate,
        body.nen-landing-body .text-join-the-ultimate {
            width: 100%;
            max-width: 100%;
            margin-right: 0 !important;
            margin-left: 0 !important;
            text-align: start;
            font-size: 15px;
            line-height: 1.7;
        }
        body.nen-landing-body #hero .frame-bottom,
        body.nen-landing-body .frame-bottom {
            width: auto !important;
            max-width: 100%;
        }

        /* Partner strip */
        body.nen-landing-body .row-bottom3 {
            position: static !important;
            padding: 0 !important;
            border-top: none !important;
        }
        body.nen-landing-body .row12 {
            position: static !important;
            top: auto !important;
            left: auto !important;
            width: 100% !important;
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 16px !important;
        }
        body.nen-landing-body .nen-hero-partners {
            justify-content: flex-start;
        }
        body.nen-landing-body #hero .row12 .col-right1 {
            margin-left: 0;
            align-items: flex-start;
        }
        body.nen-landing-body #hero .row12 .img2 {
            width: min(188px, 72vw);
        }
        body.nen-landing-body #hero .nen-hero-title {
            width: 100%;
            align-items: flex-start;
            text-align: start;
            gap: 10px;
            line-height: 1.3 !important;
            letter-spacing: -1px !important;
        }
        body.nen-landing-body #hero .nen-hero-title__study,
        body.nen-landing-body #hero .nen-hero-title__country {
            font-size: clamp(30px, 8.2vw, 44px) !important;
            line-height: 1.3 !important;
            width: 100%;
        }

        /* How It Works — mobile header */
        body.nen-landing-body #how-it-works {
            padding: 0 16px;
            gap: 28px;
        }
        body.nen-landing-body #how-it-works .row-top6 {
            flex-direction: column;
            align-items: center;
            gap: 18px;
            width: 100%;
        }
        body.nen-landing-body #how-it-works .col-left2 {
            align-items: center;
            text-align: center;
            width: 100%;
            gap: 14px;
        }
        body.nen-landing-body #how-it-works .subtitle-we-re-not-just-about {
            font-size: clamp(26px, 7.5vw, 38px) !important;
            line-height: 1.3 !important;
            letter-spacing: -0.5px !important;
            white-space: normal !important;
            text-align: center;
            color: #111;
        }
        body.nen-landing-body #how-it-works .col-left2 .text {
            font-size: 15px;
            line-height: 1.7;
            text-align: center;
            max-width: 100%;
            margin: 0;
        }
        body.nen-landing-body #how-it-works .frame-right2 {
            width: auto;
            max-width: 100%;
        }

        /* ── About Program ── */
        body.nen-landing-body #about .col3 {
            width: 100%;
            padding: 0 16px;
            gap: 28px;
        }
        body.nen-landing-body #about .column-subtitle1 {
            font-size: clamp(28px, 7vw, 40px) !important;
            line-height: 1.15 !important;
            padding: 0 8px;
        }
        body.nen-landing-body #about .group-top {
            position: relative;
            min-height: auto;
            display: block;
        }
        body.nen-landing-body #about .img3 {
            position: relative !important;
            top: auto !important;
            left: auto !important;
            width: 100% !important;
            max-width: 100% !important;
            display: block;
            border-radius: 16px;
        }
        body.nen-landing-body #about .group1 {
            position: absolute !important;
            top: 16px !important;
            right: 8px !important;
            left: auto !important;
            padding: 0 !important;
        }
        body.nen-landing-body #about .group3 {
            position: absolute !important;
            bottom: 16px !important;
            left: 8px !important;
            top: auto !important;
            padding: 0 !important;
        }
        body.nen-landing-body #about .group1 .btn-b,
        body.nen-landing-body #about .group3 .btn-b {
            font-size: 13px;
            padding: 8px 14px;
        }
        body.nen-landing-body #about .subtitle2 {
            font-size: clamp(15px, 4vw, 18px) !important;
            line-height: 1.55 !important;
            text-align: center;
            padding: 0 4px;
        }
        body.nen-landing-body #about .row-bottom4 {
            flex-direction: column;
            align-items: stretch !important;
            gap: 12px;
        }
        body.nen-landing-body #about .row-bottom4 .frame-b {
            justify-content: center;
        }

        /* ── Why Uzbekistan ── */
        body.nen-landing-body #why-uzbekistan .col5 {
            width: 100%;
            padding: 0 16px;
        }
        body.nen-landing-body #why-uzbekistan .col6 {
            gap: 32px;
        }
        body.nen-landing-body #why-uzbekistan .container {
            flex-direction: column !important;
            gap: 24px !important;
            width: 100% !important;
        }
        body.nen-landing-body #why-uzbekistan .container-container1 {
            width: 100% !important;
            overflow: visible;
        }
        body.nen-landing-body #why-uzbekistan .container-row-top,
        body.nen-landing-body #why-uzbekistan .container-row {
            gap: 16px !important;
        }
        body.nen-landing-body #why-uzbekistan .card6,
        body.nen-landing-body #why-uzbekistan .card-a {
            align-items: flex-start !important;
            text-align: start !important;
            padding: 24px 20px !important;
            min-height: auto;
        }
        body.nen-landing-body #why-uzbekistan .row-c {
            width: 100%;
            justify-content: space-between;
        }
        body.nen-landing-body #why-uzbekistan .card-container1,
        body.nen-landing-body #why-uzbekistan .card-container3 {
            align-items: flex-start !important;
            text-align: start !important;
            width: 100%;
        }
        body.nen-landing-body #why-uzbekistan .container-frame-right {
            width: 100% !important;
            padding: min(52vw, 320px) 20px 24px !important;
            background-size: cover !important;
            background-position: center top !important;
            border-radius: 16px;
            min-height: 280px;
        }
        body.nen-landing-body #why-uzbekistan .card-text1,
        body.nen-landing-body #why-uzbekistan .card-text4 {
            line-height: 1.75 !important;
            max-width: 100%;
        }

        body.nen-landing-body #why-uzbekistan .card10 {
            margin-left: 0;
        }

        /* ── Required Documents ── */
        body.nen-landing-body #documents .col14,
        body.nen-landing-body #documents .col15 {
            width: 100%;
            max-width: 100%;
            padding: 0 4px;
        }
        body.nen-landing-body #documents .row-f {
            flex-direction: column !important;
            align-items: stretch !important;
            width: 100%;
            gap: 12px !important;
        }
        body.nen-landing-body #documents .row-f > * {
            text-align: start !important;
        }
        body.nen-landing-body #documents .card-b {
            flex: none !important;
            width: 100% !important;
            min-width: 0 !important;
            height: auto !important;
            min-height: 88px !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: flex-start !important;
            gap: 14px !important;
            padding: 12px 14px !important;
            box-sizing: border-box;
        }
        body.nen-landing-body #documents .card-b > * {
            text-align: start !important;
        }
        body.nen-landing-body #documents .card-b .card-img {
            width: 64px !important;
            height: 64px !important;
            flex-shrink: 0 !important;
        }
        body.nen-landing-body #documents .card-b .card-text2 {
            width: auto !important;
            flex: 1 1 auto !important;
            min-width: 0;
            word-break: normal;
            overflow-wrap: break-word;
        }
        body.nen-landing-body #documents .column-subtitle3 {
            font-size: clamp(24px, 6.5vw, 32px) !important;
            line-height: 1.15 !important;
        }

        /* ── FAQ ── */
        body.nen-landing-body #faq .col19 {
            padding: 0 16px;
            gap: 28px;
        }
        body.nen-landing-body #faq .row20.nen-faq-grid {
            gap: 12px !important;
        }
        body.nen-landing-body #faq .nen-faq-row {
            grid-template-columns: 1fr !important;
            gap: 12px !important;
        }
        body.nen-landing-body #faq .nen-faq-item .faq-btn-d {
            width: 100%;
            box-sizing: border-box;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            min-height: 0;
            padding: 18px 16px !important;
            text-align: start;
            background: #fff;
        }
        body.nen-landing-body #faq .faq-btn-d {
            width: 100%;
            box-sizing: border-box;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 18px 16px !important;
            text-align: start;
            background: #fff;
        }
        body.nen-landing-body #faq .faq-btn-d .btn-label {
            flex: 1;
            min-width: 0;
            margin: 0;
            text-align: start;
            font-size: 15px;
            line-height: 1.6;
        }
        body.nen-landing-body #faq .faq-btn-d .btn-icon-add {
            flex-shrink: 0;
            width: 22px;
            height: 22px;
        }
        body.nen-landing-body #faq .faq-btn-d.active {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            border-color: #8e8e8e;
        }
        body.nen-landing-body #faq .faq-answer {
            padding: 16px 16px 18px;
            margin: 0;
            font-size: 14px;
            line-height: 1.75;
            text-align: start;
            color: #3e3c36;
            border: 0.2px solid #8e8e8e;
            border-top: 0;
            border-radius: 0 0 16px 16px;
            background: var(--neutrals-neutrals-2, #f5f5f5);
            overflow: visible;
        }
        body.nen-landing-body #faq .column-subtitle3 {
            font-size: clamp(24px, 6.5vw, 32px) !important;
            line-height: 1.15 !important;
            padding: 0 8px;
        }

        /* ── Trusted Agencies ── */
        body.nen-landing-body #trusted-agencies .col17 {
            padding: 0 16px;
            gap: 28px;
        }
        body.nen-landing-body #trusted-agencies .row-top9 {
            width: 100% !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: 20px !important;
            padding: 0 !important;
        }
        body.nen-landing-body #trusted-agencies .row-top9 .row-col2 {
            width: 100% !important;
            max-width: 100% !important;
            align-items: center !important;
        }
        body.nen-landing-body #trusted-agencies .row-subtitle {
            font-size: clamp(26px, 7vw, 36px) !important;
            line-height: 1.15 !important;
            word-wrap: break-word;
        }
        body.nen-landing-body #trusted-agencies .row-text-bottom {
            max-width: 100% !important;
        }
        body.nen-landing-body #trusted-agencies .col-bottom2,
        body.nen-landing-body #trusted-agencies .group5 {
            width: 100%;
            overflow: hidden;
        }
        body.nen-landing-body #trusted-agencies .nen-scroll-wrap {
            margin: 0 auto;
        }
        body.nen-landing-body #trusted-agencies .nen-scroll-wrap .row19 > .card-c {
            flex: 0 0 calc(100vw - 64px) !important;
            width: calc(100vw - 64px) !important;
            min-width: calc(100vw - 64px) !important;
            max-width: 320px;
        }

        /* Footer: show "Apply For Future" first, compact the rest */
        body.nen-landing-body .nen-foot {
            display: flex;
            flex-direction: column;
        }
        body.nen-landing-body .nen-foot__cta {
            order: 1;
            border-top: none;
            padding: 24px 16px 12px;
        }
        body.nen-landing-body .nen-foot__top {
            order: 2;
            border-top: 1px solid #ececec;
        }
        body.nen-landing-body .nen-foot__bottom {
            order: 3;
        }
        body.nen-landing-body .nen-foot__cta-title {
            white-space: normal !important;
            font-size: clamp(24px, 7vw, 36px) !important;
            line-height: 1.25 !important;
        }
        html[dir="rtl"] body.nen-landing-body .nen-foot__cta-title {
            font-size: clamp(22px, 6.5vw, 34px) !important;
            line-height: 1.35 !important;
        }
    }

    @media (max-width: 380px) {
        body.nen-landing-body .nen-foot__top {
            grid-template-columns: 1fr;
        }
    }

    body.nen-landing-body .tesrimonials.nen-about-section {
        flex-direction: column;
        align-items: stretch;
        gap: clamp(36px, 5vw, 56px);
        padding: clamp(40px, 5vw, 80px) clamp(24px, 4vw, 80px);
    }

    body.nen-landing-body .tesrimonials.nen-about-section > * {
        text-align: unset;
    }

    body.nen-landing-body .nen-about-section__top {
        display: grid;
        grid-template-columns: minmax(0, 0.95fr) minmax(280px, 1.05fr);
        align-items: start;
        gap: clamp(28px, 4vw, 80px);
        width: 100%;
    }

    body.nen-landing-body .nen-about-section__top .tesrimonials-col-left {
        width: 100%;
        min-width: 0;
        max-width: none;
        flex: unset;
    }

    body.nen-landing-body .nen-about-section__top .tesrimonials-col2 {
        max-width: 558px;
        width: 100%;
    }

    body.nen-landing-body .nen-about-nen .tesrimonials-subtitle-national {
        font-size: clamp(36px, 4.5vw, 64px);
        line-height: 1.25;
        letter-spacing: -0.03em;
        word-break: break-word;
    }

    html[dir="rtl"] body.nen-landing-body .nen-about-nen,
    html[dir="rtl"] body.nen-landing-body .nen-about-section__top .tesrimonials-col-left {
        text-align: right;
        align-items: flex-start;
    }

    html[dir="rtl"] body.nen-landing-body .nen-about-nen .tesrimonials-col2,
    html[dir="rtl"] body.nen-landing-body .nen-about-nen .tesrimonials-subtitle-national,
    html[dir="rtl"] body.nen-landing-body .nen-about-nen .tesrimonials-text-an-international {
        text-align: right;
        align-self: stretch;
        width: 100%;
    }

    html[dir="rtl"] body.nen-landing-body .nen-about-nen .tesrimonials-btn {
        width: auto;
        max-width: 100%;
        align-self: flex-start;
        text-align: center;
        white-space: nowrap;
    }

    html[dir="rtl"] body.nen-landing-body .nen-about-nen .tesrimonials-text-an-international {
        margin-right: 0;
        margin-left: 0;
    }

    html[dir="rtl"] body.nen-landing-body .nen-about-section__bottom {
        margin-right: 0;
        margin-left: 0;
        text-align: right;
        align-items: flex-start;
    }

    html[dir="rtl"] body.nen-landing-body .nen-about-section__bottom .tesrimonials-subtitle-key-milestones {
        text-align: right;
        width: 100%;
    }
    body.nen-landing-body .nen-about-section__bottom {
        width: 100%;
        max-width: 100%;
        display: flex;
        flex-direction: column;
        gap: 28px;
        line-height: normal;
    }

    /* ── About NEN (milestones left column) ── */
    body.nen-landing-body .nen-about-nen .tesrimonials-btn {
        width: fit-content;
        max-width: 100%;
        align-self: flex-start;
        color: #000 !important;
        text-decoration: none;
        font-weight: 600;
        background-color: var(--screen-basics-bg-web);
    }

    body.nen-landing-body .nen-about-nen .tesrimonials-btn:hover,
    body.nen-landing-body .nen-about-nen .tesrimonials-btn:focus,
    body.nen-landing-body .nen-about-nen .tesrimonials-btn:active {
        color: #000 !important;
        text-decoration: none;
        filter: brightness(0.85);
    }
    body.nen-landing-body .nen-about-nen__intro {
        margin: 0 0 14px;
        font-size: 15px;
        line-height: 1.65;
        color: #5b5b5b;
        text-align: left;
    }
    html[dir="rtl"] body.nen-landing-body .nen-about-nen__intro {
        text-align: right;
    }
    body.nen-landing-body .nen-about-nen__stats {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: clamp(10px, 1.4vw, 16px);
        margin: 20px 0 24px;
        width: 100%;
    }
    body.nen-landing-body .nen-about-nen__stat {
        background: #f5f8f9;
        border-radius: 16px;
        padding: clamp(12px, 1.4vw, 16px) clamp(12px, 1.2vw, 18px);
        text-align: left;
        min-width: 0;
    }
    html[dir="rtl"] body.nen-landing-body .nen-about-nen__stat {
        text-align: right;
    }
    body.nen-landing-body .nen-about-nen__stat-value {
        margin: 0 0 6px;
        font-size: clamp(20px, 2.2vw, 28px);
        font-weight: 800;
        line-height: 1;
        color: #111;
    }
    body.nen-landing-body .nen-about-nen__stat-title {
        margin: 0 0 8px;
        font-size: clamp(11px, 1.1vw, 14px);
        font-weight: 700;
        line-height: 1.35;
        color: #017785;
    }
    body.nen-landing-body .nen-about-nen__stat-desc {
        margin: 0;
        font-size: clamp(11px, 1vw, 13px);
        line-height: 1.5;
        color: #5b5b5b;
    }
    body.nen-landing-body .nen-about-nen__mission-title {
        margin: 0 0 10px;
        font-size: 18px;
        font-weight: 700;
        color: #111;
        text-align: left;
    }
    html[dir="rtl"] body.nen-landing-body .nen-about-nen__mission-title {
        text-align: right;
    }
    body.nen-landing-body .nen-about-nen__mission {
        margin: 0;
        font-size: 15px;
        line-height: 1.65;
        color: #5b5b5b;
        text-align: left;
        max-width: none;
        width: 100%;
        align-self: stretch;
    }
    html[dir="rtl"] body.nen-landing-body .nen-about-nen__mission {
        text-align: right;
        align-self: stretch;
        white-space: nowrap;
        font-size: clamp(13px, 1.05vw, 15px);
    }

    @media (max-width: 768px) {
        html[dir="rtl"] body.nen-landing-body .nen-about-nen__mission {
            white-space: normal;
        }

        body.nen-landing-body #documents .col-top4 .column-subtitle3,
        body.nen-landing-body #documents .col-top4 .column-text-bottom,
        body.nen-landing-body #trusted-agencies .row-subtitle,
        body.nen-landing-body #trusted-agencies .row-text-bottom,
        body.nen-landing-body #translation-agencies .row-subtitle,
        body.nen-landing-body #translation-agencies .row-text-bottom {
            white-space: normal;
        }
    }
    @media (max-width: 900px) {
        body.nen-landing-body .nen-about-nen__stats {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            gap: 12px;
            padding-bottom: 4px;
        }

        body.nen-landing-body .nen-about-nen__stat {
            flex: 0 0 min(200px, 72vw);
        }
    }

    /* ── Collection points map (milestones right column) ── */
    body.nen-landing-body .tesrimonials-group-right.nen-collection-map {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 14px;
        width: 100% !important;
        max-width: none;
        height: auto !important;
        min-height: auto;
        min-width: 0;
        flex: unset;
        flex-grow: 0 !important;
        align-self: stretch;
        background: #f5f8f9 !important;
        border-radius: 16px;
        padding: 20px 22px;
        overflow: visible !important;
        text-align: left;
        box-sizing: border-box;
    }

    body.nen-landing-body .nen-collection-map__tabs,
    body.nen-landing-body .nen-collection-map__map-wrap,
    body.nen-landing-body .nen-collection-map__panel {
        flex-shrink: 0;
        width: 100%;
    }

    body.nen-landing-body .nen-collection-map__map-wrap {
        width: 100%;
        height: clamp(220px, 32vw, 280px);
        min-height: 220px;
        flex: 0 0 auto;
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #dce7ea;
        background: #e8eef0;
        z-index: 1;
    }

    body.nen-landing-body .nen-collection-map__canvas,
    body.nen-landing-body #nenCollectionMap.leaflet-container {
        position: absolute !important;
        inset: 0 !important;
        width: 100% !important;
        height: 100% !important;
        min-height: 100% !important;
        flex-shrink: 0;
        display: block;
        border: 0;
        border-radius: 0;
        background: #e8eef0;
        z-index: 1;
    }

    body.nen-landing-body #nenCollectionMap.leaflet-container {
        font: inherit;
    }

    /* reset.css sets img { max-width:100% } — breaks Leaflet tiles on all viewports */
    body.nen-landing-body .leaflet-container img {
        max-width: none !important;
        max-height: none !important;
    }

    body.nen-landing-body .nen-collection-map__title {
        margin: 0;
        width: 100%;
        font-size: 20px;
        font-weight: 700;
        letter-spacing: -0.4px;
        color: #111;
        text-align: left;
    }

    body.nen-landing-body .nen-collection-map__tabs {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 8px;
        width: 100%;
    }

    body.nen-landing-body .nen-collection-map__tab {
        border: 1px solid #d8e3e6;
        background: #fff;
        color: #111;
        font-size: 14px;
        font-weight: 600;
        padding: 8px 14px;
        border-radius: 999px;
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
    }

    body.nen-landing-body .nen-collection-map__tab.is-active,
    body.nen-landing-body .nen-collection-map__tab:hover {
        background: #017785;
        border-color: #017785;
        color: #fff;
    }

    body.nen-landing-body .nen-collection-map__location-list {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 8px;
        width: 100%;
    }

    body.nen-landing-body .nen-collection-map__location-btn {
        border: 1px solid #d8e3e6;
        background: #fff;
        color: #333;
        font-size: 13px;
        font-weight: 600;
        padding: 7px 12px;
        border-radius: 999px;
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        max-width: 100%;
        text-align: start;
    }

    body.nen-landing-body .nen-collection-map__location-btn.is-active,
    body.nen-landing-body .nen-collection-map__location-btn:hover {
        background: #e6f3f5;
        border-color: #017785;
        color: #017785;
    }

    body.nen-landing-body #nenCollectionMap .leaflet-pane,
    body.nen-landing-body #nenCollectionMap .leaflet-map-pane,
    body.nen-landing-body #nenCollectionMap .leaflet-tile-pane {
        width: 100%;
        height: 100%;
    }

    body.nen-landing-body #nenCollectionMap .leaflet-marker-pane,
    body.nen-landing-body #nenCollectionMap .leaflet-shadow-pane {
        z-index: 650 !important;
        pointer-events: auto !important;
    }

    body.nen-landing-body #nenCollectionMap .leaflet-interactive {
        cursor: pointer;
    }

    body.nen-landing-body .leaflet-container img.leaflet-tile,
    body.nen-landing-body .leaflet-container img.leaflet-marker-icon,
    body.nen-landing-body .leaflet-container img.leaflet-marker-shadow,
    body.nen-landing-body .leaflet-container img.leaflet-image-layer {
        max-width: none !important;
        max-height: none !important;
    }

    body.nen-landing-body .leaflet-marker-icon.nen-collection-marker {
        background: transparent !important;
        border: none !important;
        pointer-events: auto !important;
        cursor: pointer;
    }

    body.nen-landing-body .leaflet-marker-icon.nen-collection-marker.is-selected {
        filter: drop-shadow(0 0 4px rgba(1, 119, 133, 0.55));
        z-index: 1000 !important;
    }

    body.nen-landing-body .nen-collection-marker__hit {
        display: block;
        width: 36px;
        height: 48px;
        margin: -3px -3px 0;
        pointer-events: auto;
    }

    body.nen-landing-body .nen-collection-marker svg {
        display: block;
        filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.25));
    }

    body.nen-landing-body .nen-collection-map__panel {
        position: relative;
        min-height: 120px;
        width: 100%;
        text-align: left;
    }

    body.nen-landing-body .nen-collection-map__details-live {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
        width: 100%;
        text-align: left;
    }

    body.nen-landing-body .nen-collection-map__country-panel {
        display: none;
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
        width: 100%;
        text-align: left;
    }

    body.nen-landing-body .nen-collection-map__country-panel.is-active {
        display: flex;
    }

    body.nen-landing-body .nen-collection-map__office-block {
        display: none;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
        width: 100%;
        text-align: left;
    }

    body.nen-landing-body .nen-collection-map__office-block.is-active {
        display: flex;
    }

    body.nen-landing-body .nen-collection-map__office-block + .nen-collection-map__office-block {
        border-top: none;
        padding-top: 0;
    }

    body.nen-landing-body .nen-collection-map__details {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
        width: 100%;
        text-align: left;
    }

    body.nen-landing-body .nen-collection-map__office {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #111;
        text-align: left;
        width: 100%;
    }

    body.nen-landing-body .nen-collection-map__meta {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
        width: 100%;
        font-size: 13px;
        line-height: 1.45;
        color: #444;
        text-align: left;
    }

    body.nen-landing-body .nen-collection-map__meta a {
        color: #017785;
    }

    body.nen-landing-body .nen-collection-map__actions {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 10px;
        margin-top: 4px;
        width: 100%;
    }

    body.nen-landing-body .nen-collection-map__btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 16px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        border: none;
        transition: opacity 0.2s ease;
    }

    body.nen-landing-body .nen-collection-map__btn--maps {
        background: #017785;
        color: #fff;
    }

    body.nen-landing-body .nen-collection-map__btn--share {
        background: #fff;
        color: #111;
        border: 1px solid #d8e3e6;
    }

    body.nen-landing-body .nen-collection-map__btn:hover {
        opacity: 0.88;
    }

    html[dir="rtl"] body.nen-landing-body .nen-collection-map__meta,
    html[dir="rtl"] body.nen-landing-body .nen-collection-map__title,
    html[dir="rtl"] body.nen-landing-body .nen-collection-map__office,
    html[dir="rtl"] body.nen-landing-body .nen-collection-map__country-panel,
    html[dir="rtl"] body.nen-landing-body .nen-collection-map__office-block,
    html[dir="rtl"] body.nen-landing-body .nen-collection-map__details,
    html[dir="rtl"] body.nen-landing-body .nen-collection-map__details-live {
        text-align: right;
        align-items: flex-start;
    }

    html[dir="rtl"] body.nen-landing-body .nen-collection-map__location-list,
    html[dir="rtl"] body.nen-landing-body .nen-collection-map__location-btn {
        text-align: right;
    }

    html[dir="rtl"] body.nen-landing-body .tesrimonials-group-right.nen-collection-map {
        text-align: right;
        align-items: flex-start;
    }

    @container body (width < 821px) {
        body.nen-landing-body .tesrimonials.nen-about-section {
            gap: clamp(36px, 5vw, 56px);
            align-items: stretch;
        }

        body.nen-landing-body .tesrimonials.nen-about-section > * {
            text-align: unset;
        }
    }

    @media (max-width: 768px) {
        body.nen-landing-body .tesrimonials.nen-about-section {
            padding: 32px 16px;
            gap: 36px;
            align-items: stretch;
        }
        body.nen-landing-body .nen-about-section__top {
            display: flex;
            flex-direction: column;
            gap: 28px;
        }
        html[dir="rtl"] body.nen-landing-body .nen-about-nen,
        html[dir="rtl"] body.nen-landing-body .nen-about-section__top .tesrimonials-col-left {
            text-align: right !important;
            align-items: flex-start !important;
        }
        html[dir="rtl"] body.nen-landing-body .nen-about-section__bottom {
            align-items: flex-start !important;
            text-align: right !important;
        }
        body.nen-landing-body .nen-about-section__bottom {
            max-width: 100%;
            width: 100%;
        }
        body.nen-landing-body .nen-collection-map {
            width: 100% !important;
            max-width: 100%;
            min-height: auto;
            padding: 18px;
            overflow: visible !important;
        }

        body.nen-landing-body .nen-collection-map__map-wrap {
            height: 260px;
            min-height: 260px;
        }

        body.nen-landing-body .nen-collection-map__canvas,
        body.nen-landing-body #nenCollectionMap.leaflet-container {
            height: 100% !important;
            min-height: 100% !important;
        }
    }

    /* ── Arabic (RTL): comfortable line spacing sitewide ── */
    html[dir="rtl"] body.nen-landing-body {
        line-height: 1.75;
    }

    html[dir="rtl"] body.nen-landing-body :where(
        p,
        li,
        .text,
        .column-text-bottom,
        .tesrimonials-text-an-international,
        .tesrimonials-text-bottom,
        .nen-about-nen__intro,
        .nen-about-nen__mission,
        .nen-about-nen__stat-desc,
        .row-text2,
        .row-text3,
        .card-text1,
        .card-text4,
        .text-join-the-ultimate,
        .faq-answer,
        .nen-step__desc,
        .nen-step__hint,
        .nen-collection-map__meta,
        .nen-foot__tagline
    ) {
        line-height: 1.85 !important;
    }

    html[dir="rtl"] body.nen-landing-body :where(
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .subtitle1,
        .column-subtitle1,
        .column-subtitle3,
        .subtitle-we-re-not-just-about,
        .tesrimonials-subtitle-national,
        .tesrimonials-subtitle-key-milestones,
        .nen-about-nen__mission-title,
        .nen-about-nen__stat-title,
        .card-subtitle2,
        .nen-hero-title,
        .nen-hero-title__study,
        .nen-hero-title__country
    ) {
        line-height: 1.5 !important;
        letter-spacing: 0 !important;
    }

    html[dir="rtl"] body.nen-landing-body #hero .nen-hero-title {
        gap: 10px;
    }

    html[dir="rtl"] body.nen-landing-body #hero .text-join-the-ultimate {
        line-height: 1.9 !important;
    }

    html[dir="rtl"] body.nen-landing-body #faq .faq-btn-d .btn-label {
        line-height: 1.65 !important;
    }

    html[dir="rtl"] body.nen-landing-body :where(
        .btn-a,
        .btn-b,
        .btn-c,
        .btn-d,
        .column-btn1,
        .column-btn2,
        .tesrimonials-btn,
        .row-btn,
        .nen-collection-map__tab,
        .nen-collection-map__location-btn
    ) {
        line-height: 1.45 !important;
    }
</style>
@endpush

@section('content')
    @php
        $nenLogo = ($isRtl ?? is_rtl())
            ? asset('site/home/assets/nen-ar.png')
            : asset($settings['media']->logo ?? 'site/home/assets/nen.png');
    @endphp

    {{-- ===================== HERO ===================== --}}
    @if ($landing->show_hero ?? true)
        <div class="col-top1" id="hero">
            <img src="{{ asset($landing->hero_image ?? 'site/home/assets/img1.png') }}" class="img1" alt="Study in Uzbekistan" />

            <div class="row-top4">
                <div class="row-a row1">
                    @for ($i = 1; $i <= 12; $i++)
                        <div class="row-circle row-circle{{ $i }}"></div>
                    @endfor
                </div>

                <div class="row-a row4">
                    @for ($i = 1; $i <= 12; $i++)
                        <div class="row-circle row-circle{{ $i }}"></div>
                    @endfor
                </div>
            </div>

            {{-- Floating Navigation Bar (sibling of decor rows so z-index stays above hero image) --}}
            <div class="nen-hero-header">
                <img src="{{ $nenLogo }}" class="nen nen-hero-logo" alt="NEN" />

                <div class="row2 nen-hero-nav">
                <button class="nen-nav-toggle" id="nenNavToggle" type="button" aria-expanded="false"
                    aria-controls="nenNavLinks" aria-label="Toggle menu">
                    <span class="nen-nav-toggle__bar"></span>
                    <span class="nen-nav-toggle__bar"></span>
                    <span class="nen-nav-toggle__bar"></span>
                </button>

                <div class="row3 nen-nav-links" id="nenNavLinks">
                    <a href="#hero" class="text-home">{{ __('landing.nav.home') }}</a>
                    <a href="#about" class="text-about-program">{{ __('landing.nav.about') }}</a>
                    <a href="#why-uzbekistan" class="text-why-uzbekistan-question">{{ __('landing.nav.why') }}</a>
                    <a href="#how-it-works" class="text-about-nen">{{ __('landing.nav.your_path') }}</a>
                    <a href="#documents" class="text-documents">{{ __('landing.nav.required_documents') }}</a>
                    <a href="#collection-point" class="text-collection-point">{{ __('landing.nav.collection_point') }}</a>
                    <a href="#trusted-agencies" class="text-trusted-agencies">{{ __('landing.nav.trusted_agencies') }}</a>
                    <a href="#faq" class="text-right">{{ __('landing.nav.faq') }}</a>
                </div>

                <div class="row-right2">
                    {{-- Language Switcher --}}
                    <div class="nen-lang-dropdown">
                        <button class="nen-lang-dropdown__toggle" id="nenLangBtn" type="button">
                            <img src="{{ asset('site/home/assets/globe.png') }}" class="globe" alt="Language" />
                            <span id="nenCurrentLang">{{ config('locales.labels.' . app()->getLocale(), strtoupper(app()->getLocale())) }}</span>
                        </button>
                        <div class="nen-lang-dropdown__menu" id="nenLangMenu">
                            <a class="nen-lang-dropdown__item {{ app()->getLocale() === 'en' ? 'is-active' : '' }}"
                                href="{{ route('site.locale.switch', 'en') }}" data-lang="en" data-label="EN">
                                <span class="flag-icon flag-icon-us"></span> {{ __('landing.language.english') }}
                            </a>
                            <a class="nen-lang-dropdown__item {{ app()->getLocale() === 'ar' ? 'is-active' : '' }}"
                                href="{{ route('site.locale.switch', 'ar') }}" data-lang="ar" data-label="AR">
                                <span class="flag-icon flag-icon-sa"></span> {{ __('landing.language.arabic') }}
                            </a>
                            <a class="nen-lang-dropdown__item {{ app()->getLocale() === 'ru' ? 'is-active' : '' }}"
                                href="{{ route('site.locale.switch', 'ru') }}" data-lang="ru" data-label="RU">
                                <span class="flag-icon flag-icon-ru"></span> {{ __('landing.language.russian') }}
                            </a>
                        </div>
                    </div>

                    {{-- Apply / Register Button --}}
                    @if ($landing->header_register_url)
                        <a href="{{ $landing->header_register_url }}" class="card5">
                            <img src="{{ asset('site/home/assets/card-img.png') }}" class="card-img2" />
                            <p class="card-text-left1">{{ landing_get($landing, 'header_register_text') ?? __('landing.nav.apply_now') }}</p>
                            <img src="{{ asset('site/home/assets/card-lucide-arrow.png') }}"
                                class="card-lucide-arrow1" />
                        </a>
                    @endif
                </div>
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
                        @php
                            $heroCountry = rtrim(landing_get($landing, 'hero_product_title') ?? __('landing.hero.country'), '.');
                        @endphp
                        <h2 class="subtitle1 nen-hero-title">
                            <span class="nen-hero-title__study">{{ __('landing.hero.study_in') }}</span>
                            <span class="nen-hero-title__country">{{ $heroCountry }}</span>
                        </h2>
                        <p class="text-join-the-ultimate">
                            {{ landing_get($landing, 'hero_subtitle') ?? __('landing.hero.subtitle') }}
                        </p>
                    </div>

                    <a href="{{ $landing->hero_btn_url ?? '#collection-point' }}" class="frame-a frame-bottom">
                        <p>{{ landing_get($landing, 'hero_btn_text') ?? __('landing.hero.admission_centers') }}</p>
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
                    <div class="nen-hero-partners">
                        @php
                            $stripPartners = ($partners ?? collect())->take(3);
                        @endphp
                        @forelse ($stripPartners as $pi => $partner)
                            @if ($pi > 0)
                                <div class="line nen-hero-divider"></div>
                            @endif
                            <{{ $partner->url ? 'a' : 'div' }} class="row-b nen-hero-partner"
                                @if ($partner->url) href="{{ $partner->url }}" target="_blank" rel="noopener" @endif>
                                @if ($partner->image)
                                    <img src="{{ asset($partner->image) }}" class="row-img1"
                                        alt="{{ $partner->localized('name') }}" />
                                @endif
                                <div class="row-col1">
                                    <p class="row-text1">{{ $partner->localized('name') }}</p>
                                    @if ($partner->localized('description'))
                                        <p class="row-text-republic-of">{{ $partner->localized('description') }}</p>
                                    @endif
                                </div>
                            </{{ $partner->url ? 'a' : 'div' }}>
                        @empty
                            <div class="row-b nen-hero-partner">
                                <img src="{{ asset('site/home/assets/row/row-img1.png') }}" class="row-img1"
                                    alt="Ministry" />
                                <div class="row-col1">
                                    <p class="row-text1">Ministry of Higher Education</p>
                                    <p class="row-text-republic-of">Republic of Uzbekistan</p>
                                </div>
                            </div>
                            <div class="line nen-hero-divider"></div>
                            <div class="row-b nen-hero-partner">
                                <img src="{{ asset('site/home/assets/row/row-img2.png') }}" class="row-img1"
                                    alt="Prime Minister" />
                                <div class="row-col1">
                                    <p class="row-text1">Prime Minister's Office</p>
                                    <p class="row-text-republic-of">Republic of Uzbekistan</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="col-right1">
                        <img src="{{ $landing->hero_official_logo ? asset($landing->hero_official_logo) : asset('site/home/assets/img2.png') }}"
                            class="img2"
                            alt="{{ __('landing.hero.study_in_uzbekistan') }}" />
                        <p>{{ landing_get($landing, 'hero_official_label') ?? __('landing.hero.official_partner') }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ===================== ABOUT PROGRAM ===================== --}}
    @if ($landing->show_about ?? true)
        <div class="col3" id="about">
            <div class="column-a col-top2">
                {{-- <button class="btn-a column-btn1 hover-dark">{{ landing_get($landing, 'about_label') ?? __('landing.about.badge') }}</button> --}}
                <h2 class="column-subtitle1">{{ landing_get($landing, 'about_title') ?? __('landing.about.title') }}</h2>
            </div>

            <div class="col4">
                <div class="group-top">
                    <div class="group1">
                        <img src="{{ asset('site/home/assets/group1.png') }}" class="group2" alt="" />
                        <button class="btn-b btn1 hover-bright">{{ __('landing.about.official_initiative') }}</button>
                    </div>

                    <img src="{{ $landing->about_image_main ? asset($landing->about_image_main) : asset('site/home/assets/img3.png') }}"
                        class="img3" alt="{{ $landing->about_title }}" />

                    <div class="group3">
                        <img src="{{ asset('site/home/assets/group2.png') }}" class="group4" alt="" />
                        <button class="btn-b btn-world-class hover-bright">{{ __('landing.about.world_class') }}</button>
                    </div>
                </div>

                <div class="col-bottom1">
                    {{-- Text starts dimmed and "lights up" word-by-word as it scrolls into view (JS-driven) --}}
                    <h2 class="subtitle2 nen-reveal" data-reveal>{{ landing_get($landing, 'about_description') ?? __('landing.about.description') }}</h2>

                    <div class="row-bottom4">
                        <a href="{{ $landing->footer_collaboration_url ?? 'https://studyin-uzbekistan.uz' }}"
                            class="frame-b frame-left">
                            <p>{{ __('landing.about.visit_portal') }}</p>
                            <img src="{{ asset('site/home/assets/card-img.png') }}" class="frame-img2" />
                        </a>

                        <a href="#how-it-works" class="frame-b frame-right1">
                            <p>{{ __('landing.about.life_in_uzbekistan') }}</p>
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
                    {{-- <button class="btn-a column-btn1 hover-dark">{{ __('landing.features.badge') }}</button> --}}
                    <h2 class="column-subtitle1">{{ landing_get($landing, 'features_title') ?? __('landing.features.title') }}</h2>
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
                                    <p class="row-text2">{{ $card0 ? $card0->localized('title') : __('landing.features.cards.quality_title') }}</p>
                                    <img src="{{ $card0 && $card0->image ? asset($card0->image) : $cardIcons[0] }}"
                                        class="row-group" alt="" />
                                </div>
                                <div class="card-container3">
                                    <h2 class="card-subtitle2">{{ $card0->stat_value ?? '100+' }}</h2>
                                    <p class="card-text4">
                                        {{ ($card0 ? $card0->localized('description') : null) ?? __('landing.features.cards.quality_desc') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Card 2 (card7 style) --}}
                            <div class="card-a card7">
                                <div class="row-c row-top1">
                                    <p class="row-text2">{{ $card1 ? $card1->localized('title') : __('landing.features.cards.affordable_title') }}</p>
                                    <img src="{{ $card1 && $card1->image ? asset($card1->image) : $cardIcons[1] }}"
                                        class="row-group" alt="" />
                                </div>
                                <div class="card-container1">
                                    <div class="card-container2">
                                        <h2>{{ $card1->stat_value ?? '50%' }}</h2>
                                    </div>
                                    <p class="card-text1">
                                        {{ ($card1 ? $card1->localized('description') : null) ?? __('landing.features.cards.affordable_desc') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="container-container2">
                            <div class="container-row">
                                {{-- Card 3: international --}}
                                <div class="card-a card8">
                                    <div class="row-c row-top1">
                                        <p class="row-text2">{{ $card2 ? $card2->localized('title') : __('landing.features.cards.international_title') }}</p>
                                        <img src="{{ $card2 && $card2->image ? asset($card2->image) : $cardIcons[2] }}"
                                            class="row-group" alt="" />
                                    </div>
                                    <div class="card-container1">
                                        <div class="card-container2">
                                            <h2>{{ $card2->stat_value ?? '50+' }}</h2>
                                        </div>
                                        <p class="card-text1">
                                            {{ ($card2 ? $card2->localized('description') : null) ?? __('landing.features.cards.international_desc') }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Card 4: safe & welcoming --}}
                                <div class="card-a card9">
                                    <div class="row-c row-top1">
                                        <p class="row-text2">{{ $card3 ? $card3->localized('title') : __('landing.features.cards.safe_title') }}</p>
                                        <img src="{{ $card3 && $card3->image ? asset($card3->image) : $cardIcons[3] }}"
                                            class="row-group" alt="" />
                                    </div>
                                    <div class="card-container1">
                                        <div class="card-container2">
                                            <h2>{{ $card3->stat_value ?? '100%' }}</h2>
                                        </div>
                                        <p class="card-text1">
                                            {{ ($card3 ? $card3->localized('description') : null) ?? __('landing.features.cards.safe_desc') }}
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
                            <p class="card-text-left2">{{ __('landing.features.explore_university') }}</p>
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
                    <button class="btn-a btn2 hover-dark">{{ __('landing.how_it_works.badge') }}</button>
                    <h2 class="subtitle-we-re-not-just-about">{{ landing_get($landing, 'how_it_works_title') ?? __('landing.how_it_works.title') }}</h2>
                    <p class="text">
                        {{ landing_get($landing, 'how_it_works_subtitle') ?? __('landing.how_it_works.subtitle') }}
                    </p>
                </div>

                <a href="{{ $landing->how_it_works_btn_url ?? '#collection-point' }}" class="frame-a frame-right2">
                    <p>{{ landing_get($landing, 'how_it_works_btn_text') ?? __('landing.how_it_works.btn_text') }}</p>
                    <img src="{{ asset('site/home/assets/card-img.png') }}" class="frame-img1" />
                </a>
            </div>

            @php
                $steps = $howItWorksSteps ?? collect();
                $stepsByNumber = $steps->keyBy('step_number');
                $stepTitles = collect(__('landing.how_it_works.steps'))->pluck('title')->all();
                $stepDescs = collect(__('landing.how_it_works.steps'))->pluck('desc')->all();
            @endphp

            <div class="col8 nen-steps">
                @foreach ([[0, 1, 2], [3, 4, 5]] as $row)
                    <div class="nen-steps-row">
                        @foreach ($row as $idx)
                            @php
                                $stepNum = $idx + 1;
                                $step = $stepsByNumber->get($stepNum);
                                $title = landing_item_localized($step, 'title', $stepTitles[$idx] ?? '');
                                $desc = landing_item_localized($step, 'description', $stepDescs[$idx] ?? '');
                                $num = str_pad((string) $stepNum, 2, '0', STR_PAD_LEFT);
                            @endphp
                            <div class="nen-step" tabindex="0" role="button"
                                aria-label="{{ $title }} — step {{ $stepNum }}"
                                aria-expanded="false"
                                style="--nen-step-delay: {{ $idx * 90 }}ms">
                                <div class="nen-step__card">
                                    <span class="nen-step__accent" aria-hidden="true"></span>
                                    <span class="nen-step__num">{{ $num }}.</span>
                                    <div class="nen-step__head">
                                        <div class="nen-step__icon" aria-hidden="true">
                                            @include('site.partials.how-it-works-step-icon', ['step' => $stepNum])
                                        </div>
                                        <h3 class="nen-step__title">{{ $title }}</h3>
                                        <p class="nen-step__hint">{{ __('landing.how_it_works.reveal_hint') }}</p>
                                    </div>
                                    <div class="nen-step__drawer">
                                        <p class="nen-step__desc">{{ $desc }}</p>
                                    </div>
                                    <span class="nen-step__chev" aria-hidden="true"></span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ===================== REQUIRED DOCUMENTS ===================== --}}
    @if (($landing->show_documents ?? true) && isset($applicationDocuments) && $applicationDocuments->count())
        <div class="col13 section" id="documents">
            <div class="col14">
                <div class="column-c col-top4">
                    {{-- <button class="btn-a column-btn2 hover-dark">{{ __('landing.documents.badge') }}</button> --}}
                    <h2 class="column-subtitle3">{{ landing_get($landing, 'documents_title') ?? __('landing.documents.title') }}</h2>
                    <p class="column-text-bottom">
                        {{ landing_get($landing, 'documents_subtitle') ?? __('landing.documents.subtitle') }}
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
                                        class="card-img input" alt="{{ $doc->localized('title') }}" />
                                    <p class="card-text2">{!! nl2br(e($doc->localized('title'))) !!}</p>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- ===================== COLLECTION POINT / MILESTONES ===================== --}}
    @if ($landing->show_milestones ?? true)
        <div class="tesrimonials nen-about-section" id="about-nen">
            <div class="nen-about-section__top">
                <div class="tesrimonials-col-left nen-about-nen">
                    {{-- <a href="{{ $landing->milestones_cta_url ?? '#collection-point' }}"
                        class="btn-c tesrimonials-btn hover-dark">
                        {{ landing_get($landing, 'milestones_cta_text') ?? __('landing.milestones.find_collection_point') }}
                    </a> --}}

                    <div class="tesrimonials-col2">
                        <h2 class="tesrimonials-subtitle-national">
                            {{ landing_get($landing, 'milestones_title') ?? __('landing.milestones.title') }}
                        </h2>
                        @foreach (__('landing.milestones.intro') as $paragraph)
                            <p class="text tesrimonials-text-an-international nen-about-nen__intro">{{ $paragraph }}</p>
                        @endforeach
                    </div>
                </div>

                <div class="tesrimonials-group-right nen-collection-map" id="collection-point">
                <h3 class="nen-collection-map__title">{{ __('landing.collection_points.map_title') }}</h3>

                @if (($collectionCountries ?? collect())->isNotEmpty())
                    <div class="nen-collection-map__tabs" role="tablist" aria-label="{{ __('landing.collection_points.map_title') }}">
                        @foreach ($collectionCountries as $i => $country)
                            <button type="button"
                                class="nen-collection-map__tab{{ $i === 0 ? ' is-active' : '' }}"
                                role="tab"
                                aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
                                data-country="{{ $country['code'] }}">
                                {{ $country['label'] }}
                            </button>
                        @endforeach
                    </div>

                    <div class="nen-collection-map__map-wrap" style="height:260px;min-height:260px">
                        <div id="nenCollectionMap" class="nen-collection-map__canvas" aria-hidden="false"></div>
                    </div>

                    <div class="nen-collection-map__panel">
                        @foreach ($collectionCountries as $i => $country)
                            <div class="nen-collection-map__country-panel{{ $i === 0 ? ' is-active' : '' }}"
                                data-country="{{ $country['code'] }}">
                                {{-- <div class="nen-collection-map__location-list" role="list">
                                    @foreach (($collectionPointsByCountry[$country['code']] ?? collect()) as $point)
                                        <button type="button"
                                            class="nen-collection-map__location-btn{{ $loop->first && $i === 0 ? ' is-active' : '' }}"
                                            data-slug="{{ $point->slug }}"
                                            role="listitem">
                                            {{ $point->name }}
                                        </button>
                                    @endforeach
                                </div> --}}
                                <div class="nen-collection-map__details-live" data-country="{{ $country['code'] }}" aria-live="polite"></div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="nen-collection-map__empty">
                        <img src="{{ asset('site/home/assets/tesrimonials-group2.png') }}" alt="" />
                    </div>
                @endif
                </div>
            </div>

            <div class="nen-about-section__bottom tesrimonials-col-bottom">
                {{-- <h2 class="tesrimonials-subtitle-key-milestones">{{ __('landing.milestones.key_milestones') }}</h2> --}}

                <div class="nen-about-nen__stats">
                    @foreach (__('landing.milestones.stats') as $stat)
                        <div class="nen-about-nen__stat">
                            <h3 class="nen-about-nen__stat-value">{{ $stat['value'] }}</h3>
                            <h4 class="nen-about-nen__stat-title">{{ $stat['title'] }}</h4>
                            <p class="nen-about-nen__stat-desc">{{ $stat['desc'] }}</p>
                        </div>
                    @endforeach
                </div>

                {{-- <h3 class="nen-about-nen__mission-title">{{ __('landing.milestones.mission_title') }}</h3> --}}
                <p class="text tesrimonials-text-bottom nen-about-nen__mission">
                    {{ __('landing.milestones.mission') }}
                </p>
            </div>
        </div>
    @endif

    @php
        $hasStudyAgencies = ($landing->show_trusted_agencies ?? true) && isset($trustedAgencies) && $trustedAgencies->count();
        $hasTranslationAgencies = ($landing->show_agencies ?? true) && isset($translationAgencies) && $translationAgencies->count();
    @endphp
    @if ($hasStudyAgencies || $hasTranslationAgencies)
        <div id="trusted-agencies" class="nen-agencies-group">
    @endif

    {{-- ===================== TRUSTED STUDY ABROAD AGENCIES ===================== --}}
    @if ($hasStudyAgencies)
        <div class="col16" id="study-agencies">
            <div class="col17">
                <div class="row-d row-top9">
                    <div class="row-col2">
                        {{-- <button class="btn-c row-btn hover-dark">{{ __('landing.agencies.trusted_badge') }}</button> --}}
                        <h2 class="row-subtitle">
                            {{ landing_get($landing, 'trusted_agencies_title') ?? __('landing.agencies.trusted_title') }}</h2>
                        <p class="text row-text-bottom">
                            {{ landing_get($landing, 'trusted_agencies_subtitle') ?? __('landing.agencies.trusted_subtitle') }}
                        </p>
                    </div>

                    <div class="row-row-right">
                        <div class="row-circle-black-left circle-black hover-bright" id="trustedAgencyPrev">
                            <img src="{{ asset('site/home/assets/row-circle-black/row-lucide-arrow.png') }}"
                                alt="{{ __('landing.agencies.prev') }}" />
                            <img src="{{ asset('site/home/assets/row-circle-black/row-img.png') }}" class="row-img2" />
                        </div>
                        <div class="row-circle-black-right circle-black hover-bright" id="trustedAgencyNext">
                            <img src="{{ asset('site/home/assets/row-circle-black/row-lucide-arrow.png') }}"
                                alt="{{ __('landing.agencies.next') }}" />
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
                                                class="card-whats-app" alt="{{ $agency->localized('name') }}" />
                                        @endif
                                        <div class="card-col-bottom">
                                            <p class="card-text3">{{ $agency->localized('name') }}</p>
                                            <div class="card-col">
                                                @if ($agency->localized('location'))
                                                    <div class="row-e row-top3 nen-agency-contact">
                                                        <img src="{{ asset('site/home/assets/row/row-location.png') }}"
                                                            class="row-smart-phone row-location" alt="Location" />
                                                        <p class="row-text3">{{ $agency->localized('location') }}</p>
                                                    </div>
                                                @endif
                                                @if ($agency->phone)
                                                    <div class="row-e row-bottom2 nen-agency-contact nen-agency-contact--phone">
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

    {{-- ===================== CERTIFIED TRANSLATION AGENCIES ===================== --}}
    @if ($hasTranslationAgencies)
        <div class="col12" id="translation-agencies">
            <div class="row-d row-top8">
                <div class="row-col2">
                    {{-- <button class="btn-c row-btn hover-dark">{{ __('landing.agencies.translation_badge') }}</button> --}}
                    <h2 class="row-subtitle">{{ landing_get($landing, 'agencies_title') ?? __('landing.agencies.translation_title') }}</h2>
                    <p class="text row-text-bottom">
                        {{ landing_get($landing, 'agencies_subtitle') ?? __('landing.agencies.translation_subtitle') }}
                    </p>
                </div>

                <div class="row-row-right">
                    <div class="row-circle-black-left circle-black hover-bright" id="transAgencyPrev">
                        <img src="{{ asset('site/home/assets/row-circle-black/row-lucide-arrow.png') }}"
                            alt="{{ __('landing.agencies.prev') }}" />
                        <img src="{{ asset('site/home/assets/row-circle-black/row-img.png') }}" class="row-img2" />
                    </div>
                    <div class="row-circle-black-right circle-black hover-bright" id="transAgencyNext">
                        <img src="{{ asset('site/home/assets/row-circle-black/row-lucide-arrow.png') }}"
                            alt="{{ __('landing.agencies.next') }}" />
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
                                    class="frame-img3 input" alt="{{ $agency->localized('name') }}" />
                                <div class="frame-col">
                                    <div class="frame-col-top">
                                        <p class="frame-text3">{{ $agency->localized('name') }}</p>
                                        <p class="frame-text4">{{ $agency->localized('service_description') }}</p>
                                    </div>
                                    <div class="frame-col-bottom">
                                        @if ($agency->localized('location'))
                                            <div class="row-e row-top2 nen-agency-contact">
                                                <img src="{{ asset('site/home/assets/row/row-location.png') }}"
                                                    class="row-smart-phone row-location" alt="Location" />
                                                <p class="row-text3">{{ $agency->localized('location') }}</p>
                                            </div>
                                        @endif
                                        @if ($agency->phone)
                                            <div class="row-e row-bottom1 nen-agency-contact nen-agency-contact--phone">
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

    @if ($hasStudyAgencies || $hasTranslationAgencies)
        </div>
    @endif

    {{-- ===================== FAQ ===================== --}}
    @if ($landing->show_faq ?? true)
        <div class="col18 section" id="faq">
            <div class="col19">
                <div class="column-c col-top5">
                    {{-- <button class="btn-a column-btn2 hover-dark">{{ __('landing.faq.badge') }}</button> --}}
                    <h2 class="column-subtitle3">{{ landing_get($landing, 'faq_title') ?? __('landing.faq.title') }}</h2>
                    <p class="column-text-bottom">{{ __('landing.faq.subtitle') }}</p>
                </div>

                @php
                    $allFaqs = ($faqs ?? collect())->values();
                @endphp

                <div class="row20 nen-faq-grid">
                    @foreach ($allFaqs->chunk(2) as $rowFaqs)
                        <div class="nen-faq-row">
                            @foreach ($rowFaqs as $faq)
                                <div class="nen-faq-item">
                                    <button class="btn-d faq-btn-d hover-zoom" data-faq="{{ $faq->id }}" type="button">
                                        <p class="btn-label">{{ $faq->localized('question') }}</p>
                                        <img src="{{ asset('site/home/assets/btn/btn-icon.png') }}"
                                            class="btn-icon-add btn-icon" alt="+" />
                                    </button>
                                    @if ($faq->localized('answer'))
                                        <div class="faq-answer" data-answer="{{ $faq->id }}">{{ $faq->localized('answer') }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- ===================== SUCCESS PARTNERS (UNIVERSITY LOGOS) ===================== --}}
    @if ($landing->show_university_logos ?? true)
        <div class="col20" id="success-partners">
            <button class="btn-a btn9 hover-dark">{{ landing_get($landing, 'university_logos_title') ?? __('landing.partners.success_badge') }}</button>

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
                            <img src="{{ $placeholder }}" class="mask-group" alt="{{ __('landing.partners.placeholder') }}" />
                        @endfor
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- ===================== FOOTER ===================== --}}
    @php
        $footerEmail = $landing->contact_email ?? 'admissions@nen-global.org';
        $footerPhoneLines = [
            ['lang' => 'EN', 'phone' => $landing->footer_phone ?? '+20 10 6160 0400'],
            ['lang' => 'AR', 'phone' => $landing->footer_phone ?? '+20 10 6160 0400'],
            ['lang' => 'RU', 'phone' => __('landing.footer.phone_ru')],
        ];
        $waNumber = preg_replace('/[^0-9]/', '', $footerPhoneLines[0]['phone']);
    @endphp
    <footer class="footer nen-foot">
        <div class="nen-foot__top">
            <div class="nen-foot__brand">
                <img src="{{ $nenLogo }}" class="nen-foot__logo" alt="NEN" />
                <p class="nen-foot__tagline">
                    {{ landing_get($landing, 'footer_tagline') ?? __('landing.footer.tagline') }}
                </p>
                <div class="nen-foot__socials">
                    <a href="{{ $landing->social_facebook ?? '#' }}"
                        class="nen-foot__social nen-foot__social--facebook" aria-label="Facebook"
                        target="_blank" rel="noopener">
                        <img src="{{ asset('site/home/assets/circle/circle-facebook.png') }}" alt="" />
                    </a>
                    <a href="{{ $landing->social_instagram ?? '#' }}"
                        class="nen-foot__social nen-foot__social--instagram" aria-label="Instagram"
                        target="_blank" rel="noopener">
                        <img src="{{ asset('site/home/assets/circle/circle-instagram.png') }}" alt="" />
                    </a>
                    <a href="{{ $landing->social_whatsapp ?? ('https://wa.me/' . $waNumber) }}"
                        class="nen-foot__social nen-foot__social--whatsapp" aria-label="WhatsApp"
                        target="_blank" rel="noopener">
                        <img src="{{ asset('site/home/assets/circle/circle-whatsapp.png') }}" alt="" />
                    </a>
                    <a href="{{ $landing->social_linkedin ?? '#' }}"
                        class="nen-foot__social nen-foot__social--linkedin" aria-label="LinkedIn"
                        target="_blank" rel="noopener">
                        <img src="{{ asset('site/home/assets/circle/circle-linkedin.png') }}" alt="" />
                    </a>
                    <a href="{{ $landing->social_youtube ?? '#' }}"
                        class="nen-foot__social nen-foot__social--youtube" aria-label="YouTube"
                        target="_blank" rel="noopener">
                        <img src="{{ asset('site/home/assets/circle/circle-youtube.png') }}" alt="" />
                    </a>
                </div>
            </div>

            <div class="nen-foot__col">
                <h4 class="nen-foot__heading">{{ __('landing.footer.important_links') }}</h4>
                <ul class="nen-foot__links">
                    <li><a href="https://studyin-uzbekistan.uz" target="_blank"
                            rel="noopener">{{ __('landing.footer.link_study_portal') }}</a></li>
                    <li><a href="https://edu.uz" target="_blank" rel="noopener">{{ __('landing.footer.link_ministry') }}</a></li>
                    <li><a href="#">{{ __('landing.footer.link_embassy') }}</a></li>
                </ul>
            </div>

            <div class="nen-foot__col">
                <h4 class="nen-foot__heading">{{ __('landing.footer.contact_us') }}</h4>
                <ul class="nen-foot__contacts">
                    <li class="nen-foot__contact">
                        <img class="nen-foot__cicon" src="{{ asset('site/home/assets/row/row-mail.png') }}" alt="" />
                        <a href="mailto:{{ $footerEmail }}">{{ $footerEmail }}</a>
                    </li>
                    @foreach ($footerPhoneLines as $line)
                        @php
                            $linePhone = $line['phone'];
                            $lineWaNumber = preg_replace('/[^0-9]/', '', $linePhone);
                        @endphp
                        <li class="nen-foot__contact nen-foot__contact--phone">
                            <span class="nen-foot__lang">
                                <i class="bi bi-headset" aria-hidden="true"></i>
                                <span class="nen-foot__lang-text">{{ $line['lang'] }}</span>
                            </span>
                            <a href="tel:{{ preg_replace('/\s+/', '', $linePhone) }}">{{ $linePhone }}</a>
                            <span class="nen-foot__chat">
                                <a href="https://wa.me/{{ $lineWaNumber }}" class="nen-foot__chat-link--whatsapp"
                                    aria-label="WhatsApp" target="_blank" rel="noopener">
                                    <img src="{{ asset('site/home/assets/row/row-whatsapp.png') }}" alt="" />
                                </a>
                                <a href="#" class="nen-foot__chat-link--telegram" aria-label="Telegram"
                                    target="_blank" rel="noopener">
                                    <img src="{{ asset('site/home/assets/circle-telegram/circle-telegram-img.png') }}"
                                        alt="" />
                                </a>
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="nen-foot__cta">
            <h2 class="nen-foot__cta-title">{{ __('landing.footer.cta_lead') }}<br><span>{{ __('landing.footer.cta_action') }}</span></h2>
        </div>

        <div class="nen-foot__bottom">
            <p class="nen-foot__copy">
                {{ landing_get($landing, 'footer_copyright') ?? __('landing.footer.copyright', ['year' => date('Y')]) }}
            </p>
            {{-- <div class="nen-foot__bottom-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div> --}}
        </div>
    </footer>

@endsection

@push('scripts')
    <script>
        (function() {
            /* ── Mobile nav toggle ── */
            const navBar = document.querySelector('#hero .row2');
            const navToggle = document.getElementById('nenNavToggle');
            const navLinks = document.getElementById('nenNavLinks');
            if (navBar && navToggle && navLinks) {
                navToggle.addEventListener('click', function() {
                    const open = navBar.classList.toggle('is-open');
                    navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                });
                navLinks.querySelectorAll('a').forEach(function(link) {
                    link.addEventListener('click', function() {
                        navBar.classList.remove('is-open');
                        navToggle.setAttribute('aria-expanded', 'false');
                    });
                });
            }

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
            langMenu && langMenu.querySelectorAll('[data-lang]').forEach(function(a) {
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
                    const rtl = document.documentElement.getAttribute('dir') === 'rtl';
                    const x = rtl ? offset : -offset;
                    inner.style.transform = 'translateX(' + x + 'px)';
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

            /* ── How It Works: drawer reveal cards (tap/keyboard) + staggered entrance ── */
            (function () {
                const group = document.querySelector('.nen-steps');
                if (!group) return;
                const steps = group.querySelectorAll('.nen-step');
                if (!steps.length) return;

                group.classList.add('nen-anim-ready');

                steps.forEach(function (step) {
                    step.addEventListener('click', function () {
                        const willOpen = !step.classList.contains('is-open');
                        steps.forEach(function (other) {
                            other.classList.remove('is-open');
                            other.setAttribute('aria-expanded', 'false');
                        });
                        if (willOpen) {
                            step.classList.add('is-open');
                            step.setAttribute('aria-expanded', 'true');
                        }
                    });
                    step.addEventListener('keydown', function (e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            step.click();
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
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" crossorigin=""></script>
    @if(!empty($collectionPointsJson))
    <script>
        (function() {
            const mapEl = document.getElementById('nenCollectionMap');
            const mapWrap = mapEl ? mapEl.closest('.nen-collection-map__map-wrap') : null;
            const mapPanel = document.querySelector('.nen-collection-map__panel');
            if (!mapEl || !mapWrap || !mapPanel || typeof L === 'undefined') return;

            const locations = @json($collectionPointsJson);
            const countries = @json(($collectionCountries ?? collect())->values());
            const detailLabels = {
                address: @json(__('landing.collection_points.address')),
                landline: @json(__('landing.collection_points.landline')),
                callCenter: @json(__('landing.collection_points.call_center')),
                email: @json(__('landing.collection_points.email')),
                schedule: @json(__('landing.collection_points.schedule')),
                openMaps: @json(__('landing.collection_points.open_maps')),
                share: @json(__('landing.collection_points.share')),
            };
            const slugs = Object.keys(locations);
            if (!slugs.length || !countries.length) return;

            const copiedLabel = @json(__('landing.collection_points.copied'));
            let map = null;
            let activeSlug = null;
            let mapSized = false;
            let resizeTimer = null;
            const markers = {};

            const pinSvgDefault = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 36" width="30" height="45" aria-hidden="true" focusable="false"><path fill="#017785" d="M12 0C5.373 0 0 5.373 0 12c0 8.25 12 24 12 24s12-15.75 12-24C24 5.373 18.627 0 12 0zm0 16.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9z"/></svg>';
            const pinSvgSelected = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 36" width="30" height="45" aria-hidden="true" focusable="false"><path fill="#0a5c66" d="M12 0C5.373 0 0 5.373 0 12c0 8.25 12 24 12 24s12-15.75 12-24C24 5.373 18.627 0 12 0zm0 16.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9z"/></svg>';

            function escapeHtml(value) {
                return String(value || '')
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;');
            }

            function phoneHref(value) {
                return 'tel:' + String(value || '').replace(/[^0-9+]/g, '');
            }

            function makePinIcon(selected) {
                return L.divIcon({
                    html: '<span class="nen-collection-marker__hit">' + (selected ? pinSvgSelected : pinSvgDefault) + '</span>',
                    className: 'nen-collection-marker' + (selected ? ' is-selected' : ''),
                    iconSize: [36, 48],
                    iconAnchor: [18, 48],
                    popupAnchor: [0, -42]
                });
            }

            function detailsHostForSlug(slug) {
                const loc = locations[slug];
                if (!loc) return null;
                const panel = document.querySelector('.nen-collection-map__country-panel[data-country="' + loc.countryCode + '"]');
                return panel ? panel.querySelector('.nen-collection-map__details-live') : null;
            }

            function buildDetailsHtml(loc) {
                let meta = '';
                if (loc.address) {
                    meta += '<li><strong>' + escapeHtml(detailLabels.address) + ':</strong> ' + escapeHtml(loc.address) + '</li>';
                }
                if (loc.landLine) {
                    meta += '<li><strong>' + escapeHtml(detailLabels.landline) + ':</strong> <a href="' + phoneHref(loc.landLine) + '">' + escapeHtml(loc.landLine) + '</a></li>';
                }
                if (loc.callCenter) {
                    meta += '<li><strong>' + escapeHtml(detailLabels.callCenter) + ':</strong> <a href="' + phoneHref(loc.callCenter) + '">' + escapeHtml(loc.callCenter) + '</a></li>';
                }
                if (loc.email) {
                    meta += '<li><strong>' + escapeHtml(detailLabels.email) + ':</strong> <a href="mailto:' + escapeHtml(loc.email) + '">' + escapeHtml(loc.email) + '</a></li>';
                }
                if (loc.schedule) {
                    meta += '<li><strong>' + escapeHtml(detailLabels.schedule) + ':</strong> ' + escapeHtml(loc.schedule) + '</li>';
                }

                return ''
                    + '<div class="nen-collection-map__details" data-slug="' + escapeHtml(loc.slug) + '">'
                    + '<h4 class="nen-collection-map__office">' + escapeHtml(loc.name) + '</h4>'
                    + '<ul class="nen-collection-map__meta">' + meta + '</ul>'
                    + '<div class="nen-collection-map__actions">'
                    + '<a href="' + escapeHtml(loc.mapUrl) + '" class="nen-collection-map__btn nen-collection-map__btn--maps" target="_blank" rel="noopener">'
                    + escapeHtml(detailLabels.openMaps)
                    + '</a>'
                    + '<button type="button" class="nen-collection-map__btn nen-collection-map__btn--share"'
                    + ' data-share-url="' + escapeHtml(loc.mapUrl) + '"'
                    + ' data-share-title="' + escapeHtml(loc.name) + '">'
                    + escapeHtml(detailLabels.share)
                    + '</button>'
                    + '</div>'
                    + '</div>';
            }

            function highlightMarker(slug) {
                slugs.forEach(function(entrySlug) {
                    const marker = markers[entrySlug];
                    if (!marker) return;
                    marker.setIcon(makePinIcon(entrySlug === slug));
                });
            }

            function highlightLocationBtn(slug) {
                document.querySelectorAll('.nen-collection-map__location-btn').forEach(function(btn) {
                    btn.classList.toggle('is-active', btn.dataset.slug === slug);
                });
            }

            function activateLocation(slug) {
                showLocation(slug);
            }

            function showLocation(slug) {
                const loc = locations[slug];
                const host = detailsHostForSlug(slug);
                if (!loc || !host) return;

                activeSlug = slug;
                host.innerHTML = buildDetailsHtml(loc);
                highlightMarker(slug);
                highlightLocationBtn(slug);
            }

            function activeCountryCode() {
                const activeTab = document.querySelector('.nen-collection-map__tab.is-active');
                return activeTab ? activeTab.dataset.country : null;
            }

            function nearestSlugFromLatLng(latlng, maxPx) {
                const countryCode = activeCountryCode();
                if (!countryCode || !map) return null;

                let closest = null;
                let closestDist = Infinity;
                const clickPoint = map.latLngToContainerPoint(latlng);

                slugs.forEach(function(slug) {
                    const loc = locations[slug];
                    if (loc.countryCode !== countryCode || !markers[slug] || !map.hasLayer(markers[slug])) {
                        return;
                    }

                    const markerPoint = map.latLngToContainerPoint(loc.coords);
                    const dist = clickPoint.distanceTo(markerPoint);
                    if (dist < closestDist) {
                        closestDist = dist;
                        closest = slug;
                    }
                });

                return closestDist <= (maxPx || 52) ? closest : null;
            }

            function fitActiveCountryBounds() {
                const countryCode = activeCountryCode();
                if (!countryCode || !map) return;

                const activeSlugs = countrySlugs(countryCode);
                if (!activeSlugs.length) return;

                const bounds = L.latLngBounds(activeSlugs.map(function(slug) {
                    return locations[slug].coords;
                }));
                map.fitBounds(bounds, { padding: [30, 30], animate: false, maxZoom: 14 });
            }

            function countrySlugs(countryCode) {
                return slugs.filter(function(slug) {
                    return locations[slug].countryCode === countryCode;
                });
            }

            function focusCountry(countryCode, preserveSelection) {
                if (!map) return;
                const activeSlugs = countrySlugs(countryCode);
                if (!activeSlugs.length) return;

                document.querySelectorAll('.nen-collection-map__tab').forEach(function(tab) {
                    const active = tab.dataset.country === countryCode;
                    tab.classList.toggle('is-active', active);
                    tab.setAttribute('aria-selected', active ? 'true' : 'false');
                });
                document.querySelectorAll('.nen-collection-map__country-panel').forEach(function(panel) {
                    panel.classList.toggle('is-active', panel.dataset.country === countryCode);
                });

                slugs.forEach(function(slug) {
                    if (!markers[slug]) return;
                    if (activeSlugs.indexOf(slug) === -1) {
                        map.removeLayer(markers[slug]);
                    } else if (!map.hasLayer(markers[slug])) {
                        markers[slug].addTo(map);
                    }
                });

                const bounds = L.latLngBounds(activeSlugs.map(function(slug) {
                    return locations[slug].coords;
                }));
                map.fitBounds(bounds, { padding: [30, 30], animate: false, maxZoom: 14 });

                const nextSlug = preserveSelection && activeSlug && activeSlugs.indexOf(activeSlug) !== -1
                    ? activeSlug
                    : activeSlugs[0];
                showLocation(nextSlug);
            }

            function refreshMapSize() {
                if (!map) return;
                map.invalidateSize(true);
                fitActiveCountryBounds();
            }

            async function handleShareClick(btn) {
                const url = btn.dataset.shareUrl;
                const title = btn.dataset.shareTitle || document.title;
                if (!url) return;

                if (navigator.share) {
                    try {
                        await navigator.share({ title: title, url: url });
                        return;
                    } catch (e) { /* fall through to copy */ }
                }

                try {
                    await navigator.clipboard.writeText(url);
                    const original = btn.textContent;
                    btn.textContent = copiedLabel;
                    setTimeout(function() { btn.textContent = original; }, 2000);
                } catch (e) {
                    window.open(url, '_blank', 'noopener');
                }
            }

            function bootMap() {
                if (map) return;

                map = L.map('nenCollectionMap', { scrollWheelZoom: false, tap: true });
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 18,
                    attribution: '&copy; OpenStreetMap'
                }).addTo(map);

                slugs.forEach(function(slug) {
                    const loc = locations[slug];
                    markers[slug] = L.marker(loc.coords, {
                        icon: makePinIcon(false),
                        interactive: true,
                        keyboard: true,
                        title: loc.name,
                        riseOnHover: true,
                        riseOffset: 1000
                    });
                    markers[slug].on('click', function(e) {
                        L.DomEvent.stopPropagation(e);
                        activateLocation(slug);
                    });
                });

                map.on('click', function(e) {
                    const slug = nearestSlugFromLatLng(e.latlng, 52);
                    if (slug) {
                        activateLocation(slug);
                    }
                });

                document.querySelectorAll('.nen-collection-map__tab').forEach(function(tab) {
                    tab.addEventListener('click', function() {
                        focusCountry(tab.dataset.country, false);
                    });
                });

                document.querySelectorAll('.nen-collection-map__location-btn').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        activateLocation(btn.dataset.slug);
                    });
                });

                mapPanel.addEventListener('click', function(e) {
                    const btn = e.target.closest('.nen-collection-map__btn--share');
                    if (btn) {
                        e.preventDefault();
                        handleShareClick(btn);
                    }
                });

                focusCountry(countries[0].code, false);
            }

            function startMap() {
                bootMap();
                if (!mapSized) {
                    refreshMapSize();
                    mapSized = true;
                    setTimeout(refreshMapSize, 200);
                    setTimeout(refreshMapSize, 700);
                }
            }

            window.addEventListener('load', startMap);
            window.addEventListener('resize', function() {
                if (!map) return;
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(refreshMapSize, 150);
            });
            window.addEventListener('orientationchange', function() {
                if (!map) return;
                setTimeout(refreshMapSize, 400);
            });

            if ('IntersectionObserver' in window) {
                let mapVisible = false;
                const mapObserver = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting && !mapVisible) {
                            mapVisible = true;
                            startMap();
                        }
                    });
                }, { threshold: 0.05 });
                mapObserver.observe(mapWrap);
            } else {
                startMap();
            }
        })();
    </script>
    @endif
@endpush
