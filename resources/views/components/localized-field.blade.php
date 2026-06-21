@props([
    'name',
    'label',
    'value' => '',
    'valueAr' => '',
    'type' => 'input',
    'rows' => 3,
    'required' => false,
    'placeholder' => null,
    'placeholderAr' => null,
])

<div class="localized-field mb-2">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-2">
                <label>{{ $label }} <span class="text-muted">(English)</span>@if($required) <span class="text-danger">*</span>@endif</label>
                @if($type === 'textarea')
                    <textarea class="form-control" name="{{ $name }}" rows="{{ $rows }}" @if($required) required @endif @if($placeholder) placeholder="{{ $placeholder }}" @endif>{{ old($name, $value) }}</textarea>
                @else
                    <input class="form-control" name="{{ $name }}" value="{{ old($name, $value) }}" @if($required) required @endif @if($placeholder) placeholder="{{ $placeholder }}" @endif>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-2">
                <label>{{ $label }} <span class="text-muted">(Arabic)</span></label>
                @if($type === 'textarea')
                    <textarea class="form-control" name="{{ $name }}_ar" rows="{{ $rows }}" dir="rtl" lang="ar" @if($placeholderAr) placeholder="{{ $placeholderAr }}" @endif>{{ old($name . '_ar', $valueAr) }}</textarea>
                @else
                    <input class="form-control" name="{{ $name }}_ar" value="{{ old($name . '_ar', $valueAr) }}" dir="rtl" lang="ar" @if($placeholderAr) placeholder="{{ $placeholderAr }}" @endif>
                @endif
            </div>
        </div>
    </div>
</div>
