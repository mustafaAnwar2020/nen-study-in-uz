<small>Max Size: 5 MB</small>
<div class="uploader-container">
    <input type="file" {{ $attributes }} accept="{{ $accept }}">
    <progress class="progressBar progress__sec" value="0" max="100" style="width:100%;"></progress>
    <p class="status"></p>
</div>

@push('styles')
    <style>
        .progress__sec {
            display: none;
        }
    </style>
@endpush

@push('push_styles')
    <style>
        .progress__sec {
            display: none;
        }
    </style>
@endpush
