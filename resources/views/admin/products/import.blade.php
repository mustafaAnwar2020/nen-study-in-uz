<div class="modal fade bd-example-modal-lg" id="import">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إستيراد من ملف XLS</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <form action="{{route('admin.products.import')}}" method="post" enctype="multipart/form-data" class="with_loader">
                @csrf

                <div class="modal-body">

                    <div class="form-group text-center">
                        <a href="{{asset('assets/helpers/import_products_v1.xlsx')}}" download
                           class="btn btn-sm btn-outline-info">
                            تحميل تمبلت Excel
                            <i class="fa fa-download"></i>
                        </a>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label for="user_id">بعد ملء المرفع قم باعده رفعه هنا</label>
                        <input type="file" class="form-control" name="file" accept=".xls,.xlsx">
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">استيراد</button>
                </div>
            </form>
        </div>
    </div>
</div>
