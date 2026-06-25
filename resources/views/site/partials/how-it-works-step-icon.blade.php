@php
    $step = (int) ($step ?? 1);
@endphp
@switch($step)
    @case(1)
        {{-- Registration --}}
        <svg class="nen-step__svg" viewBox="0 0 48 48" fill="none" aria-hidden="true">
            <circle cx="24" cy="16" r="7" stroke="currentColor" stroke-width="2.5"/>
            <path d="M10 40c0-7.732 6.268-14 14-14s14 6.268 14 14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
            <path d="M34 14v8M38 18h-8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
        </svg>
        @break
    @case(2)
        {{-- Choose major & university — graduation cap --}}
        <svg class="nen-step__svg" viewBox="0 0 48 48" fill="none" aria-hidden="true">
            <path d="M4 20 24 10l20 10" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 24v7c0 3.8 5.4 7 12 7s12-3.2 12-7v-7" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M40 20v9" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
            <circle cx="40" cy="31" r="2" fill="currentColor"/>
        </svg>
        @break
    @case(3)
        {{-- Submit documents --}}
        <svg class="nen-step__svg" viewBox="0 0 48 48" fill="none" aria-hidden="true">
            <path d="M14 8h14l8 8v26a2 2 0 0 1-2 2H14a2 2 0 0 1-2-2V10a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round"/>
            <path d="M28 8v8h8" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round"/>
            <path d="M18 24h12M18 30h12M18 36h8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
            <path d="M32 30l4-4 4 4M36 26v10" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @break
    @case(4)
        {{-- Document verification — magnifying glass only --}}
        <svg class="nen-step__svg" viewBox="0 0 48 48" fill="none" aria-hidden="true">
            <circle cx="22" cy="22" r="11" stroke="currentColor" stroke-width="2.5"/>
            <path d="M30.5 30.5 38 38" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
        </svg>
        @break
    @case(5)
        {{-- Admission process --}}
        <svg class="nen-step__svg" viewBox="0 0 48 48" fill="none" aria-hidden="true">
            <rect x="10" y="8" width="28" height="32" rx="3" stroke="currentColor" stroke-width="2.5"/>
            <path d="M16 18h16M16 24h16M16 30h10" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
            <circle cx="32" cy="32" r="9" fill="#f1f3f2" stroke="currentColor" stroke-width="2.5"/>
            <path d="M28.5 32l2.5 2.5 5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @break
    @default
        {{-- Success / obtain visa --}}
        <svg class="nen-step__svg" viewBox="0 0 48 48" fill="none" aria-hidden="true">
            <circle cx="24" cy="24" r="16" stroke="currentColor" stroke-width="2.5"/>
            <path d="M15 24.5 21 30.5 33 18.5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
@endswitch
