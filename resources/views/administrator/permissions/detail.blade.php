@extends('administrator.layouts.main')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Toolbar-->
        <div class="toolbar" id="kt_toolbar">
            <!--begin::Container-->
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <!--begin::Title-->
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Product</h1>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <!--end::Separator-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.products') }}" class="text-muted text-hover-primary">Products</a>
                        </li>
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-dark">Detail</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->

            </div>
            <!--end::Container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <!--begin::Form-->
                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <!--begin::General options-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>General</h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="required form-label">Category</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="category" class="form-select" data-control="select2"
                                        data-placeholder="Select an option">
                                        <option value="">Please Select</option>
                                        @foreach ($categories as $row) {
                                            <option value="{{ $row->id }}"
                                                {{ $row->id == $detail->category_id ? 'selected' : '' }}>
                                                {{ $row->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="required form-label">Product Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="name" class="form-control mb-2" placeholder="Product name"
                                        value="{{ $detail->name }}" />
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">A product name is required and recommended to
                                        be unique.</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="required form-label">Brand</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="brand" class="form-select" data-control="select2"
                                        data-placeholder="Select an option">
                                        <option value="">Please Select</option>
                                        @foreach ($brands as $row) {
                                            <option value="{{ $row->id }}"
                                                {{ $row->id == $detail->brand_id ? 'selected' : '' }}>
                                                {{ $row->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label">Description</label>
                                    <!--end::Label-->
                                    <!--begin::Editor-->
                                    <div class="description min-h-200px mb-2" name="description">
                                        {!! $detail->description !!}
                                    </div>
                                    <!--end::Editor-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">Set a description to the product for better
                                        visibility.</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label">Status</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" id="status" name="status"
                                            {{ $detail->status ? 'checked="checked"' : '' }} />
                                        <label class="form-check-label fw-bold text-gray-400 ms-3"
                                            for="status">Active</label>
                                    </div>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                        <!--begin::Media-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Media</h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <input type="hidden" name="image_delete" id="image_delete">
                                <div id="product_media">
                                    @foreach ($detail->images as $image)

                                        <!--begin::Image input-->
                                        <div class="image-list image-input image-input-outline mr-5"
                                            data-kt-image-input="true"
                                            style="background-image: url('{{ img_src($image->data_file, 'product') }}')">
                                            <!--begin::Image preview wrapper-->
                                            <div class="image-input-wrapper w-125px h-125px"
                                                style="background-image: url('{{ img_src($image->data_file, 'product') }}')">
                                            </div>
                                            <!--end::Image preview wrapper-->

                                        </div>
                                        <!--end::Image input-->

                                    @endforeach
                                </div>
                               
                                <br>
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Set the product media gallery.</div>
                                <!--end::Description-->
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::Media-->
                        <!--begin::Variations-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Variations</h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div id="product_options" class="row">
                                    <?php $index = 0; ?>
                                    @foreach ($detail->variants as $variant)
                                        <div class="variant-list col-6 mb-10" childidx="{{ $index }}">
                                            <div class="card card-bordered mb-10">
                                                <div class="card-header">
                                                    <h3 class="card-title">Variant</h3>
                                                    <div class="card-toolbar">
                                    
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <div class="mb-10 fv-row">
                                                            <!--begin::Input group-->
                                                            <div class="mb-10 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required form-label">SKU</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="hidden"
                                                                    name="variants[{{ $index }}][id]"
                                                                    class="form-control variant-id mb-2" placeholder="ID"
                                                                    value="{{ $variant->id }}" />
                                                                <!--end::Input-->
                                                                <!--begin::Input-->
                                                                <input type="text"
                                                                    name="variants[{{ $index }}][sku]"
                                                                    class="form-control variant-sku mb-2" placeholder="SKU"
                                                                    value="{{ $variant->sku }}" />
                                                                <!--end::Input-->
                                                                <!--begin::Description-->
                                                                <div class="text-muted fs-7"></div>
                                                                <!--end::Description-->
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--begin::Input group-->
                                                        <div class="mb-10 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="required form-label">Name</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" name="variants[{{ $index }}][name]"
                                                                class="form-control variant-name mb-2"
                                                                placeholder="Variant name"
                                                                value="{{ $variant->name }}" />
                                                            <!--end::Input-->
                                                            <!--begin::Description-->
                                                            <div class="text-muted fs-7">A product name is required and
                                                                recommended to
                                                                be unique.</div>
                                                            <!--end::Description-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Editor-->
                                                        <!--begin::Input group-->
                                                        <div class="mb-10 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="form-label">Description</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text"
                                                                name="variants[{{ $index }}][description]"
                                                                class="form-control variant-description mb-2"
                                                                placeholder="Description"
                                                                value="{{ $variant->description }}" />
                                                            <!--end::Input-->
                                                            <!--begin::Description-->
                                                            <div class="text-muted fs-7"></div>
                                                            <!--end::Description-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--end::Editor-->
                                                        <div class="row">
                                                            <div class="col-6 mb-10 fv-row">
                                                                <!--begin::Input group-->
                                                                <div class="fv-row">
                                                                    <!--begin::Label-->
                                                                    <label class="required form-label">Weight</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <div class="input-group mb-5">
                                                                        <input type="text"
                                                                            name="variants[{{ $index }}][weight]"
                                                                            class="form-control withseparator format-number text-end variant-weight"
                                                                            placeholder="Weight"
                                                                            value="{{ number_format($variant->weight, 2, '.', ',') }}" />
                                                                        <span class="input-group-text"
                                                                            id="basic-addon2">gram</span>
                                                                    </div>
                                                                    <!--end::Input-->
                                                                    <!--begin::Description-->
                                                                    <div class="text-muted fs-7"></div>
                                                                    <!--end::Description-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <div class="col-6 mb-10 fv-row">
                                                                <!--begin::Input group-->
                                                                <div class="row">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label">Dimensions</label>
                                                                    <!--end::Label-->
                                                                    <?php $dimension = json_decode($variant->dimensions); ?>
                                                                    <!--begin::Input-->
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <div class="input-group mb-5">
                                                                            <input type="text"
                                                                                name="variants[{{ $index }}][dimensions][length]"
                                                                                class="form-control withseparator format-number text-end variant-dimensions_length "
                                                                                placeholder="Length"
                                                                                value="{{ number_format($dimension->length, 2, '.', ',') }}" />
                                                                            <span class="input-group-text"
                                                                                id="basic-addon2">cm</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <div class="input-group mb-5">
                                                                            <input type="text"
                                                                                name="variants[{{ $index }}][dimensions][width]"
                                                                                class="form-control withseparator format-number text-end variant-dimensions_width "
                                                                                placeholder="Width"
                                                                                value="{{ number_format($dimension->width, 2, '.', ',') }}" />
                                                                            <span class="input-group-text"
                                                                                id="basic-addon2">cm</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <div class="input-group mb-5">
                                                                            <input type="text"
                                                                                name="variants[{{ $index }}][dimensions][height]"
                                                                                class="form-control withseparator format-number text-end variant-dimensions_height "
                                                                                placeholder="Height"
                                                                                value="{{ number_format($dimension->height, 2, '.', ',') }}" />
                                                                            <span class="input-group-text"
                                                                                id="basic-addon2">cm</span>
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-4 mb-10 fv-row">
                                                                <!--begin::Input group-->
                                                                <div class="mb-10 fv-row">
                                                                    <!--begin::Label-->
                                                                    <label class="required form-label">Price</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        name="variants[{{ $index }}][price]"
                                                                        class="form-control withseparator format-number text-end variant-price mb-2"
                                                                        placeholder="Price"
                                                                        value="{{ number_format($variant->price, 2, '.', ',') }}" />
                                                                    <!--end::Input-->
                                                                    <!--begin::Description-->
                                                                    <div class="text-muted fs-7"></div>
                                                                    <!--end::Description-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <div class="col-4 mb-10 fv-row">
                                                                <!--begin::Input group-->
                                                                <div class="mb-10 fv-row">
                                                                    <!--begin::Label-->
                                                                    <label class="required form-label">Minimal
                                                                        Stock</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        name="variants[{{ $index }}][minimal_stock]"
                                                                        class="form-control withseparator format-number text-end variant-minimal_stock mb-2"
                                                                        placeholder="Minimal Stock"
                                                                        value="{{ number_format($variant->minimal_stock, 2, '.', ',') }}" />
                                                                    <!--end::Input-->
                                                                    <!--begin::Description-->
                                                                    <div class="text-muted fs-7"></div>
                                                                    <!--end::Description-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <div class="col-4 mb-10 fv-row">
                                                                <!--begin::Input group-->
                                                                <div class="mb-10 fv-row">
                                                                    <!--begin::Label-->
                                                                    <label class="required form-label">Stock</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        name="variants[{{ $index }}][stock]"
                                                                        class="form-control withseparator format-number text-end variant-stock mb-2"
                                                                        placeholder="Stock"
                                                                        value="{{ number_format($variant->stock, 2, '.', ',') }}" />
                                                                    <!--end::Input-->
                                                                    <!--begin::Description-->
                                                                    <div class="text-muted fs-7"></div>
                                                                    <!--end::Description-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Form group-->
                                                </div>
                                            </div>
                                        </div>
                                        <?php $index++; ?>
                                    @endforeach
                                </div>

                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::Variations-->
                    </div>

                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <a href="{{ route('admin.products') }}" id="kt_ecommerce_add_product_cancel"
                            class="btn btn-light me-5">Cancel</a>
                        <!--end::Button-->
                    </div>
                </div>
                <!--end::Main column-->
                <!--end::Form-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>


@endsection

@push('scripts')
    <script src="{{ asset_administrator('assets/js/custom/apps/ecommerce/catalog/products.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            resetData();
            resetImage();
        });

        function resetData() {

            var index = 0;
            $(".variant-list").each(function() {
                var another = this;
                search_index = $(this).attr("childidx");
                $(this).find('input,select').each(function() {
                    // console.log("this name : " + this.name);
                    // console.log('search name (' + search_index + ')')
                    // console.log('replace name [' + index + ']')
                    // console.log("----------------------------------------------------------------");
                    this.name = this.name.replace('[' + search_index + ']', '[' + index + ']');
                    $(another).attr("childidx", index);
                });

                $(this).find(".format-number").keydown(function(e) {
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e.keyCode == 65 && (e
                            .ctrlKey === true || e.metaKey === true)) || (e.keyCode >= 35 && e.keyCode <=
                            40)) {
                        return;
                    }
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode >
                            105)) {
                        e.preventDefault();
                    }
                });

                $(this).find('.withseparator').on({
                    keyup: function() {
                        formatCurrency($(this));
                    },
                    blur: function() {
                        formatCurrency($(this), "blur");
                    }
                });

                $(this).find(".delete").click(function(e) {
                    Swal.fire({
                        html: 'Are you sure delete this data?',
                        icon: "info",
                        buttonsStyling: false,
                        showCancelButton: true,
                        confirmButtonText: "Ok, got it!",
                        cancelButtonText: 'Nope, cancel it',
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: 'btn btn-danger'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(another).remove();
                            new swal("Horray!", "Data has been deleted.", "success");
                            resetData()
                        }
                    });
                });

                $(this).find(".duplicate").click(function(e) {
                    Swal.fire({
                        html: 'Are you sure duplicate this data?',
                        icon: "info",
                        buttonsStyling: false,
                        showCancelButton: true,
                        confirmButtonText: "Ok, got it!",
                        cancelButtonText: 'Nope, cancel it',
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: 'btn btn-danger'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {

                            var clonning = $(".template-variant").clone();
                            clonning.removeAttr("style");
                            clonning.removeClass('template-variant');
                            clonning.addClass('variant-list');
                            clonning.find(".variant-sku").val($(another).find(".variant-sku")
                                .val());
                            clonning.find(".variant-name").val($(another).find(".variant-name")
                                .val());
                            clonning.find(".variant-description").val($(another).find(
                                ".variant-description").val());
                            clonning.find(".variant-price").val($(another).find(".variant-price")
                                .val());
                            clonning.find(".variant-weight").val($(another).find(".variant-weight")
                                .val());
                            clonning.find(".variant-dimensions_length").val($(another).find(
                                ".variant-dimensions_length").val());
                            clonning.find(".variant-dimensions_width").val($(another).find(
                                ".variant-dimensions_width").val());
                            clonning.find(".variant-dimensions_height").val($(another).find(
                                ".variant-dimensions_height").val());
                            clonning.find(".variant-minimal_stock").val($(another).find(
                                ".variant-minimal_stock").val());
                            clonning.find(".variant-stock").val($(another).find(".variant-stock")
                                .val());
                            $("#product_options").append(clonning);

                            new swal("Horray!", "Data has been duplicated", "success");
                            resetData()
                        }
                    });
                });

                index++;
            });

        }

        $(document).on('click', '#add_another_variation', function(event) {
            console.log("this")
            var clonning = $(".template-variant").clone();
            clonning.removeAttr("style");
            clonning.removeClass('template-variant');
            clonning.addClass('variant-list');
            $("#product_options").append(clonning);
            resetData();
        });

        function resetImage() {

            var index = 0;
            $(".image-list").each(function() {
                var another = this;
                $(this).find(".delete").click(function(e) {
                    Swal.fire({
                        html: 'Are you sure delete this data?',
                        icon: "info",
                        buttonsStyling: false,
                        showCancelButton: true,
                        confirmButtonText: "Ok, got it!",
                        cancelButtonText: 'Nope, cancel it',
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: 'btn btn-danger'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(another).remove();
                            new swal("Horray!", "Data has been deleted.", "success");
                            resetImage()
                        }
                    });
                });

                $(this).find(".image-delete").click(function(e) {
                    Swal.fire({
                        html: 'Are you sure delete this data?',
                        icon: "info",
                        buttonsStyling: false,
                        showCancelButton: true,
                        confirmButtonText: "Ok, got it!",
                        cancelButtonText: 'Nope, cancel it',
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: 'btn btn-danger'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var ix = $(this).data('ix');
                            $(another).remove();
                            var image_delete = $("#image_delete").val();
                            if (image_delete != "") {
                                image_delete += "," + ix;
                            } else {
                                image_delete += ix;
                            }
                            $("#image_delete").val(image_delete)
                            new swal("Horray!", "Data has been deleted.", "success");
                            resetImage()
                        }
                    });
                });
            });
        }

        $(document).on('click', '#add_another_image', function(event) {
            var clonning = $(".template-image").clone();
            clonning.removeAttr("style");
            clonning.removeClass('template-image');
            clonning.addClass('image-list');
            $("#product_media").append(clonning);
            var media = $("#product_media .image-list").length;
            var preview = $("#product_media .image-preview").length;
            var total = parseInt(media) + parseInt(preview);
            if (total == 5) {
                console.log("do this");
                $('#add_another_image').attr('disabled', 'disabled');
            }
            resetImage();
        });

        $(this).find('.withseparator').on({
            keyup: function() {
                formatCurrency($(this));
            },
            blur: function() {
                formatCurrency($(this), "blur");
            }
        });

        function formatNumber(n) {
            // format number 1000000 to 1,234,567
            var xx = n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            // console.log(xx)/
            return xx;

        }

        function formatDecimal(n) {
            // format number 1000000 to 1,234,567
            var xx = n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "");
            // console.log(xx)
            return xx;

        }

        function formatCurrency(input, blur) {
            // appends $ to value, validates decimal side
            // and puts cursor back in right position.

            // get input value
            var input_val = input.val();

            // don't validate empty input
            if (input_val === "") {
                return;
            }

            // original length
            var original_len = input_val.length;

            // initial caret position 
            var caret_pos = input.prop("selectionStart");

            // check for decimal
            if (input_val.indexOf(".") >= 0) {

                // get position of first decimal
                // this prevents multiple decimals from
                // being entered
                var decimal_pos = input_val.indexOf(".");

                // split number by decimal point
                var left_side = input_val.substring(0, decimal_pos);
                var right_side = input_val.substring(decimal_pos);

                // add commas to left side of number
                left_side = formatNumber(left_side);

                // validate right side
                right_side = formatDecimal(right_side);

                // On blur make sure 2 numbers after decimal
                if (blur === "blur") {
                    right_side += "00";
                }

                // Limit decimal to only 2 digits
                right_side = right_side.substring(0, 2);

                // join number by .
                input_val = "" + left_side + "." + right_side;

            } else {
                // no decimal entered
                // add commas to number
                // remove all non-digits
                input_val = formatNumber(input_val);
                input_val = "" + input_val;

                // final formatting
                if (blur === "blur") {
                    input_val += ".00";
                }
            }

            // send updated string to input
            input.val(input_val);

            // put caret back in the right position
            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);
        }
    </script>
@endpush
