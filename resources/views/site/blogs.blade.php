@extends('site.layouts.app')

@push('styles')
    <style>
        .blog-card {
            border-radius: 1rem;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .blog-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.12);
        }
        .blog-card .blog-card__media {
            height: 220px;
            overflow: hidden;
        }
        .blog-card .blog-card__media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .blog-card:hover .blog-card__media img {
            transform: scale(1.05);
        }
        .blog-card .blog-card__body {
            padding: 1.25rem;
        }
        .blog-card .blog-card__body h3 {
            font-size: 1.15rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .blog-card .blog-card__body p {
            font-size: 0.9rem;
            color: #6c757d;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .blog-card .blog-card__footer {
            padding: 0.75rem 1.25rem;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .blog-card .blog-card__footer .date {
            font-size: 0.8rem;
            color: #999;
        }
        .blog-card .blog-card__footer .badge {
            font-size: 0.7rem;
        }
    </style>
@endpush

@section('content')
    <main class="main">

        <section id="blogs" class="services section">

            <div class="container section-title aos-init aos-animate" data-aos="fade-up">
                <h2>{{ $pageTitle }}</h2>
            </div>

            <div class="container">
                @if($rows->count() > 0)
                    <div class="row gy-4">
                        @foreach($rows as $blog)
                            <div class="col-md-6 col-lg-4 d-flex">
                                <div class="card shadow blog-card w-100 h-100">
                                    <a href="{{ route('site.blogs.show', $blog->slug) }}" class="text-decoration-none text-dark">
                                        <div class="blog-card__media">
                                            <img src="{{ $blog->getImage() }}" alt="{{ $blog->title }}" class="img-fluid" loading="lazy">
                                        </div>
                                        <div class="blog-card__body">
                                            <h3>{{ $blog->title }}</h3>
                                            <p>{!! $blog->getExcerpt(200) !!}</p>
                                        </div>
                                    </a>
                                    <div class="blog-card__footer">
                                        <span class="date">
                                            <i class="bi bi-calendar3"></i>
                                            {{ $blog->created_at->diffForHumans() }}
                                        </span>
                                        <a href="{{ route('site.blogs.show', $blog->slug) }}" class="btn btn-sm btn-outline-dark">
                                            Read More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center mt-5">
                        {{ $rows->links() }}
                    </div>
                @else
                    <div class="shadow p-5 mt-2 mb-2 text-center rounded-3">
                        <i class="bi bi-journal-text" style="font-size: 3rem; color: #ddd;"></i>
                        <h4 class="mt-3 text-muted">No blogs published yet.</h4>
                        <p class="text-muted">Check back soon for new articles.</p>
                    </div>
                @endif
            </div>

        </section>

    </main>
@stop
