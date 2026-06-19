@extends('site.layouts.app')

@include('site.assets')

@section('body_class', 'event-landing-body')

@push('styles')
    <style>
        body.event-landing-body > header.header {
            display: none !important;
        }

        body.event-landing-body #footer.footer,
        body.event-landing-body .floating-icons,
        body.event-landing-body .s-soft,
        body.event-landing-body .scroll-top {
            display: none !important;
        }

        body.event-landing-body {
            scroll-padding-top: 100px;
        }

        :root {
            --el-font-family: 'Roboto', sans-serif;
            --el-bg: #F9F9F9;
            --el-text-dark: #1D1D1D;
            --el-text-mid: #444444;
            --el-text-light: #E4E4E4;
            --el-accent: #CC1616;
            --el-accent-dark: #B31111;
            --el-white: #FFFFFF;
            --el-card-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.16);
        }

        .event-landing-page {
            overflow-x: hidden;
            background: var(--el-bg);
            font-family: var(--el-font-family);
        }

        .event-landing-header {
            position: fixed !important;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 9999;
            padding: 1rem 0;
            background: linear-gradient(180deg, rgba(13, 17, 23, 0.9) 0%, rgba(13, 17, 23, 0) 100%);
            transition: background-color 0.2s ease, box-shadow 0.2s ease;
        }

        .event-landing-header--scrolled {
            background: rgba(26, 31, 37, 0.95);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .event-landing-header__inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            max-width: 1320px;
        }

        .event-landing-header__brand {
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
            text-decoration: none;
            flex-shrink: 0;
        }

        .event-landing-header__logo {
            display: block;
            width: auto;
            object-fit: contain;
            flex-shrink: 0;
        }

        .event-landing-header__logo--nen {
            width: 96px;
            height: 40px;
            filter: brightness(0) invert(1);
        }

        .event-landing-header__logo--ets {
            height: 75px;
            width: auto;
            margin-left: 0.1rem;
            transform: translateY(1px);
        }

        .event-landing-header__nav {
            display: inline-flex;
            align-items: center;
            gap: 2rem;
        }

        .event-landing-header__nav-link {
            color: var(--el-white);
            font-family: 'Roboto', sans-serif;
            font-size: 1.125rem;
            text-decoration: none;
            transition: opacity 0.2s ease;
        }

        .event-landing-header__nav-link:hover {
            color: var(--el-white);
            opacity: 0.85;
        }

        .event-landing-header__actions {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            flex-shrink: 0;
        }

        .event-landing-header__phone {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            color: var(--el-white);
            font-family: 'Roboto', sans-serif;
            font-size: 1rem;
            text-decoration: none;
        }

        .event-landing-header__phone:hover {
            color: var(--el-white);
            opacity: 0.85;
        }

        .event-landing-header__register {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            border-radius: 26px;
            background: var(--el-accent);
            color: var(--el-white);
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.65rem 1.25rem;
            box-shadow: 0px 4px 4px 0px rgba(50, 50, 50, 0.16);
        }

        .event-landing-header__register:hover {
            background: var(--el-accent-dark);
            color: var(--el-white);
        }

        .event-landing-header__lang {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            color: var(--el-white);
            font-family: 'Roboto', sans-serif;
            font-size: 1rem;
        }

        .event-landing-header__lang a {
            color: inherit;
            text-decoration: none;
        }

        .event-landing-header__lang a:hover {
            color: inherit;
            opacity: 0.85;
        }

        .event-landing-hero.section {
            position: relative;
            padding: 8rem 0 5.5rem;
            overflow: visible;
            min-height: 760px;
            background: #2F363C;
            scroll-margin-top: 96px;
        }

        .event-landing-hero__bg {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .event-landing-hero__bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 25% center;
            opacity: 0.58;
            mix-blend-mode: normal;
        }

        .event-landing-hero__bg::after {
            content: "";
            position: absolute;
            inset: 0 0 0 auto;
            width: 32%;
            background: linear-gradient(270deg, rgba(26, 31, 37, 0.85) 0%, rgba(26, 31, 37, 0.55) 55%, rgba(26, 31, 37, 0) 100%);
            pointer-events: none;
        }

        .event-landing-hero__container {
            position: relative;
            z-index: 2;
        }

        @media (min-width: 992px) {
            .event-landing-hero__container {
                padding-right: 12.5rem;
            }
        }

        .event-landing-hero__title {
            font-family: 'Roboto', sans-serif;
            font-weight: 500;
            font-size: clamp(2rem, 4.2vw, 3.75rem);
            color: var(--el-white);
            line-height: 1.4;
            margin-bottom: 1rem;
        }

        .event-landing-hero__title-highlight {
            color: #FA1B1B;
        }

        .event-landing-hero__lead {
            color: #E4E4E4;
            font-size: 1.25rem;
            font-weight: 400;
            font-family: 'Roboto', sans-serif;
            line-height: 1.4;
            max-width: 32rem;
            margin-bottom: 1.75rem;
        }

        .event-landing-hero__meta {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1.75rem;
        }

        .event-landing-hero__meta li {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            color: var(--el-white);
            font-weight: 400;
            font-size: 1rem;
            line-height: 1.4;
            font-family: 'Roboto', sans-serif;
        }

        .event-landing-hero__meta li span {
            padding-top: 0.1rem;
        }

        .event-landing-hero__meta i {
            color: var(--el-white);
            font-size: 1.125rem;
            width: 20px;
            flex-shrink: 0;
            text-align: center;
            margin-top: 0.15rem;
            opacity: 1;
        }

        .event-landing-hero__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .event-landing-hero__btn {
            border-radius: 26px;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .event-landing-hero__btn--primary {
            background: var(--el-accent);
            border-color: var(--el-accent);
            color: var(--el-white);
            box-shadow: 0px 4px 4px 0px rgba(50, 50, 50, 0.16);
        }

        .event-landing-hero__btn--primary:hover {
            background: #a81111;
            border-color: #a81111;
            color: var(--el-white);
        }

        .event-landing-hero__btn--secondary {
            background: var(--el-white);
            border: 1px solid var(--el-accent);
            color: var(--el-accent);
            box-shadow: 0px 4px 4px 0px rgba(50, 50, 50, 0.16);
        }

        .event-landing-hero__btn--secondary:hover {
            background: #fff5f5;
            color: var(--el-accent-dark);
            border-color: var(--el-accent-dark);
        }

        .event-landing-countdown-bridge {
            position: relative;
            z-index: 12;
            margin-top: -6.25rem;
            margin-bottom: -6.25rem;
            pointer-events: none;
        }

        .event-landing-countdown-bridge .container {
            pointer-events: auto;
        }

        .event-landing-countdown-bridge__row {
            display: flex;
            flex-wrap: wrap;
            align-items: stretch;
            gap: 1.25rem;
        }

        .event-landing-countdown-card {
            background: var(--el-white);
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
            font-family: 'Roboto', sans-serif;
            color: var(--el-accent);
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
            font-family: 'Roboto', sans-serif;
            color: #444444;
            line-height: 1.4;
        }

        .event-landing-countdown-card__name {
            display: block;
            font-size: 0.95rem;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            text-transform: uppercase;
            color: #555555;
        }

        .event-landing-countdown-card__sep {
            font-size: 2rem;
            font-weight: 800;
            font-family: 'Roboto', sans-serif;
            color: #7F7F7F;
            line-height: 1.4;
            flex-shrink: 0;
        }

        .event-landing-countdown-card--expired .event-landing-countdown-card__value {
            opacity: 0.45;
        }

        /* QR: scrolls with hero, anchored to viewport right edge so it doesn't sit on top of the hero artwork */
        .event-landing-hero__qr-wrap {
            position: absolute;
            top: 7.5rem;
            right: 1.25rem;
            z-index: 6;
            width: 168px;
        }

        /* Social rail: fixed, follows the viewport on scroll, vertically below where the QR sits */
        .event-landing-page-rail {
            position: fixed;
            top: 26rem;
            right: 1.25rem;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            pointer-events: none;
        }

        .event-landing-page-rail > * {
            pointer-events: auto;
        }

        .event-landing-page-rail__social {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin: 0;
            padding: 0;
        }

        .event-landing-page-rail .floating-icon {
            width: 50px;
            height: 50px;
        }

        .event-landing-page-rail .floating-icon i {
            font-size: 24px;
            color: #fff;
        }

        .event-landing-hero__qr-card {
            background: var(--el-white);
            border-radius: 12px;
            box-shadow: 0px 0px 7.7px 0px rgba(0, 0, 0, 0.23);
            border: 1px solid #e8ecf0;
            padding: 1.125rem 1rem 1.2rem;
            text-align: center;
            width: 100%;
        }

        .event-landing-hero__qr-title {
            font-size: 0.875rem;
            font-weight: 400;
            font-family: 'Roboto', sans-serif;
            color: #444444;
            margin-bottom: 0.75rem;
            line-height: 1.3;
        }

        .event-landing-hero__qr-image {
            width: 100%;
            height: auto;
            display: block;
            max-width: 123px;
            margin: 0 auto;
        }

        .event-landing-hero__qr-foot {
            font-size: 0.95rem;
            font-weight: 400;
            font-family: 'Roboto', sans-serif;
            color: #444444;
            margin: 0.8rem 0 0;
            line-height: 1.3;
        }

        @media (max-width: 991.98px) {
            .event-landing-header {
                padding: 0.75rem 0;
                background: rgba(26, 31, 37, 0.95);
            }

            .event-landing-header__logo--nen {
                width: 82px;
                height: 34px;
            }

            .event-landing-header__logo--ets {
                height: 74px;
                width: auto;
                max-height: 74px;
                transform: none;
            }

            .event-landing-header__nav,
            .event-landing-header__phone span {
                display: none;
            }

            .event-landing-header__actions {
                gap: 0.5rem;
            }

            .event-landing-header__register {
                padding: 0.55rem 1rem;
                font-size: 0.85rem;
            }

            .event-landing-header__lang {
                font-size: 0.9rem;
            }

            .event-landing-hero.section {
                padding-top: 6.5rem;
                padding-bottom: 5rem;
            }

            .event-landing-countdown-bridge {
                margin-top: -5rem;
                margin-bottom: -5rem;
            }

            .event-landing-countdown-card {
                max-width: 100%;
            }

            .event-landing-about {
                padding-top: 6.5rem;
            }

            .event-landing-hero__container {
                padding-right: var(--bs-gutter-x, 0.75rem);
            }

            .event-landing-hero__qr-wrap {
                right: 1rem;
                top: 6.5rem;
                width: 150px;
            }

            .event-landing-page-rail {
                right: 10px;
                top: 21rem;
            }

        }

        @media (max-width: 575.98px) {
            .event-landing-hero.section {
                min-height: auto;
                padding-bottom: 3rem;
            }

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
                padding: 0.5rem 0.2rem;
            }

            .event-landing-about {
                padding-top: 5.5rem;
            }

            .event-landing-header__register {
                padding: 0.45rem 0.8rem;
                font-size: 0.78rem;
            }

            .event-landing-hero__qr-wrap {
                position: static;
                width: 100%;
                max-width: 220px;
                margin: 1.5rem auto 0;
            }

            .event-landing-page-rail {
                right: 8px;
                top: auto;
                bottom: 1.25rem;
            }

            .event-landing-page-rail .floating-icon {
                width: 44px;
                height: 44px;
            }

            .event-landing-page-rail .floating-icon i {
                font-size: 20px;
            }

            .event-landing-hero__qr-card {
                padding: 0.85rem 0.75rem 0.95rem;
            }

            .event-landing-hero__qr-image {
                max-width: 96px;
            }
        }

        .event-landing-about {
            padding: 7.5rem 0 4.25rem;
            background: var(--el-bg);
        }

        .event-landing-about__intro {
            max-width: 540px;
            padding-top: 0.25rem;
        }

        .event-landing-about__eyebrow {
            font-size: 1.25rem;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            color: #2F363C;
            margin-bottom: 0.55rem;
        }

        .event-landing-about__title {
            font-size: clamp(1.5rem, 3vw, 2.125rem);
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            color: #B31111;
            line-height: 1.33;
            letter-spacing: -0.01em;
            margin-bottom: 0.95rem;
            max-width: 500px;
        }

        .event-landing-about__text p {
            color: #444444;
            font-size: 1rem;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            line-height: 1.45;
            margin-bottom: 0.55rem;
            max-width: 500px;
        }

        .event-landing-about__text p:last-child {
            margin-bottom: 0;
        }

        .event-landing-about__images {
            position: relative;
            min-height: 320px;
            width: 100%;
            max-width: 620px;
            margin-left: auto;
        }

        .event-landing-about__img-main {
            position: absolute;
            top: 0;
            right: 0;
            width: 314px;
            height: 188px;
            border-radius: 20px;
            object-fit: cover;
        }

        .event-landing-about__img-secondary {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 438px;
            height: 200px;
            border-radius: 20px;
            object-fit: cover;
            box-shadow: 0px 0px 5.5px 0px rgba(0, 0, 0, 0.24);
        }

        .event-landing-about__badge {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            background: var(--el-white);
            border-radius: 51px;
            padding: 0.58rem 0.9rem;
            box-shadow: 2px 4px 8.6px 0px rgba(0, 0, 0, 0.16);
            position: absolute;
        }

        .event-landing-about__badge-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: var(--el-accent);
            border-radius: 50%;
            color: var(--el-white);
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .event-landing-about__badge-text {
            font-size: 1.02rem;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            color: var(--el-text-dark);
            white-space: nowrap;
        }

        .event-landing-about__badge--speakers {
            right: 0.15rem;
            bottom: 0.95rem;
        }

        .event-landing-about__badge--experience {
            left: 0.85rem;
            top: 1.95rem;
        }

        .event-landing-about__read-more {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--el-accent);
            color: var(--el-white);
            border-radius: 26px;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            text-decoration: none;
            box-shadow: 0px 4px 4px 0px rgba(50, 50, 50, 0.16);
            margin-top: 1.3rem;
            transition: background 0.2s ease;
        }

        .event-landing-about__read-more:hover {
            background: #a81111;
            color: var(--el-white);
        }

        @media (max-width: 991.98px) {
            .event-landing-about {
                padding: 3.25rem 0 3rem;
            }

            .event-landing-about__intro {
                max-width: 100%;
                padding-top: 0;
            }

            .event-landing-about__images {
                margin-top: 1.65rem;
                min-height: auto;
                padding-bottom: 66%;
                max-width: 100%;
            }

            .event-landing-about__img-main {
                width: 58%;
                height: auto;
            }

            .event-landing-about__img-secondary {
                width: 76%;
                height: auto;
            }

            .event-landing-about__badge--speakers {
                right: 0;
                bottom: 0.35rem;
            }

            .event-landing-about__badge--experience {
                left: 0.5rem;
                top: 1.2rem;
            }
        }

        .event-landing-stats {
            margin-top: -5.15rem;
            padding: 0 0 3rem;
            background: transparent;
            position: relative;
            z-index: 4;
        }

        .event-landing-stats__bar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem 0;
            background: var(--el-white);
            border-radius: 12px;
            border: 1px solid #dddddd;
            padding: 1.55rem 2.15rem;
            color: var(--el-text-dark);
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.08);
            width: min(100%, 1110px);
            margin: 0 auto;
        }

        .event-landing-stats__item {
            flex: 1 1 180px;
            display: flex;
            flex-direction: row;
            align-items: baseline;
            justify-content: center;
            gap: 0.55rem;
            text-align: center;
            padding: 0 0.35rem;
        }

        .event-landing-stats__value {
            font-size: clamp(2.05rem, 2vw, 2.2rem);
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            line-height: 1;
            color: #111111;
        }

        .event-landing-stats__value .highlight {
            color: var(--el-accent);
        }

        .event-landing-stats__label {
            font-size: clamp(1.15rem, 1.35vw, 1.38rem);
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            color: #3d3d3d;
            margin-top: 0;
            line-height: 1.1;
        }

        @media (max-width: 991.98px) {
            .event-landing-stats {
                margin-top: -3rem;
                padding-bottom: 2.25rem;
            }

            .event-landing-stats__item {
                flex: 1 1 45%;
            }
        }

        @media (max-width: 575.98px) {
            .event-landing-stats {
                margin-top: -1.4rem;
            }

            .event-landing-stats__bar {
                padding: 1.15rem 1rem;
            }

            .event-landing-stats__item {
                flex: 1 1 100%;
                justify-content: flex-start;
                gap: 0.45rem;
            }
        }

        .event-landing-details {
            /* padding: 0 0 5rem; */
            background: var(--el-bg);
        }

        .event-landing-details__inner {
            position: relative;
            display: flex;
            gap: 2rem;
            align-items: flex-start;
        }

        .event-landing-details__content {
            flex: 0 0 598px;
            max-width: 598px;
        }

        .event-landing-details__eyebrow {
            font-size: 1.25rem;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            color: #2F363C;
            margin-bottom: 0.75rem;
        }

        .event-landing-details__title {
            font-size: clamp(1.3rem, 2.5vw, 1.75rem);
            font-weight: 600;
            font-family: 'Roboto', sans-serif;
            color: #570A0A;
            margin-bottom: 1rem;
        }

        .event-landing-details__lead {
            color: #444444;
            font-size: 1rem;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            line-height: 1.4;
            margin-bottom: 1.5rem;
        }

        .event-landing-details__list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .event-landing-details__list li {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--el-text-dark);
            font-size: 1rem;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
        }

        .event-landing-details__list li strong {
            font-weight: 700;
        }

        .event-landing-details__list i {
            color: var(--el-text-dark);
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
        }

        .event-landing-details__map-wrap {
            flex: 1;
            min-width: 0;
            position: relative;
        }

        .event-landing-details__map {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0px 0px 4px 0px rgba(68, 68, 68, 0.16);
            min-height: 410px;
            width: 100%;
        }

        .event-landing-details__map iframe {
            width: 100%;
            height: 410px;
            border: 0;
        }

        .event-landing-details__directions {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: var(--el-white);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            box-shadow: 0px 0px 5.5px 0px rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            gap: 2.5rem;
            min-width: 360px;
        }

        .event-landing-details__directions-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .event-landing-details__directions-name {
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Roboto', sans-serif;
            color: var(--el-text-dark);
            margin: 0;
        }

        .event-landing-details__directions-address {
            font-size: 0.875rem;
            font-weight: 400;
            font-family: 'Roboto', sans-serif;
            color: #444444;
            margin: 0;
        }

        .event-landing-details__directions-reviews {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .event-landing-details__directions-stars {
            display: flex;
            gap: 2px;
            color: #FFC107;
            font-size: 0.875rem;
        }

        .event-landing-details__directions-rating {
            font-size: 1rem;
            font-weight: 500;
            color: var(--el-text-dark);
        }

        .event-landing-details__directions-count {
            font-size: 0.875rem;
            font-weight: 500;
            color: #518CE4;
        }

        .event-landing-details__directions-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.25rem;
            text-decoration: none;
            color: #518CE4;
            font-size: 0.875rem;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            margin-left: auto;
        }

        .event-landing-details__directions-link i {
            font-size: 1.25rem;
            color: #518CE4;
        }

        .event-landing-details__map-zoom {
            position: absolute;
            right: 1rem;
            top: 1rem;
            display: flex;
            flex-direction: column;
            background: var(--el-white);
            border-radius: 4px;
            box-shadow: 0px 0px 4px 0px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        .event-landing-details__map-zoom-btn {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: var(--el-white);
            color: #6D6D6D;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .event-landing-details__map-zoom-btn:hover {
            background: #f0f0f0;
        }

        .event-landing-details__map-zoom-btn--divider {
            height: 1px;
            width: 100%;
            background: #E1E1E1;
            padding: 0;
        }

        .event-landing-details__view-larger {
            font-size: 1rem;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            color: #518CE4;
            text-decoration: none;
            display: inline-block;
            margin-top: 0.5rem;
        }

        @media (max-width: 991.98px) {
            .event-landing-details__inner {
                flex-direction: column;
            }

            .event-landing-details__content {
                flex: 1;
                max-width: 100%;
            }

            .event-landing-details__map-wrap {
                width: 100%;
            }

            .event-landing-details__directions {
                position: relative;
                top: auto;
                left: auto;
                min-width: auto;
                width: 100%;
                margin-top: 1rem;
                flex-wrap: wrap;
                gap: 1rem;
            }
        }

        .event-landing-section-title {
            font-size: 1.25rem;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            color: #2F363C;
            margin-bottom: 2rem;
        }

        .event-landing-speakers {
            /* padding: 5rem 0; */
            background: var(--el-bg);
        }

        .event-landing-speakers__scroll {
            overflow-x: auto;
            overflow-y: hidden;
            padding-bottom: 0;
            scroll-behavior: smooth;
            scroll-snap-type: x mandatory;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .event-landing-speakers__scroll::-webkit-scrollbar {
            display: none;
            width: 0;
            height: 0;
        }

        .event-landing-speakers__track {
            display: flex;
            flex-wrap: nowrap;
            gap: 1.2rem;
            min-width: max-content;
        }

        .event-landing-speakers__card {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            background: var(--el-white);
            border-radius: 12px;
            border: 1px solid #e3e3e3;
            padding: 0 0.9rem 0 0;
            box-shadow: 0px 0px 4px 0px rgba(0, 0, 0, 0.08);
            position: relative;
            flex: 0 0 520px;
            min-width: 520px;
            max-width: 520px;
            min-height: 174px;
            scroll-snap-align: start;
        }

        .event-landing-speakers__photo {
            flex-shrink: 0;
            width: 155px;
            height: 174px;
            border-radius: 12px;
            overflow: hidden;
            background: #f0f0f0;
        }

        .event-landing-speakers__photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .event-landing-speakers__body {
            flex: 1;
            min-width: 0;
            padding: 0.7rem 0 0.85rem;
        }

        .event-landing-speakers__name {
            font-size: 1.05rem;
            font-weight: 600;
            font-family: 'Roboto', sans-serif;
            color: var(--el-text-dark);
            margin-bottom: 0.4rem;
            line-height: 1.3;
        }

        .event-landing-speakers__role {
            font-size: 1.02rem;
            font-weight: 400;
            font-family: 'Roboto', sans-serif;
            color: var(--el-text-dark);
            margin-bottom: 0.25rem;
            line-height: 1.35;
        }

        .event-landing-speakers__org-logo {
            position: absolute;
            right: 0.65rem;
            bottom: 0.55rem;
            width: 36px;
            height: 36px;
        }

        .event-landing-speakers__org-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .event-landing-speakers__scroll-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: var(--el-white);
            color: var(--el-text-dark);
            box-shadow: 0px 0px 4px 0px rgba(0, 0, 0, 0.25);
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            flex-shrink: 0;
        }

        .event-landing-speakers__scroll-btn:hover {
            transform: scale(1.05);
        }

        .event-landing-speakers__scroll-btn i {
            font-size: 1.25rem;
        }

        @media (max-width: 768px) {
            .event-landing-speakers__card {
                align-items: stretch;
                min-width: 88vw;
                max-width: 88vw;
                flex: 0 0 88vw;
                padding: 0 0.75rem 0 0;
                overflow: hidden;
                min-height: 160px;
            }

            .event-landing-speakers__photo {
                width: 132px;
                height: auto;
                min-height: 100%;
                align-self: stretch;
                border-radius: 0;
                display: flex;
            }

            .event-landing-speakers__photo img {
                width: 100%;
                height: 100%;
                min-height: 100%;
                object-fit: cover;
                object-position: center top;
            }

            .event-landing-speakers__body {
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding: 0.85rem 2.5rem 0.85rem 0.85rem;
            }
        }

        .event-landing-agenda {
            /* padding: 4.25rem 0 4.75rem; */
            background: #f7f7f7;
            position: relative;
        }

        .event-landing-agenda__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
        }

        .event-landing-agenda__header .event-landing-section-title {
            margin-bottom: 0;
        }

        .event-landing-agenda__header-actions {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            flex-shrink: 0;
        }

        .event-landing-agenda__pdf-btn {
            border-radius: 26px;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            padding: 0.65rem 1.35rem;
            font-size: 0.95rem;
            line-height: 1.2;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            background: var(--el-white);
            border: 1px solid var(--el-accent);
            color: var(--el-accent);
            box-shadow: 0 4px 4px rgba(50, 50, 50, 0.16);
            text-decoration: none;
            transition: background 0.15s ease, color 0.15s ease, border-color 0.15s ease;
        }

        .event-landing-agenda__pdf-btn:hover {
            background: #fff5f5;
            color: var(--el-accent-dark);
            border-color: var(--el-accent-dark);
        }

        .event-landing-agenda__track {
            overflow-x: auto;
            overflow-y: hidden;
            scroll-behavior: smooth;
            -ms-overflow-style: none;
            scrollbar-width: none;
            padding-bottom: 0.35rem;
        }

        .event-landing-agenda__track::-webkit-scrollbar {
            display: none;
        }

        .event-landing-agenda__timeline {
            --agenda-col-width: 150px;
            --agenda-icon-size: 44px;
            display: flex;
            align-items: flex-start;
            position: relative;
            width: max-content;
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
            padding: 0;
        }

        .event-landing-agenda__column {
            flex: 0 0 var(--agenda-col-width);
            width: var(--agenda-col-width);
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0 0.35rem;
            position: relative;
            z-index: 1;
        }

        .event-landing-agenda__column:not(:last-child)::after {
            content: '';
            position: absolute;
            top: calc(var(--agenda-icon-size) / 2);
            left: 50%;
            width: var(--agenda-col-width);
            height: 2px;
            background: #d7d7d7;
            transform: translateY(-50%);
            z-index: 0;
            pointer-events: none;
        }

        .event-landing-agenda__icon {
            width: var(--agenda-icon-size);
            height: var(--agenda-icon-size);
            border-radius: 50%;
            background: #fde7ea;
            border: 1px solid #f9d6dc;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8a0c0f;
            font-size: 1.05rem;
            flex-shrink: 0;
            margin-bottom: 0.8rem;
            position: relative;
            z-index: 1;
        }

        .event-landing-agenda__time {
            font-size: 1.15rem;
            font-weight: 700;
            font-family: 'Roboto', sans-serif;
            color: #4f0d10;
            margin: 0 0 0.45rem;
            line-height: 1.1;
            text-align: center;
            letter-spacing: -0.01em;
        }

        .event-landing-agenda__session {
            font-size: 1rem;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            color: #2f363c;
            margin: 0;
            line-height: 1.32;
            text-align: center;
        }

        .event-landing-agenda__scroll-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid #e7e7e7;
            background: var(--el-white);
            color: #7f7f7f;
            box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            transition: all 0.15s ease;
        }

        .event-landing-agenda__scroll-btn:hover {
            color: #4f4f4f;
            border-color: #d8d8d8;
            transform: translateX(1px);
        }

        @media (max-width: 991.98px) {
            .event-landing-agenda__timeline {
                --agenda-col-width: 134px;
            }

            .event-landing-agenda__time {
                font-size: 1.2rem;
            }

            .event-landing-agenda__session {
                font-size: 0.95rem;
            }
        }

        @media (max-width: 575.98px) {
            .event-landing-agenda__header {
                flex-wrap: wrap;
                gap: 1rem;
            }

            .event-landing-agenda__header-actions {
                width: 100%;
                justify-content: space-between;
            }

            .event-landing-agenda__pdf-btn {
                flex: 1 1 auto;
                min-width: 0;
                padding: 0.6rem 1rem;
                font-size: 0.88rem;
            }
        }

        .event-landing-partners {
            padding: 3.4rem 0 4.4rem;
            background: var(--el-bg);
        }

        .event-landing-partners .event-landing-section-title {
            margin-bottom: 1.5rem;
        }

        .event-landing-partners__grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem 1.25rem;
        }

        .event-landing-partners__card {
            border: 1px solid #dddddd;
            border-radius: 12px;
            padding: 1rem 1.15rem;
            text-align: left;
            background: var(--el-white);
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-start;
            gap: 1rem;
            min-height: 112px;
            width: 100%;
        }

        .event-landing-partners__logo {
            width: 88px;
            height: 88px;
            min-width: 88px;
            min-height: 88px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 10px;
            background: #f7f7f7;
            padding: 0.5rem;
            box-sizing: border-box;
        }

        .event-landing-partners__logo img {
            width: 100%;
            height: 100%;
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            object-position: center;
        }

        button.event-landing-partners__logo--interactive {
            border: none;
            cursor: pointer;
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }

        button.event-landing-partners__logo--interactive:hover,
        button.event-landing-partners__logo--interactive:focus {
            box-shadow: 0 0 0 2px var(--el-accent);
            outline: none;
            transform: scale(1.02);
        }

        button.event-landing-partners__logo--interactive:focus-visible {
            outline: 2px solid var(--el-accent);
            outline-offset: 2px;
        }

        .event-landing-partner-modal__content {
            border-radius: 12px;
            border: 1px solid #dddddd;
        }

        .event-landing-partner-modal__title {
            font-family: var(--el-font-family);
            font-size: 1.15rem;
            font-weight: 600;
            color: var(--el-text-dark);
        }

        .event-landing-partner-modal__body {
            font-family: var(--el-font-family);
            font-size: 0.95rem;
            line-height: 1.6;
            color: var(--el-text-mid);
            white-space: pre-line;
        }

        .event-landing-partner-modal__link {
            background: var(--el-accent);
            border-color: var(--el-accent);
        }

        .event-landing-partners__name {
            font-size: 0.95rem;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            color: var(--el-text-dark);
            margin: 0;
            line-height: 1.25;
        }

        @media (max-width: 992px) {
            .event-landing-partners__grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 575.98px) {
            .event-landing-partners__grid {
                grid-template-columns: 1fr;
            }

            .event-landing-partners__card {
                min-height: 104px;
                padding: 1rem 1.1rem;
            }

            .event-landing-partners__logo {
                width: 80px;
                height: 80px;
                min-width: 80px;
                min-height: 80px;
            }
        }

        .event-landing-faq {
            /* padding: 4.5rem 0; */
            background: var(--el-bg);
        }

        .event-landing-faq__title {
            font-size: 2.25rem;
            font-weight: 600;
            font-family: 'Roboto', sans-serif;
            color: var(--el-text-dark);
            margin-bottom: 1.6rem;
            text-align: left;
        }

        .event-landing-faq__list {
            margin: 0;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem 1.25rem;
        }

        .event-landing-faq__item {
            border: 1px solid #e5e5e5;
            border-radius: 12px !important;
            overflow: hidden;
            background: var(--el-white);
            box-shadow: none;
        }

        .event-landing-faq__trigger {
            font-size: 1.1rem;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            color: #1f1f1f !important;
            box-shadow: none !important;
            padding: 1.05rem 1.1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            border: none;
            background: var(--el-white);
        }

        .event-landing-faq__trigger:not(.collapsed) {
            color: #1f1f1f !important;
            background: var(--el-white) !important;
        }

        .event-landing-faq__trigger::after {
            display: none;
        }

        .event-landing-faq__trigger .faq-icon {
            font-size: 1.45rem;
            color: #3f3f3f;
            flex-shrink: 0;
            line-height: 1;
        }

        .event-landing-faq__answer {
            font-size: 0.98rem;
            font-weight: 400;
            font-family: 'Roboto', sans-serif;
            color: #5d5d5d;
            line-height: 1.45;
            padding: 0 1.1rem 1rem;
        }

        @media (max-width: 992px) {
            .event-landing-faq__list {
                grid-template-columns: 1fr;
            }
        }

        /* ---- Media (near footer) ---- */
        .event-landing-media {
            padding: 4rem 0 5rem;
            background: var(--el-bg);
        }

        .event-landing-media__grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.5rem;
        }

        .event-landing-media__card {
            background: var(--el-white);
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            min-height: 220px;
        }

        .event-landing-media__card-title {
            font-size: 1rem;
            font-weight: 600;
            font-family: 'Roboto', sans-serif;
            color: var(--el-text-dark);
            margin: 0;
        }

        .event-landing-media__pane {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 160px;
        }

        .event-landing-media__img {
            max-width: 100%;
            max-height: 280px;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 8px;
            cursor: zoom-in;
        }

        .event-landing-media__video-ratio {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%;
            border-radius: 8px;
            overflow: hidden;
            background: #000;
        }

        .event-landing-media__video-ratio iframe {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .event-landing-media__video {
            width: 100%;
            max-height: 280px;
            border-radius: 8px;
            background: #000;
        }

        .event-landing-media__pane--pdf .offer-site-media__pdf-panel {
            width: 100%;
        }

        @media (max-width: 991.98px) {
            .event-landing-media__grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 575.98px) {
            .event-landing-media__grid {
                grid-template-columns: 1fr;
            }
        }

        /* ---- Reasons Section ---- */
        .event-landing-reasons {
            padding: 0 0 2rem;
            background: var(--el-bg);
        }

        .event-landing-reasons .container {
            background: #f7e7e8;
            border-radius: 14px;
            padding: 2.3rem 1.9rem 6.1rem;
        }

        .event-landing-reasons__eyebrow {
            font-size: 1.25rem;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            color: #2F363C;
            margin-bottom: 0.6rem;
        }

        .event-landing-reasons__title {
            font-size: clamp(1.5rem, 3vw, 2.25rem);
            font-weight: 600;
            font-family: 'Roboto', sans-serif;
            color: #B31111;
            line-height: 1.33;
            margin-bottom: 1.05rem;
        }

        .event-landing-reasons__desc {
            font-size: 1rem;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            color: #444444;
            line-height: 1.45;
            margin-bottom: 1.65rem;
            max-width: 600px;
        }

        .event-landing-reasons__grid {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .event-landing-reasons__card {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .event-landing-reasons__card-icon {
            width: 54px;
            height: 54px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            box-shadow: 0px 0px 4px 0px rgba(0, 0, 0, 0.16);
            font-size: 1.6rem;
            color: var(--el-white);
        }

        .event-landing-reasons__card-icon--blue {
            background: #C50F17 !important;
        }

        .event-landing-reasons__card-icon--default {
            background: #C96A08;
        }

        .event-landing-reasons__card-icon--red {
            background: #9E0D10 !important;
        }

        .event-landing-reasons__card-body {
            flex: 1;
            padding-top: 0.1rem;
        }

        .event-landing-reasons__card-title {
            font-size: 1.125rem;
            font-weight: 600;
            font-family: 'Roboto', sans-serif;
            color: var(--el-text-dark);
            margin-bottom: 0.3rem;
            line-height: 1.25;
        }

        .event-landing-reasons__card-text {
            font-size: 0.875rem;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            color: #444444;
            margin: 0;
            line-height: 1.45;
        }

        @media (max-width: 991.98px) {
            .event-landing-reasons {
                padding-bottom: 1.5rem;
            }

            .event-landing-reasons .container {
                padding: 2rem 1.15rem 4.85rem;
            }
        }

        @media (max-width: 575.98px) {
            .event-landing-reasons .container {
                padding: 1.6rem 0.9rem 2.25rem;
            }

            .event-landing-reasons__card-icon {
                width: 48px;
                height: 48px;
                font-size: 1.4rem;
            }
        }

        /* ---- NEN Organizers (homepage-style map block) ---- */
        .event-landing-organizers {
            padding: 5rem 0;
            background: var(--el-bg);
        }

        .event-landing-organizers__description {
            text-align: justify;
            color: var(--el-text-mid);
            line-height: 1.6;
        }

        .event-landing-organizers__map {
            height: 400px;
            border-radius: 20px;
            z-index: 1;
        }

        .event-landing-organizers__logo {
            max-width: 200px;
            height: auto;
        }

        .event-landing-organizers__actions {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .event-landing-organizers__actions .read-more {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .event-landing-organizers__partner-btn {
            margin-top: 0;
        }

        /* ---- Footer ---- */
        .event-landing-footer {
            background: #2F363C;
            color: var(--el-white);
            padding: 3rem 0 2rem;
        }

        .event-landing-footer__inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .event-landing-footer__copy {
            font-size: 0.875rem;
            font-weight: 400;
            font-family: 'Roboto', sans-serif;
            color: var(--el-white);
            margin: 0;
        }

        .event-landing-footer__link {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            color: var(--el-white);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 400;
            font-family: 'Roboto', sans-serif;
            transition: opacity 0.15s ease;
        }

        .event-landing-footer__link:hover {
            color: var(--el-white);
            opacity: 0.8;
        }

        .event-landing-footer__phone {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--el-white);
            text-decoration: none;
            font-size: 1rem;
            font-weight: 400;
            font-family: 'Poppins', sans-serif;
        }
    </style>
@endpush

@section('content')
    @include('site.helpers.event-landing-header', ['event' => $event])
    @include('site.helpers.event-landing-floating-aside', ['event' => $event])
    <main class="event-landing-page">
        @include('site.helpers.event-landing-hero', ['event' => $event])
        @include('site.helpers.event-landing-countdown', ['event' => $event])
        @include('site.helpers.event-landing-about-reasons', ['event' => $event])
        @include('site.helpers.event-landing-stats', ['event' => $event])
        @include('site.helpers.event-landing-details-map', ['event' => $event])
        @include('site.helpers.event-landing-speakers', ['event' => $event])
        @include('site.helpers.event-landing-agenda', ['event' => $event])
        @include('site.helpers.event-landing-organizers', ['event' => $event])
        @include('site.helpers.event-landing-partners', ['event' => $event])
        @include('site.helpers.event-landing-faq', ['event' => $event])
        @include('site.helpers.event-landing-media', ['event' => $event])

        {{-- Footer --}}
        @php
            $phoneLabel = $event->getLandingDateLabel() ? '+998908227567/68' : null;
        @endphp
        <footer class="event-landing-footer">
            <div class="container">
                <div class="event-landing-footer__inner">
                    <p class="event-landing-footer__copy">© {{ date('Y') }} (NEN) All rights reserved</p>
                    <div class="d-flex align-items-center gap-4 flex-wrap">
                        @if($phoneLabel)
                            <a href="tel:+998908227567/68" class="event-landing-footer__phone">
                                <i class="bi bi-telephone"></i> +998908227567/68
                            </a>
                        @endif
                        {{-- <a href="https://ets.nen-global.org/" class="event-landing-footer__link">
                            Read more about our Collaboration with ETS
                            <i class="bi bi-arrow-right"></i>
                        </a> --}}
                    </div>
                </div>
            </div>
        </footer>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var landingHeader = document.getElementById('event-landing-header');
            if (landingHeader) {
                var toggleLandingHeader = function () {
                    if (window.scrollY > 24) {
                        landingHeader.classList.add('event-landing-header--scrolled');
                    } else {
                        landingHeader.classList.remove('event-landing-header--scrolled');
                    }
                };
                toggleLandingHeader();
                window.addEventListener('scroll', toggleLandingHeader, { passive: true });
            }

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

            // FAQ accordion toggle with + / x icon
            document.querySelectorAll('.event-landing-faq__trigger').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var icon = this.querySelector('.faq-icon');
                    if (icon) {
                        var isExpanded = this.getAttribute('aria-expanded') === 'true';
                        icon.classList.toggle('bi-plus', !isExpanded);
                        icon.classList.toggle('bi-dash', isExpanded);
                    }
                });
            });

            // Agenda horizontal scroll
            var agendaTrack = document.querySelector('.event-landing-agenda__track');
            var agendaScrollBtn = document.querySelector('.event-landing-agenda__scroll-btn--next');
            if (agendaTrack && agendaScrollBtn) {
                agendaScrollBtn.addEventListener('click', function () {
                    agendaTrack.scrollBy({ left: 320, behavior: 'smooth' });
                });
            }

            // Speakers auto-slider (30s) + arrow controls
            (function () {
                var speakersScroll = document.querySelector('.event-landing-speakers__scroll');
                if (!speakersScroll) {
                    return;
                }

                var track = speakersScroll.querySelector('.event-landing-speakers__track');
                var cards = track ? track.querySelectorAll('.event-landing-speakers__card') : [];
                var prevBtn = document.querySelector('.event-landing-speakers__scroll-btn--prev');
                var nextBtn = document.querySelector('.event-landing-speakers__scroll-btn--next');
                var autoTimer = null;
                var AUTO_MS = 5000;

                function canSlide() {
                    return cards.length > 1 && speakersScroll.scrollWidth > speakersScroll.clientWidth + 8;
                }

                function getStep() {
                    if (!cards.length) {
                        return 350;
                    }
                    var gap = parseFloat(getComputedStyle(track).gap) || 0;
                    return cards[0].getBoundingClientRect().width + gap;
                }

                function scrollTo(left) {
                    speakersScroll.scrollTo({ left: left, behavior: 'smooth' });
                }

                function scrollNext() {
                    if (!canSlide()) {
                        return;
                    }
                    var maxScroll = speakersScroll.scrollWidth - speakersScroll.clientWidth;
                    if (speakersScroll.scrollLeft >= maxScroll - 8) {
                        scrollTo(0);
                    } else {
                        scrollTo(speakersScroll.scrollLeft + getStep());
                    }
                }

                function scrollPrev() {
                    if (!canSlide()) {
                        return;
                    }
                    var maxScroll = speakersScroll.scrollWidth - speakersScroll.clientWidth;
                    if (speakersScroll.scrollLeft <= 8) {
                        scrollTo(maxScroll);
                    } else {
                        scrollTo(Math.max(0, speakersScroll.scrollLeft - getStep()));
                    }
                }

                function stopAuto() {
                    if (autoTimer) {
                        window.clearInterval(autoTimer);
                        autoTimer = null;
                    }
                }

                function startAuto() {
                    stopAuto();
                    if (!canSlide()) {
                        return;
                    }
                    autoTimer = window.setInterval(scrollNext, AUTO_MS);
                }

                function restartAuto() {
                    stopAuto();
                    startAuto();
                }

                if (prevBtn) {
                    prevBtn.addEventListener('click', function () {
                        scrollPrev();
                        restartAuto();
                    });
                }

                if (nextBtn) {
                    nextBtn.addEventListener('click', function () {
                        scrollNext();
                        restartAuto();
                    });
                }

                speakersScroll.addEventListener('mouseenter', stopAuto);
                speakersScroll.addEventListener('mouseleave', startAuto);
                speakersScroll.addEventListener('focusin', stopAuto);
                speakersScroll.addEventListener('focusout', startAuto);

                window.addEventListener('resize', restartAuto);
                startAuto();
            })();
        });
    </script>
    @include('site.helpers.event-landing-organizers-map-script')
@endpush

