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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Products</h1>
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
                        <li class="breadcrumb-item text-dark">Import Data</li>
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
                @if (isset($failures))
                    @php
                        $data_error = array();
                        foreach($failures as $failure){
                            $data_error = array_unique(array_merge($data_error,$failure->errors()));
                        }
                    @endphp
                    <div class="alert alert-danger d-flex align-items-center p-5">
                        <span class="svg-icon svg-icon-2hx svg-icon-danger me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"/>
                                <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="black"/>
                                <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="black"/>
                                </svg></span>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-dark">Error</h4>
                            @foreach ($data_error as $value)
                                <span>{{ $value }}</span>
                            @endforeach
                        </div>
                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                            <span class="svg-icon svg-icon-muted svg-icon-2hx">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="black"/>
                                    <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="black"/>
                                </svg>
                            </span>
                        </button>
                    </div>
                @endif
                <form id="form_add" class="form d-flex flex-column flex-lg-row"
                    action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Main column-->
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
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
                                    <label class="required form-label">Brand</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="brand" class="form-select" data-control="select2"
                                        data-placeholder="Select an option" required>
                                        <option value="">Please Select</option>
                                        @foreach ($brands as $row)
                                            <option value="{{ $row->id }}"> {{ $row->name }} </option>
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
                                    <label class="required form-label">Category</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="category" class="form-select" data-control="select2"
                                        data-placeholder="Select an option" required>
                                        <option value="">Please Select</option>
                                        @foreach ($categories as $row)
                                            <option value="{{ $row->id }}"> {{ $row->name }} </option>
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
                                    <label class="required form-label">File Excel</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="file" name="file" class="form-control mb-2" placeholder="Image Category"
                                        value="" required/>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                    </div>
                                </div>

                                <div class="mb-10 fv-row">
                                    <a href="{{ route('admin.products.downloadFormat') }}" class="btn btn-sm btn-light-success">
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none">
                                                <path opacity="0.3"
                                                    d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14V4H6V20H18V8H20V21C20 21.6 19.6 22 19 22Z"
                                                    fill="black" />
                                                <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
                                            </svg>
                                        </span>
                                        Format Import Product
                                    </a>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label">Format Example</label>
                                    <!--end::Label-->
                                    <table class="table table-bordered"
                                        style="display: block; overflow-x: auto; white-space: nowrap;">
                                        <thead>
                                            <tr>
                                                <th>A</th>
                                                <th>B</th>
                                                <th>C</th>
                                                <th>D</th>
                                                <th>E</th>
                                                <th>F</th>
                                                <th>G</th>
                                                <th>H</th>
                                                <th>I</th>
                                                <th>J</th>
                                                <th>K</th>
                                                <th>L</th>
                                                <th>M</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>name</td>
                                                <td>description</td>
                                                <td>variant_sku</td>
                                                <td>variant_name</td>
                                                <td>variant_description</td>
                                                <td>variant_price</td>
                                                <td>variant_minimal_stock</td>
                                                <td>variant_stock</td>
                                                <td>variant_weight</td>
                                                <td>variant_length</td>
                                                <td>variant_width</td>
                                                <td>variant_height</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--begin::Description {"length":"20.00","width":"10.00","height":"10.00"} -->
                                    <div class="text-muted fs-7">
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="../../demo1/dist/apps/ecommerce/catalog/products.html"
                                id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="import" class="btn btn-primary">
                                <span class="indicator-label">Save Changes</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Button-->
                        </div>
                    </div>
                    <!--end::Main column-->
                </form>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
@endsection

@push('scripts')
    <script src="{{ asset_administrator('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/apps/ecommerce/catalog/import_product.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/documentation.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/search.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/forms/select2.js') }}"></script>
@endpush
