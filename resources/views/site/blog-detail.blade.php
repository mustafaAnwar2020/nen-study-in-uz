@extends('site.layouts.app')

@push('styles')
    <style>
        .blog-detail-header {
            background: #f8f9fa;
            padding: 3rem 0;
            border-bottom: 1px solid #eee;
        }
        .blog-detail-header h1 {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.3;
        }
        .blog-detail-header .blog-meta {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .blog-detail-header .blog-meta span {
            margin-right: 1.5rem;
        }
        .blog-detail-header .blog-meta i {
            margin-right: 0.35rem;
        }
        .blog-detail-image {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 1rem;
        }
        .blog-detail-content {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #333;
        }
        .blog-detail-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
        }
        .blog-detail-content p {
            margin-bottom: 1.25rem;
        }
        .recent-blog-card {
            border-radius: 0.75rem;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .recent-blog-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .recent-blog-card .recent-blog-media {
            height: 160px;
            overflow: hidden;
        }
        .recent-blog-card .recent-blog-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .recent-blog-card .recent-blog-body {
            padding: 1rem;
        }
        .recent-blog-card .recent-blog-body h5 {
            font-size: 0.95rem;
            font-weight: 600;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .recent-blog-card .recent-blog-body .date {
            font-size: 0.8rem;
            color: #999;
        }
    </style>
@endpush

@section('content')
    <main class="main">

        <!-- Header Section -->
        <section class="blog-detail-header">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="blog-meta mb-3">
                            <span>
                                <i class="bi bi-calendar3"></i> {{ $row->created_at->diffForHumans() }}
                            </span>
                            {{-- @if($row->status === 'published')
                                <span>
                                    <i class="bi bi-check-circle"></i> Published
                                </span>
                            @endif --}}
                        </div>
                        <h1>{{ $row->title }}</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Content Section -->
        <section class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        @if($row->image)
                            <div class="text-center mb-5">
                                <img src="{{ asset($row->image) }}" alt="{{ $row->title }}" class="blog-detail-image">
                            </div>
                        @endif

                        <div class="blog-detail-content">
                            {!! $row->article !!}
                        </div>

                        <div class="mt-5 pt-4 border-top text-center">
                            <a href="{{ route('site.blogs') }}" class="btn btn-dark">
                                <i class="bi bi-arrow-left"></i> Back to Blogs
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- Recent Blogs -->
        @if($recentBlogs->count() > 0)
            <section class="section section-bg light-background pb-5">
                <div class="container">
                    <div class="section-title mb-4" data-aos="fade-up">
                        <h4>Recent Blogs</h4>
                    </div>
                    <div class="row gy-4">
                        @foreach($recentBlogs as $recent)
                            <div class="col-md-6 col-lg-3">
                                <a href="{{ route('site.blogs.show', $recent->slug) }}" class="text-decoration-none text-dark">
                                    <div class="card shadow recent-blog-card h-100">
                                        <div class="recent-blog-media">
                                            <img src="{{ $recent->getImage() }}" alt="{{ $recent->title }}" loading="lazy">
                                        </div>
                                        <div class="recent-blog-body">
                                            <h5>{{ $recent->title }}</h5>
                                            <div class="date">
                                                <i class="bi bi-calendar3"></i> {{ $recent->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

    </main>
@stop
