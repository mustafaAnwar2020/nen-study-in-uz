@extends('site.layouts.app')

@section('content')
    <section id="services" class="services section">

        <div class="container section-title aos-init aos-animate" data-aos="fade-up">
            <h2>{{$pageTitle}}</h2>
        </div>

        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <form method="get">
                        <div class="row text-left">

                            <div class="col">
                                <label>Product Product</label>
                                <select id="type" class="form-control" name="type">
                                    <option selected value="">-Choose product-</option>
                                    @foreach(\App\Models\Product::TYPESEXCEPTGENERAL as $key=>$value)
                                        <option
                                                {{ (request()->type == $key)  ? 'selected' : ''  }}
                                                value="{{$key}}">{{$value}}</option>
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
            </div>

            <div class="row isotope-container more-services section" data-aos="fade-up"
                 data-aos-delay="200">

                @foreach($rows as $product)
                    <div class="col-lg-4 isotope-item filter-{{$product->type}} mt-4" data-aos="fade-up"
                         data-aos-delay="100">
                        <div class="card">
                            <img src="{{asset($product->getImage())}}" class="img-fluid" style="height: 320px;"
                                 alt="">
                            <h3>{{limitText($product->name, 15)}}</h3>
                            <p>{{limitText($product->description, 50)}}</p>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-custom-dark dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    Book Now
                                </button>
                                <div class="dropdown-menu">
                                    @foreach($product->getBookNowUrl() as $entry)
                                        <a class="dropdown-item" target="_blank"
                                           href="{{$entry->url}}">
                                            <span class="flag-icon flag-icon-{{$entry->country}}"></span>
                                            {{config('countries')[$entry->country]}}
                                        </a>
                                    @endforeach
                                </div>

                                <a href="{{$product->more_link}}" target="_blank"
                                   class="btn btn-custom-outline-dark">Learn
                                    More</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>

    </section>
@stop