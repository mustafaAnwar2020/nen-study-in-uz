@extends('site.layouts.app', ['pageTitle' => 'Enter Password'])

@section('content')
<main class="main">
    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
        <div class="container">
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{route('site.index')}}">Home</a></li>
                    <li><a href="{{route('protected-files.index')}}">Protected Files</a></li>
                    <li class="current">Enter Password</li>
                </ol>
            </nav>
            <h1>Enter Password</h1>
        </div>
    </div><!-- End Page Title -->

    <!-- Password Form Section -->
    <section id="password-form" class="password-form section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="card shadow">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <i class="bi bi-shield-lock text-primary" style="font-size: 3rem;"></i>
                                <h3 class="mt-3">{{$protectedFile->name}}</h3>
                                @if($protectedFile->description)
                                    <p class="text-muted">{{$protectedFile->description}}</p>
                                @endif
                            </div>

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{session('error')}}
                                </div>
                            @endif

                            <form method="POST" action="{{route('protected-files.verify-password', $protectedFile->id)}}">
                                @csrf
                                <div class="mb-4">
                                    <label for="password" class="form-label">
                                        <i class="bi bi-key me-1"></i>Password
                                    </label>
                                    <input type="password" 
                                           class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Enter password to access this file"
                                           required 
                                           autofocus>
                                    @error('password')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-unlock me-1"></i>Access File
                                    </button>
                                    <a href="{{route('protected-files.index')}}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-1"></i>Back to Files
                                    </a>
                                </div>
                            </form>

                            <div class="text-center mt-4">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    This file is password protected. Please contact the administrator if you need access.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Password Form Section -->
</main>
@endsection

@push('styles')
<style>
.password-form .card {
    border: none;
    border-radius: 15px;
}

.password-form .form-control-lg {
    border-radius: 10px;
    padding: 15px 20px;
}

.password-form .btn-lg {
    border-radius: 10px;
    padding: 15px 30px;
    font-weight: 600;
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

.text-primary {
    color: #4e73df !important;
}

.btn-primary {
    background-color: #4e73df;
    border-color: #4e73df;
}

.btn-primary:hover {
    background-color: #2e59d9;
    border-color: #2653d4;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Focus on password input
    document.getElementById('password').focus();
    
    // Handle form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Verifying...';
        
        // Re-enable button after 5 seconds in case of slow response
        setTimeout(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }, 5000);
    });
});
</script>
@endpush