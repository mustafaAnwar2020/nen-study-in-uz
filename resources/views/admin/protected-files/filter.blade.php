<div class="modal fade bd-example-modal-lg" id="filter">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter data</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <form action="?" method="get">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" value="{{request()->name}}" id="name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="is_active">Status</label>
                        <select name="is_active" id="is_active" class="form-control">
                            <option value="all" {{request()->is_active == 'all' ? 'selected' : ''}}>All</option>
                            <option value="1" {{request()->is_active == '1' ? 'selected' : ''}}>Active</option>
                            <option value="0" {{request()->is_active == '0' ? 'selected' : ''}}>Inactive</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>