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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Permissions</h1>
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
                            <a href="{{ route('admin.permissions') }}" class="text-muted text-hover-primary">Permissions</a>
                        </li>
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-dark">Edit</li>
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
                    action="{{ route('admin.permissions.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PUT') }}
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
                                        <label class="required form-label">Identifiers</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="identifiers" class="form-control mb-2"
                                            placeholder="Module identifiers" value="{{ $edit->identifiers }}" />
                                        <!--end::Input-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7"></div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <!--begin::Label-->
                                        <label class="required form-label">Name</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="name" class="form-control mb-2" placeholder="Module name"
                                            value="{{ $edit->name }}" />
                                        <!--end::Input-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7"></div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <!--begin::Label-->
                                        <label class="required form-label">Access</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div id="module_access">
                                            <?php $index = 0; ?>
                                            @foreach ($edit->access as $row)                                              
                                            <div class="form-group mb-3 access-list" childidx="{{ $index }}">
                                                <div data-repeater-list="kt_ecommerce_add_email_options" class="d-flex flex-column gap-3">
                                                    <div data-repeater-item="" class="form-group d-flex flex-wrap gap-5">
                                                        <div class="d-flex">
                                                            <input type="hidden" class="form-control mw-100 w-200px name_receive" name="access[{{ $index }}][id]"
                                                            placeholder="Module access identifiers" value="{{ $row->id }}"/>
                                                            <input type="text" class="form-control mw-100 w-200px name_receive" name="access[{{ $index }}][identifiers]"
                                                                placeholder="Module access identifiers"  value="{{ $row->identifiers }}"/>
                                                            <input type="email" class="form-control ms-3 mw-100 w-300px email_receive" name="access[{{ $index }}][name]"
                                                                placeholder="Module access name"  value="{{ $row->name }}"/>
                                                        </div>
                                                        <button type="button" data-repeater-delete="" class="btn btn-sm btn-icon btn-light-danger delete">
                                                            <span class="svg-icon svg-icon-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1"
                                                                        transform="rotate(-45 7.05025 15.5356)" fill="black" />
                                                                    <rect x="8.46447" y="7.05029" width="12" height="2" rx="1"
                                                                        transform="rotate(45 8.46447 7.05029)" fill="black" />
                                                                </svg>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $index++; ?>
                                            @endforeach
                                        </div>
                                        <!--end::Input-->
                                        <button type="button" id="add_another_access"
                                            class=" btn btn-sm btn-light-primary">
                                            <span class="svg-icon svg-icon-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1"
                                                        transform="rotate(-90 11 18)" fill="black" />
                                                    <rect x="6" y="11" width="12" height="2" rx="1" fill="black" />
                                                </svg>
                                            </span>Add another access
                                        </button>
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7"></div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Card header-->
                            </div>
                            <!--end::General options-->
                        </div>

                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="{{ route('admin.permissions') }}" id="kt_ecommerce_add_product_cancel"
                                class="btn btn-light me-5">Cancel</a>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                                <span class="indicator-label">Save</span>
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

    <div class="form-group mb-3 template-access" childidx="0" style="display: none">
        <div data-repeater-list="kt_ecommerce_add_email_options" class="d-flex flex-column gap-3">
            <div data-repeater-item="" class="form-group d-flex flex-wrap gap-5">
                <div class="d-flex">
                    <input type="hidden" class="form-control mw-100 w-200px name_receive" name="access[0][id]"
                    placeholder="Module access identifiers" />
                    <input type="text" class="form-control mw-100 w-200px name_receive" name="access[0][identifiers]"
                        placeholder="Module access identifiers" />
                    <input type="email" class="form-control ms-3 mw-100 w-300px email_receive" name="access[0][name]"
                        placeholder="Module access name" />
                </div>
                <button type="button" data-repeater-delete="" class="btn btn-sm btn-icon btn-light-danger delete">
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1"
                                transform="rotate(-45 7.05025 15.5356)" fill="black" />
                            <rect x="8.46447" y="7.05029" width="12" height="2" rx="1"
                                transform="rotate(45 8.46447 7.05029)" fill="black" />
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset_administrator('assets/js/custom/apps/ecommerce/catalog/products.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            resetData();
        });

        function resetData() {

            var index = 0;
            $(".access-list").each(function() {
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

                validator.addField("variants[" + index + "][identifiers]", {
                    validators: {
                        notEmpty: {
                            message: 'Module access identifiers is required'
                        }
                    }
                });

                validator.addField("variants[" + index + "][name]", {
                    validators: {
                        notEmpty: {
                            message: 'Module access name is required'
                        }
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

                index++;
            });
        }

        $(document).on('click', '#add_another_access', function(event) {
            var clonning = $(".template-access").clone();
            clonning.removeAttr("style");
            clonning.removeClass('template-access');
            clonning.addClass('access-list');
            $("#module_access").append(clonning);
            resetData();
        });
    </script>
@endpush
