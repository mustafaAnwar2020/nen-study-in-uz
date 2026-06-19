<div class="modal fade bd-example-modal-lg" id="filter">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">فلترة البيانات</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <form action="?" method="get">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="type">القسم</label>
                        <select name="type" id="type" class="form-control">
                            <option value="all">الكل</option>
                            <option {{(request()->type == 'Car') ? 'selected' : ''}} value="Car">
                                السيارات
                            </option>

                            <option {{(request()->type == 'Company') ? 'selected' : ''}} value="Company">
                                الشركات
                            </option>

                            <option {{(request()->type == 'Provider') ? 'selected' : ''}} value="Provider">
                                مزودي الخدمات
                            </option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">عرض البيانات</button>
                </div>
            </form>
        </div>
    </div>
</div>
