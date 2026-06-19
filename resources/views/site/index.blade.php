@extends('site.layouts.app')

@section('body_class', 'nen-landing-body')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    body.nen-landing-body {
        margin: 0;
        padding: 0;
        background: var(--nl-bg);
    }
    body.nen-landing-body > header.header,
    body.nen-landing-body #footer.footer,
    body.nen-landing-body .floating-icons,
    body.nen-landing-body .s-soft,
    body.nen-landing-body #preloader { display: none !important; }

    :root {
        --nl-font: 'Roboto', sans-serif;
        --nl-bg: #F9F9F9;
        --nl-dark: #1A1C1E;
        --nl-mid: #444444;
        --nl-muted: #5E403D;
        --nl-accent: #CC1616;
        --nl-white: #FFFFFF;
        --nl-border: #DADADA;
        --nl-max: 1239px;
    }

    .nen-landing { font-family: var(--nl-font); background: var(--nl-bg); color: var(--nl-dark); overflow-x: hidden; }
    .nen-landing__container { max-width: var(--nl-max); margin: 0 auto; padding: 0 24px; }

    .nen-hero-wrap { position: relative; overflow: visible; }
    .nen-header {
        --nen-header-pad: 20px;
        position: absolute; top: 0; left: 0; right: 0; width: 100%; z-index: 20;
        box-sizing: border-box; overflow: visible;
        min-height: calc(52px + var(--nen-header-pad) * 2);
        padding: var(--nen-header-pad) 0;
        background: linear-gradient(180deg, rgba(0,0,0,.72) 0%, rgba(0,0,0,.65) 75%, rgba(0,0,0,.35) 100%) !important;
        transition: background .25s ease, box-shadow .25s ease;
    }
    .nen-header.nen-header--fixed {
        position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
    }
    .nen-header--scrolled {
        background: rgba(26,31,37,.97) !important;
        box-shadow: 0 8px 24px rgba(0,0,0,.15);
    }
    .nen-header__inner {
        display: flex; align-items: center; justify-content: space-between; gap: 1rem;
        min-height: 52px;
        max-width: 1440px; margin: 0 auto; padding: 0 24px;
        background: transparent !important;
    }
    .nen-header__logos { display: flex; align-items: center; gap: 16px; flex-shrink: 0; }
    .nen-header__logos a {
        display: block; background: transparent !important; line-height: 0; text-decoration: none;
    }
    .nen-header__logo-mark {
        display: flex; align-items: center; flex-shrink: 0;
        background: transparent !important; line-height: 0;
    }
    .nen-header__logo--nen {
        height: 52px; width: auto; display: block; margin: 0; padding: 0;
        border: 0 !important; object-fit: contain; object-position: left center;
        background: transparent !important; mix-blend-mode: screen;
    }
    .nen-header__logo--ets {
        height: 36px; width: auto; display: block; margin: 0; padding: 0;
        border: 0 !important; background: transparent !important;
    }
    .nen-header__nav { display: flex; gap: 2rem; list-style: none; margin: 0; padding: 0; }
    .nen-header__nav a { color: var(--nl-white) !important; text-decoration: none; font-size: 18px; font-weight: 500; }
    .nen-header a:not(.nen-header__register):not(.dropdown-item) { color: var(--nl-white); }
    .nen-header__actions { display: flex; align-items: center; gap: 1rem; }
    .nen-header__phone { color: var(--nl-white); font-size: 16px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
    .nen-header__register {
        background: var(--nl-accent); border: 0; color: var(--nl-white) !important;
        padding: 8px 20px; border-radius: 6px; font-size: 14px; font-weight: 500; text-decoration: none;
        display: inline-flex; align-items: center; gap: 6px; cursor: pointer;
    }
    .nen-register-switch { position: relative; }
    .nen-register-switch .dropdown-toggle::after { display: none; }
    .nen-register-switch .dropdown-menu {
        min-width: 200px;
        border-radius: 8px;
        border: 1px solid var(--nl-border);
        box-shadow: 0 8px 24px rgba(0, 0, 0, .12);
        padding: 6px 0;
        background: var(--nl-white);
    }
    .nen-register-switch .dropdown-item {
        font-size: 14px;
        padding: 8px 16px;
        display: flex;
        align-items: center;
        color: var(--nl-dark) !important;
    }
    .nen-register-switch .dropdown-item:hover,
    .nen-register-switch .dropdown-item:focus {
        color: var(--nl-dark) !important;
        background: #f5f5f5;
    }
    .nen-register-switch .dropdown-item .flag-icon {
        width: 1.1em;
        line-height: 1;
    }
    .nen-header__lang { color: var(--nl-white); font-size: 16px; }
    .nen-lang-switch { position: relative; }
    .nen-lang-switch__toggle {
        color: var(--nl-white) !important;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 10px;
        border: 1px solid rgba(255, 255, 255, .25);
        border-radius: 6px;
        background: rgba(255, 255, 255, .08);
        cursor: pointer;
        white-space: nowrap;
        line-height: 1;
    }
    .nen-lang-switch__toggle .flag-icon {
        width: 1.1em;
        line-height: 1;
    }
    .nen-lang-switch__toggle::after { display: none; }
    .nen-lang-switch .dropdown-menu {
        min-width: 160px;
        border-radius: 8px;
        border: 1px solid var(--nl-border);
        box-shadow: 0 8px 24px rgba(0, 0, 0, .12);
        padding: 6px 0;
        background: var(--nl-white);
    }
    .nen-lang-switch .dropdown-item {
        font-size: 14px;
        padding: 8px 16px;
        display: flex;
        align-items: center;
        color: var(--nl-dark) !important;
    }
    .nen-lang-switch .dropdown-item:hover,
    .nen-lang-switch .dropdown-item:focus {
        color: var(--nl-dark) !important;
        background: #f5f5f5;
    }
    .nen-header--scrolled .nen-lang-switch__toggle { color: var(--nl-white) !important; }

    .nen-hero-slider { position: relative; min-height: 772px; background: #1a1f25; }
    .nen-hero-swiper { width: 100%; height: 772px; }
    .nen-hero-swiper .swiper-slide { height: 772px; }
    .nen-hero-slide {
        height: 100%; display: flex; align-items: flex-end;
        background-size: cover; background-position: center; padding: 120px 0 100px;
        position: relative;
    }
    .nen-hero-slide::before {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(180deg, rgba(0,0,0,.35) 0%, rgba(0,0,0,.55) 100%);
    }
    .nen-hero__content { position: relative; z-index: 1; max-width: var(--nl-max); margin: 0 auto; padding: 0 24px; width: 100%; }
    .nen-hero__title { color: var(--nl-white); font-size: 32px; font-weight: 700; margin-bottom: .5rem; }
    .nen-hero__subtitle { color: #F9F9F9; font-size: 16px; font-weight: 500; margin-bottom: 1.5rem; max-width: 520px; }
    .nen-hero__btn {
        display: inline-block; background: #30363B; color: var(--nl-white);
        padding: 12px 28px; border-radius: 6px; font-size: 14px; font-weight: 500; text-decoration: none;
    }
    .nen-hero-swiper .swiper-button-prev,
    .nen-hero-swiper .swiper-button-next {
        color: var(--nl-white); width: 52px; height: 52px;
        margin-top: 0; transform: translateY(-50%);
        display: flex; align-items: center; justify-content: center;
        background: rgba(0,0,0,.35); border-radius: 50%;
        transition: background .2s ease;
    }
    .nen-hero-swiper .swiper-button-prev:hover,
    .nen-hero-swiper .swiper-button-next:hover { background: rgba(0,0,0,.55); }
    .nen-hero-swiper .swiper-button-prev::after,
    .nen-hero-swiper .swiper-button-next::after { display: none !important; }
    .nen-hero-swiper .swiper-button-prev svg,
    .nen-hero-swiper .swiper-button-next svg {
        width: 24px; height: 24px; display: block; pointer-events: none;
    }
    .nen-hero-swiper .swiper-button-prev { left: 24px; }
    .nen-hero-swiper .swiper-button-next { right: 24px; }
    .nen-hero-swiper .swiper-pagination { bottom: 32px; }
    .nen-hero-swiper .swiper-pagination-bullet {
        width: 8px; height: 8px; background: var(--nl-white); opacity: .45;
    }
    .nen-hero-swiper .swiper-pagination-bullet-active { opacity: 1; width: 10px; height: 10px; }

    .event-landing-countdown-bridge {
        position: relative;
        z-index: 12;
        margin-top: -6.25rem;
        margin-bottom: -6.25rem;
        pointer-events: none;
    }
    .event-landing-countdown-bridge .container {
        max-width: var(--nl-max);
        margin: 0 auto;
        padding: 0 24px;
        pointer-events: auto;
    }
    .event-landing-countdown-bridge__row {
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
        gap: 1.25rem;
    }
    .event-landing-countdown-card {
        background: var(--nl-white);
        border-radius: 16px;
        box-shadow: 0 0 7.7px rgba(0, 0, 0, 0.23);
        padding: 1rem 1.125rem 1.25rem;
        flex: 1 1 280px;
        max-width: 540px;
        width: min(100%, 540px);
    }
    .event-landing-countdown-card__label {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--nl-accent);
        margin-bottom: 0.85rem;
    }
    .event-landing-countdown-card__grid {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.65rem;
    }
    .event-landing-countdown-card__unit {
        text-align: center;
        flex: 1;
        background: #EFEFEF;
        border-radius: 8px;
        padding: 0.65rem 0.35rem;
        min-width: 72px;
    }
    .event-landing-countdown-card__value {
        display: block;
        font-size: 2rem;
        font-weight: 600;
        color: #444444;
        line-height: 1.4;
    }
    .event-landing-countdown-card__name {
        display: block;
        font-size: 0.95rem;
        font-weight: 500;
        text-transform: uppercase;
        color: #555555;
    }
    .event-landing-countdown-card__sep {
        font-size: 2rem;
        font-weight: 800;
        color: #7F7F7F;
        line-height: 1.4;
        flex-shrink: 0;
    }
    .event-landing-countdown-card--expired .event-landing-countdown-card__value {
        opacity: 0.45;
    }
    .nen-hero-wrap:has(.event-landing-countdown-bridge) + .nen-section#about {
        padding-top: 7rem;
    }

    .nen-section { padding: 80px 0; }
    .nen-section__title { font-size: 24px; font-weight: 500; color: #30363B; margin-bottom: .5rem; }
    .nen-section__subtitle { font-size: 18px; color: var(--nl-mid); margin-bottom: 2rem; }

    .nen-about { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: center; }
    .nen-about__label { font-size: 24px; font-weight: 500; color: var(--nl-dark); margin-bottom: 1rem; }
    .nen-about__title { font-size: 28px; font-weight: 500; line-height: 1.35; margin-bottom: 1.25rem; max-width: 520px; }
    .nen-about__text { font-size: 16px; color: var(--nl-mid); line-height: 1.65; margin-bottom: 0; }
    .nen-about__metrics { display: flex; gap: 16px; margin-top: 2rem; flex-wrap: wrap; }
    .nen-about__metric {
        flex: 1 1 200px; display: flex; align-items: center; gap: 14px;
        border: 1px solid var(--nl-border); border-radius: 12px; background: var(--nl-white);
        padding: 18px 20px; min-height: 88px;
    }
    .nen-about__metric-icon {
        width: 44px; height: 44px; border-radius: 50%; background: rgba(204, 22, 22, .1);
        color: var(--nl-accent); display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .nen-about__metric-value { font-size: 22px; font-weight: 600; color: var(--nl-dark); line-height: 1.2; }
    .nen-about__metric-label { font-size: 14px; color: var(--nl-mid); line-height: 1.3; }
    .nen-about__collage {
        position: relative; display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, .82fr);
        grid-template-rows: 200px 200px; gap: 16px; min-height: 416px;
    }
    .nen-about__collage img { width: 100%; height: 100%; object-fit: cover; border-radius: 16px; display: block; }
    .nen-about__img--main { grid-column: 1; grid-row: 1; }
    .nen-about__img--secondary { grid-column: 1; grid-row: 2; box-shadow: 0 0 6px rgba(0,0,0,.12); }
    .nen-about__img--side { grid-column: 2; grid-row: 1 / span 2; border-radius: 16px 16px 16px 0; }
    .nen-about__badge {
        position: absolute; left: 50%; top: 50%; transform: translate(-42%, -50%);
        background: var(--nl-accent); color: var(--nl-white); border-radius: 12px;
        padding: 22px 28px; min-width: 150px; text-align: center; z-index: 2;
        box-shadow: 0 8px 24px rgba(204, 22, 22, .28); overflow: hidden;
    }
    .nen-about__badge::before {
        content: ''; position: absolute; top: -18px; right: -18px; width: 64px; height: 64px;
        border: 2px solid rgba(255,255,255,.25); border-radius: 50%;
        box-shadow: 0 0 0 8px rgba(255,255,255,.08);
    }
    .nen-about__badge-value { display: block; font-size: 28px; font-weight: 600; line-height: 1.1; }
    .nen-about__badge-label { display: block; font-size: 14px; font-weight: 400; margin-top: 4px; }

    /* NEN events section */
    .nen-events-eyebrow {
        font-size: 12px;
        font-weight: 500;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--nl-accent);
        margin-bottom: .4rem;
    }
    .nen-events-explore {
        font-size: 14px;
        color: var(--nl-mid);
        margin: .25rem 0 1.75rem;
    }
    .nen-events-explore a {
        color: var(--nl-accent);
        text-decoration: none;
        font-weight: 500;
    }
    .nen-events-explore a:hover { text-decoration: underline; }
    .nen-events-row {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 20px;
        align-items: start;
    }
    .nen-ev-slider-wrap {
        position: relative;
        padding: 0 48px;
    }
    .nen-ev-arrow {
        position: absolute;
        top: 42%;
        transform: translateY(-50%);
        z-index: 3;
        width: 40px;
        height: 40px;
        margin: 0;
        padding: 0;
        border-radius: 50%;
        border: 1px solid var(--nl-border);
        background: var(--nl-white);
        color: var(--nl-dark);
        box-shadow: 0 2px 12px rgba(0, 0, 0, .1);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background .2s ease, border-color .2s ease, box-shadow .2s ease;
    }
    .nen-ev-arrow:hover {
        background: #f5f5f5;
        border-color: #ccc;
        box-shadow: 0 4px 16px rgba(0, 0, 0, .12);
    }
    .nen-ev-arrow svg {
        width: 20px;
        height: 20px;
        display: block;
        pointer-events: none;
    }
    .nen-ev-arrow--prev { left: 0; }
    .nen-ev-arrow--next { right: 0; }
    .nen-ev-card {
        background: var(--nl-white);
        border: 1px solid var(--nl-border);
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .nen-ev-card__media {
        position: relative;
        height: 240px;
        background: #1a1f25;
        overflow: hidden;
        flex-shrink: 0;
    }
    .nen-ev-card__media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .4s ease;
    }
    .nen-ev-card:hover .nen-ev-card__media img { transform: scale(1.03); }
    .nen-ev-card__live {
        position: absolute;
        top: 14px;
        left: 14px;
        background: rgba(204, 22, 22, .92);
        color: #fff;
        font-size: 11px;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 20px;
        letter-spacing: .04em;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .nen-ev-card__live-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #fff;
        animation: nen-pulse 1.4s ease-in-out infinite;
    }
    @keyframes nen-pulse {
        0%, 100% { opacity: 1; }
        50%       { opacity: .35; }
    }
    .nen-ev-card__date-pill {
        position: absolute;
        top: 14px;
        right: 14px;
        background: rgba(0, 0, 0, .55);
        color: #fff;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        backdrop-filter: blur(4px);
    }
    .nen-ev-card__body {
        padding: 20px 22px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .nen-ev-card__title {
        font-size: 17px;
        font-weight: 600;
        color: var(--nl-dark);
        line-height: 1.35;
        margin-bottom: 8px;
    }
    .nen-ev-card__desc {
        font-size: 13px;
        color: var(--nl-mid);
        line-height: 1.65;
        margin-bottom: 14px;
        flex: 1;
    }
    .nen-ev-card__loc {
        display: flex;
        align-items: flex-start;
        gap: 6px;
        width: 100%;
        font-size: 13px;
        color: var(--nl-mid);
        line-height: 1.5;
        margin-bottom: 14px;
    }
    .nen-ev-card__loc > svg {
        flex-shrink: 0;
        margin-top: 3px;
        color: var(--nl-mid);
    }
    .nen-ev-card__loc-text {
        flex: 1;
        min-width: 0;
    }
    .nen-ev-card__loc-sep {
        margin: 0 4px;
        color: #adb5bd;
    }
    .nen-ev-card__loc-country {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }
    .nen-ev-card__loc .flag-icon {
        width: 1.1em;
        line-height: 1;
        flex-shrink: 0;
    }
    .nen-ev-card__meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px 12px;
        font-size: 13px;
        color: var(--nl-mid);
        margin-bottom: 8px;
    }
    .nen-ev-card__meta .event-venue-badge {
        font-size: 11px;
        padding: 3px 8px;
    }
    .nen-ev-card__date-row {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: var(--nl-mid);
        margin-bottom: 10px;
    }
    body.nen-landing-body.modal-open .floating-icons,
    body.nen-landing-body.modal-open .s-soft {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }
    .nen-ev-card__actions { display: flex; gap: 10px; }
    .nen-ev-card__btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
        transition: opacity .15s ease;
    }
    .nen-ev-card__btn:hover { opacity: .85; }
    .nen-ev-card__btn--primary { background: #1A1C1E; color: #fff; border-color: #1A1C1E; }
    .nen-ev-card__btn--secondary { background: transparent; color: var(--nl-dark); border-color: var(--nl-border); }
    .nen-ev-dots {
        display: flex;
        gap: 8px;
        justify-content: center;
        margin-top: 18px;
        padding-bottom: 4px;
    }
    .nen-ev-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #D9D9D9;
        cursor: pointer;
        transition: background .2s ease, transform .2s ease;
        border: none;
        padding: 0;
    }
    .nen-ev-dot.is-active { background: var(--nl-accent); transform: scale(1.15); }
    .nen-cal-panel {
        background: var(--nl-white);
        border: 1px solid var(--nl-border);
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        flex-direction: column;
        gap: 14px;
        box-shadow: 0 0 8px rgba(0, 0, 0, .05);
    }
    .nen-cal__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .nen-cal__nav {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .nen-cal__nav-btn {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        border: 1px solid var(--nl-border);
        background: #f5f5f5;
        color: var(--nl-dark);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: background .15s;
    }
    .nen-cal__nav-btn:hover { background: #ebebeb; }
    .nen-cal__month-label {
        font-size: 15px;
        font-weight: 500;
        color: var(--nl-dark);
        min-width: 96px;
        text-align: center;
    }
    .nen-cal__today-btn {
        font-size: 12px;
        padding: 4px 12px;
        border-radius: 6px;
        border: 1px solid var(--nl-border);
        background: transparent;
        color: var(--nl-mid);
        cursor: pointer;
        transition: background .15s;
    }
    .nen-cal__today-btn:hover { background: #f3f3f3; }
    .nen-cal__grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
    }
    .nen-cal__dow {
        text-align: center;
        font-size: 11px;
        font-weight: 500;
        color: #aaa;
        padding: 4px 0 6px;
        letter-spacing: .04em;
        text-transform: uppercase;
    }
    .nen-cal__day {
        aspect-ratio: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-size: 13px;
        color: var(--nl-mid);
        cursor: default;
        position: relative;
        gap: 2px;
        transition: background .12s;
    }
    .nen-cal__day.is-other { color: #ccc; }
    .nen-cal__day.is-today {
        background: #1A1C1E;
        color: #fff;
        font-weight: 500;
    }
    .nen-cal__day.has-event { color: var(--nl-dark); font-weight: 500; cursor: pointer; }
    .nen-cal__day.has-event:hover { background: #f5f5f5; }
    .nen-cal__day.is-today:hover { background: #2d3035; }
    .nen-cal__event-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--nl-accent);
        flex-shrink: 0;
    }
    .nen-cal__day.is-today .nen-cal__event-dot { background: rgba(255, 255, 255, .7); }
    .nen-upcoming {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .nen-upcoming__label {
        font-size: 11px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: #aaa;
        padding-bottom: 8px;
        border-bottom: 1px solid var(--nl-border);
        margin-bottom: 2px;
    }
    .nen-upcoming__item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 10px;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        transition: background .12s;
        color: inherit;
    }
    .nen-upcoming__item:hover { background: #f5f5f5; }
    .nen-upcoming__stripe {
        width: 3px;
        min-height: 36px;
        border-radius: 2px;
        background: var(--nl-accent);
        flex-shrink: 0;
        align-self: stretch;
    }
    .nen-upcoming__stripe--alt { background: #30363B; }
    .nen-upcoming__name {
        font-size: 13px;
        font-weight: 500;
        color: var(--nl-dark);
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .nen-upcoming__meta {
        font-size: 11px;
        color: var(--nl-mid);
        margin-top: 2px;
        display: flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .nen-events-empty {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 360px;
        background: var(--nl-white);
        border: 1px solid var(--nl-border);
        border-radius: 16px;
        color: var(--nl-mid);
        font-size: 15px;
        padding: 24px;
        text-align: center;
    }

    .nen-archive-head {
        display: flex; align-items: flex-end; justify-content: space-between;
        gap: 24px; margin-bottom: 2rem; flex-wrap: wrap;
    }
    .nen-archive-head__text { flex: 1; min-width: 240px; }
    .nen-archive-head__text .nen-section__subtitle { margin-bottom: 0; }
    .nen-archive-head__actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
        flex-shrink: 0;
    }
    .nen-archive-request-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        color: var(--nl-dark);
        border: 1px solid var(--nl-border);
        padding: 12px 24px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s ease, border-color .15s ease;
    }
    .nen-archive-request-btn:hover {
        background: #f5f5f5;
        border-color: #ccc;
    }
    .nen-archive-btn {
        display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;
        background: var(--nl-accent); color: var(--nl-white);
        padding: 12px 24px; border-radius: 6px; font-size: 14px; font-weight: 600; text-decoration: none;
    }
    .nen-archive-list { display: flex; flex-direction: column; gap: 20px; }
    .nen-archive-card {
        display: flex; align-items: stretch; background: var(--nl-white); border-radius: 16px;
        overflow: hidden; box-shadow: 0 0 8px rgba(0,0,0,.08);
    }
    .nen-archive-card__media {
        position: relative; flex: 0 0 280px; width: 280px; height: 200px;
        background: #eee; overflow: hidden;
    }
    .nen-archive-card__media img {
        width: 100%; height: 100%; object-fit: cover; display: block;
        border-radius: 16px 0 0 16px;
    }
    .nen-archive-card__year {
        position: absolute; top: 12px; right: 12px;
        background: rgba(0,0,0,.55); color: var(--nl-white);
        padding: 4px 10px; border-radius: 6px; font-size: 13px; font-weight: 500;
    }
    .nen-archive-card__body {
        flex: 1; padding: 24px 28px; display: flex; flex-direction: column; justify-content: center;
    }
    .nen-archive-card__meta {
        display: flex; flex-wrap: wrap; align-items: center; gap: 16px 24px;
        margin-bottom: 12px; font-size: 14px; color: var(--nl-mid);
    }
    .nen-archive-card__meta-item {
        display: inline-flex; align-items: center; gap: 6px;
    }
    .nen-archive-card__meta-item svg { color: var(--nl-accent); flex-shrink: 0; }
    .nen-archive-card__title {
        font-size: 20px; font-weight: 600; color: #8B1515;
        margin-bottom: 8px; line-height: 1.35;
    }
    .nen-archive-card__desc {
        font-size: 15px; color: var(--nl-mid); line-height: 1.55; margin-bottom: 18px;
    }
    .nen-archive-card__btn {
        display: inline-flex; align-items: center; justify-content: center; align-self: flex-start;
        background: #1A1C1E; color: var(--nl-white); border: 0;
        padding: 10px 20px; border-radius: 6px; font-size: 14px; font-weight: 500;
        text-decoration: none; cursor: pointer;
    }
    .nen-archive-card__actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }
    .nen-archive-card__btn--request {
        background: transparent;
        color: var(--nl-dark);
        border: 1px solid var(--nl-border);
    }
    .nen-archive-card__btn--request:hover {
        background: #f5f5f5;
        border-color: #ccc;
    }

    .nen-event-request-modal__event {
        font-size: 15px;
        font-weight: 600;
        color: #8B1515;
        margin-bottom: 10px;
        line-height: 1.35;
    }
        border: 0;
        border-radius: 16px;
        overflow: hidden;
        font-family: var(--nl-font);
    }
    .nen-event-request-modal__header {
        border-bottom: 1px solid var(--nl-border);
        padding: 20px 24px;
    }
    .nen-event-request-modal__header .modal-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--nl-dark);
    }
    .nen-event-request-modal__body { padding: 20px 24px; }
    .nen-event-request-modal__intro {
        font-size: 14px;
        color: var(--nl-mid);
        line-height: 1.6;
        margin-bottom: 18px;
    }
    .nen-event-request-modal__field { margin-bottom: 16px; }
    .nen-event-request-modal__field label {
        display: block;
        font-size: 14px;
        color: var(--nl-mid);
        margin-bottom: 8px;
    }
    .nen-event-request-modal__field .form-control {
        border-radius: 8px;
        border-color: #ddd;
        padding: 12px 14px;
        font-size: 15px;
    }
    .nen-event-request-modal__field .form-control:focus {
        border-color: #bbb;
        box-shadow: none;
    }
    .nen-event-request-modal__footer {
        border-top: 1px solid var(--nl-border);
        padding: 16px 24px;
        gap: 10px;
    }
    .nen-event-request-modal__btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        border: 1px solid transparent;
        cursor: pointer;
    }
    .nen-event-request-modal__btn--primary {
        background: var(--nl-accent);
        color: var(--nl-white);
        border-color: var(--nl-accent);
    }
    .nen-event-request-modal__btn--secondary {
        background: transparent;
        color: var(--nl-dark);
        border-color: var(--nl-border);
    }
    .nen-event-request-modal__alert {
        background: #edf7ed;
        color: #1e4620;
        border: 1px solid #c8e6c9;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 16px;
        font-size: 14px;
    }
    .nen-event-request-modal__alert--error {
        background: #fdecea;
        color: #611a15;
        border-color: #f5c6cb;
    }
    .nen-archive-success {
        background: #edf7ed;
        color: #1e4620;
        border: 1px solid #c8e6c9;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .nen-partners { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 16px; }
    .nen-partner-card {
        display: flex; align-items: center; gap: 12px; padding: 24px;
        border: 1px solid var(--nl-border); border-radius: 12px; background: var(--nl-white);
    }
    .nen-partner-card__logo { width: 64px; height: 64px; object-fit: contain; flex-shrink: 0; }
    .nen-partner-card__name { font-size: 18px; color: #000; margin: 0; }

    .nen-faq { display: flex; flex-direction: column; gap: 12px; }
    .nen-faq__item { border: 1px solid var(--nl-border); border-radius: 8px; background: var(--nl-white); overflow: hidden; }
    .nen-faq__q {
        width: 100%; text-align: left; background: none; border: 0; padding: 18px 20px;
        font-size: 20px; font-weight: 400; cursor: pointer; display: flex; justify-content: space-between; align-items: center;
    }
    .nen-faq__a { padding: 0 20px 18px; font-size: 18px; color: #5E5E5E; display: none; }
    .nen-faq__item.is-open .nen-faq__a { display: block; }

    .nen-media {
        background: #1A1F25;
        padding: 72px 0;
        overflow: hidden;
    }
    .nen-media__header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }
    .nen-media__eyebrow {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--nl-accent);
        margin-bottom: 6px;
    }
    .nen-media__title {
        font-size: 24px;
        font-weight: 500;
        color: #fff;
        margin: 0;
        line-height: 1.3;
    }
    .nen-media__view-all {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: rgba(255, 255, 255, .55);
        text-decoration: none;
        border: 1px solid rgba(255, 255, 255, .15);
        padding: 8px 18px;
        border-radius: 8px;
        transition: border-color .2s ease, color .2s ease;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .nen-media__view-all:hover {
        color: #fff;
        border-color: rgba(255, 255, 255, .35);
    }
    .nen-media__grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr 1fr;
        grid-template-rows: 200px 200px;
        gap: 10px;
    }
    .nen-media__item {
        overflow: hidden;
        border-radius: 12px;
        position: relative;
        cursor: pointer;
        background: #2a3038;
    }
    .nen-media__item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .45s ease, filter .3s ease;
        filter: brightness(.85);
    }
    .nen-media__item:hover img {
        transform: scale(1.06);
        filter: brightness(1);
    }
    .nen-media__item::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, transparent 50%, rgba(0, 0, 0, .6) 100%);
        border-radius: 12px;
        opacity: 0;
        transition: opacity .3s ease;
        pointer-events: none;
    }
    .nen-media__item:hover::after { opacity: 1; }
    .nen-media__caption {
        position: absolute;
        bottom: 12px;
        left: 14px;
        right: 14px;
        font-size: 12px;
        color: rgba(255, 255, 255, .92);
        font-weight: 500;
        z-index: 2;
        opacity: 0;
        transform: translateY(4px);
        transition: opacity .3s ease, transform .3s ease;
        line-height: 1.4;
        pointer-events: none;
    }
    .nen-media__item:hover .nen-media__caption {
        opacity: 1;
        transform: translateY(0);
    }
    .nen-media__zoom {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(0, 0, 0, .45);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transform: scale(.8);
        transition: opacity .25s ease, transform .25s ease;
        z-index: 3;
        pointer-events: none;
    }
    .nen-media__item--center .nen-media__zoom {
        width: 40px;
        height: 40px;
    }
    .nen-media__item:hover .nen-media__zoom {
        opacity: 1;
        transform: scale(1);
    }
    .nen-media__item--left-top    { grid-column: 1; grid-row: 1; }
    .nen-media__item--left-bottom { grid-column: 1; grid-row: 2; }
    .nen-media__item--center      { grid-column: 2; grid-row: 1 / span 2; }
    .nen-media__item--right-top   { grid-column: 3; grid-row: 1; }
    .nen-media__item--right-bottom{ grid-column: 3; grid-row: 2; }
    .nen-media__footer {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 18px;
    }
    .nen-media__footer-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .22);
    }
    .nen-media__footer-dot--active { background: var(--nl-accent); }
    .nen-media__footer-count {
        font-size: 12px;
        color: rgba(255, 255, 255, .38);
        margin-left: 4px;
    }

    .nen-contact { display: grid; grid-template-columns: 1fr 1.15fr; gap: 48px; align-items: start; }
    .nen-contact__info-title { font-size: 24px; font-weight: 500; color: #30363B; margin-bottom: .5rem; }
    .nen-contact__info-desc { font-size: 16px; color: var(--nl-mid); line-height: 1.6; margin-bottom: 2rem; }
    .nen-contact__items { display: flex; flex-direction: column; gap: 20px; }
    .nen-contact__item { display: flex; align-items: flex-start; gap: 14px; }
    .nen-contact__icon {
        width: 44px; height: 44px; border-radius: 10px; background: rgba(204, 22, 22, .1);
        color: var(--nl-accent); display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .nen-contact__label { font-size: 14px; color: var(--nl-mid); margin-bottom: 2px; }
    .nen-contact__value { font-size: 16px; font-weight: 500; color: var(--nl-dark); text-decoration: none; }
    a.nen-contact__value:hover { color: var(--nl-accent); }
    .nen-contact__form-card {
        background: var(--nl-white); border: 1px solid var(--nl-border); border-radius: 16px;
        padding: 32px; box-shadow: 0 0 8px rgba(0,0,0,.04);
    }
    .nen-contact__field { margin-bottom: 18px; }
    .nen-contact__field label {
        display: block; font-size: 14px; color: var(--nl-mid); margin-bottom: 8px; font-weight: 400;
    }
    .nen-contact .form-control {
        border-radius: 8px; border-color: #ddd; padding: 12px 14px; font-size: 15px;
        width: 100%; background: var(--nl-white);
    }
    .nen-contact .form-control:focus { border-color: #bbb; box-shadow: none; }
    .nen-contact__btn {
        width: 100%; background: var(--nl-accent); color: var(--nl-white); border: 0;
        padding: 14px 32px; border-radius: 8px; font-size: 16px; font-weight: 500; margin-top: 6px;
    }
    .nen-contact__alert {
        background: #edf7ed; color: #1e4620; border: 1px solid #c8e6c9;
        border-radius: 8px; padding: 12px 16px; margin-bottom: 18px; font-size: 14px;
    }

    .nen-footer {
        background: #1A1F25; color: var(--nl-white); padding: 48px 0;
    }
    .nen-footer__inner { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem; }
    .nen-footer__copy { font-size: 18px; margin: 0; white-space: pre-line; }
    .nen-footer__link { color: var(--nl-white); font-size: 18px; text-decoration: none; }
    .nen-footer__phone { color: var(--nl-white); font-size: 16px; text-decoration: none; }

    @media (max-width: 991px) {
        .nen-header__nav { display: none; }
        .nen-about { grid-template-columns: 1fr; }
        .nen-about__collage { min-height: 360px; grid-template-rows: 160px 160px; }
        .nen-about__badge { transform: translate(-50%, -50%); padding: 18px 22px; }
        .nen-contact { grid-template-columns: 1fr; gap: 32px; }
        .nen-events-row { grid-template-columns: 1fr; }
        .nen-ev-slider-wrap { padding: 0 40px; }
        .nen-ev-arrow { width: 34px; height: 34px; }
        .nen-ev-arrow svg { width: 18px; height: 18px; }
        .nen-ev-card__media { height: 200px; }
        .nen-archive-head { align-items: flex-start; }
        .nen-archive-card { flex-direction: column; }
        .nen-archive-card__media { flex: none; width: 100%; height: 200px; }
        .nen-archive-card__media img { border-radius: 0; }
        .nen-media { padding: 48px 0; }
        .nen-media__grid {
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 180px 180px 180px;
            gap: 8px;
        }
        .nen-media__item--center {
            grid-column: 1 / -1;
            grid-row: 1;
        }
        .nen-media__item--left-top    { grid-column: 1; grid-row: 2; }
        .nen-media__item--left-bottom { grid-column: 2; grid-row: 2; }
        .nen-media__item--right-top   { grid-column: 1; grid-row: 3; }
        .nen-media__item--right-bottom{ grid-column: 2; grid-row: 3; }
        .event-landing-countdown-bridge {
            margin-top: -5rem;
            margin-bottom: -5rem;
        }
        .event-landing-countdown-card {
            max-width: 100%;
        }
    }

    @media (max-width: 575px) {
        .event-landing-countdown-bridge {
            margin-top: -2.5rem;
            margin-bottom: -2.5rem;
        }
        .event-landing-countdown-card__value {
            font-size: 1.5rem;
        }
        .event-landing-countdown-card__sep {
            font-size: 1.5rem;
        }
        .event-landing-countdown-card__unit {
            min-width: 58px;
            padding: 0.5rem 0.25rem;
        }
        .nen-media__grid {
            grid-template-rows: 140px 140px 140px;
        }
        .nen-media__title { font-size: 20px; }
    }
</style>
@endpush

@section('content')
<div class="nen-landing">
    <div class="nen-hero-wrap">
        <header class="nen-header" id="nenHeader">
            <div class="nen-header__inner">
                <div class="nen-header__logos">
                    <a href="{{ route('site.index') }}" class="nen-header__logo-mark">
                        <img src="{{ asset('site/images/nen-landing/logo.png') }}" alt="NEN" class="nen-header__logo--nen">
                    </a>
                    {{-- <img src="{{ asset('assets/ets-white.svg') }}" alt="ETS" class="nen-header__logo--ets"> --}}
                </div>
                <ul class="nen-header__nav">
                    <li><a href="{{ $landing->nav_about_url }}">About</a></li>
                    <li><a href="{{ $landing->nav_events_url }}">Events</a></li>
                    <li><a href="{{ $landing->nav_partners_url }}">Partners</a></li>
                    <li><a href="{{ $landing->nav_contact_url }}">Contact Us</a></li>
                    <li><a href="#media">Gallery</a></li>
                </ul>
                <div class="nen-header__actions">
                    {{-- <a href="tel:{{ preg_replace('/\s+/', '', $landing->footer_phone) }}" class="nen-header__phone">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24 11.36 11.36 0 003.56.57 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1 11.36 11.36 0 00.57 3.56 1 1 0 01-.25 1.01l-2.2 2.22z"/></svg>
                        {{ $landing->footer_phone }}
                    </a> --}}
                    @if (!empty($countries))
                        <div class="dropdown nen-register-switch">
                            <a href="#"
                               class="dropdown-toggle nen-header__register"
                               id="nenRegisterDropdown"
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                {{ $landing->header_register_text }}
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 14l5-5 5 5H7z"/></svg>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nenRegisterDropdown">
                                @foreach ($countries as $code => $country)
                                    <li>
                                        <a class="dropdown-item" target="_blank" rel="noopener noreferrer" href="{{ $country['url'] }}">
                                            <span class="flag-icon {{ $country['flag_icon'] }} me-2"></span>
                                            {{ ucfirst($country['name']) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <a href="{{ $landing->header_register_url }}" class="nen-header__register">
                            {{ $landing->header_register_text }}
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 14l5-5 5 5H7z"/></svg>
                        </a>
                    @endif
                    @include('site.partials.language-switcher', ['switcherId' => 'nenLanguageDropdown'])
                </div>
            </div>
        </header>

        <section class="nen-hero-slider">
        <div class="swiper nen-hero-swiper">
            <div class="swiper-wrapper">
                @foreach($heroSlides as $slide)
                    <div class="swiper-slide">
                        <div class="nen-hero-slide" @if($slide->image) style="background-image: url('{{ asset($slide->image) }}')" @endif>
                            <div class="nen-hero__content">
                                <h1 class="nen-hero__title">{{ $slide->title }}</h1>
                                @if($slide->subtitle)
                                    <p class="nen-hero__subtitle">{{ $slide->subtitle }}</p>
                                @endif
                                @if($slide->btn_text)
                                    <a href="{{ $slide->btn_url ?: '#' }}" class="nen-hero__btn">{{ $slide->btn_text }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if($heroSlides->count() > 1)
                <div class="swiper-button-prev" aria-label="Previous slide">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
                </div>
                <div class="swiper-button-next" aria-label="Next slide">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
                </div>
                <div class="swiper-pagination"></div>
            @endif
        </div>
        </section>

        @if(!empty($featuredEvent))
            @include('site.helpers.event-landing-countdown', ['event' => $featuredEvent])
        @endif
    </div>

    <section class="nen-section" id="about">
        <div class="nen-landing__container">
            @php
                $aboutFallback = asset('site/images/nen-landing/hero-bg.png');
                $aboutMain = $landing->about_image_main ?: $landing->about_image;
                $aboutSecondary = $landing->about_image_secondary ?: $landing->about_image;
                $aboutSide = $landing->about_image_side ?: $landing->about_image;
            @endphp
            <div class="nen-about">
                <div class="nen-about__content">
                    <div class="nen-about__label">{{ $landing->about_label }}</div>
                    <h2 class="nen-about__title">{{ $landing->about_title }}</h2>
                    <p class="nen-about__text">{!! nl2br(e($landing->about_description)) !!}</p>
                    <div class="nen-about__metrics">
                        @if($landing->about_metric1_value)
                            <div class="nen-about__metric">
                                <span class="nen-about__metric-icon" aria-hidden="true">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                                </span>
                                <div>
                                    <div class="nen-about__metric-value">{{ $landing->about_metric1_value }}</div>
                                    <div class="nen-about__metric-label">{{ $landing->about_metric1_label }}</div>
                                </div>
                            </div>
                        @endif
                        @if($landing->about_metric2_value)
                            <div class="nen-about__metric">
                                <span class="nen-about__metric-icon" aria-hidden="true">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
                                </span>
                                <div>
                                    <div class="nen-about__metric-value">{{ $landing->about_metric2_value }}</div>
                                    <div class="nen-about__metric-label">{{ $landing->about_metric2_label }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="nen-about__collage">
                    <img src="{{ $aboutMain ? asset($aboutMain) : $aboutFallback }}"
                         alt="" class="nen-about__img--main" loading="lazy">
                    <img src="{{ $aboutSecondary ? asset($aboutSecondary) : $aboutFallback }}"
                         alt="" class="nen-about__img--secondary" loading="lazy">
                    <img src="{{ $aboutSide ? asset($aboutSide) : $aboutFallback }}"
                         alt="" class="nen-about__img--side" loading="lazy">
                    @if($landing->about_stat_value)
                        <div class="nen-about__badge">
                            <span class="nen-about__badge-value">{{ $landing->about_stat_value }}</span>
                            <span class="nen-about__badge-label">{{ $landing->about_stat_label }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @include('site.helpers.nen-events-section')

    <section class="nen-section" id="archive">
        <div class="nen-landing__container">
            <div class="nen-archive-head">
                <div class="nen-archive-head__text">
                    <h2 class="nen-section__title">{{ $landing->archive_title }}</h2>
                    <p class="nen-section__subtitle">{{ $landing->archive_subtitle }}</p>
                </div>
                <div class="nen-archive-head__actions">
                    <a href="{{ $landing->archive_btn_url }}" class="nen-archive-btn">{{ $landing->archive_btn_text }}</a>
                </div>
            </div>
            @if(session('event_request_success'))
                <div class="nen-archive-success">{{ session('event_request_success') }}</div>
            @endif
            @if($archiveEvents->isNotEmpty())
                <div class="nen-archive-list">
                    @foreach($archiveEvents as $event)
                        @include('site.helpers.nen-archive-event-card', ['event' => $event])
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    @include('site.helpers.nen-event-request-modal')

    <section class="nen-section" id="partners">
        <div class="nen-landing__container">
            <h2 class="nen-section__title">{{ $landing->partners_title }}</h2>
            <div class="nen-partners mt-4">
                @foreach($partners as $partner)
                    <div class="nen-partner-card">
                        @if($partner->image)
                            <img src="{{ asset($partner->image) }}" alt="{{ $partner->name }}" class="nen-partner-card__logo" loading="lazy">
                        @else
                            <div class="nen-partner-card__logo bg-light rounded"></div>
                        @endif
                        <p class="nen-partner-card__name">{{ $partner->description ?: $partner->name }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    @include('site.helpers.nen-media-gallery')

    
    <section class="nen-section" id="faq">
        <div class="nen-landing__container">
            <h2 class="nen-section__title">{{ $landing->faq_title }}</h2>
            <div class="nen-faq mt-4">
                @foreach($faqs as $faq)
                    <div class="nen-faq__item">
                        <button type="button" class="nen-faq__q" onclick="this.parentElement.classList.toggle('is-open')">
                            <span>{{ $faq->question }}</span>
                            <i class="bi bi-chevron-down"></i>
                        </button>
                        @if($faq->answer)
                            <div class="nen-faq__a">{!! nl2br(e($faq->answer)) !!}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="nen-section" id="contact">
        <div class="nen-landing__container">
            <div class="nen-contact">
                <div class="nen-contact__info">
                    <h2 class="nen-contact__info-title">{{ $landing->contact_title }}</h2>
                    <p class="nen-contact__info-desc">{{ $landing->contact_description }}</p>
                    {{-- <div class="nen-contact__items">
                        @if($landing->footer_phone)
                            <div class="nen-contact__item">
                                <span class="nen-contact__icon" aria-hidden="true">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24 11.36 11.36 0 003.56.57 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1 11.36 11.36 0 00.57 3.56 1 1 0 01-.25 1.01l-2.2 2.22z"/></svg>
                                </span>
                                <div>
                                    <div class="nen-contact__label">Call us</div>
                                    <a href="tel:{{ preg_replace('/\s+/', '', $landing->footer_phone) }}" class="nen-contact__value">{{ $landing->footer_phone }}</a>
                                </div>
                            </div>
                        @endif
                        @if($landing->contact_email)
                            <div class="nen-contact__item">
                                <span class="nen-contact__icon" aria-hidden="true">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                                </span>
                                <div>
                                    <div class="nen-contact__label">E-mail</div>
                                    <a href="mailto:{{ $landing->contact_email }}" class="nen-contact__value">{{ $landing->contact_email }}</a>
                                </div>
                            </div>
                        @endif
                        @if($landing->contact_headquarters)
                            <div class="nen-contact__item">
                                <span class="nen-contact__icon" aria-hidden="true">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg>
                                </span>
                                <div>
                                    <div class="nen-contact__label">Headquarters</div>
                                    <div class="nen-contact__value">{{ $landing->contact_headquarters }}</div>
                                </div>
                            </div>
                        @endif
                    </div> --}}
                </div>
                <div class="nen-contact__form-card">
                    @if(session('success'))
                        <div class="nen-contact__alert">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('site.contact') }}" method="post">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="nen-contact__field">
                                    <label for="contact-phone">Phone number</label>
                                    <input type="tel" id="contact-phone" name="phone" class="form-control" placeholder="+998" value="{{ old('phone') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="nen-contact__field">
                                    <label for="contact-name">Full Name</label>
                                    <input type="text" id="contact-name" name="name" class="form-control" placeholder="Enter name" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="nen-contact__field">
                                    <label for="contact-email">E-mail</label>
                                    <input type="email" id="contact-email" name="email" class="form-control" placeholder="example@mail.com" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="nen-contact__field">
                                    <label for="contact-message">Event Contact Reason</label>
                                    <textarea id="contact-message" name="message" class="form-control" rows="4" placeholder="Please specify your reason for contacting us about the event" required>{{ old('message') }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="nen-contact__btn">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="nen-footer">
        <div class="nen-landing__container nen-footer__inner">
            <p class="nen-footer__copy">{{ $landing->footer_copyright }}</p>
            {{-- <a href="{{ $landing->footer_collaboration_url }}" class="nen-footer__link" target="_blank">{{ $landing->footer_collaboration_text }}</a> --}}
            {{-- <div>
                <span class="nen-footer__phone">Question? Call us</span><br>
                <a href="tel:{{ preg_replace('/\s+/', '', $landing->footer_phone) }}" class="nen-footer__phone">{{ $landing->footer_phone }}</a>
            </div> --}}
        </div>
    </footer>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof Swiper !== 'undefined') {
            var heroEl = document.querySelector('.nen-hero-swiper');
            if (heroEl) {
                new Swiper(heroEl, {
                    loop: {{ $heroSlides->count() > 1 ? 'true' : 'false' }},
                    autoplay: {{ $heroSlides->count() > 1 ? '{ delay: 6000, disableOnInteraction: false }' : 'false' }},
                    pagination: { el: '.nen-hero-swiper .swiper-pagination', clickable: true },
                    navigation: {
                        nextEl: '.nen-hero-swiper .swiper-button-next',
                        prevEl: '.nen-hero-swiper .swiper-button-prev',
                    },
                });
            }
        }

        var nenHeader = document.getElementById('nenHeader');
        var heroWrap = document.querySelector('.nen-hero-wrap');
        function updateNenHeader() {
            if (!nenHeader) return;
            var scrolled = window.scrollY > 40;
            nenHeader.classList.toggle('nen-header--scrolled', scrolled);
            nenHeader.classList.toggle('nen-header--fixed', scrolled);
        }
        updateNenHeader();
        window.addEventListener('scroll', updateNenHeader, { passive: true });

        document.querySelectorAll('[data-event-countdown]:not([data-event-countdown-init])').forEach(function (counter) {
            counter.setAttribute('data-event-countdown-init', '1');
            var target = new Date(counter.getAttribute('data-date')).getTime();
            if (Number.isNaN(target)) {
                return;
            }

            var daysEl = counter.querySelector('.days');
            var hoursEl = counter.querySelector('.hours');
            var minutesEl = counter.querySelector('.minutes');
            var secondsEl = counter.querySelector('.seconds');

            function pad(n) {
                return String(n).padStart(2, '0');
            }

            function tick() {
                var distance = target - Date.now();
                if (distance < 0) {
                    counter.classList.add('event-landing-countdown-card--expired');
                    if (daysEl) daysEl.textContent = '00';
                    if (hoursEl) hoursEl.textContent = '00';
                    if (minutesEl) minutesEl.textContent = '00';
                    if (secondsEl) secondsEl.textContent = '00';
                    return;
                }
                var days = Math.floor(distance / 86400000);
                var hours = Math.floor((distance % 86400000) / 3600000);
                var minutes = Math.floor((distance % 3600000) / 60000);
                var seconds = Math.floor((distance % 60000) / 1000);
                if (daysEl) daysEl.textContent = pad(days);
                if (hoursEl) hoursEl.textContent = pad(hours);
                if (minutesEl) minutesEl.textContent = pad(minutes);
                if (secondsEl) secondsEl.textContent = pad(seconds);
            }

            tick();
            setInterval(tick, 1000);
        });
    });
</script>
@endpush
