<div class="modal fade bd-example-modal-lg" id="filter">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter offers</h5>
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
                        <label for="date">Date</label>
                        <input type="date" name="date" value="{{request()->date}}" id="date" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="country_code">Country</label>
                        <select id="country_code" class="form-control" name="country_code">
                            @foreach(config('countries') as $code=>$country)
                                <option
                                        {{ (isset($row) && $row->country_code == $code)  ? 'selected' : ''  }}
                                        value="{{$code}}">{{$country}}</option>
                            @endforeach
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
