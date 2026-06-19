<section id="cefr" class="faq section mb-5">
    <div class="container section-title" data-aos="fade-up">
        <h2 style="padding-bottom: 0;margin-bottom: 0;">CEFR</h2>
    </div>

    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="text-center">
                    <img src="{{asset('site/images/cefr.jpg')}}" alt="cefr" class="img-fluid">

                    <p style="
    font-size: 20px;
    text-align: justify;
" class="f-p">
                        The Common European Framework of Reference for Languages (CEFR) was published by the Council of
                        Europe in 2001 as a reference document describing the knowledge and skills language learners
                        must
                        develop to communicate effectively in a foreign language. It provides a common basis for the
                        development of language curricula and textbooks and for the interpretation of
                        language test scores.
                    </p>
                    <a href="https://www.coe.int/en/web/common-european-framework-reference-languages/level-descriptions"
                       target="_blank" class="read-more">Learn more <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>

            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">

                <div class="cefr-container">
                    @if(isset($cefrs) && $cefrs->count() > 0)
                        @foreach($cefrs as $index => $cefr)
                            <div class="cefr-item {{ $index === 0 ? 'cefr-active' : '' }}">
                                <h3><span class="num">{{ $cefr->order_number }}.</span>
                                    <span>{{ $cefr->title }}</span>
                                </h3>
                                <div class="cefr-content">
                                    @if($cefr->content_type === 'text')
                                        <p>{!! $cefr->content !!}</p>
                                    @elseif($cefr->content_type === 'image' && $cefr->image_path)
                                        <p>
                                            <img src="{{ asset($cefr->image_path) }}" class="img-fluid" alt="{{ $cefr->title }}">
                                        </p>
                                    @elseif($cefr->content_type === 'table')
                                        {!! $cefr->content !!}
                                    @endif
                                </div>
                                <i class="cefr-toggle bi bi-chevron-right"></i>
                            </div>
                        @endforeach
                    @else
                        <!-- Fallback to original static content if no dynamic data -->
                        <div class="cefr-item cefr-active">
                            <h3><span class="num">1.</span>
                                <span>What is the CEFR?</span>
                            </h3>
                            <div class="cefr-content">
                                <p>
                                    The CEFR describes language activities and competences at six main levels: A1
                                    (the lowest) through A2, B1, B2, C1, and C2 (the highest). The levels include
                                    can-do statements, which describe in a positive way what language learners can
                                    do when they use a language, rather than what they cannot do.
                                    <br>
                                    The CEFR proficiency scales provide a convenient structure for thinking about
                                    and communicating a progression of language proficiency and for considering
                                    where people stand in relation to that progression. Therefore, mapping language
                                    test scores onto the CEFR levels is useful for assigning practical meaning to
                                    those scores. ETS has conducted several studies to facilitate the interpretation
                                    of the scores of the language tests it develops in relation to the CEFR levels.
                                </p>
                            </div>
                            <i class="cefr-toggle bi bi-chevron-right"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>