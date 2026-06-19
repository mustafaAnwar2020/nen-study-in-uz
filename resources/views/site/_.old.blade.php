


{{--
        <section id="contact" class="contact section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">
                    <div class="col-lg-6">
                        <div class="row gy-4">

                            <div class="col-md-6">
                                <div class="info-item" data-aos="fade" data-aos-delay="300">
                                    <i class="bi bi-telephone"></i>
                                    <h3>Call Us</h3>
                                    <p>{{$settings['general']->phone}}</p>
                                    <p>{{$settings['general']->phone2}}</p>
                                    <p>{{$settings['general']->phone3}}</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="col-md-6">
                                <div class="info-item" data-aos="fade" data-aos-delay="400">
                                    <i class="bi bi-envelope"></i>
                                    <h3>Email Us</h3>
                                    <p><a href="#" class="__cf_email__">{{$settings['general']->email}}</a>
                                    <p><a href="#" class="__cf_email__">{{$settings['general']->cs_email}}</a>
                                    </p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="col-md-6">
                                <div class="info-item" data-aos="fade" data-aos-delay="500">
                                    <i class="bi bi-clock"></i>
                                    <h3>Open Hours</h3>
                                    <p>{{$settings['general']->open_hours}}</p>
                                    <p> &nbsp; </p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="col-md-6">
                                <div class="info-item" data-aos="fade" data-aos-delay="200">
                                    <i class="bi bi-person-add"></i>
                                    <h3>Sign Up</h3>
                                    <p>Add your email to our newsletter <br> to receive weekly updates.</p>
                                    <form action="{{route('site.subscribe')}}" method="POST" class="">
                                        @csrf
                                        <div class="d-flex">
                                            <input type="email" name="email" class="form-control me-2"
                                                   placeholder="Enter your email" required>
                                            <button type="submit" class="btn btn-sm read-more btn-custom-danger"
                                                    style="padding: 4px">Send
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- End Info Item -->


                        </div>

                    </div>

                    <div class="col-lg-6">
                        <form action="{{route('site.contact')}}" method="post" class="php-email-form" data-aos="fade-up"
                              data-aos-delay="200">
                            @csrf
                            <div class="row gy-4">

                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name"
                                           required="">
                                </div>

                                <div class="col-md-6 ">
                                    <input type="email" class="form-control" name="email" placeholder="Your Email"
                                           required="">
                                </div>

                                <div class="col-12">
                                    <input type="text" class="form-control" name="phone" placeholder="Phone"
                                           required="">
                                </div>

                                <div class="col-12">
                                <textarea class="form-control" name="message" rows="6" placeholder="Message"
                                          required=""></textarea>
                                </div>

                                <div class="col-12 text-center">
                                    <button type="submit">Send Message</button>
                                </div>

                            </div>
                        </form>
                    </div><!-- End Contact Form -->

                </div>

            </div>

        </section>
--}}
