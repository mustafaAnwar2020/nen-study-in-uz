@extends('admin.layouts.admin_dashboard', ['title'=>$model])

@section('content')

    <div class="content-wrapper">
        @include('admin.layouts.breadcrumb', ['model'=>$model])
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Edit {{$model}} - {{$protectedFile->name}}</h3>
                                <a href="{{route('admin.protected-files.index')}}" class="btn btn-sm btn-secondary float-right">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>

                            <div class="card-body p-0 table-responsive">
                                <form action="{{route('admin.protected-files.update', $protectedFile->id)}}" method="post" id="form">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Name <span class="text-danger">*</span></label>
                                                    <input id="name" class="form-control @error('name') is-invalid @enderror" 
                                                           name="name" value="{{old('name', $protectedFile->name)}}" required>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="directory">Directory <span class="text-danger">*</span></label>
                                    <select id="directory" class="form-control @error('directory') is-invalid @enderror" 
                                            name="directory" required onchange="updateFilePath()">
                                        <option value="">Select Directory</option>
                                        @foreach($availableDirectories as $path => $label)
                                            @php
                                                $currentDirectory = dirname($protectedFile->file_path);
                                                $selected = old('directory', $currentDirectory) == $path ? 'selected' : '';
                                            @endphp
                                            <option value="{{$path}}" {{$selected}}>
                                                {{$label}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('directory')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="filename">Filename <span class="text-danger">*</span></label>
                                    <input id="filename" class="form-control @error('filename') is-invalid @enderror" 
                                           name="filename" value="file.xlsx" readonly required>
                                    @error('filename')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        All protected files use the standard filename "file.xlsx"
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="file_path">Full File Path <span class="text-danger">*</span></label>
                                    <input id="file_path" class="form-control @error('file_path') is-invalid @enderror" 
                                           name="file_path" value="{{old('file_path', $protectedFile->file_path)}}" readonly required>
                                    @error('file_path')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        This will be automatically generated from directory and filename
                                    </small>
                                </div>
                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input id="password" type="password" 
                                                           class="form-control @error('password') is-invalid @enderror" 
                                                           name="password" minlength="6">
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <small class="form-text text-muted">
                                                        Leave empty to keep current password. Minimum 6 characters if changing.
                                                    </small>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="is_active">Status</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" 
                                                               id="is_active" name="is_active" value="1" 
                                                               {{old('is_active', $protectedFile->is_active) ? 'checked' : ''}}>
                                                        <label class="form-check-label" for="is_active">
                                                            Active
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" 
                                                              name="description" rows="3">{{old('description', $protectedFile->description)}}</textarea>
                                                    @error('description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="alert alert-info">
                                                    <strong>File Info:</strong><br>
                                                    <strong>Created:</strong> {{$protectedFile->created_at->format('Y-m-d H:i:s')}}<br>
                                                    <strong>Last Accessed:</strong> 
                                                    @if($protectedFile->last_accessed)
                                                        {{$protectedFile->last_accessed->format('Y-m-d H:i:s')}}
                                                    @else
                                                        Never
                                                    @endif<br>
                                                    <strong>File Exists:</strong> 
                                                    @if($protectedFile->fileExists())
                                                        <span class="text-success">Yes</span>
                                                    @else
                                                        <span class="text-danger">No</span>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </form>
                            </div>

                            <div class="card-footer clearfix">
                                <button type="submit" form="form" class="btn btn-dark">
                                    <i class="fa fa-save"></i> Update Protected File
                                </button>
                                <a href="{{route('admin.protected-files.index')}}" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('scripts')
<script>
function updateFilePath() {
    const directory = document.getElementById('directory').value;
    const filename = 'file.xlsx'; // Always use file.xlsx
    const filePathInput = document.getElementById('file_path');
    
    if (directory) {
        filePathInput.value = directory + '/' + filename;
    } else {
        filePathInput.value = '';
    }
}

// Initialize on page load if values exist
document.addEventListener('DOMContentLoaded', function() {
    updateFilePath();
});
</script>
@endsection