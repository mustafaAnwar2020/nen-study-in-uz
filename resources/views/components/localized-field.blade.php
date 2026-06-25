@props([
    'name',
    'label',
    'value' => '',
    'valueAr' => null,
    'valueRu' => null,
    'source' => null,
    'type' => 'input',
    'rows' => 3,
    'required' => false,
    'placeholder' => null,
    'placeholderAr' => null,
    'placeholderRu' => null,
])

@php
    $enValue = old($name, $value !== '' && $value !== null ? $value : ($source?->{$name} ?? ''));
    $arValue = old($name . '_ar', $valueAr ?? ($source?->{$name . '_ar'} ?? ''));
    $ruValue = old($name . '_ru', $valueRu ?? ($source?->{$name . '_ru'} ?? ''));
@endphp

<div class="localized-field mb-2">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group mb-2">
                <label>{{ $label }} <span class="text-muted">(English)</span>@if($required) <span class="text-danger">*</span>@endif</label>
                @if($type === 'textarea')
                    <textarea class="form-control" name="{{ $name }}" rows="{{ $rows }}" @if($required) required @endif @if($placeholder) placeholder="{{ $placeholder }}" @endif>{{ $enValue }}</textarea>
                @else
                    <input class="form-control" name="{{ $name }}" value="{{ $enValue }}" @if($required) required @endif @if($placeholder) placeholder="{{ $placeholder }}" @endif>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-2">
                <label>{{ $label }} <span class="text-muted">(Arabic)</span></label>
                @if($type === 'textarea')
                    <textarea class="form-control" name="{{ $name }}_ar" rows="{{ $rows }}" dir="rtl" lang="ar" @if($placeholderAr) placeholder="{{ $placeholderAr }}" @endif>{{ $arValue }}</textarea>
                @else
                    <input class="form-control" name="{{ $name }}_ar" value="{{ $arValue }}" dir="rtl" lang="ar" @if($placeholderAr) placeholder="{{ $placeholderAr }}" @endif>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-2">
                <label>{{ $label }} <span class="text-muted">(Russian)</span></label>
                @if($type === 'textarea')
                    <textarea class="form-control" name="{{ $name }}_ru" rows="{{ $rows }}" lang="ru" @if($placeholderRu) placeholder="{{ $placeholderRu }}" @endif>{{ $ruValue }}</textarea>
                @else
                    <input class="form-control" name="{{ $name }}_ru" value="{{ $ruValue }}" lang="ru" @if($placeholderRu) placeholder="{{ $placeholderRu }}" @endif>
                @endif
            </div>
        </div>
    </div>
</div>
