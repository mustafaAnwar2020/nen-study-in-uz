@extends('site.layouts.app')

@section('content')
    <section id="services" class="services section">

        <!-- Section Title -->
        <div class="container section-title aos-init aos-animate" data-aos="fade-up">
            <h2>{{$pageTitle}}</h2>
            <form method="get">
                <div class="row text-left">

                    <div class="col">
                        <label>Product</label>
                        <select id="product_id" class="form-control" name="product_id">
                            <option selected value="">-Choose product-</option>
                            @foreach (\App\Models\Product::TYPES as $idx => $type)
                                <option
                                        {{ (request()->product_id == $idx)  ? 'selected' : ''  }}
                                        value="{{$idx}}">{{$type}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <label> </label>
                        <button class="d-block btn bt-sm btn-dark">Filter</button>
                    </div>

                </div>
            </form>
        </div>

    </section>


    <section id="faq" class="faq section light-background">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="content px-xl-5">
                        <h3><span>Frequently Asked </span><strong>Questions</strong></h3>

                        @if(request()->product_id)
                            Specific Product
                        @else
                            All Faqs
                        @endif
                    </div>

                    <div class="text-center">
                        <img src="{{asset('site/images/faq.svg')}}">
                    </div>

                </div>

                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">

                    <div class="faq-container">
                        @forelse($rows as $idx=>$faq)
                            <div class="faq-item {{$idx == 0 ? 'faq-active' : ''}}">
                                <h3><span class="num">{{$idx+1 }}.</span>
                                    <span>{{$faq->name}}</span>
                                </h3>
                                <div class="faq-content">
                                    <p>
                                        {{$faq->answer}}
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div>
                        @empty
                            <div class="col-md-12">
                                <div class="shadow p-4 mt-5 mb-5 text-center">
                                    There are no Faqs with these filters.
                                </div>
                            </div>
                        @endforelse

                    </div>

                </div>
            </div>
        </div>
    </section>



@stop