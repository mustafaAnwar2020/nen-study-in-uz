<div class="tab-pane" id="menu">
    <form class="form-horizontal" action="{{route('admin.settings.update')}}" method="post">
        @csrf
        <input type="hidden" name="setting_type" value="menu">
        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label>Pay URL</label>
                    <input type="text" name="pay_url" class="form-control"
                           value="{{getSerializedSettingsData('menu')->pay_url}}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Book Now URL</label>
                    <input type="text" name="book_now_url" class="form-control"
                           value="{{getSerializedSettingsData('menu')->book_now_url}}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Register URL</label>
                    <input type="text" name="register_url" class="form-control"
                           value="{{getSerializedSettingsData('menu')->register_url}}">
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
