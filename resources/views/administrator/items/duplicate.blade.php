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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Items</h1>
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
                            <a href="{{ route('admin.items') }}" class="text-muted text-hover-primary">Items</a>
                        </li>
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-dark">Duplicate</li>
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
                <form id="form_add" class="form d-flex flex-column flex-lg-row"
                    action="{{ route('admin.items.doduplicate') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" class="form-control mb-2" placeholder="ID" value="{{ $edit->id }}" />
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
                                                    {{ $row->id == $edit->category_id ? 'selected' : '' }}>
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
                                        <label class="required form-label">Item Name</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="name" class="form-control mb-2" placeholder="Item name"
                                            value="{{ $edit->name }}" />
                                        <!--end::Input-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">A item name is required and recommended to
                                            be unique.</div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Input group-->
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
                                                    {{ $row->id == $edit->brand_id ? 'selected' : '' }}>
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
                                        {{-- <div class="description min-h-200px mb-2" name="description">

                                        </div> --}}
                                        <textarea class="form-control"
                                            name="description" id="description">{!! $edit->description !!}</textarea>
                                        <!--end::Editor-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">Set a description to the item for better
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
                                            <input class="form-check-input" type="checkbox" value="1" id="status"
                                                name="status" {{ $edit->status ? 'checked="checked"' : '' }} />
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
                                    <div class="overflow-auto pb-3">
                                        <div class="notice d-flex bg-light-dark rounded border-dark border border-dashed min-w-lg-600px flex-shrink-0 p-6">
                                            <span class="svg-icon svg-icon-2tx svg-icon-dark me-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 28 28" fill="none">
                                                    <path opacity="0.3" d="M5.78001 21.115L3.28001 21.949C3.10897 22.0059 2.92548 22.0141 2.75004 21.9727C2.57461 21.9312 2.41416 21.8418 2.28669 21.7144C2.15923 21.5869 2.06975 21.4264 2.0283 21.251C1.98685 21.0755 1.99507 20.892 2.05201 20.7209L2.886 18.2209L7.22801 13.879L10.128 16.774L5.78001 21.115Z" fill="black"/>
                                                    <path d="M21.7 8.08899L15.911 2.30005C15.8161 2.2049 15.7033 2.12939 15.5792 2.07788C15.455 2.02637 15.3219 1.99988 15.1875 1.99988C15.0531 1.99988 14.92 2.02637 14.7958 2.07788C14.6717 2.12939 14.5589 2.2049 14.464 2.30005L13.74 3.02295C13.548 3.21498 13.4402 3.4754 13.4402 3.74695C13.4402 4.01849 13.548 4.27892 13.74 4.47095L14.464 5.19397L11.303 8.35498C10.1615 7.80702 8.87825 7.62639 7.62985 7.83789C6.38145 8.04939 5.2293 8.64265 4.332 9.53601C4.14026 9.72817 4.03256 9.98855 4.03256 10.26C4.03256 10.5315 4.14026 10.7918 4.332 10.984L13.016 19.667C13.208 19.859 13.4684 19.9668 13.74 19.9668C14.0115 19.9668 14.272 19.859 14.464 19.667C15.3575 18.77 15.9509 17.618 16.1624 16.3698C16.374 15.1215 16.1932 13.8383 15.645 12.697L18.806 9.53601L19.529 10.26C19.721 10.452 19.9814 10.5598 20.253 10.5598C20.5245 10.5598 20.785 10.452 20.977 10.26L21.7 9.53601C21.7952 9.44108 21.8706 9.32825 21.9221 9.2041C21.9737 9.07995 22.0002 8.94691 22.0002 8.8125C22.0002 8.67809 21.9737 8.54505 21.9221 8.4209C21.8706 8.29675 21.7952 8.18392 21.7 8.08899Z" fill="black"/>
                                                </svg>
                                            </span>
                                            <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                                <div class="mb-3 mb-md-0 fw-bold">
                                                    <h4 class="text-gray-900 fw-bolder">Best Resolution Image Display:</h4>
                                                    <div class="fs-6 text-gray-700 pe-7">
                                                        <ul class="m-0">
                                                            <li>Potrait image</li>
                                                            <li>385 X 387 px</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="image_delete" id="image_delete">
                                    <div id="item_media">
                                        @foreach ($edit->images as $image)

                                            <!--begin::Image input-->
                                            <div class="image-list image-input image-input-outline mr-5"
                                                data-kt-image-input="true"
                                                style="background-image: url('{{ img_src($image->data_file, 'product') }}')">
                                                    {{-- JIKA INGIN KE LOCAL STORANGE --}}
                                                    {{-- {{ asset('storage/administrator/assets/media/products/'.$image->data_file) }} --}}
                                                <!--begin::Image preview wrapper-->
                                                <div class="image-input-wrapper w-125px h-125px"
                                                    style="background-image: url('{{ img_src($image->data_file, 'product') }}')">
                                                </div>
                                                <!--end::Image preview wrapper-->

                                                <button type="button" data-ix="{{ $image->id }}"
                                                    class="btn btn-sm btn-icon btn-light-danger image-delete">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
                                                    <span class="svg-icon svg-icon-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none">
                                                            <rect opacity="0.5" x="7.05025" y="15.5356" width="12"
                                                                height="2" rx="1" transform="rotate(-45 7.05025 15.5356)"
                                                                fill="black" />
                                                            <rect x="8.46447" y="7.05029" width="12" height="2" rx="1"
                                                                transform="rotate(45 8.46447 7.05029)" fill="black" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </button>
                                            </div>
                                            <!--end::Image input-->

                                        @endforeach
                                    </div>
                                    <!--begin::Form group-->
                                    <div class="form-group mt-5">
                                        <button type="button" id="add_another_image" class="btn btn-sm btn-light-primary">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1"
                                                        transform="rotate(-90 11 18)" fill="black" />
                                                    <rect x="6" y="11" width="12" height="2" rx="1" fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->Add another image
                                        </button>
                                    </div>
                                    <!--end::Form group-->
                                    <br>
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">Set the item media gallery.</div>
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
                                    <div id="item_options" class="row">
                                        <?php $index = 0; ?>
                                        @foreach ($edit->variants as $variant)
                                            <div class="variant-list col-6 mb-10" childidx="{{ $index }}">
                                                <div class="card card-bordered mb-10">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Variant</h3>
                                                        <div class="card-toolbar">
                                                            <button type="button" data-repeater-delete=""
                                                                class="btn btn-sm btn-icon btn-light-danger duplicate">
                                                                <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen054.svg-->
                                                                <span class="svg-icon svg-icon-muted svg-icon-2"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none">
                                                                        <path opacity="0.5"
                                                                            d="M18 2H9C7.34315 2 6 3.34315 6 5H8C8 4.44772 8.44772 4 9 4H18C18.5523 4 19 4.44772 19 5V16C19 16.5523 18.5523 17 18 17V19C19.6569 19 21 17.6569 21 16V5C21 3.34315 19.6569 2 18 2Z"
                                                                            fill="black" />
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M14.7857 7.125H6.21429C5.62255 7.125 5.14286 7.6007 5.14286 8.1875V18.8125C5.14286 19.3993 5.62255 19.875 6.21429 19.875H14.7857C15.3774 19.875 15.8571 19.3993 15.8571 18.8125V8.1875C15.8571 7.6007 15.3774 7.125 14.7857 7.125ZM6.21429 5C4.43908 5 3 6.42709 3 8.1875V18.8125C3 20.5729 4.43909 22 6.21429 22H14.7857C16.5609 22 18 20.5729 18 18.8125V8.1875C18 6.42709 16.5609 5 14.7857 5H6.21429Z"
                                                                            fill="black" />
                                                                    </svg></span>
                                                                <!--end::Svg Icon-->
                                                            </button>
                                                            &nbsp;
                                                            <button type="button" data-repeater-delete=""
                                                                class="btn btn-sm btn-icon btn-light-danger delete"
                                                                data-ix="{{ $variant->id }}">
                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none">
                                                                        <rect opacity="0.5" x="7.05025" y="15.5356"
                                                                            width="12" height="2" rx="1"
                                                                            transform="rotate(-45 7.05025 15.5356)"
                                                                            fill="black" />
                                                                        <rect x="8.46447" y="7.05029" width="12" height="2"
                                                                            rx="1" transform="rotate(45 8.46447 7.05029)"
                                                                            fill="black" />
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </button>
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
                                                                        class="form-control variant-id mb-2"
                                                                        placeholder="ID" value="{{ $variant->id }}" />
                                                                    <!--end::Input-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        name="variants[{{ $index }}][sku]"
                                                                        class="form-control variant-sku mb-2"
                                                                        placeholder="SKU" value="{{ $variant->sku }}" />
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
                                                                <input type="text"
                                                                    name="variants[{{ $index }}][name]"
                                                                    class="form-control variant-name mb-2"
                                                                    placeholder="Variant name"
                                                                    value="{{ $variant->name }}" />
                                                                <!--end::Input-->
                                                                <!--begin::Description-->
                                                                <div class="text-muted fs-7">A item name is required and
                                                                    recommended to
                                                                    be unique.</div>
                                                                <!--end::Description-->
                                                            </div>
                                                            <div class="mb-10 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required form-label">Unit</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="variants[{{ $index }}][unit]" class="form-select variant-unit">
                                                                    @foreach ($units as $row) 
                                                                        <option value="{{ $row->id }}" {{ $row->id == $variant->unit_id ? "Selected" : "" }}> {{ $row->name }} </option>
                                                                    @endforeach
                                                                </select>
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="mb-10 row">
                                                                <div class="col-lg-4">
                                                                    <div class="form-check form-check-custom form-check-solid mb-2">
                                                                        <input class="form-check-input variant-sale" type="checkbox" name="variants[{{ $index }}][sale]" id="variants[{{ $index }}][sale]" value="1" {{ $variant->sale == 1 ? 'checked' : '' }}/>
                                                                        <label class="form-check-label" for="variants[{{ $index }}][sale]">Sale?</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-check form-check-custom form-check-solid mb-2">
                                                                        <input class="form-check-input variant-bought" type="checkbox" name="variants[{{ $index }}][bought]" id="variants[{{ $index }}][bought]" value="1" {{ $variant->bought == 1 ? 'checked' : '' }} />
                                                                        <label class="form-check-label" for="variants[{{ $index }}][bought]">Bought?</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-check form-check-custom form-check-solid mb-2">
                                                                        <input class="form-check-input variant-ingredient" type="checkbox" name="variants[{{ $index }}][ingredient]" id="variants[{{ $index }}][ingredient]" value="1" {{ $variant->ingredient == 1 ? 'checked' : '' }} />
                                                                        <label class="form-check-label" for="variants[{{ $index }}][ingredient]">Ingredient?</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-10 row">
                                                                <div class="col-lg-4">
                                                                    <div class="form-check form-check-custom form-check-solid mb-2">
                                                                        <input class="form-check-input variant-show_online_shop" type="checkbox" name="variants[{{ $index }}][show_online_shop]" id="variants[{{ $index }}][show_online_shop]" value="1" {{ $variant->show_online_shop == 1 ? 'checked' : '' }}/>
                                                                        <label class="form-check-label" for="variants[{{ $index }}][show_online_shop]">Show In Online Shop Module??</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-check form-check-custom form-check-solid mb-2">
                                                                        <input class="form-check-input variant-show_pos" type="checkbox" name="variants[{{ $index }}][show_pos]" id="variants[{{ $index }}][show_pos]" value="1" {{ $variant->show_pos == 1 ? 'checked' : '' }} />
                                                                        <label class="form-check-label" for="variants[{{ $index }}][show_pos]">Show In POS Module?</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-check form-check-custom form-check-solid mb-2">
                                                                        <input class="form-check-input variant-production" type="checkbox" name="variants[{{ $index }}][production]" id="variants[{{ $index }}][production]" value="1" {{ $variant->production == 1 ? 'checked' : '' }} />
                                                                        <label class="form-check-label" for="variants[{{ $index }}][production]">Is Production?</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end::Input group-->
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
                                                                        <?php $dimension = (array) json_decode($variant->dimensions); ?>
                                                                        <!--begin::Input-->
                                                                        <div class="col-md-12 col-sm-12">
                                                                            <div class="input-group mb-5">
                                                                                <input type="text"
                                                                                    name="variants[{{ $index }}][dimensions][length]"
                                                                                    class="form-control withseparator format-number text-end variant-dimensions_length "
                                                                                    placeholder="Length"
                                                                                    value="{{ $dimension["length"] != ""?number_format($dimension["length"], 2, '.', ','):"" }}" />
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
                                                                                    value="{{ $dimension["width"] != ""?number_format($dimension["width"], 2, '.', ','):"" }}" />
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
                                                                                    value="{{ $dimension["height"] != ""?number_format($dimension["height"], 2, '.', ','):"" }}" />
                                                                                <span class="input-group-text"
                                                                                    id="basic-addon2">cm</span>
                                                                            </div>
                                                                        </div>
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                            </div>
                                                            <!--end::Editor-->
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
                                                                {{-- <div class="col-4 mb-10 fv-row">
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
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                        <!--end::Form group-->
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $index++; ?>
                                        @endforeach
                                    </div>
                                    <!--begin::Form group-->
                                    <div class="form-group mt-5">
                                        <button type="button" id="add_another_variation"
                                            class="btn btn-sm btn-light-primary">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1"
                                                        transform="rotate(-90 11 18)" fill="black" />
                                                    <rect x="6" y="11" width="12" height="2" rx="1" fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->Add another variation
                                        </button>
                                    </div>
                                    <!--end::Form group-->
                                </div>
                                <!--end::Card header-->
                            </div>
                            <!--end::Variations-->
                        </div>

                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="{{ route('admin.items') }}"
                                id="kt_ecommerce_add_item_cancel" class="btn btn-light me-5">Cancel</a>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="kt_ecommerce_add_item_submit" class="btn btn-primary">
                                <span class="indicator-label">Save Changes</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Button-->
                        </div>
                    </div>
                    <!--end::Main column-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <div class="template-variant col-6 mb-10" childidx="0" style="display: none">
        <div class="card card-bordered">
            <div class="card-header">
                <h3 class="card-title">Variant</h3>
                <div class="card-toolbar">
                    <button type="button" data-repeater-delete="" class="btn btn-sm btn-icon btn-light-danger duplicate">
                        <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen054.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.5"
                                    d="M18 2H9C7.34315 2 6 3.34315 6 5H8C8 4.44772 8.44772 4 9 4H18C18.5523 4 19 4.44772 19 5V16C19 16.5523 18.5523 17 18 17V19C19.6569 19 21 17.6569 21 16V5C21 3.34315 19.6569 2 18 2Z"
                                    fill="black" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M14.7857 7.125H6.21429C5.62255 7.125 5.14286 7.6007 5.14286 8.1875V18.8125C5.14286 19.3993 5.62255 19.875 6.21429 19.875H14.7857C15.3774 19.875 15.8571 19.3993 15.8571 18.8125V8.1875C15.8571 7.6007 15.3774 7.125 14.7857 7.125ZM6.21429 5C4.43908 5 3 6.42709 3 8.1875V18.8125C3 20.5729 4.43909 22 6.21429 22H14.7857C16.5609 22 18 20.5729 18 18.8125V8.1875C18 6.42709 16.5609 5 14.7857 5H6.21429Z"
                                    fill="black" />
                            </svg></span>
                        <!--end::Svg Icon-->
                    </button>
                    &nbsp;
                    <button type="button" data-repeater-delete="" class="btn btn-sm btn-icon btn-light-danger delete">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1"
                                    transform="rotate(-45 7.05025 15.5356)" fill="black" />
                                <rect x="8.46447" y="7.05029" width="12" height="2" rx="1"
                                    transform="rotate(45 8.46447 7.05029)" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </button>
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
                            <input type="hidden" name="variants[0][id]" class="form-control variant-id mb-2"
                                placeholder="ID" value="" />
                            <!--end::Input-->
                            <!--begin::Input-->
                            <input type="text" name="variants[0][sku]" class="form-control variant-sku mb-2"
                                placeholder="SKU" value="" />
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
                        <input type="text" name="variants[0][name]" class="form-control variant-name mb-2"
                            placeholder="Variant name" value="" />
                        <!--end::Input-->
                        <!--begin::Description-->
                        <div class="text-muted fs-7">A item name is required and
                            recommended to
                            be unique.</div>
                        <!--end::Description-->
                    </div>
                    <!--end::Input group-->
                    <div class="mb-10 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Unit</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select name="variants[0][unit]" class="form-select variant-unit" data-placeholder="Select an option">
                            <option value="">Please Select</option>
                            @foreach ($units as $row)
                                <option value="{{ $row->id }}"> {{ $row->name }} </option>
                            @endforeach
                        </select>
                        <!--end::Input-->
                    </div>
                    <div class="mb-10 row">
                        <div class="col-lg-4">
                            <div class="form-check form-check-custom form-check-solid mb-2">
                                <input class="form-check-input variant-sale" type="checkbox" name="variants[0][sale]" id="variants[0][sale]" value="1" />
                                <label class="form-check-label" for="variants[0][sale]">Sale?</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check form-check-custom form-check-solid mb-2">
                                <input class="form-check-input variant-bought" type="checkbox" name="variants[0][bought]" id="variants[0][bought]" value="1" />
                                <label class="form-check-label" for="variants[0][bought]">Bought?</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check form-check-custom form-check-solid mb-2">
                                <input class="form-check-input variant-ingredient" type="checkbox" name="variants[0][ingredient]" id="variants[0][ingredient]" value="1" />
                                <label class="form-check-label" for="variants[0][ingredient]">Ingredient?</label>
                            </div>
                        </div>
                    </div>
                    <!--begin::Editor-->
                    <div class="mb-10 row">
                        <div class="col-lg-4">
                            <div class="form-check form-check-custom form-check-solid mb-2">
                                <input class="form-check-input variant-show_online_shop" type="checkbox" name="variants[0][show_online_shop]" id="variants[0][show_online_shop]" value="1" />
                                <label class="form-check-label" for="variants[0][show_online_shop]">Show In Online Shop Module?</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check form-check-custom form-check-solid mb-2">
                                <input class="form-check-input variant-show_pos" type="checkbox" name="variants[0][show_pos]" id="variants[0][show_pos]" value="1" />
                                <label class="form-check-label" for="variants[0][show_pos]">Show In POS Module??</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check form-check-custom form-check-solid mb-2">
                                <input class="form-check-input variant-production" type="checkbox" name="variants[0][production]" id="variants[0][production]" value="1" />
                                <label class="form-check-label" for="variants[0][production]">Is Production?</label>
                            </div>
                        </div>
                    </div>
                    <!--begin::Input group-->
                    <div class="mb-10 fv-row">
                        <!--begin::Label-->
                        <label class="form-label">Description</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="variants[0][description]" class="form-control variant-description mb-2"
                            placeholder="Description" value="" />
                        <!--end::Input-->
                        <!--begin::Description-->
                        <div class="text-muted fs-7"></div>
                        <!--end::Description-->
                    </div>
                    <!--end::Input group-->
                    <div class="row">
                        <div class="col-6 mb-10 fv-row">
                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Label-->
                                <label class="required form-label">Weight</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="input-group mb-5">
                                    <input type="text" name="variants[0][weight]"
                                        class="form-control withseparator format-number text-end variant-weight"
                                        placeholder="Weight" value="" />
                                    <span class="input-group-text" id="basic-addon2">gram</span>
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

                                <!--begin::Input-->
                                <div class="col-md-12 col-sm-12">
                                    <div class="input-group mb-5">
                                        <input type="text" name="variants[0][dimensions][length]"
                                            class="form-control withseparator format-number text-end variant-dimensions_length"
                                            placeholder="Length" value="" />
                                        <span class="input-group-text" id="basic-addon2">cm</span>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="input-group mb-5">
                                        <input type="text" name="variants[0][dimensions][width]"
                                            class="form-control withseparator format-number text-end variant-dimensions_width"
                                            placeholder="Width" value="" />
                                        <span class="input-group-text" id="basic-addon2">cm</span>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="input-group mb-5">
                                        <input type="text" name="variants[0][dimensions][height]"
                                            class="form-control withseparator format-number text-end variant-dimensions_height"
                                            placeholder="Height" value="" />
                                        <span class="input-group-text" id="basic-addon2">cm</span>
                                    </div>
                                </div>
                                <!--end::Input-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7"></div>
                                <!--end::Description-->
                            </div>
                            <!--end::Input group-->
                        </div>

                    </div>
                    <!--end::Editor-->
                    <div class="row">
                        <div class="col-4 mb-10 fv-row">
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class="required form-label">Price</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="variants[0][price]"
                                    class="form-control withseparator format-number text-end variant-price mb-2" placeholder="Price"
                                    value="" />
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
                                <label class="required form-label">Minimal Stock</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="variants[0][minimal_stock]"
                                    class="form-control withseparator format-number text-end variant-minimal_stock mb-2"
                                    placeholder="Minimal Stock" value="" />
                                <!--end::Input-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7"></div>
                                <!--end::Description-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        {{-- <div class="col-4 mb-10 fv-row">
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class="required form-label">Stock</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="variants[0][stock]"
                                    class="form-control withseparator format-number text-end variant-stock mb-2" placeholder="Stock"
                                    value="" />
                                <!--end::Input-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7"></div>
                                <!--end::Description-->
                            </div>
                            <!--end::Input group-->
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fileinput fileinput-new template-image" data-provides="fileinput" style="display: none !important">
        <div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 100%; height: 150px;"></div>
        <div>
            <a href="#" class="btn btn-light fileinput-exists" data-dismiss="fileinput">Remove</a>
            <span class="btn btn-light btn-file"><span class="fileinput-new">Select image</span><span
                    class="fileinput-exists">Change</span><input type="file" name="images[]"></span>
        </div>
        <button type="button" data-repeater-delete="" class="btn btn-sm btn-icon btn-light-danger delete">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
            <span class="svg-icon svg-icon-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1"
                        transform="rotate(-45 7.05025 15.5356)" fill="black" />
                    <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)"
                        fill="black" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </button>
    </div>


@endsection

@push('scripts')
    <script src="{{ asset_administrator('assets/js/custom/apps/ecommerce/catalog/items.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
    <script type="text/javascript">
      const url = `{!! url('/') !!}`;
         $(document).ready(function() {
            CKEDITOR.replace('description',{
                filebrowserBrowseUrl : url+'/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                filebrowserUploadUrl : url+'/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                filebrowserImageBrowseUrl : url+'/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
            });
        });
    </script>
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
                            // clonning.find(".variant-stock").val($(another).find(".variant-stock")
                            //     .val());
                            clonning.find(".variant-unit").val($(another).find(".variant-unit")
                                .val());
                            if($(another).find(".variant-sale").is(':checked')){
                                clonning.find(".variant-sale").prop('checked', true);
                            }
                            if($(another).find(".variant-bought").is(':checked')){
                                clonning.find(".variant-bought").prop('checked', true);
                            }
                            if($(another).find(".variant-ingredient").is(':checked')){
                                clonning.find(".variant-ingredient").prop('checked', true);
                            }
                            if($(another).find(".variant-show_online_shop").is(':checked')){
                                clonning.find(".variant-show_online_shop").prop('checked', true);
                            }
                            if($(another).find(".variant-show_pos").is(':checked')){
                                clonning.find(".variant-show_pos").prop('checked', true);
                            }
                            if($(another).find(".variant-production").is(':checked')){
                                clonning.find(".variant-production").prop('checked', true);
                            }
                            $("#item_options").append(clonning);

                            new swal("Horray!", "Data has been duplicated", "success");
                            resetData()
                        }
                    });
                });

                index++;
            });

        }

        $(document).on('click', '#add_another_variation', function(event) {
            var clonning = $(".template-variant").clone();
            clonning.removeAttr("style");
            clonning.removeClass('template-variant');
            clonning.addClass('variant-list');
            $("#item_options").append(clonning);
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
            $("#item_media").append(clonning);
            var media = $("#item_media .image-list").length;
            var preview = $("#item_media .image-preview").length;
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
