@extends('site.layouts.app', ['pageTitle' => 'Verification'])

@section('content')
    <section id="services" class="services section">

        <div class="container">
            <div class="row gy-4">

                @php
                    $types = [
                        'TOFEL-IBT' => 'TOFEL IBT',
                        'TOEFL-ITP' => 'TOEFL ITP',
                    ];
                    $activeType = request()->type ?? 'TOFEL-IBT';
                @endphp

                <ul class="nav nav-pills nav-fill">
                    @foreach ($types as $type => $label)
                        <li class="nav-item">
                            <a class="nav-link {{ $activeType == $type ? 'active' : '' }}"
                                href="?type={{ $type }}">{{ $label }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>


        @php($section = \App\Models\Section::query()->where('key', 'testing-events')->first())

        @if (isset($section))

            <div class="container mt-5">

                <div class="row">

                    <div class="col-md-12">
                        <div class="">
                            {!! $section->description !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-4">
                @if (isset($data) && $data->isNotEmpty())
                    <?php
                    $headers = $data->first();
                    $rows = $data->slice(1);
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
            </div>

        @endif
        @endif


    </section>
@stop

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
