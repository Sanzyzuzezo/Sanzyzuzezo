@extends('administrator.layouts.main')
<style>
    #buys_table {
        font-family: Arial, sans-serif;
        font-size: 12px;
    }

    #buys_table th {
        font-weight: bold;
        font-size: 11px;
    }

    #buys_table td {
        font-size: 12px;
    }
    .form-label {
        font-weight: bold !important;
        font-size: 12px !important;
    }
    #buys_table th.detail.min-w-10px {
    display: none;
    }
</style>
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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Purchase</h1>
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
                        <li class="breadcrumb-item text-dark">Purchase</li>
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
                <div class="card card-flush py-4 mb-10 container">
                    <div class="card-header m-0 p-0 min-h-10px">
                        <div class="card-title m-0 fs-5 fw-bold">
                            Filter Data
                        </div>
                    </div>
                    <div class="my-5 fv-row">
                        <div class="row mb-5">
                            <div class="col-lg-4">
                                <label class="form-label">Date</label>
                                <input type="text" class="form-control tanggal" id="tanggal" placeholder="Date"/>
                            </div>
                            <div class="col-lg-4">
                                    <label class="form-label">Warehouse</label>
                                    <select name="warehouses" class="form-select" id="warehouses" data-control="select2" data-hide-search="true" data-placeholder="Please Select">
                                        <option value="">Please Select</option>
                                        @foreach($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="text-muted fs-7">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Supplier</label>
                                <select name="suppliers" class="form-select" id="suppliers" data-control="select2" data-hide-search="true" data-placeholder="Please Select">
                                    <option value="">Please Select</option>
                                    @foreach($supplier as $supply)
                                        <option value="{{ $supply->id }}">{{ $supply->name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-muted fs-7">
                            </div>
                        </div>
                        </div>
                    </div> 
                    <div class="my-6 fv-row ps-10 d-flex flex-row justify-content-end">
                        <a href="{{ route("admin.buys.exportExcel") }}" class="btn btn-sm btn-light-warning" id="exportIndexExcel">
                            <span class="svg-icon svg-icon-muted svg-icon-2"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                            </svg></span>
                        Export Excel
                        </a>
                        <button class="btn btn-sm btn-light-success ms-3" id="filterData">
                            <span class="svg-icon svg-icon-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/>
                                    <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/>
                                </svg>
                            </span>
                            Filter Data
                        </button>
                        <button class="btn btn-sm btn-light-danger ms-3" id="reset">
                            <span class="svg-icon svg-icon-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M14.5 20.7259C14.6 21.2259 14.2 21.826 13.7 21.926C13.2 22.026 12.6 22.0259 12.1 22.0259C9.5 22.0259 6.9 21.0259 5 19.1259C1.4 15.5259 1.09998 9.72592 4.29998 5.82592L5.70001 7.22595C3.30001 10.3259 3.59999 14.8259 6.39999 17.7259C8.19999 19.5259 10.8 20.426 13.4 19.926C13.9 19.826 14.4 20.2259 14.5 20.7259ZM18.4 16.8259L19.8 18.2259C22.9 14.3259 22.7 8.52593 19 4.92593C16.7 2.62593 13.5 1.62594 10.3 2.12594C9.79998 2.22594 9.4 2.72595 9.5 3.22595C9.6 3.72595 10.1 4.12594 10.6 4.02594C13.1 3.62594 15.7 4.42595 17.6 6.22595C20.5 9.22595 20.7 13.7259 18.4 16.8259Z" fill="black"/>
                                    <path opacity="0.3" d="M2 3.62592H7C7.6 3.62592 8 4.02592 8 4.62592V9.62589L2 3.62592ZM16 14.4259V19.4259C16 20.0259 16.4 20.4259 17 20.4259H22L16 14.4259Z" fill="black"/>
                                </svg>
                            <span>
                            Reset
                        </button>
                    </div>
                </div>
                <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                            transform="rotate(45 17.0365 15.1223)" fill="black" />
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
                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                            <div class="card-toolbar">
                                @if (isAllowed("buys", "add"))
                                <a href="{{ route('admin.buys.add') }}" class="btn btn-sm btn-light-primary">
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                                transform="rotate(-90 11.364 20.364)" fill="black" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                                        </svg>
                                    </span>
                                    Add Data
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="buys_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-10px">No</th>
                                    <th class="min-w-90px">Date</th>
                                    <th class="min-w-90px">Purchase Number</th>
                                    <th class="min-w-90px">Supplier</th>
                                    <th class="min-w-90px">Warehouse</th>
                                    <th class="min-w-30px">Quantity</th>
                                    <th class="min-w-40px">Total Price</th>
                                    <th class="min-w-10px">Actions</th>
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
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
@endsection

@push('scripts')
<script src="{{ asset_administrator('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
<script src="{{ asset_administrator('assets/js/custom/apps/ecommerce/catalog/buys.js') }}"></script>
<script src="{{ asset_administrator('assets/js/custom/documentation/documentation.js') }}"></script>
<script src="{{ asset_administrator('assets/js/custom/documentation/search.js') }}"></script>
<script src="{{ asset_administrator('assets/js/custom/documentation/forms/select2.js') }}"></script>
<script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#tanggal").daterangepicker();

        $('#filterData').on('click',function(){
            getData();
            setParams();
        });

        var data_buys = $('#buys_table').DataTable({
            "language": {
                "emptyTable": "Please Filter Data!!"
            }
        });

        function getData(){
            $('#searchdatatable').keyup(function(){
                $('#buys_table').DataTable().search($(this).val()).draw() ;
            });
            $("#buys_table").DataTable().destroy();
            $('#buys_table tbody').remove();
            var data_buys = $('#buys_table').DataTable({
                "searching": true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.buys.getData') }}',
                    dataType: "JSON",
                    type: "GET",
                    data: function(d) {
                        d.tanggal = getTanggal();
                        d.warehouses = getWarehouse();
                        d.suppliers = getSupplier();
                        d.status = getStatus();
                    }
                },
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        "render": function(data, type, row) {
                            return moment(row.tanggal).format('YYYY-MM-DD');
                        }
                    },
                    {
                        data: 'nomor_pembelian',
                        name: 'nomor_pembelian'
                    },
                    {
                        data: 'supplier',
                        name: 'supplier'
                    },
                    {
                        data: 'warehouse',
                        name: 'warehouse'
                    },
                    {
                        data: 'total_item',
                        name: 'total_item'
                    },
                    {
                        data: 'total_keseluruhan',
                        name: 'total_keseluruhan'
                    },
                    {
                        data: 'action', 'searchable': false,
                        name: 'action'
                    }
                ],
            });
        }

        function setParams(){
                linkExcel = '{{ route('admin.buys.exportExcel')}}' + '?search=tanggal:'+getTanggal()+'|warehouse:'+getWarehouse()+'|supplier:'+getSupplier()+'|txt:'+$("#searchdatatable").val();
                console.log(linkExcel);
                $("#exportIndexExcel").attr('href',linkExcel);
            }  

        function getTanggal() {
            return $("#tanggal").val();
            setParams();
        }

        function getWarehouse() {
            return $("#warehouses").val();
            setParams();
        }

        function getSupplier() {
            return $("#suppliers").val();
            setParams();
        }

        function getStatus() {
            return $("#filterstatus").val();
            setParams();
        }

        // button reset
        $('#reset').off().on('click', function () {
            $(".tanggal").val('');
            $("#warehouses").append('<option value="" selected>Silahkan Pilih</option>');
            $("#suppliers").append('<option value="" selected>Silahkan Pilih</option>');
            $("#filterstatus").append('<option value="" selected>Silahkan Pilih</option>');
        });

        //Delete Confirmation
        $(document).on('click', '.delete', function(event) {
                var ix = $(this).data('ix');

                Swal.fire({
                    html: 'Are you sure remove this data?',
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
                            url: "{{ route('admin.buys.delete') }}",
                            data: ({
                                "_token": "{{ csrf_token() }}",
                                "_method": 'DELETE',
                                ix: ix,
                            }),
                            success: function(resp){
                            if(resp.success){
                                Swal.fire('Deleted!', 'Data has been deleted', 'success');
                            }else{
                                Swal.fire('Failed!', 'Stock less than purchase', 'error');
                            }

                            getData().ajax.reload(null, false);
                            },
                            error: function (resp) {
                                Swal.fire("Error!", 'Stock less than purchase', "error");
                                getData().ajax.reload(null, false);
                            }
                        });
                    }
                });
            });

        });
</script>
@endpush
