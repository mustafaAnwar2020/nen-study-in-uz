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
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg border-0" data-aos="fade-up">
                        <div class="card-header bg-primary text-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h4 class="mb-0">
                                        <i class="bi bi-file-earmark-text"></i> {{$protectedFile->name}}
                                    </h4>
                                    <small class="opacity-75">
                                        <i class="bi bi-folder"></i> {{$protectedFile->file_path}}
                                    </small>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-light btn-sm" id="saveBtn">
                                            <i class="bi bi-save"></i> Save
                                        </button>
                                        <a href="{{route('protected-files.download', $protectedFile->id)}}" 
                                           class="btn btn-light btn-sm">
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                        <a href="{{route('protected-files.logout')}}" 
                                           class="btn btn-outline-light btn-sm">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body p-0">
                            <form id="fileEditForm" action="{{route('protected-files.update', $protectedFile->id)}}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <!-- File Content Editor -->
                                <div class="editor-container">
                                    <textarea id="fileContent" 
                                              name="content" 
                                              class="form-control border-0"
                                              style="min-height: 70vh; font-family: 'Courier New', monospace; font-size: 14px; resize: none;"
                                              placeholder="File content will appear here...">{{$fileContent}}</textarea>
                                </div>
                            </form>
                        </div>
                        
                        <div class="card-footer bg-light">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle"></i>
                                        File size: <span id="fileSize">{{strlen($fileContent)}} bytes</span> |
                                        Lines: <span id="lineCount">{{substr_count($fileContent, "\n") + 1}}</span> |
                                        Last saved: <span id="lastSaved">{{now()->format('Y-m-d H:i:s')}}</span>
                                    </small>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-secondary" id="undoBtn">
                                            <i class="bi bi-arrow-counterclockwise"></i> Undo
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" id="redoBtn">
                                            <i class="bi bi-arrow-clockwise"></i> Redo
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" id="findBtn">
                                            <i class="bi bi-search"></i> Find
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End File Editor Section -->

    <!-- File Upload Section -->
    <section id="file-upload" class="file-upload section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg border-0" data-aos="fade-up">
                        <div class="card-header bg-success text-white">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="mb-0">
                                        <i class="bi bi-cloud-upload"></i> Upload New File
                                    </h4>
                                    <small class="opacity-75">
                                        Replace the current file with a new one
                                    </small>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <button type="button" class="btn btn-outline-light btn-sm" id="toggleUploadBtn">
                                        <i class="bi bi-chevron-down"></i> Show Upload
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body" id="uploadSection" style="display: none;">
                            <form id="fileUploadForm" action="{{route('protected-files.upload', $protectedFile->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group mb-3">
                                            <label for="uploadFile" class="form-label">Select New File</label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="uploadFile" name="file" 
                                                       accept=".xlsx,.xls,.txt,.csv" required>
                                                <button type="submit" class="btn btn-success" id="uploadBtn">
                                                    <i class="bi bi-upload"></i> Upload & Replace
                                                </button>
                                            </div>
                                            <small class="form-text text-muted">
                                                Accepted formats: .xlsx, .xls, .txt, .csv (Maximum size: 10MB)
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mt-4">
                                            <input class="form-check-input" type="checkbox" id="createBackup" name="create_backup" checked>
                                            <label class="form-check-label" for="createBackup">
                                                Create backup of current file
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Upload Progress -->
                                <div id="uploadProgress" style="display: none;">
                                    <div class="progress mb-3">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                             role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <small class="text-muted">Uploading file...</small>
                                </div>
                                
                                <!-- Upload Status -->
                                <div id="uploadStatus"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End File Upload Section -->

    <!-- Find Modal -->
    <div class="modal fade" id="findModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Find & Replace</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="findText" class="form-label">Find:</label>
                        <input type="text" class="form-control" id="findText" placeholder="Enter text to find">
                    </div>
                    <div class="mb-3">
                        <label for="replaceText" class="form-label">Replace with:</label>
                        <input type="text" class="form-control" id="replaceText" placeholder="Enter replacement text">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="caseSensitive">
                        <label class="form-check-label" for="caseSensitive">Case sensitive</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="findNextBtn">Find Next</button>
                    <button type="button" class="btn btn-warning" id="replaceBtn">Replace</button>
                    <button type="button" class="btn btn-danger" id="replaceAllBtn">Replace All</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
.file-editor .card {
    border-radius: 0.5rem;
}

.file-editor .card-header {
    border-radius: 0.5rem 0.5rem 0 0;
}

.editor-container {
    position: relative;
}

#fileContent {
    border: none !important;
    outline: none !important;
    box-shadow: none !important;
    line-height: 1.5;
    tab-size: 4;
}

#fileContent:focus {
    border: none !important;
    outline: none !important;
    box-shadow: none !important;
}

.btn-group .btn {
    border-radius: 0.25rem;
}

.card-footer {
    border-radius: 0 0 0.5rem 0.5rem;
}

.modal-content {
    border-radius: 0.5rem;
}

/* Custom scrollbar for textarea */
#fileContent::-webkit-scrollbar {
    width: 12px;
}

#fileContent::-webkit-scrollbar-track {
    background: #f1f1f1;
}

#fileContent::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 6px;
}

#fileContent::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileContent = document.getElementById('fileContent');
    const saveBtn = document.getElementById('saveBtn');
    const undoBtn = document.getElementById('undoBtn');
    const redoBtn = document.getElementById('redoBtn');
    const findBtn = document.getElementById('findBtn');
    const fileEditForm = document.getElementById('fileEditForm');
    const findModal = new bootstrap.Modal(document.getElementById('findModal'));
    const toggleUploadBtn = document.getElementById('toggleUploadBtn');
    const uploadSection = document.getElementById('uploadSection');
    const fileUploadForm = document.getElementById('fileUploadForm');
    const uploadBtn = document.getElementById('uploadBtn');
    const uploadProgress = document.getElementById('uploadProgress');
    const uploadStatus = document.getElementById('uploadStatus');
    
    let isModified = false;
    let undoStack = [];
    let redoStack = [];
    let currentContent = fileContent.value;
    
    // Save initial state
    undoStack.push(currentContent);
    
    // Update file stats
    function updateStats() {
        const content = fileContent.value;
        document.getElementById('fileSize').textContent = new Blob([content]).size + ' bytes';
        document.getElementById('lineCount').textContent = (content.split('\n').length);
    }
    
    // Track changes
    fileContent.addEventListener('input', function() {
        if (!isModified) {
            isModified = true;
            saveBtn.innerHTML = '<i class="bi bi-save"></i> Save *';
            saveBtn.classList.add('btn-warning');
            saveBtn.classList.remove('btn-light');
        }
        
        // Add to undo stack if content changed significantly
        if (Math.abs(this.value.length - currentContent.length) > 10 || 
            this.value !== currentContent) {
            undoStack.push(currentContent);
            if (undoStack.length > 50) undoStack.shift(); // Limit stack size
            redoStack = []; // Clear redo stack
            currentContent = this.value;
        }
        
        updateStats();
    });
    
    // Save functionality
    saveBtn.addEventListener('click', function() {
        fileEditForm.submit();
    });
    
    // Undo functionality
    undoBtn.addEventListener('click', function() {
        if (undoStack.length > 1) {
            redoStack.push(undoStack.pop());
            fileContent.value = undoStack[undoStack.length - 1];
            currentContent = fileContent.value;
            updateStats();
        }
    });
    
    // Redo functionality
    redoBtn.addEventListener('click', function() {
        if (redoStack.length > 0) {
            const content = redoStack.pop();
            undoStack.push(content);
            fileContent.value = content;
            currentContent = fileContent.value;
            updateStats();
        }
    });
    
    // Find functionality
    findBtn.addEventListener('click', function() {
        findModal.show();
    });
    
    // Find and replace logic
    document.getElementById('findNextBtn').addEventListener('click', function() {
        const findText = document.getElementById('findText').value;
        const caseSensitive = document.getElementById('caseSensitive').checked;
        
        if (findText) {
            const content = fileContent.value;
            const flags = caseSensitive ? 'g' : 'gi';
            const regex = new RegExp(findText.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), flags);
            const match = regex.exec(content);
            
            if (match) {
                fileContent.focus();
                fileContent.setSelectionRange(match.index, match.index + match[0].length);
            } else {
                alert('Text not found');
            }
        }
    });
    
    document.getElementById('replaceBtn').addEventListener('click', function() {
        const findText = document.getElementById('findText').value;
        const replaceText = document.getElementById('replaceText').value;
        
        if (findText && fileContent.selectionStart !== fileContent.selectionEnd) {
            const selectedText = fileContent.value.substring(fileContent.selectionStart, fileContent.selectionEnd);
            const caseSensitive = document.getElementById('caseSensitive').checked;
            
            if ((caseSensitive && selectedText === findText) || 
                (!caseSensitive && selectedText.toLowerCase() === findText.toLowerCase())) {
                
                const start = fileContent.selectionStart;
                const end = fileContent.selectionEnd;
                fileContent.value = fileContent.value.substring(0, start) + replaceText + fileContent.value.substring(end);
                fileContent.setSelectionRange(start, start + replaceText.length);
                updateStats();
            }
        }
    });
    
    document.getElementById('replaceAllBtn').addEventListener('click', function() {
        const findText = document.getElementById('findText').value;
        const replaceText = document.getElementById('replaceText').value;
        const caseSensitive = document.getElementById('caseSensitive').checked;
        
        if (findText) {
            const flags = caseSensitive ? 'g' : 'gi';
            const regex = new RegExp(findText.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), flags);
            const newContent = fileContent.value.replace(regex, replaceText);
            
            if (newContent !== fileContent.value) {
                undoStack.push(fileContent.value);
                fileContent.value = newContent;
                currentContent = newContent;
                updateStats();
                findModal.hide();
            }
        }
    });
    
    // Keyboard shortcuts
    fileContent.addEventListener('keydown', function(e) {
        if (e.ctrlKey) {
            switch(e.key) {
                case 's':
                    e.preventDefault();
                    saveBtn.click();
                    break;
                case 'f':
                    e.preventDefault();
                    findBtn.click();
                    break;
                case 'z':
                    if (!e.shiftKey) {
                        e.preventDefault();
                        undoBtn.click();
                    } else {
                        e.preventDefault();
                        redoBtn.click();
                    }
                    break;
                case 'y':
                    e.preventDefault();
                    redoBtn.click();
                    break;
            }
        }
    });
    
    // Warn before leaving if unsaved changes
    window.addEventListener('beforeunload', function(e) {
        if (isModified) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
    
    // Toggle upload section
    toggleUploadBtn.addEventListener('click', function() {
        if (uploadSection.style.display === 'none') {
            uploadSection.style.display = 'block';
            this.innerHTML = '<i class="bi bi-chevron-up"></i> Hide Upload';
        } else {
            uploadSection.style.display = 'none';
            this.innerHTML = '<i class="bi bi-chevron-down"></i> Show Upload';
        }
    });
    
    // File upload functionality
    fileUploadForm.addEventListener('submit', function(e) {
        e.preventDefault();
        uploadFile();
    });
    
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
        uploadStatus.innerHTML = `<div class="alert alert-${type === 'error' ? 'danger' : (type === 'success' ? 'success' : 'info')} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>`;
        
        if (type !== 'info') {
            setTimeout(() => {
                uploadStatus.innerHTML = '';
            }, 5000);
        }
    }
    
    // Initial stats update
    updateStats();
});
</script>
@endpush