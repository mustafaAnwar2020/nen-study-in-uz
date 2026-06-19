<div class="tab-pane active" id="general">
    <form class="form-horizontal" action="{{route('admin.settings.update')}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="setting_type" value="general">
        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label>Site name</label>
                    <input type="text" name="site_name" class="form-control"
                           value="{{getSerializedSettingsData('general')->site_name}}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Open hours</label>
                    <input type="text" name="open_hours" class="form-control"
                           value="{{getSerializedSettingsData('general')->open_hours}}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control"
                           value="{{getSerializedSettingsData('general')->phone}}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Phone2</label>
                    <input type="text" name="phone2" class="form-control"
                           value="{{getSerializedSettingsData('general')->phone2}}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Phone3</label>
                    <input type="text" name="phone3" class="form-control"
                           value="{{getSerializedSettingsData('general')->phone3}}">
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control"
                           value="{{getSerializedSettingsData('general')->email}}">
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control"
                           value="{{getSerializedSettingsData('general')->address}}">
                </div>
            </div>


            <div class="col-md-12">
                <div class="form-group">
                    <label>About</label>
                    <textarea rows="3" name="site_about" class="form-control">{{getSerializedSettingsData('general')->site_about}}</textarea>
                </div>
            </div>



            <div class="col-md-6">
                <div class="form-group">
                    <label>Customer Service Email</label>
                    <input type="text" name="cs_email" class="form-control"
                           value="{{getSerializedSettingsData('general')->cs_email}}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Technical Support Email</label>
                    <input type="text" name="support_email" class="form-control"
                           value="{{getSerializedSettingsData('general')->support_email}}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Accreditation Email</label>
                    <input type="text" name="acc_email" class="form-control"
                           value="{{getSerializedSettingsData('general')->acc_email}}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Sales Email</label>
                    <input type="text" name="sales_email" class="form-control"
                           value="{{getSerializedSettingsData('general')->sales_email}}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>International Testing Email</label>
                    <input type="text" name="tca_email" class="form-control"
                           value="{{getSerializedSettingsData('general')->tca_email}}">
                </div>
            </div>



            <div class="col-md-6">
                <div class="custom-control custom-checkbox mt-2 mb-4">
                    <input class="custom-control-input"
                           name="m_mode"
                           {{getSettingByKey('m_mode') == 'on' ? 'checked' :''}}
                           type="checkbox" id="mModel">
                    <label for="mModel" class="custom-control-label">Activate maintained mode?</label>
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
