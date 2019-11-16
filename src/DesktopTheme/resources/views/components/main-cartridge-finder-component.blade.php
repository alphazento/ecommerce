<div class="col-sm-12">
<div id="printer-finder">
    <div>
        <div class="col-12 col-xl-12">
            <div class="form-group">
                <select class="form-control" id="brand-id">
                    <option value="default">1. Select Printer Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->printer_category_id }}">{{ $brand->category_name }}</option>
                    @endforeach
                </select>
                <div class="alert alert-danger text-center" style="display: none;"><i class="fa fa-warning"></i>
                    Please
                    select printer brand.
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-12">
            <div class="form-group">
                <select class="form-control" id="printer-series" disabled>
                    <option value="default">2. Select Printer Series</option>
                </select>
                <div class="alert alert-danger text-center" style="display: none;"><i class="fa fa-warning"></i>
                    Please
                    select printer series.
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-12">
            <div class="form-group">
                <select class="form-control" id="printer-model" disabled>
                    <option value="default">3. Select Printer Model</option>
                </select>
                <div class="alert alert-danger text-center" style="display: none;"><i class="fa fa-warning"></i>
                    Please
                    select printer model.
                </div>
            </div>
        </div>
        <div class="cartrigefinder__btn-wrapper col-xl-12">
            <button type="button" class="btn button cartrigefinder__btn" id="find">Find Now<i
                        class="fa fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>
</div>