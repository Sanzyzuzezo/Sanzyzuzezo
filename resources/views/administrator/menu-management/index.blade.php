@extends('administrator.layouts.main')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Menu Management</h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">Menu Management</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="card card-flush">
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                                    </svg>
                                </span>
                                <input type="text" data-kt-ecommerce-category-filter="search" class="form-control form-control-sm form-control-solid w-250px ps-14" placeholder="Search" />
                            </div>
                        </div>
                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                            {{-- <div class="w-100 mw-150px">
                                <select class="form-select btn-sm form-select-solid" data-control="select2" data-hide-search="true"
                                    data-placeholder="Status" data-kt-ecommerce-product-filter="status">
                                    <option></option>
                                    <option value="active">Active</option>
                                    <option value="non-active">Inctive</option>
                                </select>
                            </div> --}}
                            <div class="card-toolbar">
                                @if (isAllowed("menu_managements", "add"))
                                <a href="{{ route('menu-management.add') }}" class="btn btn-sm btn-light-primary">
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                                        </svg>
                                    </span>
                                    Add Data
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="datatable">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-10px">No</th>
                                    <th class="min-w-150px">Name</th>
                                    {{-- <th class="min-w-150px">Status</th> --}}
                                    <th class="min-w-50px">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let url = `{!! route('menu-management.getData') !!}`;
        $(document).ready(function() {
            var data_customer_group = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: url,
                    dataType: "JSON",
                    type: "GET"
                },
                columns: [
                    {
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    { data: 'name' },
                    { data: 'action', name: 'action', 'searchable': false},
                ]
            });

            $('#searchdatatable').keyup(function() {
                data_customer_group.search($(this).val()).draw();
            })

            $(document).on('click', '.delete', function(event) {
                var ix = $(this).data('ix');
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
                        $.ajax({
                            type: "POST",
                            url: "{{ route('menu-management.delete') }}",
                            data: ({
                                "_token": "{{ csrf_token() }}",
                                "_method": 'DELETE',
                                ix: ix,

                            }),
                            success: function() {
                                Swal.fire('Deleted!', 'Data has been deleted',
                                    'success');
                                data_customer_group.ajax.reload(null, false);
                            },
                            error: function (request, status, error) {
                                // alert(request.responseText);
                                console.log(error);
                            }
                        });

                    }
                });
            });
        });
    </script>
@endpush
