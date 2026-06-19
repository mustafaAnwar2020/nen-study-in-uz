@extends('site.layouts.app', ['pageTitle' => 'Edit Protected File'])

@section('content')
<main class="main">
    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
        <div class="container">
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{route('site.index')}}">Home</a></li>
                    <li><a href="{{route('protected-files.index')}}">Protected Files</a></li>
                    <li class="current">{{$protectedFile->name}}</li>
                </ol>
            </nav>
            <h1>{{$protectedFile->name}}</h1>
        </div>
    </div><!-- End Page Title -->

    <!-- File Editor Section -->
    <section id="file-editor" class="file-editor section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0">
                                        <i class="bi bi-file-earmark-text me-2"></i>
                                        {{$protectedFile->name}}
                                    </h5>
                                </div>
                                <div>
                                    <a href="{{route('protected-files.download', $protectedFile->id)}}" 
                                       class="btn btn-light btn-sm me-2">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                    <a href="{{route('protected-files.logout', $protectedFile->id)}}" 
                                       class="btn btn-outline-light btn-sm">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @if($errors->any())
                                <div class="alert alert-danger m-3">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success m-3">
                                    {{session('success')}}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger m-3">
                                    {{session('error')}}
                                </div>
                            @endif

                            <form method="POST" action="{{route('protected-files.update', $protectedFile->id)}}">
                                @csrf
                                @method('PUT')
                                
                                <div class="p-3 border-bottom">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0">
                                                <strong>File Type:</strong> 
                                                <span class="badge bg-secondary">{{strtoupper($fileExtension)}}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="editor-container">
                                    @if(in_array($fileExtension, ['txt', 'csv', 'json', 'xml', 'html', 'css', 'js', 'php', 'py']))
                                        <textarea name="content" 
                                                  id="file-content" 
                                                  class="form-control border-0" 
                                                  rows="25" 
                                                  style="resize: vertical; font-family: 'Courier New', monospace;">{{$fileContent}}</textarea>
                                    @elseif($fileExtension === 'xlsx' || $fileExtension === 'xls')
                                        <div class="p-4 text-center">
                                            <i class="bi bi-file-earmark-excel text-success" style="font-size: 4rem;"></i>
                                            <h4 class="mt-3">Excel File</h4>
                                            <p class="text-muted">This is an Excel file. You can download it to view and edit in Excel.</p>
                                            <a href="{{route('protected-files.download', $protectedFile->id)}}" 
                                               class="btn btn-success btn-lg">
                                                <i class="bi bi-download"></i> Download Excel File
                                            </a>
                                        </div>
                                    @else
                                        <div class="p-4 text-center">
                                            <i class="bi bi-file-earmark text-muted" style="font-size: 4rem;"></i>
                                            <h4 class="mt-3">Binary File</h4>
                                            <p class="text-muted">This file type cannot be edited directly. You can download it instead.</p>
                                            <a href="{{route('protected-files.download', $protectedFile->id)}}" 
                                               class="btn btn-primary btn-lg">
                                                <i class="bi bi-download"></i> Download File
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- File Information -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>File Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Name:</strong> {{$protectedFile->name}}</p>
                                    <p><strong>File Path:</strong> {{$protectedFile->file_path}}</p>
                                    @if($protectedFile->description)
                                        <p><strong>Description:</strong> {{$protectedFile->description}}</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Last Accessed:</strong> 
                                        @if($protectedFile->last_accessed)
                                            {{$protectedFile->last_accessed->format('M d, Y H:i:s')}}
                                        @else
                                            Never
                                        @endif
                                    </p>
                                    <p><strong>File Size:</strong> 
                                        @if($protectedFile->fileExists())
                                            {{number_format(filesize($protectedFile->full_path) / 1024, 2)}} KB
                                        @else
                                            File not found
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload Section -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><i class="bi bi-cloud-upload me-2"></i>Upload New File</h6>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="toggleUploadBtn">
                                    <i class="bi bi-chevron-down"></i> Show Upload
                                </button>
                            </div>
                        </div>
                        <div class="card-body" id="uploadSection" style="display: none;">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Note:</strong> Uploading a new file will replace the current file. Make sure to create a backup if needed.
                            </div>
                            
                            <form id="fileUploadForm" action="{{route('protected-files.upload', $protectedFile->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="uploadFile" class="form-label">Select File</label>
                                            <input type="file" 
                                                   class="form-control" 
                                                   id="uploadFile" 
                                                   name="file" 
                                                   accept=".xlsx,.xls,.txt,.csv"
                                                   required>
                                            <div class="form-text">
                                                Supported formats: Excel (.xlsx, .xls) - Max size: 10MB
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">&nbsp;</label>
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       id="createBackup" 
                                                       name="create_backup" 
                                                       value="1"
                                                       checked>
                                                <label class="form-check-label" for="createBackup">
                                                    Create backup of current file
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="submit" class="btn btn-primary" id="uploadBtn">
                                        <i class="bi bi-cloud-upload"></i> Upload File
                                    </button>
                                    
                                    <div id="uploadProgress" style="display: none;">
                                        <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                                            <span class="visually-hidden">Uploading...</span>
                                        </div>
                                        <span class="text-muted">Uploading...</span>
                                    </div>
                                </div>
                            </form>
                            
                            <!-- Upload Status -->
                            <div id="uploadStatus" class="mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End File Editor Section -->
</main>
@endsection

@push('styles')
<style>
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

.file-editor .card {
    border: none;
    border-radius: 10px;
}

.file-editor .card-header {
    border-radius: 10px 10px 0 0 !important;
}

.editor-container {
    min-height: 400px;
}

#file-content {
    border-radius: 0;
    font-size: 14px;
    line-height: 1.5;
}

#file-content:focus {
    box-shadow: none;
    border-color: transparent;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-save functionality (optional)
    let saveTimeout;
    const contentTextarea = document.getElementById('file-content');
    
    if (contentTextarea) {
        contentTextarea.addEventListener('input', function() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                // You can implement auto-save here if needed
                console.log('Content changed - could auto-save here');
            }, 2000);
        });
    }
    
    // Confirm before leaving if content changed
    let originalContent = contentTextarea ? contentTextarea.value : '';
    
    window.addEventListener('beforeunload', function(e) {
        if (contentTextarea && contentTextarea.value !== originalContent) {
            e.preventDefault();
            e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
            return e.returnValue;
        }
    });
    
    // Reset original content when form is submitted
    const mainForm = document.querySelector('form[method="POST"]');
    if (mainForm) {
        mainForm.addEventListener('submit', function() {
            originalContent = contentTextarea ? contentTextarea.value : '';
        });
    }

    // File upload functionality
    const toggleUploadBtn = document.getElementById('toggleUploadBtn');
    const uploadSection = document.getElementById('uploadSection');
    const fileUploadForm = document.getElementById('fileUploadForm');
    const uploadBtn = document.getElementById('uploadBtn');
    const uploadProgress = document.getElementById('uploadProgress');
    const uploadStatus = document.getElementById('uploadStatus');

    // Toggle upload section
    if (toggleUploadBtn) {
        toggleUploadBtn.addEventListener('click', function() {
            if (uploadSection.style.display === 'none') {
                uploadSection.style.display = 'block';
                this.innerHTML = '<i class="bi bi-chevron-up"></i> Hide Upload';
            } else {
                uploadSection.style.display = 'none';
                this.innerHTML = '<i class="bi bi-chevron-down"></i> Show Upload';
            }
        });
    }

    // File upload form submission
    if (fileUploadForm) {
        fileUploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            uploadFile();
        });
    }

    function uploadFile() {
        const fileInput = document.getElementById('uploadFile');
        const file = fileInput.files[0];
        
        if (!file) {
            showUploadStatus('Please select a file', 'error');
            return;
        }
        
        const formData = new FormData(fileUploadForm);
        
        uploadBtn.disabled = true;
        uploadProgress.style.display = 'block';
        showUploadStatus('Uploading...', 'info');
        
        fetch(fileUploadForm.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            uploadBtn.disabled = false;
            uploadProgress.style.display = 'none';
            
            if (data.success) {
                showUploadStatus(data.message || 'File uploaded successfully', 'success');
                fileInput.value = '';
                
                // Reload the page to show the new file content
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                showUploadStatus(data.message || 'Upload failed', 'error');
            }
        })
        .catch(error => {
            uploadBtn.disabled = false;
            uploadProgress.style.display = 'none';
            showUploadStatus('Upload failed', 'error');
            console.error('Error:', error);
        });
    }
    
    function showUploadStatus(message, type = 'info') {
        const alertClass = type === 'error' ? 'danger' : (type === 'success' ? 'success' : 'info');
        uploadStatus.innerHTML = `<div class="alert alert-${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>`;
        
        if (type !== 'info') {
            setTimeout(() => {
                uploadStatus.innerHTML = '';
            }, 5000);
        }
    }
});
</script>
@endpush