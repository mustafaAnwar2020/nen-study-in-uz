<!-- Tabs Section -->
<section id="tabs" class="tabs section">

    <div class="container section-title" data-aos="fade-up">
        <h2>Universities and Colleges</h2>
    </div>

    <div class="container">

        @php($data = \App\Models\Section::query()->where('type', 'joins')->get())

        <ul class="nav nav-tabs row  d-flex" data-aos="fade-up" data-aos-delay="100">
            @foreach($data as $idx => $row)
                <li class="nav-item col-3">
                    <a class="nav-link {{$idx == 0 ? 'active show' : ''}}" data-bs-toggle="tab"
                       data-bs-target="#tabs{{$row->id}}">
                        <h4 class="d-block">{{$row->title}}</h4>
                    </a>
                </li>
            @endforeach
        </ul>


        <div class="tab-content" data-aos="fade-up" data-aos-delay="200">
            @foreach($data as $idx => $row)
                <div class="tab-pane fade {{$idx == 0 ? 'active show' : ''}}" id="tabs{{$row->id}}">
                    <div class="row">
                        <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                            <h3>{{$row->title}}</h3>
                            <div class="decs-html mt-3">
                                {!! $row->description !!}
                            </div>

                            @if($row->btn_text && $row->btn_url)
                                <a target="_blank" href="{{$row->btn_url}}"
                                   class="btn btn-md btn-custom-danger mt-4">{{$row->btn_text}}</a>
                            @endif


                            @if($row->btn2_text && $row->btn2_url)
                                <a target="_blank" href="{{$row->btn2_url}}"
                                   class="btn btn-md btn-custom-danger mt-4">{{$row->btn2_text}}</a>
                            @endif

                        </div>
                        <div class="col-lg-6 order-1 order-lg-2 text-center">
                            <img src="{{asset($row->getImage())}}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

</section>
