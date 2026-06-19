<div class="tab-pane" id="media">
    <form class="form-horizontal" action="{{route('admin.settings.update')}}" method="post">
        @csrf
        <input type="hidden" name="setting_type" value="media">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        Favicon
                        <a target="_blank" href="{{getSerializedSettingsData('media')->fav_icon}}">show current</a>
                    </label>
                    <x-file-upload class="form-control" data-folder="profile_process" name="fav_icon-file"/>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>logo
                        <a target="_blank" href="{{getSerializedSettingsData('media')->logo}}">show current</a>
                    </label>
                    <x-file-upload class="form-control" data-folder="profile_process" name="logo-file"/>
                </div>
            </div>

            {{-- <div class="col-md-6">
                <div class="form-group">
                    <label>ETS logo
                        <a target="_blank" href="{{getSerializedSettingsData('media')->ets_logo}}">show current</a>
                    </label>
                    <x-file-upload class="form-control" data-folder="profile_process" name="ets_logo-file"/>
                </div>
            </div> --}}



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
