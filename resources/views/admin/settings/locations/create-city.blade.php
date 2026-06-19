<div class="modal fade bd-example-modal-md" id="create">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة مركز / حي</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <form action="{{route('admin.set_locations.store_city', $governorate->id)}}" method="post"
                  enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf

                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name_ar" class="col-form-label">
                                    الاسم بالعربي
                                </label>
                                <input type="text" name="name_ar" id="name_ar" required class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name_en" class="col-form-label">
                                    الاسم بالانجليزي
                                </label>
                                <input type="text" name="name_en" id="name_en" required class="form-control">
                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
