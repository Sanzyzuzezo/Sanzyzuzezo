@extends('administrator.layouts.main')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Warehouse</h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">Warehouse</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">

                @if ($message = Session::get('success'))
                    <div class="alert alert-success d-flex align-items-center p-5">
                        <span class="svg-icon svg-icon-2hx svg-icon-success me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.5" d="M12.8956 13.4982L10.7949 11.2651C10.2697 10.7068 9.38251 10.7068 8.85731 11.2651C8.37559 11.7772 8.37559 12.5757 8.85731 13.0878L12.7499 17.2257C13.1448 17.6455 13.8118 17.6455 14.2066 17.2257L21.1427 9.85252C21.6244 9.34044 21.6244 8.54191 21.1427 8.02984C20.6175 7.47154 19.7303 7.47154 19.2051 8.02984L14.061 13.4982C13.7451 13.834 13.2115 13.834 12.8956 13.4982Z" fill="black"/>
                                <path d="M7.89557 13.4982L5.79487 11.2651C5.26967 10.7068 4.38251 10.7068 3.85731 11.2651C3.37559 11.7772 3.37559 12.5757 3.85731 13.0878L7.74989 17.2257C8.14476 17.6455 8.81176 17.6455 9.20663 17.2257L16.1427 9.85252C16.6244 9.34044 16.6244 8.54191 16.1427 8.02984C15.6175 7.47154 14.7303 7.47154 14.2051 8.02984L9.06096 13.4982C8.74506 13.834 8.21146 13.834 7.89557 13.4982Z" fill="black"/>
                            </svg>
                        </span>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-dark">Success</h4>
                            <span>{{ $message }}</span>
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
                                <input type="text" data-kt-ecommerce-category-filter="search" class="form-control form-control-sm form-control-solid w-250px ps-14" placeholder="Search" id="searchdatatable" />
                            </div>
                        </div>
                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                            <div class="w-100 mw-150px">
                                <select class="form-select btn-sm form-select-solid" data-control="select2" data-hide-search="true" id="filterstatus">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="non-active">Inactive</option>
                                </select>
                            </div>
                            <div class="card-toolbar">
                                @if (isAllowed("warehouse", "add"))
                                <a href="{{ route('admin.warehouse.add') }}" class="btn btn-sm btn-light-primary">
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
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="warehouse-table">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-10px">No</th>
                                    <th class="min-w-100px">Code</th>
                                    <th class="min-w-150px">Name</th>
                                    <th class="min-w-150px">PIC</th>
                                    <th class="min-w-150px">Status</th>
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
        $(document).ready(function() {
            setTimeout(function(){
                $("div.alert").fadeOut(300, function(){ $(this).remove();});
            }, 5000);

            var data_warehouse = $('#warehouse-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "warehouse-data",
                    dataType: "JSON",
                    type: "GET",
                    data:function(d){
                        d.status = getStatus();
                    }
                },
                columns: [
                    {
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'pic',
                        name: 'pic'
                    },
                    {
                        render: function(data, type, row) {
                            if(row.status == 1){
                                return '<div class="badge badge-light-success">Active</div>'
                            }else{
                                return '<div class="badge badge-light-danger">Inactive</div>'
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        'searchable': false,
                        render: function(data, type, row) {
                            var btn = "";
                            @if (isAllowed("warehouse", "add"))
                            btn += "<a href='warehouse/edit/"+row.id+"' class='btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1'><span class='svg-icon svg-icon-3'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none'><path opacity='0.3' d='M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z' fill='black' /><path d='M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z' fill='black' /></svg></span></a><a href='#' data-ix='"+row.id+"' class='btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete'><span class='svg-icon svg-icon-3'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none'><path d='M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z' fill='black' /><path opacity='0.5' d='M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z' fill='black' /><path opacity='0.5' d='M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z' fill='black' /></svg></span></a>";
                            @endif
                            return btn;
                        }
                    },
                ]
            });

            $('#searchdatatable').keyup(function() {
                data_warehouse.search($(this).val()).draw();
            })

            $('#filterstatus').change(function() {
                data_warehouse.search($("#searchdatatable").val()).draw();
            })

            function getStatus(){
                return $("#filterstatus").val();
            }

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
                            url: "{{ route('admin.warehouse.delete') }}",
                            data: ({
                                "_token": "{{ csrf_token() }}",
                                "_method": 'DELETE',
                                ix: ix,
                            }),
                            success: function(resp){
                                if(resp.success){
                                    Swal.fire('Deleted!', 'Data has been deleted', 'success');
                                }else{
                                    Swal.fire('Failed!', 'Deleted data failed', 'error');
                                }
                                data_warehouse.ajax.reload(null, false);
                            },
                            error: function (resp) {
                                Swal.fire("Error!", "Something went wrong.", "error");
                                data_warehouse.ajax.reload(null, false);
                            }
                        });
                    }
                });
            });
        });

        @if(session('warning'))
            $(document).ready(function() {
                Swal.fire({
                    icon: 'warning',
                    text: '{{ session('warning') }}',
                    showCancelButton: false,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: "btn btn-primary",
                    }
                });
            });
      
    @endif
    </script>
@endpush
