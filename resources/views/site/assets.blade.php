@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/js/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <style>
        .flag-icon {
            margin-right: 5px;
            vertical-align: middle;
        }

        .custom-red-marker {
            background: transparent !important;
            border: none !important;
        }

        .custom-red-marker i {
            display: block;
            text-align: center;
            line-height: 1;
        }

    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('assets/js/locale-all.min.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
@endpush
