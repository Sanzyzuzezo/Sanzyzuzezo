@extends('administrator.layouts.main')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Stock Warehouse</h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">Detail</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success d-flex align-items-center p-5">
                        <span class="svg-icon svg-icon-2hx svg-icon-success me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path opacity="0.5"
                                    d="M12.8956 13.4982L10.7949 11.2651C10.2697 10.7068 9.38251 10.7068 8.85731 11.2651C8.37559 11.7772 8.37559 12.5757 8.85731 13.0878L12.7499 17.2257C13.1448 17.6455 13.8118 17.6455 14.2066 17.2257L21.1427 9.85252C21.6244 9.34044 21.6244 8.54191 21.1427 8.02984C20.6175 7.47154 19.7303 7.47154 19.2051 8.02984L14.061 13.4982C13.7451 13.834 13.2115 13.834 12.8956 13.4982Z"
                                    fill="black" />
                                <path
                                    d="M7.89557 13.4982L5.79487 11.2651C5.26967 10.7068 4.38251 10.7068 3.85731 11.2651C3.37559 11.7772 3.37559 12.5757 3.85731 13.0878L7.74989 17.2257C8.14476 17.6455 8.81176 17.6455 9.20663 17.2257L16.1427 9.85252C16.6244 9.34044 16.6244 8.54191 16.1427 8.02984C15.6175 7.47154 14.7303 7.47154 14.2051 8.02984L9.06096 13.4982C8.74506 13.834 8.21146 13.834 7.89557 13.4982Z"
                                    fill="black" />
                            </svg>
                        </span>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-dark">Success</h4>
                            <span>{{ $message }}</span>
                        </div>
                        <button type="button"
                            class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                            data-bs-dismiss="alert">
                            <span class="svg-icon svg-icon-muted svg-icon-2hx">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2"
                                        rx="1" transform="rotate(-45 7.05025 15.5356)" fill="black" />
                                    <rect x="8.46447" y="7.05029" width="12" height="2" rx="1"
                                        transform="rotate(45 8.46447 7.05029)" fill="black" />
                                </svg>
                            </span>
                        </button>
                    </div>
                @endif
                <div class="card card-flush py-4 mb-10 container">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                        rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="black" />
                                </svg>
                            </span>
                            <input type="text" data-kt-ecommerce-category-filter="search"
                                class="form-control form-control-sm form-control-solid w-250px ps-14" placeholder="Search"
                                id="searchdatatable" />
                            &nbsp;
                            <div class="d-flex align-items-center w-100 mw-150px justify-content-end ms-auto">
                                <select class="form-select btn-sm form-select-solid" data-control="select2"
                                    data-hide-search="true" id="filterstatus">
                                    <option value="">Pilih Gudang</option>
                                    @foreach ($gudang as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-flush">
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                            <div class="card-title">
                                <div class="d-flex align-items-center position-relative my-1">
                                    <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                    </span>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="warehouse-table">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-10px">No</th>
                                            <th class="min-w-150px">Name</th>
                                            <th class="min-w-150px">Name Variant</th>
                                            <th class="min-w-100px">Sku</th>
                                            <th class="min-w-150px">Price</th>
                                            <th class="min-w-150px">Minimal Stock</th>
                                            <th class="min-w-50px">Stock</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset_administrator('assets/plugins/custom/jstree/jstree.bundle.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $('#filterstatus').on('input', function() {
                var filterValue = $(this).val();
                if (!filterValue.trim()) {
                    $('#warehouse-table').DataTable().clear().destroy();
                    $('#warehouse-table tbody').append(
                    '<tr><td colspan="6">Silahkan filter data</td></tr>');
                } else {
                    getData();
                    setParams();
                }
            });

            var data_warehouse = $('#warehouse-table').DataTable({
                "language": {
                    "emptyTable": "Silahkan filter data"
                },
                "columns": [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'item_name'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'sku'
                    },
                    {
                        data: 'price'
                    },
                    {
                        data: 'minimal_stock'
                    },
                    {
                        data: 'stock_warehouse'
                    },
                ],
            });

            function getData() {
                $("#warehouse-table").DataTable().clear().destroy();
                var filterValue = $('#filterstatus').val();

                data_warehouse = $('#warehouse-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('admin.warehouse.getDataDetail') }}',
                        dataType: "JSON",
                        type: "GET",
                        data: function(d) {
                            d.gudang = getStockId();
                        }
                    },
                    columns: [{
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                        },
                        {
                            data: 'item_name'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'sku'
                        },
                        {
                            data: 'price'
                        },
                        {
                            data: 'minimal_stock'
                        },
                        {
                            data: 'stock_warehouse',
                            render: function(data, type, row) {
                                // Assuming stock_warehouse is a string representing a float
                                return parseFloat(data)
                            }
                        },

                    ],
                });
            }

            $('#searchdatatable').keyup(function() {
                data_warehouse.search($(this).val()).draw();
            })

            $('#filterstatus').change(function() {
                data_warehouse.ajax.reload();
            });

            function getStockId() {
                return $("#filterstatus").val();
            }
        });
    </script>
@endpush
