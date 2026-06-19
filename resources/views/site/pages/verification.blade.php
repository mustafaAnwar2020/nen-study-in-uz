@extends('site.layouts.app', ['pageTitle' => 'Verification'])

@section('content')

    <section id="services" class="services section">

        <div class="container">
            <div class="row gy-4 mb-4">

                @php
                    $types = [
                        'TOFEL-IBT' => 'TOFEL IBT',
                        'TOEFL-ITP' => 'TOEFL ITP',
                        'Banned-list' => 'Banned list',
                        'Auditor' => 'Auditor',
                    ];
                    $activeType = request()->type ?? 'TOFEL-IBT';
                @endphp

                <ul class="nav nav-pills nav-fill">
                    @foreach ($types as $type => $label)
                        <li class="nav-item">
                            <a class="nav-link {{ $activeType == $type ? 'active' : '' }} "
                                href="?type={{ $type }}">{{ $label }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>


        </div>


        @php(
    $section = \App\Models\Section::query()->where('key', request()->type ?? 'TOFEL-IBT')->first()
)

        @if (isset($section))

            <div class="container mt-5">

                <div class="row">

                    <div class="col-md-{{ $section->key == 'TOFEL-IBT' ? '6' : '12' }}">
                        <div class="decs-html">
                            {!! $section->description !!}
                        </div>
                    </div>

                    @if ($section->key == 'TOFEL-IBT' && $section->image)
                        <div class="col-md-6">
                            <img src="{{ asset($section->image) }}" class="img-fluid">

                            @if ($section->key == 'TOFEL-IBT' && $section->btn_text && $section->btn_url)
                                <div>
                                    <a href="{{ $section->btn_url }}" class="btn btn-custom-dark mt-3 m-1" target="_blank">
                                        {{ $section->btn_text }}
                                    </a>

                                    <a href="{{ $section->btn2_url }}" class="btn btn-custom-dark mt-3 m-1" target="_blank">
                                        {{ $section->btn2_text }}
                                    </a>
                                </div>
                            @endif

                            @if ($section->key != 'TOFEL-IBT' && $section->btn_text && $section->btn_url)
                                <a href="{{ $section->btn_url }}" class="btn btn-custom-dark m-1" target="_blank">
                                    {{ $section->btn_text }}
                                </a>
                            @endif

                            @if ($section->key != 'TOFEL-IBT' && $section->btn_text2 && $section->btn_url2)
                                <a href="{{ $section->btn_url2 }}" class="btn btn-custom-dark m-1" target="_blank">
                                    {{ $section->btn_text2 }}
                                </a>
                            @endif

                        </div>
                    @endif

                    <div class="col-md-12">
                        <form action="?" method="get" class="row g-2 align-items-end">

                            <input type="hidden" name="type" value="{{ $activeType }}">

                            @if (request()->type == 'TOEFL-ITP' || request()->type == 'Auditor')
                                @if (request()->type == 'TOEFL-ITP')
                                    <div class="col">
                                        <label for="country" class="form-label">Country</label>
                                        <select class="form-control" name="country" id="country">
                                            @foreach (config('countries') as $code => $country)
                                                @if (in_array($code, $allowedCountries))
                                                    <option value="{{ $code }}"
                                                        {{ request()->country == $code ? 'selected' : '' }}>
                                                        {{ $country }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col">
                                        <label for="test_date" class="form-label">Test Date</label>
                                        <input type="date" name="test_date" id="test_date" class="form-control"
                                            value="{{ request('test_date') }}">
                                    </div>
                                    <div class="col">
                                        <label for="st_name" class="form-label">Student Name</label>
                                        <input type="text" name="st_name" id="st_name" class="form-control"
                                            value="{{ request('st_name') }}">
                                    </div>

                                    <div class="col">
                                        <label for="dob" class="form-label">Date Of Birth</label>
                                        <input type="date" name="dob" id="dob" class="form-control"
                                            value="{{ request('dob') }}">
                                    </div>
                                @endif

                                @if (request()->type == 'Auditor')
                                    <div class="col">
                                        <label for="visit_code" class="form-label">Visit code</label>
                                        <input type="text" name="visit_code" id="visit_code" class="form-control"
                                            value="{{ request('visit_code') }}">
                                    </div>
                                @endif


                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success w-100">
                                        Search <i class="bi bi-funnel-fill ms-2"></i>
                                    </button>
                                </div>

                            @endif


                        </form>
                    </div>

                </div>
            </div>

        @endif

        <div class="container mt-4">
            @if (isset($data) && $data->isNotEmpty())
                <?php
                $rows = $data->toArray();
                $rows = isset($headers) ? $rows : array_slice($rows, 1);
                $headers = isset($headers) ? $headers : $data->first();
                ?>

                @if (count($rows) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    @foreach ($headers as $header)
                                        <th>{{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $row)
                                    <tr>
                                        @foreach ($row as $cell)
                                            <td>{{ $cell }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endif
        </div>


    </section>

@endsection

@push('styles')
    <style>
        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            background-color: #000 !important;
            color: #fff !important;
        }

        .nav-pills .nav-link.active:hover {
            background-color: #cc1616 !important;
            color: #fff !important;
        }
    </style>
@endpush
