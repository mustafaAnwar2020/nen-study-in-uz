@extends('site.layouts.app', ['pageTitle' => 'Protected Files'])

@section('content')
<main class="main">
    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
        <div class="container">
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{route('site.index')}}">Home</a></li>
                    <li class="current">Protected Files</li>
                </ol>
            </nav>
            <h1>Protected Files</h1>
        </div>
    </div><!-- End Page Title -->

    <!-- Protected Files Section -->
    <section id="protected-files" class="protected-files section">
        <div class="container">
            <div class="row gy-4">
                @if($protectedFiles->count() > 0)
                    @foreach($protectedFiles as $file)
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-file-lock2 text-primary me-2" style="font-size: 2rem;"></i>
                                        <div>
                                            <h5 class="card-title mb-1">{{$file->name}}</h5>
                                            <small class="text-muted">
                                                {{pathinfo($file->file_path, PATHINFO_DIRNAME)}}
                                            </small>
                                        </div>
                                    </div>
                                    
                                    @if($file->description)
                                        <p class="card-text text-muted">{{$file->description}}</p>
                                    @endif
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            @if($file->last_accessed)
                                                Last accessed: {{$file->last_accessed->diffForHumans()}}
                                            @else
                                                Never accessed
                                            @endif
                                        </small>
                                        
                                        <a href="{{route('protected-files.password-form', $file->id)}}" 
                                           class="btn btn-primary btn-sm">
                                            <i class="bi bi-unlock"></i> Access File
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-file-lock2 text-muted" style="font-size: 4rem;"></i>
                            <h4 class="mt-3 text-muted">No Protected Files Available</h4>
                            <p class="text-muted">There are currently no protected files to access.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            @if(method_exists($protectedFiles, 'hasPages') && $protectedFiles->hasPages())
                <div class="row mt-4">
                    <div class="col-12">
                        <nav aria-label="Protected files pagination">
                            {{$protectedFiles->links()}}
                        </nav>
                    </div>
                </div>
            @endif
        </div>
    </section><!-- End Protected Files Section -->
</main>
@endsection

@push('styles')
<style>
.protected-files .card {
    border: 1px solid #e3e6f0;
    border-radius: 0.35rem;
    transition: all 0.3s ease;
}

.protected-files .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.protected-files .card-title {
    color: #5a5c69;
    font-weight: 600;
}

.protected-files .btn-primary {
    background-color: #4e73df;
    border-color: #4e73df;
}

.protected-files .btn-primary:hover {
    background-color: #2e59d9;
    border-color: #2653d4;
}

.page-title {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 60px 0;
    margin-bottom: 0;
}

.page-title h1 {
    color: white;
    margin-bottom: 0;
}

.breadcrumbs ol {
    margin-bottom: 10px;
}

.breadcrumbs a {
    color: rgba(255, 255, 255, 0.8);
}

.breadcrumbs .current {
    color: white;
}
</style>
@endpush