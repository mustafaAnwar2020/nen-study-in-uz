<div class="modal fade bd-example-modal-md" id="create">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة قرية / منطقة</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <form action="{{route('admin.set_locations.store_village', $city->id)}}" method="post"
                  enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf

                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="col-form-label">
                                    الاسم
                                </label>
                                <input type="text" name="name" id="name" required class="form-control">
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
