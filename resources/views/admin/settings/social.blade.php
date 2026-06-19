<div class="tab-pane" id="social">
    <form class="form-horizontal" action="{{ route('admin.settings.update') }}" method="post">
        @csrf
        <input type="hidden" name="setting_type" value="social">
        <div class="form-group row">
            <label for="inputName" class="col-sm-2 col-form-label">Facebook</label>
            <div class="col-sm-10">
                <input type="text" name="facebook" class="form-control"
                    value="{{ getSerializedSettingsData('social')->facebook }}">
            </div>
        </div>

        <div class="form-group row">
            <label for="inputName" class="col-sm-2 col-form-label">Twitter</label>
            <div class="col-sm-10">
                <input type="text" name="twitter" class="form-control"
                    value="{{ getSerializedSettingsData('social')->twitter }}">
            </div>
        </div>

        <div class="form-group row">
            <label for="inputName" class="col-sm-2 col-form-label">Instagram</label>
            <div class="col-sm-10">
                <input type="text" name="instagram" class="form-control"
                    value="{{ getSerializedSettingsData('social')->instagram }}">
            </div>
        </div>

        <div class="form-group row">
            <label for="inputName" class="col-sm-2 col-form-label">Linkedin</label>
            <div class="col-sm-10">
                <input type="text" name="linkedin" class="form-control"
                    value="{{ getSerializedSettingsData('social')->linkedin }}">
            </div>
        </div>

        <div class="form-group row">
            <label for="inputName" class="col-sm-2 col-form-label">Youtube</label>
            <div class="col-sm-10">
                <input type="text" name="youtube" class="form-control"
                    value="{{ getSerializedSettingsData('social')->youtube }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputName" class="col-sm-2 col-form-label">Tiktok</label>
            <div class="col-sm-10">
                <input type="text" name="tiktok" class="form-control"
                    value="{{ getSerializedSettingsData('social')->tiktok }}">
            </div>
        </div>

        <div class="form-group row">
            <label for="inputName" class="col-sm-2 col-form-label">Whatsapp</label>
            <div class="col-sm-10">
                <input type="text" name="whatsapp" class="form-control"
                    value="{{ getSerializedSettingsData('social')->whatsapp }}">
            </div>
        </div>

        <div class="form-group row">
            <label for="inputName" class="col-sm-2 col-form-label">Telegram</label>
            <div class="col-sm-10">
                <input type="text" name="telegram" class="form-control"
                    value="{{ getSerializedSettingsData('social')->telegram }}">
            </div>
        </div>

        @php
            $socialSettings = getSerializedSettingsData('social');
            $floatingWhatsapp = $socialSettings->floating_whatsapp ?? [];
            if (!is_array($floatingWhatsapp) && !is_object($floatingWhatsapp)) {
                $floatingWhatsapp = [];
            }
            $floatingTelegram = $socialSettings->floating_telegram ?? [];
            if (!is_array($floatingTelegram) && !is_object($floatingTelegram)) {
                $floatingTelegram = [];
            }
        @endphp

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Floating Whatsapp</label>
            <div class="col-sm-10">
                <div id="whatsapp-container">
                    @foreach ($floatingWhatsapp as $index => $wa)
                        @php $wa = (object)$wa; @endphp
                        <div class="row mb-2 wa-row">
                            <div class="col-md-5">
                                <input type="text" name="floating_whatsapp[{{ $index }}][title]"
                                    class="form-control" placeholder="Title (e.g. Sales)"
                                    value="{{ $wa->title ?? '' }}">
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="floating_whatsapp[{{ $index }}][number]"
                                    class="form-control" placeholder="Number (e.g. 961...)"
                                    value="{{ $wa->number ?? '' }}">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-sm remove-row"><i
                                        class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-success btn-sm mt-2" id="add-whatsapp"><i class="fa fa-plus"></i>
                    Add Whatsapp</button>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Floating Telegram</label>
            <div class="col-sm-10">
                <div id="telegram-container">
                    @foreach ($floatingTelegram as $index => $tg)
                        @php $tg = (object)$tg; @endphp
                        <div class="row mb-2 tg-row">
                            <div class="col-md-5">
                                <input type="text" name="floating_telegram[{{ $index }}][title]"
                                    class="form-control" placeholder="Title (e.g. Support)"
                                    value="{{ $tg->title ?? '' }}">
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="floating_telegram[{{ $index }}][username]"
                                    class="form-control" placeholder="Username" value="{{ $tg->username ?? '' }}">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-sm remove-row"><i
                                        class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-success btn-sm mt-2" id="add-telegram"><i
                        class="fa fa-plus"></i> Add Telegram</button>
            </div>
        </div>


        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-dark">
                    Update
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // WhatsApp Logic
        let waIndex = {{ count($floatingWhatsapp) }};
        document.getElementById('add-whatsapp').addEventListener('click', function() {
            let container = document.getElementById('whatsapp-container');
            let html = `
                <div class="row mb-2 wa-row">
                    <div class="col-md-5">
                        <input type="text" name="floating_whatsapp[${waIndex}][title]" class="form-control" placeholder="Title (e.g. Sales)">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="floating_whatsapp[${waIndex}][number]" class="form-control" placeholder="Number (e.g. 961...)">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>
                    </div>
                </div>`;
            container.insertAdjacentHTML('beforeend', html);
            waIndex++;
        });

        // Telegram Logic
        let tgIndex = {{ count($floatingTelegram) }};
        document.getElementById('add-telegram').addEventListener('click', function() {
            let container = document.getElementById('telegram-container');
            let html = `
                <div class="row mb-2 tg-row">
                    <div class="col-md-5">
                        <input type="text" name="floating_telegram[${tgIndex}][title]" class="form-control" placeholder="Title (e.g. Support)">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="floating_telegram[${tgIndex}][username]" class="form-control" placeholder="Username">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>
                    </div>
                </div>`;
            container.insertAdjacentHTML('beforeend', html);
            tgIndex++;
        });

        // Remove Row Logic (Event Delegation)
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-row')) {
                e.target.closest('.row').remove();
            }
        });
    });
</script>
