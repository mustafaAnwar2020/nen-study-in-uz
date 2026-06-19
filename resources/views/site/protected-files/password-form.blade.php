@extends('site.layouts.app', ['pageTitle' => 'Access Protected File'])

@section('content')
<main class="main">
    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
        <div class="container">
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{route('site.index')}}">Home</a></li>
                    <li><a href="{{route('protected-files.index')}}">Protected Files</a></li>
                    <li class="current">Access File</li>
                </ol>
            </nav>
            <h1>Access Protected File</h1>
        </div>
    </div><!-- End Page Title -->

    <!-- Password Form Section -->
    <section id="password-form" class="password-form section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="card shadow-lg border-0" data-aos="fade-up">
                        <div class="card-body p-5">
                            <!-- File Info -->
                            <div class="text-center mb-4">
                                <i class="bi bi-file-lock2 text-primary" style="font-size: 3rem;"></i>
                                <h3 class="mt-3 mb-2">{{$protectedFile->name}}</h3>
                                @if($protectedFile->description)
                                    <p class="text-muted">{{$protectedFile->description}}</p>
                                @endif
                                <small class="text-muted">
                                    <i class="bi bi-folder"></i> {{$protectedFile->file_path}}
                                </small>
                            </div>

                            <!-- Password Form -->
                            <form action="{{route('protected-files.verify-password', $protectedFile->id)}}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="password" class="form-label">
                                        <i class="bi bi-key"></i> Enter Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password" 
                                               class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password" 
                                               placeholder="Enter the file password"
                                               required>
                                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-unlock"></i> Access File
                                    </button>
                                    <a href="{{route('protected-files.index')}}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left"></i> Back to Files
                                    </a>
                                </div>
                            </form>

                            <!-- Security Notice -->
                            <div class="alert alert-info mt-4" role="alert">
                                <i class="bi bi-info-circle"></i>
                                <strong>Security Notice:</strong> This file is password protected. 
                                Please ensure you have authorization to access this content.
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
    border-radius: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    background-clip: padding-box;
    border: 1px solid rgba(255, 255, 255, 0.125);
}

.password-form .card-body {
    background: white;
    border-radius: 0.9rem;
}

.password-form .form-control-lg {
    border-radius: 0.5rem;
    border: 2px solid #e3e6f0;
    transition: all 0.3s ease;
}

.password-form .form-control-lg:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.password-form .btn-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    border: none;
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.password-form .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.password-form .btn-outline-secondary {
    border-radius: 0.5rem;
    border: 2px solid #6c757d;
    font-weight: 600;
    transition: all 0.3s ease;
}

.password-form .alert-info {
    border-radius: 0.5rem;
    border: none;
    background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
    color: #0c5460;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        const icon = this.querySelector('i');
        icon.className = type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
    });
});
</script>
@endpush