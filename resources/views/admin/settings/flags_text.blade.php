<div class="tab-pane" id="flags_text">
    <form class="form-horizontal" action="{{route('admin.settings.update')}}" method="post">
        @csrf
        <input type="hidden" name="setting_type" value="flags_text">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Flags Text</label>
                    <textarea rows="3" name="text" class="form-control" placeholder="Enter text to display above the flags">{{getSerializedSettingsData('flags_text')->text ?? 'Click on flags to search for partners in your region'}}</textarea>
                    <small class="form-text text-muted">This text will be displayed above the country flags on the homepage.</small>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-dark">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>