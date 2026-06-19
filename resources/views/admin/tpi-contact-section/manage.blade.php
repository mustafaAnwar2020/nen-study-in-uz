@extends('admin.layouts.admin_dashboard', ['title' => $model])

@section('content')
    <div class="content-wrapper">
        @include('admin.layouts.breadcrumb', ['model' => $model])
        <section class="content">
            <div class="container-fluid">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ $model }}</h3>
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <form action="{{ route('admin.tpi-contact-section.update') }}" method="post"
                                    id="form">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="section_title">Section Title (e.g. CONTACT)</label>
                                                    <input id="section_title" class="form-control" name="section_title"
                                                        value="{{ $row->section_title ?? old('section_title') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title_highlight">Title Highlight (red part, e.g. US)</label>
                                                    <input id="title_highlight" class="form-control" name="title_highlight"
                                                        value="{{ $row->title_highlight ?? old('title_highlight') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Active</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="is_active" value="1"
                                                            class="form-check-input"
                                                            {{ $row->is_active ?? true ? 'checked' : '' }}>
                                                        <label class="form-check-label">Show section</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <h5 class="mt-3">Phone Cards (Regional Offices)</h5>
                                            </div>
                                            <div class="col-md-12">
                                                <div id="tpi-phone-cards-container">
                                                    @php $phoneCards = $row->getPhoneCardsList(); @endphp
                                                    @forelse($phoneCards as $index => $card)
                                                        @php $card = (array) $card; @endphp
                                                        <div class="row mb-2 tpi-phone-row border rounded p-2">
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="phone_cards[{{ $index }}][icon]"
                                                                    value="{{ $card['icon'] ?? '' }}" placeholder="icon">
                                                            </div>
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="phone_cards[{{ $index }}][flag]"
                                                                    value="{{ $card['flag'] ?? '' }}"
                                                                    placeholder="flag-icon-xx"></div>
                                                            <div class="col-md-1"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="phone_cards[{{ $index }}][lang_tag]"
                                                                    value="{{ $card['lang_tag'] ?? '' }}"
                                                                    placeholder="(EN)"></div>
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="phone_cards[{{ $index }}][phone_number]"
                                                                    value="{{ $card['phone_number'] ?? '' }}"
                                                                    placeholder="tel number"></div>
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="phone_cards[{{ $index }}][phone_display]"
                                                                    value="{{ $card['phone_display'] ?? '' }}"
                                                                    placeholder="display"></div>
                                                            <div class="col-md-1">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-success add-phone-card {{ $loop->last ? '' : 'd-none' }}">+</button>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger remove-phone-card {{ $loop->first ? 'd-none' : '' }}">−</button>
                                                            </div>
                                                            <div class="col-md-6 mt-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="phone_cards[{{ $index }}][whatsapp]"
                                                                    value="{{ $card['whatsapp'] ?? '' }}"
                                                                    placeholder="WhatsApp Link"></div>
                                                            <div class="col-md-6 mt-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="phone_cards[{{ $index }}][telegram]"
                                                                    value="{{ $card['telegram'] ?? '' }}"
                                                                    placeholder="Telegram Link"></div>
                                                        </div>
                                                    @empty
                                                        <div class="row mb-2 tpi-phone-row border rounded p-2">
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="phone_cards[0][icon]" placeholder="icon"></div>
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="phone_cards[0][flag]" placeholder="flag"></div>
                                                            <div class="col-md-1"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="phone_cards[0][lang_tag]" placeholder="(EN)">
                                                            </div>
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="phone_cards[0][phone_number]" placeholder="tel">
                                                            </div>
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="phone_cards[0][phone_display]"
                                                                    placeholder="display"></div>
                                                            <div class="col-md-1"><button type="button"
                                                                    class="btn btn-sm btn-success add-phone-card">+</button><button
                                                                    type="button"
                                                                    class="btn btn-sm btn-danger remove-phone-card d-none">−</button>
                                                            </div>
                                                            <div class="col-md-6 mt-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="phone_cards[0][whatsapp]"
                                                                    placeholder="WhatsApp Link"></div>
                                                            <div class="col-md-6 mt-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="phone_cards[0][telegram]"
                                                                    placeholder="Telegram Link"></div>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <h5 class="mt-3">Social Media Card</h5>
                                            </div>
                                            @php
                                                $social = $row->getSocialCard();
                                                $socialLinks = $social['links'] ?? [];
                                            @endphp
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Social Card Icon</label>
                                                    <input type="text" class="form-control" name="social_card[icon]"
                                                        value="{{ $social['icon'] ?? '' }}" placeholder="bi-chat-dots">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Social Card Title</label>
                                                    <input type="text" class="form-control" name="social_card[title]"
                                                        value="{{ $social['title'] ?? '' }}" placeholder="Social Media">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Social Links</label>
                                                <div id="tpi-social-links-container">
                                                    @forelse($socialLinks as $idx => $link)
                                                        @php $link = (array) $link; @endphp
                                                        <div class="row mb-2 tpi-social-link-row">
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="social_card[links][{{ $idx }}][label]"
                                                                    value="{{ $link['label'] ?? '' }}"
                                                                    placeholder="Label"></div>
                                                            <div class="col-md-3"><input type="url"
                                                                    class="form-control form-control-sm"
                                                                    name="social_card[links][{{ $idx }}][url]"
                                                                    value="{{ $link['url'] ?? '' }}" placeholder="URL">
                                                            </div>
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="social_card[links][{{ $idx }}][icon_class]"
                                                                    value="{{ $link['icon_class'] ?? '' }}"
                                                                    placeholder="css class"></div>
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="social_card[links][{{ $idx }}][bi_icon]"
                                                                    value="{{ $link['bi_icon'] ?? '' }}"
                                                                    placeholder="bi-icon"></div>
                                                            <div class="col-md-1"><button type="button"
                                                                    class="btn btn-sm btn-success add-social-link {{ $loop->last ? '' : 'd-none' }}">+</button><button
                                                                    type="button"
                                                                    class="btn btn-sm btn-danger remove-social-link {{ $loop->first ? 'd-none' : '' }}">−</button>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="row mb-2 tpi-social-link-row">
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="social_card[links][0][label]"
                                                                    placeholder="Label"></div>
                                                            <div class="col-md-3"><input type="url"
                                                                    class="form-control form-control-sm"
                                                                    name="social_card[links][0][url]" placeholder="URL">
                                                            </div>
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="social_card[links][0][icon_class]"
                                                                    placeholder="css class"></div>
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="social_card[links][0][bi_icon]"
                                                                    placeholder="bi-icon"></div>
                                                            <div class="col-md-1"><button type="button"
                                                                    class="btn btn-sm btn-success add-social-link">+</button><button
                                                                    type="button"
                                                                    class="btn btn-sm btn-danger remove-social-link d-none">−</button>
                                                            </div>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <h5 class="mt-3">Email Cards</h5>
                                            </div>
                                            <div class="col-md-12">
                                                <div id="tpi-email-cards-container">
                                                    @php $emailCards = $row->getEmailCardsList(); @endphp
                                                    @forelse($emailCards as $index => $card)
                                                        @php $card = (array) $card; @endphp
                                                        <div class="row mb-2 tpi-email-row border rounded p-2">
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="email_cards[{{ $index }}][icon]"
                                                                    value="{{ $card['icon'] ?? '' }}" placeholder="icon">
                                                            </div>
                                                            <div class="col-md-3"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="email_cards[{{ $index }}][title]"
                                                                    value="{{ $card['title'] ?? '' }}"
                                                                    placeholder="Title"></div>
                                                            <div class="col-md-4"><input type="email"
                                                                    class="form-control form-control-sm"
                                                                    name="email_cards[{{ $index }}][email]"
                                                                    value="{{ $card['email'] ?? '' }}"
                                                                    placeholder="email"></div>
                                                            <div class="col-md-1">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-success add-email-card {{ $loop->last ? '' : 'd-none' }}">+</button>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger remove-email-card {{ $loop->first ? 'd-none' : '' }}">−</button>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="row mb-2 tpi-email-row border rounded p-2">
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="email_cards[0][icon]" placeholder="icon"></div>
                                                            <div class="col-md-3"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="email_cards[0][title]" placeholder="Title">
                                                            </div>
                                                            <div class="col-md-4"><input type="email"
                                                                    class="form-control form-control-sm"
                                                                    name="email_cards[0][email]" placeholder="email">
                                                            </div>
                                                            <div class="col-md-1"><button type="button"
                                                                    class="btn btn-sm btn-success add-email-card">+</button><button
                                                                    type="button"
                                                                    class="btn btn-sm btn-danger remove-email-card d-none">−</button>
                                                            </div>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer clearfix">
                                <button type="submit" form="form" class="btn btn-dark">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let phoneIdx = {{ count($row->getPhoneCardsList() ?: []) }};
            if (phoneIdx === 0) phoneIdx = 1;
            $(document).on('click', '.add-phone-card', function() {
                const $row = $(this).closest('.tpi-phone-row');
                const $new = $row.clone();
                $new.find('input').val('');
                $new.find('input').each(function() {
                    const n = $(this).attr('name');
                    if (n) $(this).attr('name', n.replace(/\[\d+\]/, '[' + phoneIdx + ']'));
                });
                $new.find('.add-phone-card').addClass('d-none');
                $new.find('.remove-phone-card').removeClass('d-none');
                $('#tpi-phone-cards-container').append($new);
                phoneIdx++;
            });
            $(document).on('click', '.remove-phone-card', function() {
                $(this).closest('.tpi-phone-row').remove();
            });

            let socialIdx = {{ count($row->getSocialCard()['links'] ?? []) }};
            if (socialIdx === 0) socialIdx = 1;
            $(document).on('click', '.add-social-link', function() {
                const $row = $(this).closest('.tpi-social-link-row');
                const $new = $row.clone();
                $new.find('input').val('');
                $new.find('input').each(function() {
                    const n = $(this).attr('name');
                    if (n) $(this).attr('name', n.replace(/\[\d+\]/, '[' + socialIdx + ']'));
                });
                $new.find('.add-social-link').addClass('d-none');
                $new.find('.remove-social-link').removeClass('d-none');
                $('#tpi-social-links-container').append($new);
                socialIdx++;
            });
            $(document).on('click', '.remove-social-link', function() {
                $(this).closest('.tpi-social-link-row').remove();
            });

            let emailIdx = {{ count($row->getEmailCardsList() ?: []) }};
            if (emailIdx === 0) emailIdx = 1;
            $(document).on('click', '.add-email-card', function() {
                const $row = $(this).closest('.tpi-email-row');
                const $new = $row.clone();
                $new.find('input').val('');
                $new.find('input').each(function() {
                    const n = $(this).attr('name');
                    if (n) $(this).attr('name', n.replace(/\[\d+\]/, '[' + emailIdx + ']'));
                });
                $new.find('.add-email-card').addClass('d-none');
                $new.find('.remove-email-card').removeClass('d-none');
                $('#tpi-email-cards-container').append($new);
                emailIdx++;
            });
            $(document).on('click', '.remove-email-card', function() {
                $(this).closest('.tpi-email-row').remove();
            });
        });
    </script>
@endpush
