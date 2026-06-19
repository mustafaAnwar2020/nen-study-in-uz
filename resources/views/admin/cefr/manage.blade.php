@extends('admin.layouts.admin_dashboard', ['title'=>$model, 'hasEditor'=> true])

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
                            </div>

                            <div class="card-body p-0 table-responsive">
                                <form action="{{route('admin.cefr.store')}}" method="post" id="form"
                                      enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="row_id" value="{{isset($row) ? $row->id : ''}}">

                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input id="title" class="form-control" name="title"
                                                           value="{{isset($row) ? $row->title : old('title')}}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="content_type">Content Type</label>
                                                    <select id="content_type" class="form-control" name="content_type" required>
                                                        <option value="">Select Type</option>
                                                        <option value="text" {{ (isset($row) && $row->content_type == 'text') || old('content_type') == 'text' ? 'selected' : '' }}>Text</option>
                                                        <option value="table" {{ (isset($row) && $row->content_type == 'table') || old('content_type') == 'table' ? 'selected' : '' }}>Table</option>
                                                        <option value="image" {{ (isset($row) && $row->content_type == 'image') || old('content_type') == 'image' ? 'selected' : '' }}>Image</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="order_number">Order Number</label>
                                                    <input id="order_number" class="form-control" name="order_number" type="number" min="1"
                                                           value="{{isset($row) ? $row->order_number : old('order_number')}}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="content">Content</label>
                                                    <div id="content-editor-wrapper">
                                                        <!-- Rich text editor for text content -->
                                                        <div id="rich-editor" data-tiny-editor data-input="content" style="display: none;">{!! isset($row) ? $row->content : old('content') !!}</div>
                                                        
                                                        <!-- Code editor for table content -->
                                                        <textarea id="code-editor" name="content" class="form-control" rows="15" style="display: none; font-family: 'Courier New', monospace;" placeholder="Enter HTML code for your table here...">{!! isset($row) ? $row->content : old('content') !!}</textarea>
                                                        
                                                        <!-- Hint for code editor -->
                                                        <div id="code-editor-hint" class="editor-hint" style="display: none;">
                                                            <i class="fas fa-info-circle"></i> You can write HTML code directly here. Use standard HTML table tags like &lt;table&gt;, &lt;tr&gt;, &lt;td&gt;, etc.
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="content" id="content">
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="image_path">
                                                        Image
                                                        @if(isset($row) && $row->image_path)
                                                            <a href="{{$row->image_path}}" target="_blank">
                                                                show
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endif
                                                    </label>
                                                    <x-file-upload class="form-control" data-folder="cefr"
                                                                   name="image_path"/>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                                                               {{ (isset($row) && $row->is_active) || (!isset($row)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="is_active">
                                                            Active
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </form>
                            </div>

                            <div class="card-footer clearfix">
                                <button type="submit" form="form" class="btn btn-dark">Save</button>
                                <a href="{{route('admin.cefr.index')}}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('scripts')
<style>
#code-editor {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    font-size: 14px;
    line-height: 1.5;
    resize: vertical;
}

#code-editor:focus {
    border-color: #86b7fe;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.editor-hint {
    font-size: 12px;
    color: #6c757d;
    margin-top: 5px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contentTypeSelect = document.getElementById('content_type');
    const richEditor = document.getElementById('rich-editor');
    const codeEditor = document.getElementById('code-editor');
    const codeEditorHint = document.getElementById('code-editor-hint');
    const hiddenContentInput = document.getElementById('content');
    
    function toggleEditor() {
        const selectedType = contentTypeSelect.value;
        
        if (selectedType === 'table') {
            // Show code editor for table content
            richEditor.style.display = 'none';
            codeEditor.style.display = 'block';
            codeEditorHint.style.display = 'block';
            codeEditor.removeAttribute('name'); // Remove name to prevent double submission
        } else {
            // Show rich text editor for text and image content
            richEditor.style.display = 'block';
            codeEditor.style.display = 'none';
            codeEditorHint.style.display = 'none';
            codeEditor.setAttribute('name', 'content_backup'); // Backup name
        }
    }
    
    // Initialize editor based on current content type
    toggleEditor();
    
    // Listen for content type changes
    contentTypeSelect.addEventListener('change', function() {
        // Transfer content between editors when switching
        if (this.value === 'table') {
            codeEditor.value = richEditor.innerHTML;
        } else {
            richEditor.innerHTML = codeEditor.value;
        }
        toggleEditor();
    });
    
    // Handle form submission
    const form = document.getElementById('form');
    form.addEventListener('submit', function(e) {
        const selectedType = contentTypeSelect.value;
        
        if (selectedType === 'table') {
            // For table content, use code editor value
            hiddenContentInput.value = codeEditor.value;
        } else {
            // For other content types, use rich editor value
            hiddenContentInput.value = richEditor.innerHTML;
        }
    });
});
</script>
@endsection