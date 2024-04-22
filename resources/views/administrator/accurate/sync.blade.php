@extends('administrator.layouts.main')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Accurate</h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">Token</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="post d-flex flex-column-fluid" id="form">
            <div id="kt_content_container" class="container-xxl">
                <button class="btn btn-primary" id="triggerSync" type="button">
                    <span id="syncText" class="">Sync now</span>
                    <span id="syncLoader" class="d-none">
                        <i class="fas fa-spinner fa-spin"></i> Loading...
                    </span>
                </button>
                <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                            rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <input type="text" id="searchdatatable"
                                    class="form-control form-control-sm form-control-solid w-250px ps-14"
                                    placeholder="Search" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                            {{-- <div class="w-100 mw-150px">
                                <select class="form-select btn-sm form-select-solid" data-control="select2"
                                    data-hide-search="true" id="filterstatus">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="non-active">Inactive</option>
                                </select>
                            </div> --}}
                            <div class="card-toolbar">
                                <a class="btn btn-sm btn-light-warning button_filter_data">
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z"
                                                fill="black" />
                                            <path opacity="0.3"
                                                d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    Filter Data
                                </a>
                            </div>
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <form id="filter_data">
                            <div class="row">
                                <div class="col collapse">
                                    <label class="form-label">Date</label>
                                    <input type="text" class="form-control tanggal bg-secondary" id="tanggal"
                                        placeholder="Date" readonly />
                                </div>
                                <div class="col collapse">
                                    <label class="form-label required">Customer</label>
                                    <div class="row">
                                        <div class="col-md-9 col-auto">
                                            <input type="text" name="customer_name" class="form-control bg-secondary"
                                                id="customer_name" placeholder="Customer Name" value="" readonly />
                                            <input type="hidden" name="customer_id" id="customer_id" class="form-control"
                                                value="" />
                                        </div>
                                        <div class="col-md-3 col-auto">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="triggerCustomer"
                                                data-bs-toggle="modal">
                                                <span class="svg-icon svg-icon-2 m-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z"
                                                            fill="white" />
                                                        <path opacity="0.5"
                                                            d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z"
                                                            fill="white" />
                                                    </svg>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class='col collapse' style="margin-top:7rem;">
                                    <div class="d-flex justify-content-end mt-5 ">
                                        <button type="submit" class="btn btn-sm btn-light-warning collapse">
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z"
                                                        fill="black" />
                                                    <path opacity="0.3"
                                                        d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            Search
                                        </button>
                                        &nbsp; &nbsp;
                                        <button type="reset" id="reset-btn"
                                            class="btn btn-sm btn-light-danger collapse" value="Reset">
                                            <span class="svg-icon svg-icon-3">
                                                <svg height="21" viewBox="0 0 21 21" width="21"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g fill="none" fill-rule="evenodd" stroke="currentColor"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        transform="translate(2 2)">
                                                        <path
                                                            d="m12.5 1.5c2.4138473 1.37729434 4 4.02194088 4 7 0 4.418278-3.581722 8-8 8s-8-3.581722-8-8 3.581722-8 8-8" />
                                                        <path d="m12.5 5.5v-4h4" />
                                                    </g>
                                                </svg>
                                            </span>
                                            Reset
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_items_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-10px pe-2">
                                        No
                                    </th>
                                    <th class="min-w-100px">Module</th>
                                    <th class="min-w-70px">Flag</th>
                                    <th class="min-w-70px">Date</th>
                                    <th class="min-w-70px">Actions</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-600">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset_administrator('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/documentation.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/search.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/forms/select2.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // $.ajax({
            //     method: "GET",
            //     url: "http://cors-anywhere.herokuapp.com/https://public.accurate.id/accurate/api/warehouse/list.do",
            //     headers: {
            //         "X-Api-Timestamp": "12/01/2024 14:34:14",
            //         "X-Api-Signature": "BWQdglhBUQMvo5814LS9HBgrEPQHL0piuGdXzkAXzj8=",
            //         "Authorization": "Bearer aat.MTAw.eyJ2IjoxLCJ1Ijo2MDA4NjksImQiOjEwODc0NjIsImFpIjo0Mzg1MSwiYWsiOiJjY2E3MDU2MS00YTZlLTQzOGMtYmMzMS1kNjIwZjEwODQ4ODYiLCJhbiI6IkJhc2UiLCJhcCI6IjRmYWEzOWZmLWU4NDUtNGQxOC05YzQ1LTk5MTZlNWU2NmIzYiIsInQiOjE3MDQ4NjkxOTQwODF9.vM0Q4tm5ReY4yY5wVu0R7/vai01pfqVbWDYos/faAGqjcye/tw5c4ZZ15LBqcFTPdpxlyzKvR13mBGhlcyMgoorj/N4QkSd9TaFZPXRdc1W/KW7eWFXiNLi9uZ8QJsiilhBj3aHUq34PSry10UtnhrowPDXxDv19U1DYE7d5Cn5e9y3Hhx52MpoQFJfIn782JokpugzkVSI=.aZjMfZX9tH4+2vNnMWRu/j/GAMcndjgQjz0H2tqw6KM"
            //     },
            //     success: function(response) {
            //         console.log(response);
            //     }
            // });
            // var settings = {
            //     "url": "https://public.accurate.id/accurate/api/warehouse/list.do",
            //     "method": "GET",
            //     "timeout": 0,
            //     "headers": {
            //         "X-Api-Timestamp": "12/01/2024 14:34:14",
            //         "X-Api-Signature": "BWQdglhBUQMvo5814LS9HBgrEPQHL0piuGdXzkAXzj8=",
            //         "Authorization": "Bearer aat.MTAw.eyJ2IjoxLCJ1Ijo2MDA4NjksImQiOjEwODc0NjIsImFpIjo0Mzg1MSwiYWsiOiJjY2E3MDU2MS00YTZlLTQzOGMtYmMzMS1kNjIwZjEwODQ4ODYiLCJhbiI6IkJhc2UiLCJhcCI6IjRmYWEzOWZmLWU4NDUtNGQxOC05YzQ1LTk5MTZlNWU2NmIzYiIsInQiOjE3MDQ4NjkxOTQwODF9.vM0Q4tm5ReY4yY5wVu0R7/vai01pfqVbWDYos/faAGqjcye/tw5c4ZZ15LBqcFTPdpxlyzKvR13mBGhlcyMgoorj/N4QkSd9TaFZPXRdc1W/KW7eWFXiNLi9uZ8QJsiilhBj3aHUq34PSry10UtnhrowPDXxDv19U1DYE7d5Cn5e9y3Hhx52MpoQFJfIn782JokpugzkVSI=.aZjMfZX9tH4+2vNnMWRu/j/GAMcndjgQjz0H2tqw6KM"
            //     },
            // };

            // $.ajax(settings).done(function(response) {
            //     console.log(response);
            // });
            $("#tanggal").daterangepicker({
                // locale: {
                //     format: "DD/MM/YYYY",
                // },
            });
            $('#tanggal').val('').change();


            $(".button_filter_data").click(function() {
                $(".collapse").slideToggle();
            });

            var data_items = $('#kt_ecommerce_items_table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: {
                    url: '{{ route('admin.accurate.sync.getData') }}',
                    dataType: "JSON",
                    type: "GET",
                    // data: function(d) {
                    //     d.date = getDate();
                    //     d.customer_id = getCustomer();
                    // }
                },
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'module'
                    },
                    {
                        data: 'flag'
                    },
                    {
                        mRender: function(data, type, row, meta) {
                            var date = new Date(row.created_at);
                            var formattedDate = moment(date).format('DD-MM-YYYY HH:mm:ss');

                            return formattedDate;
                        },
                        className: "text-center"
                    },
                    {
                        data: 'action',
                        'searchable': false
                    }
                ],
            });

            $('#searchdatatable').keyup(function() {
                data_items.search($(this).val()).draw();
            });

            $('#filter_data').submit(function(e) {
                e.preventDefault();
                data_items.search($("#searchdatatable").val()).draw();
            })

            $("#reset-btn").click(function() {
                $('#tanggal').val('').change();
                $('#customer_id').val('').change();
                $('#customer_name').val('').change();
                data_items.search($("#searchdatatable").val()).draw();
            });

            function getDate() {
                return $("#tanggal").val();
            }

            function getCustomer() {
                return $("#customer_id").val();
            }

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

            //Delete Confirmation
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
                            url: "{{ route('admin.sales.delete') }}",
                            data: ({
                                "_token": "{{ csrf_token() }}",
                                "_method": 'DELETE',
                                ix: ix,

                            }),
                            success: function() {
                                Swal.fire('Deleted!', 'Data has been deleted',
                                    'success');
                                data_items.ajax.reload(null, false);
                            },
                            error: function() {
                                Swal.fire('Fail!', 'data failed to delete',
                                    'error');
                            }
                        });

                    }
                });
            });

            $('#triggerSync').on('click', function() {
                
                //Warehouse
                toggleSyncButton(true);
                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.accurate.sync.getToken') }}",
                    success: function(response) {
                        toggleSyncButton(false);
                        var token = response.output;
                        toggleSyncButton(true);
                        $.ajax({
                            method: "GET",
                            url: "{{ route('admin.accurate.sync.getDataWarehouse') }}",
                            success: function(response) {
                                toggleSyncButton(false);
                                let data = response.data;
                                // console.log('=======================')
                                // console.log(response.data,"-asdasdas")
                                // console.log(listIndex)
                                var index = 0
                                const updateData = () => {
                                    if(index < response.data.length){
                                        var accurate_id = data[index].accurate_id !== 0 ? data[index].accurate_id : '';
                                    
                                    toggleSyncButton(true);
                                        $.ajax({
                                        method: "POST",
                                        url: "https://cors-anywhere.herokuapp.com/https://public.accurate.id/accurate/api/warehouse/save.do",
                                        headers: {
                                            "X-Api-Timestamp": token
                                                .plain_text,
                                            "X-Api-Signature": token
                                                .hashed_output,
                                            "Authorization": "Bearer aat.MTAw.eyJ2IjoxLCJ1Ijo2MDA4NjksImQiOjEwODc0NjIsImFpIjo0Mzg1MSwiYWsiOiJjY2E3MDU2MS00YTZlLTQzOGMtYmMzMS1kNjIwZjEwODQ4ODYiLCJhbiI6IkJhc2UiLCJhcCI6IjRmYWEzOWZmLWU4NDUtNGQxOC05YzQ1LTk5MTZlNWU2NmIzYiIsInQiOjE3MDQ4NjkxOTQwODF9.vM0Q4tm5ReY4yY5wVu0R7/vai01pfqVbWDYos/faAGqjcye/tw5c4ZZ15LBqcFTPdpxlyzKvR13mBGhlcyMgoorj/N4QkSd9TaFZPXRdc1W/KW7eWFXiNLi9uZ8QJsiilhBj3aHUq34PSry10UtnhrowPDXxDv19U1DYE7d5Cn5e9y3Hhx52MpoQFJfIn782JokpugzkVSI=.aZjMfZX9tH4+2vNnMWRu/j/GAMcndjgQjz0H2tqw6KM"
                                        },
                                        data: {
                                            id: accurate_id,
                                            name: data[index].name,
                                            pic: data[index].pic,
                                            suspended: (data[index].status === true ? false : true),
                                        },
                                        success : function(respon){
                                            toggleSyncButton(false);
                                            console.log('============ response');
                                            console.log(respon);
                                            if ((respon.s === false) && (respon.d[0] === "Data tidak ditemukan atau sudah dihapus")) {
                                                toggleSyncButton(true);
                                                $.ajax({
                                                    method: "POST",
                                                    url: "{{ route('admin.accurate.sync.updateWarehouse') }}",
                                                    data: {
                                                        "_token": "{{ csrf_token() }}",
                                                        "_method": "POST",
                                                        data: item
                                                    },
                                                    success: function(respon) {
                                                    toggleSyncButton(false);
                                                        console.log(respon);
                                                    }
                                                });
                                            }
                                        }
                                    });
                                        index++
                                    }
                                    else {
                                        clearInterval(loopData)
                                    }
                                }
                                const loopData = setInterval(updateData,1000);
                            }
                        });
                    }
                });
                toggleSyncButton(true);
                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.accurate.sync.getToken') }}",
                    success: function(response) {
                        toggleSyncButton(false);
                        var token = response.output;
                        toggleSyncButton(true);
                        $.ajax({
                            method: "GET",
                            url: "{{ route('admin.accurate.sync.getDataWarehouseDeleted') }}",
                            success: function(response) {
                                toggleSyncButton(false);
                                let data = response.data;
                                data.forEach(function(item) {
                                            console.log(item);
                                    var accurate_id = item.accurate_id !==
                                    0 ? item.accurate_id : '';
                                    
                                    toggleSyncButton(true);
                                    $.ajax({
                                        method: "POST",
                                        url: "https://cors-anywhere.herokuapp.com/https://public.accurate.id/accurate/api/warehouse/delete.do",//cors-anywhere.herokuapp.com
                                        headers: {
                                            "X-Api-Timestamp": token
                                                .plain_text,
                                            "X-Api-Signature": token
                                                .hashed_output,
                                            "Authorization": "Bearer aat.MTAw.eyJ2IjoxLCJ1Ijo2MDA4NjksImQiOjEwODc0NjIsImFpIjo0Mzg1MSwiYWsiOiJjY2E3MDU2MS00YTZlLTQzOGMtYmMzMS1kNjIwZjEwODQ4ODYiLCJhbiI6IkJhc2UiLCJhcCI6IjRmYWEzOWZmLWU4NDUtNGQxOC05YzQ1LTk5MTZlNWU2NmIzYiIsInQiOjE3MDQ4NjkxOTQwODF9.vM0Q4tm5ReY4yY5wVu0R7/vai01pfqVbWDYos/faAGqjcye/tw5c4ZZ15LBqcFTPdpxlyzKvR13mBGhlcyMgoorj/N4QkSd9TaFZPXRdc1W/KW7eWFXiNLi9uZ8QJsiilhBj3aHUq34PSry10UtnhrowPDXxDv19U1DYE7d5Cn5e9y3Hhx52MpoQFJfIn782JokpugzkVSI=.aZjMfZX9tH4+2vNnMWRu/j/GAMcndjgQjz0H2tqw6KM"
                                        },
                                        data: {
                                            id: accurate_id,
                                        },
                                        success : function(respon){
                                            toggleSyncButton(false);
                                            console.log(respon);
                                            toggleSyncButton(true);
                                            $.ajax({
                                                method: "POST",
                                                url: "{{ route('admin.accurate.sync.updateWarehouse') }}",
                                                data: {
                                                    "_token": "{{ csrf_token() }}",
                                                    "_method": "POST",
                                                    data: item
                                                },
                                                success: function(respon) {
                                                toggleSyncButton(false);
                                                    console.log(respon);
                                                }
                                            });
                                        }
                                    });
                                });
                            }
                        });
                    }
                });
                toggleSyncButton(true);
                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.accurate.sync.getToken') }}",
                    success: function(response) {
                        toggleSyncButton(false);
                        var token = response.output;
                        toggleSyncButton(true);
                        $.ajax({
                            method: "GET",
                            url: "https://cors-anywhere.herokuapp.com/https://public.accurate.id/accurate/api/warehouse/list.do",
                            headers: {
                                "X-Api-Timestamp": token.plain_text,
                                "X-Api-Signature": token.hashed_output,
                                "Authorization": "Bearer aat.MTAw.eyJ2IjoxLCJ1Ijo2MDA4NjksImQiOjEwODc0NjIsImFpIjo0Mzg1MSwiYWsiOiJjY2E3MDU2MS00YTZlLTQzOGMtYmMzMS1kNjIwZjEwODQ4ODYiLCJhbiI6IkJhc2UiLCJhcCI6IjRmYWEzOWZmLWU4NDUtNGQxOC05YzQ1LTk5MTZlNWU2NmIzYiIsInQiOjE3MDQ4NjkxOTQwODF9.vM0Q4tm5ReY4yY5wVu0R7/vai01pfqVbWDYos/faAGqjcye/tw5c4ZZ15LBqcFTPdpxlyzKvR13mBGhlcyMgoorj/N4QkSd9TaFZPXRdc1W/KW7eWFXiNLi9uZ8QJsiilhBj3aHUq34PSry10UtnhrowPDXxDv19U1DYE7d5Cn5e9y3Hhx52MpoQFJfIn782JokpugzkVSI=.aZjMfZX9tH4+2vNnMWRu/j/GAMcndjgQjz0H2tqw6KM"
                            },
                            success: function(response) {
                                toggleSyncButton(false);
                                let data = response.d;
                                data.forEach(function(item) {
                                    toggleSyncButton(true);
                                    $.ajax({
                                        method: "POST",
                                        url: "{{ route('admin.accurate.sync.saveWarehouse') }}",
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            "_method": "POST",
                                            data: item
                                        },
                                        success: function(respon) {
                                            toggleSyncButton(false);
                                            console.log(respon);
                                        }
                                    });
                                });
                            }
                        });
                    }
                });
                
                //Employee
                toggleSyncButton(true);
                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.accurate.sync.getToken') }}",
                    success: function(response) {
                        toggleSyncButton(false);
                        var token = response.output;
                        toggleSyncButton(true);
                        $.ajax({
                            method: "GET",
                            url: "{{ route('admin.accurate.sync.getDataEmployee') }}",
                            success: function(response) {
                                toggleSyncButton(false);
                                let data = response.data;
                                data.forEach(function(item) {
                                    var accurate_id = item.accurate_id !==
                                    0 ? item.accurate_id : '';
                                    
                                    toggleSyncButton(true);
                                    $.ajax({
                                        method: "POST",
                                        url: "https://cors-anywhere.herokuapp.com/https://public.accurate.id/accurate/api/employee/save.do",
                                        headers: {
                                            "X-Api-Timestamp": token
                                                .plain_text,
                                            "X-Api-Signature": token
                                                .hashed_output,
                                            "Authorization": "Bearer aat.MTAw.eyJ2IjoxLCJ1Ijo2MDA4NjksImQiOjEwODc0NjIsImFpIjo0Mzg1MSwiYWsiOiJjY2E3MDU2MS00YTZlLTQzOGMtYmMzMS1kNjIwZjEwODQ4ODYiLCJhbiI6IkJhc2UiLCJhcCI6IjRmYWEzOWZmLWU4NDUtNGQxOC05YzQ1LTk5MTZlNWU2NmIzYiIsInQiOjE3MDQ4NjkxOTQwODF9.vM0Q4tm5ReY4yY5wVu0R7/vai01pfqVbWDYos/faAGqjcye/tw5c4ZZ15LBqcFTPdpxlyzKvR13mBGhlcyMgoorj/N4QkSd9TaFZPXRdc1W/KW7eWFXiNLi9uZ8QJsiilhBj3aHUq34PSry10UtnhrowPDXxDv19U1DYE7d5Cn5e9y3Hhx52MpoQFJfIn782JokpugzkVSI=.aZjMfZX9tH4+2vNnMWRu/j/GAMcndjgQjz0H2tqw6KM"
                                        },
                                        data: {
                                            id: accurate_id,
                                            name: item.name,
                                            email: item.email,
                                            suspended: (item.status === true ? false : true),
                                        },
                                        success : function(respon){
                                            toggleSyncButton(false);
                                            console.log(respon);
                                            if ((respon.s === false) && (respon.d[0] === "Data tidak ditemukan atau sudah dihapus")) {
                                                toggleSyncButton(true);
                                                $.ajax({
                                                    method: "POST",
                                                    url: "{{ route('admin.accurate.sync.updateEmployee') }}",
                                                    data: {
                                                        "_token": "{{ csrf_token() }}",
                                                        "_method": "POST",
                                                        data: item
                                                    },
                                                    success: function(respon) {
                                                    toggleSyncButton(false);
                                                        console.log(respon);
                                                    }
                                                });
                                            }
                                        }
                                    });
                                });
                            }
                        });
                    }
                });
                toggleSyncButton(true);
                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.accurate.sync.getToken') }}",
                    success: function(response) {
                        toggleSyncButton(false);
                        var token = response.output;
                        toggleSyncButton(true);
                        $.ajax({
                            method: "GET",
                            url: "{{ route('admin.accurate.sync.getDataEmployeeDeleted') }}",
                            success: function(response) {
                                toggleSyncButton(false);
                                let data = response.data;
                                data.forEach(function(item) {
                                            console.log(item);
                                    var accurate_id = item.accurate_id !==
                                    0 ? item.accurate_id : '';
                                    
                                    toggleSyncButton(true);
                                    $.ajax({
                                        method: "POST",
                                        url: "https://cors-anywhere.herokuapp.com/https://public.accurate.id/accurate/api/employee/delete.do",
                                        headers: {
                                            "X-Api-Timestamp": token
                                                .plain_text,
                                            "X-Api-Signature": token
                                                .hashed_output,
                                            "Authorization": "Bearer aat.MTAw.eyJ2IjoxLCJ1Ijo2MDA4NjksImQiOjEwODc0NjIsImFpIjo0Mzg1MSwiYWsiOiJjY2E3MDU2MS00YTZlLTQzOGMtYmMzMS1kNjIwZjEwODQ4ODYiLCJhbiI6IkJhc2UiLCJhcCI6IjRmYWEzOWZmLWU4NDUtNGQxOC05YzQ1LTk5MTZlNWU2NmIzYiIsInQiOjE3MDQ4NjkxOTQwODF9.vM0Q4tm5ReY4yY5wVu0R7/vai01pfqVbWDYos/faAGqjcye/tw5c4ZZ15LBqcFTPdpxlyzKvR13mBGhlcyMgoorj/N4QkSd9TaFZPXRdc1W/KW7eWFXiNLi9uZ8QJsiilhBj3aHUq34PSry10UtnhrowPDXxDv19U1DYE7d5Cn5e9y3Hhx52MpoQFJfIn782JokpugzkVSI=.aZjMfZX9tH4+2vNnMWRu/j/GAMcndjgQjz0H2tqw6KM"
                                        },
                                        data: {
                                            id: accurate_id,
                                        },
                                        success : function(respon){
                                            toggleSyncButton(false);
                                            console.log(respon);
                                            toggleSyncButton(true);
                                            $.ajax({
                                                method: "POST",
                                                url: "{{ route('admin.accurate.sync.updateEmployee') }}",
                                                data: {
                                                    "_token": "{{ csrf_token() }}",
                                                    "_method": "POST",
                                                    data: item
                                                },
                                                success: function(respon) {
                                                toggleSyncButton(false);
                                                    console.log(respon);
                                                }
                                            });
                                        }
                                    });
                                });
                            }
                        });
                    }
                });
                toggleSyncButton(true);
                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.accurate.sync.getToken') }}",
                    success: function(response) {
                        toggleSyncButton(false);
                        var token = response.output;
                        toggleSyncButton(true);
                        $.ajax({
                            method: "GET",
                            url: "https://cors-anywhere.herokuapp.com/https://public.accurate.id/accurate/api/employee/list.do",
                            headers: {
                                "X-Api-Timestamp": token.plain_text,
                                "X-Api-Signature": token.hashed_output,
                                "Authorization": "Bearer aat.MTAw.eyJ2IjoxLCJ1Ijo2MDA4NjksImQiOjEwODc0NjIsImFpIjo0Mzg1MSwiYWsiOiJjY2E3MDU2MS00YTZlLTQzOGMtYmMzMS1kNjIwZjEwODQ4ODYiLCJhbiI6IkJhc2UiLCJhcCI6IjRmYWEzOWZmLWU4NDUtNGQxOC05YzQ1LTk5MTZlNWU2NmIzYiIsInQiOjE3MDQ4NjkxOTQwODF9.vM0Q4tm5ReY4yY5wVu0R7/vai01pfqVbWDYos/faAGqjcye/tw5c4ZZ15LBqcFTPdpxlyzKvR13mBGhlcyMgoorj/N4QkSd9TaFZPXRdc1W/KW7eWFXiNLi9uZ8QJsiilhBj3aHUq34PSry10UtnhrowPDXxDv19U1DYE7d5Cn5e9y3Hhx52MpoQFJfIn782JokpugzkVSI=.aZjMfZX9tH4+2vNnMWRu/j/GAMcndjgQjz0H2tqw6KM"
                            },
                            success: function(response) {
                                toggleSyncButton(false);
                                let data = response.d;
                                data.forEach(function(item) {
                                    toggleSyncButton(true);
                                    $.ajax({
                                        method: "GET",
                                        url: "https://cors-anywhere.herokuapp.com/https://public.accurate.id/accurate/api/employee/detail.do?id=" + item.id,
                                        headers: {
                                            "X-Api-Timestamp": token.plain_text,
                                            "X-Api-Signature": token.hashed_output,
                                            "Authorization": "Bearer aat.MTAw.eyJ2IjoxLCJ1Ijo2MDA4NjksImQiOjEwODc0NjIsImFpIjo0Mzg1MSwiYWsiOiJjY2E3MDU2MS00YTZlLTQzOGMtYmMzMS1kNjIwZjEwODQ4ODYiLCJhbiI6IkJhc2UiLCJhcCI6IjRmYWEzOWZmLWU4NDUtNGQxOC05YzQ1LTk5MTZlNWU2NmIzYiIsInQiOjE3MDQ4NjkxOTQwODF9.vM0Q4tm5ReY4yY5wVu0R7/vai01pfqVbWDYos/faAGqjcye/tw5c4ZZ15LBqcFTPdpxlyzKvR13mBGhlcyMgoorj/N4QkSd9TaFZPXRdc1W/KW7eWFXiNLi9uZ8QJsiilhBj3aHUq34PSry10UtnhrowPDXxDv19U1DYE7d5Cn5e9y3Hhx52MpoQFJfIn782JokpugzkVSI=.aZjMfZX9tH4+2vNnMWRu/j/GAMcndjgQjz0H2tqw6KM"
                                        },
                                        success: function(response) {
                                            toggleSyncButton(false);
                                            let detail = response.d;
                                            console.log(detail);
                                            // return false;
                                            toggleSyncButton(true);
                                            $.ajax({
                                                method: "POST",
                                                url: "{{ route('admin.accurate.sync.saveEmployee') }}",
                                                data: {
                                                    "_token": "{{ csrf_token() }}",
                                                    "_method": "POST",
                                                    data: detail
                                                },
                                                success: function(respon) {
                                                    toggleSyncButton(false);
                                                    console.log(respon);
                                                }
                                            });
                                        }
                                    });
                                });
                            }
                        });
                    }
                });
            });
            // $('#triggerSync').on('click', function() {
            //     toggleSyncButton(true);

            //     function ajaxRequest(url, type, data, successCallback, errorCallback) {
            //         $.ajax({
            //             url: url,
            //             type: type,
            //             data: data,
            //             cache: false,
            //             success: successCallback,
            //             error: errorCallback
            //         });
            //     }

            //     var token;

            //     ajaxRequest('{{ route('admin.accurate.sync.getToken') }}', 'GET', {}, function(
            //         responToken) {
            //         token = responToken.output;
            //         ajaxRequest('{{ route('admin.accurate.sync.getDataWarehouse') }}', 'GET', {},
            //             function(
            //                 respon) {
            //                 var warehouse = respon.data;

            //                 var saveWarehousePromises = warehouse.map(function(item) {
            //                     return ajaxRequest(
            //                         '{{ route('admin.accurate.sync.saveWarehouse') }}',
            //                         'POST', {
            //                             "_token": "{{ csrf_token() }}",
            //                             "_method": "POST",
            //                             timestamps: token.plain_text,
            //                             signature: token.hashed_output,
            //                             id: item.id,
            //                             accurate_id: item.accurate_id,
            //                             name: item.name,
            //                             pic: item.pic,
            //                             suspended: (item.status === true ? 'true' :
            //                                 'false')
            //                         }, null, null);
            //                 });

            //                 Promise.all(saveWarehousePromises)
            //                     .then(function(responses) {
            //                         console.log(responses);
            //                         data_items.ajax.reload(null, false);
            //                     })
            //                     .catch(function(error) {
            //                         console.error(error);
            //                     })
            //                     .finally(function() {
            //                         toggleSyncButton(false);
            //                     });
            //             },
            //             function() {
            //                 toggleSyncButton(false);
            //             });

            //         ajaxRequest('{{ route('admin.accurate.sync.getAccurateWarehouse') }}', 'GET', {
            //             "_token": "{{ csrf_token() }}",
            //             "_method": "GET",
            //             timestamps: token.plain_text,
            //             signature: token.hashed_output,
            //         }, function() {
            //             data_items.ajax.reload(null, false);
            //             toggleSyncButton(false);
            //         }, function() {
            //             toggleSyncButton(false);
            //         });
            //     }, function() {
            //         toggleSyncButton(false);
            //     });
            // });
        });

        function toggleSyncButton(showLoader) {
            var syncLoader = $('#syncLoader');
            var syncText = $('#syncText');

            if (showLoader) {
                syncLoader.removeClass('d-none');
                syncText.addClass('d-none');
            } else {
                syncLoader.addClass('d-none');
                syncText.removeClass('d-none');
            }
        }
    </script>
@endpush
