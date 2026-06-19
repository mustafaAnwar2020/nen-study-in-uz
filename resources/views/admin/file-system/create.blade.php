@extends('admin.layouts.admin_dashboard', ['title'=>$model])

@section('content')

    <div class="content-wrapper">
        @include('admin.layouts.breadcrumb', ['model'=>$model])
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Upload Excel File</h3>
                                <div class="float-right">
                                    <a href="{{route('admin.file-system.index')}}" class="btn btn-sm btn-secondary">
                                        <i class="fa fa-arrow-left"></i> Back to List
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <form action="{{route('admin.file-system.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    
                                    <!-- Directory Selection -->
                                    <div class="form-group">
                                        <label for="directory">Target Directory <span class="text-danger">*</span></label>
                                        <select name="directory" id="directory" class="form-control @error('directory') is-invalid @enderror" required>
                                            <option value="">Select Directory</option>
                                            @foreach($directories as $key => $value)
                                                <option value="{{$key}}" {{old('directory', request('directory')) == $key ? 'selected' : ''}}>
                                                    {{$value}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('directory')
                                            <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Select the directory where the file will be uploaded. The file will be named "file.xlsx".
                                        </small>
                                    </div>

                                    <!-- File Upload -->
                                    <div class="form-group">
                                        <label for="file">Excel File <span class="text-danger">*</span></label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('file') is-invalid @enderror" 
                                                   id="file" name="file" accept=".xlsx,.xls" required>
                                            <label class="custom-file-label" for="file">Choose Excel file...</label>
                                        </div>
                                        @error('file')
                                            <div class="invalid-feedback d-block">{{$message}}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Accepted formats: .xlsx, .xls (Maximum size: 10MB)
                                        </small>
                                    </div>


                                    <!-- Current File Info (if exists) -->
                                    <div id="currentFileInfo" style="display: none;">
                                        <div class="alert alert-info">
                                            <h6><i class="fa fa-info-circle"></i> Current File Information</h6>
                                            <div id="currentFileDetails"></div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-upload"></i> Upload File
                                    </button>
                                    <a href="{{route('admin.file-system.index')}}" class="btn btn-secondary">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Update file input label
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });

    // Check for existing file when directory changes
    $('#directory').change(function() {
        var directory = $(this).val();
        if (directory) {
            checkExistingFile(directory);
        } else {
            $('#currentFileInfo').hide();
        }
    });

    // Check on page load if directory is pre-selected
    var initialDirectory = $('#directory').val();
    if (initialDirectory) {
        checkExistingFile(initialDirectory);
    }

    function checkExistingFile(directory) {
        $.ajax({
            url: '{{route("admin.file-system.getDirectoryInfo")}}',
            type: 'GET',
            data: { directory: directory },
            success: function(response) {
                if (response.success && response.file_exists) {
                    var fileInfo = response.file_info;
                    var infoHtml = '<strong>File:</strong> ' + fileInfo.name + '<br>' +
                                   '<strong>Size:</strong> ' + fileInfo.size + '<br>' +
                                   '<strong>Last Modified:</strong> ' + fileInfo.last_modified + '<br>' +
                                   '<span class="text-warning"><i class="fa fa-exclamation-triangle"></i> This file will be replaced!</span>';
                    
                    $('#currentFileDetails').html(infoHtml);
                    $('#currentFileInfo').show();
                } else {
                    $('#currentFileInfo').hide();
                }
            },
            error: function() {
                $('#currentFileInfo').hide();
            }
        });
    }

    // Form validation
    $('form').submit(function(e) {
        var directory = $('#directory').val();
        var file = $('#file').val();
        
        if (!directory) {
            alert('Please select a target directory.');
            e.preventDefault();
            return false;
        }
        
        if (!file) {
            alert('Please select a file to upload.');
            e.preventDefault();
            return false;
        }
        
        // Check file extension
        var allowedExtensions = ['xlsx', 'xls'];
        var fileExtension = file.split('.').pop().toLowerCase();
        
        if (allowedExtensions.indexOf(fileExtension) === -1) {
            alert('Please select a valid Excel file (.xlsx or .xls).');
            e.preventDefault();
            return false;
        }
        
        return true;
    });
});
</script>
@endsection