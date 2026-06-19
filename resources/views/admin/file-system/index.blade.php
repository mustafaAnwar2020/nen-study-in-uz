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
                                <h3 class="card-title">{{$model}}</h3>
                                <div class="float-right">
                                    <button class="btn btn-sm btn-info mr-2"
                                            onclick="refreshDirectories()" title="Refresh Scan"
                                    >
                                        <i class="fa fa-sync"></i> Refresh
                                    </button>
                                    <button class="btn btn-sm btn-primary mr-2"
                                            data-toggle="modal" data-target="#filter" title="Filter"
                                    >
                                        <i class="fa fa-filter"></i>
                                    </button>
                                    {{-- <a href="{{route('admin.file-system.create')}}" class="btn btn-sm btn-dark">
                                        <i class="fa fa-plus"></i> Upload File
                                    </a> --}}
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0 table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="bg-gradient-gray">
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th class="text-center">Directory</th>
                                        <th class="text-center">File Name</th>
                                        <th class="text-center">File Size</th>
                                        <th class="text-center">Last Modified</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($files as $idx => $file)
                                        <tr class="{{!$file['exists'] ? 'table-warning' : ''}}">
                                            <td>{{$idx+1}}</td>
                                            <td class="text-center">
                                                <span class="badge badge-info">{{$file['directory_name']}}</span>
                                                <br>
                                                <small class="text-muted">{{$file['directory']}}</small>
                                            </td>
                                            <td class="text-center">
                                                <strong>{{$file['file_name']}}</strong>
                                                <br>
                                                <small class="text-muted">{{$file['relative_path']}}</small>
                                            </td>
                                            <td class="text-center">{{$file['formatted_size']}}</td>
                                            <td class="text-center">{{$file['last_modified_formatted']}}</td>
                                            <td class="text-center">
                                                @if($file['exists'])
                                                    <span class="badge badge-success">
                                                        <i class="fa fa-check"></i> Available
                                                    </span>
                                                @else
                                                    <span class="badge badge-warning">
                                                        <i class="fa fa-exclamation-triangle"></i> Missing
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    @if($file['exists'])
                                                        <button class="btn btn-sm btn-info preview-file" 
                                                                data-directory="{{$file['directory']}}" 
                                                                title="Preview">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                        <a href="{{route('admin.file-system.download')}}?directory={{$file['directory']}}" 
                                                           class="btn btn-sm btn-success" 
                                                           title="Download">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                        <button class="btn btn-sm btn-danger delete-file" 
                                                                data-directory="{{$file['directory']}}" 
                                                                title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    @else
                                                        <a href="{{route('admin.file-system.create')}}?directory={{$file['directory']}}" 
                                                           class="btn btn-sm btn-primary" 
                                                           title="Upload File">
                                                            <i class="fa fa-upload"></i> Upload
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

                <!-- Summary Cards -->
                {{-- <div class="row">
                    <div class="col-md-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$files->where('exists', true)->count()}}</h3>
                                <p>Available Files</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{$files->where('exists', false)->count()}}</h3>
                                <p>Missing Files</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-exclamation-triangle"></i>
                            </div>
                        </div>
                    </div>
                </div> --}}

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="filterLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterLabel">Filter Files</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="GET" action="{{route('admin.file-system.index')}}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="directory">Directory</label>
                            <select name="directory" id="directory" class="form-control">
                                <option value="">All Directories</option>
                                @foreach($directories as $key => $value)
                                    <option value="{{$key}}" {{request('directory') == $key ? 'selected' : ''}}>
                                        {{$value}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Apply Filter</button>
                        <a href="{{route('admin.file-system.index')}}" class="btn btn-warning">Clear</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">File Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="previewContent">
                        <div class="text-center">
                            <i class="fa fa-spinner fa-spin fa-2x"></i>
                            <p>Loading preview...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Preview file
    $('.preview-file').click(function() {
        var directory = $(this).data('directory');
        $('#previewModal').modal('show');
        
        $.ajax({
            url: '{{route("admin.file-system.preview")}}',
            type: 'GET',
            data: { directory: directory },
            success: function(response) {
                if (response.success) {
                    var fileInfo = response.file_info;
                    var infoHtml = '<div class="alert alert-info">' +
                        '<strong>File:</strong> ' + fileInfo.name + '<br>' +
                        '<strong>Directory:</strong> ' + fileInfo.directory + '<br>' +
                        '<strong>Size:</strong> ' + fileInfo.size + '<br>' +
                        '<strong>Last Modified:</strong> ' + fileInfo.last_modified +
                        '</div>';
                    
                    $('#previewContent').html(infoHtml + response.html);
                } else {
                    $('#previewContent').html('<div class="alert alert-danger">' + response.error + '</div>');
                }
            },
            error: function(xhr) {
                var error = xhr.responseJSON ? xhr.responseJSON.error : 'Error loading preview';
                $('#previewContent').html('<div class="alert alert-danger">' + error + '</div>');
            }
        });
    });

    // Delete file
    $('.delete-file').click(function() {
        var directory = $(this).data('directory');
        
        if (confirm('Are you sure you want to delete this file? This action cannot be undone.')) {
            var form = $('<form>', {
                'method': 'POST',
                'action': '{{route("admin.file-system.destroy")}}'
            });
            
            form.append($('<input>', {
                'type': 'hidden',
                'name': '_token',
                'value': '{{csrf_token()}}'
            }));
            
            form.append($('<input>', {
                'type': 'hidden',
                'name': '_method',
                'value': 'DELETE'
            }));
            
            form.append($('<input>', {
                'type': 'hidden',
                'name': 'directory',
                'value': directory
            }));
            
            $('body').append(form);
            form.submit();
        }
    });
});

function refreshDirectories() {
    window.location.href = '{{route("admin.file-system.refresh")}}';
}
</script>
@endsection