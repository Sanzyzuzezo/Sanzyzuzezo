<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <form id="form" class="form d-flex flex-column flex-lg-row" action="" method="POST" enctype="multipart/form-data">
            <!--begin::Main column-->
            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <!--begin::General options-->
                <div class="card card-flush py-4">
                    <!--begin::Card header-->
                    <div class="card-header"style="clear:both; position:relative;">
                        <div class="col-md-3" style="position:absolute; left:25pt; width:292pt;">
                            <img src="{{$logoPath}}" width="25%" height="10%">
                        </div>
                        <div class="card-title" style="margin-left:250pt; margin-bottom:50pt;">
                            <h2>Purchase</h2>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div class="row" style="margin-bottom: 30px !important">
                                <table class="table" id="putih">
                                    <tbody>
                                        <tr>
                                            <td class=fw-bolder style="left:25pt; width:45pt;">
                                                <div class="d-flex justify-content-between">
                                                    <span class="fw-bold">Purchase &nbsp;&nbsp;&nbsp;&nbsp;:</span>
                                                </div>
                                            </td>
                                            <td>{{ $detail->nomor_pembelian }}</td>
                                        </tr>
                                        <tr>
                                            <td class=fw-bolder style="left:25pt; width:45pt;">
                                                <div class="d-flex justify-content-between">
                                                    <span class="fw-bold">Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</span>
                                                </div>
                                            </td>
                                            <td>{{ date('d F Y', strtotime($detail->tanggal)) }}</td>
                                        </tr>
                                        <tr>
                                            <td class=fw-bolder style="left:25pt; width:45pt;">
                                                <div class="d-flex justify-content-between">
                                                    <span class="fw-bold">Warehouse :</span>
                                                </div>
                                            </td>
                                            <td>{{ $detail->warehouse }}</td>
                                        </tr>
                                        <tr>
                                            <td class=fw-bolder style="left:25pt; width:45pt;">
                                                <div class="d-flex justify-content-between">
                                                    <span class="fw-bold">supplier &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</span>
                                                </div>
                                            </td>
                                            <td>{{ $detail->supplier }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                        </div>

                        <div class="mb-10 fv-row" style="margin-bottom: 30px !important">
                            <!--begin::Label-->
                            <label class="form-label">Purchase Detail</label><br/><br/>
                            <!--end::Label-->
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table detail gy-3 fs-7">
                                        <thead style="vertical-align: top;">
                                            <tr class="fw-bolder bg-light">
                                                <th class="text-end min-w-50px">Product</th>
                                                <th class="text-end min-w-50px">Variant</th>
                                                <th class="text-end min-w-50px">Item Price</th>
                                                <th class="text-end min-w-50px">Quantity</th>
                                                <th class="text-end min-w-50px">Unit</th>
                                                <th class="text-end min-w-50px">Price</th>
                                                <th class="p-2 text-end min-w-50px">Expired</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($detail_item as $data)
                                                <tr>
                                                    <td class="p-2 text-end">{{ $data['item_name'] }}</td>
                                                    <td class="p-2 text-end">{{ $data['item_variant_name'] }}</td>
                                                    <td class="p-2 text-end">{{ number_format($data['harga']) }}</td>
                                                    <td class="p-2 text-end">{{ number_format($data['jumlah']) }}</td>
                                                    <td class="p-2 text-end">{{ $data['unit_name'] }}</td>
                                                    <td class="p-2 text-end">{{ number_format($data['total']) }}</td>
                                                    <td class="p-2 text-end">{{ date('Y-F-d', strtotime($data['expired']))}}</td>
                                                </tr>
                                            @endforeach
                                            <tr class="fw-bold fs-6 text-gray-700">
                                                <th class="text-end" colspan="6">Total Price</th>
                                                <th class="p-2 text-end">{{number_format($detail->total_keseluruhan) }}</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--end::Input-->
                        </div>
                    </div>
                    <!--end::Card header-->
                </div>
                <!--end::General options-->
            </div>
            <!--end::Main column-->
        </form>
    </div>
    <!--end::Container-->
</div>
<style>
    html,
    @page { margin: 0px; }
    body {
        margin: 10px;
        padding: 10px;
        font-family: sans-serif;
    }
    h1,h2,h3,h4,h5,h6,p,span,label {
        font-family: sans-serif;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0px !important;
    }
    table#putih >td{
        border: 1px solid white !important;
    }
    table thead th {
        height: 10px;
        text-align: left;
        font-size: 12px;
        font-family: sans-serif;
    }
    table, th, td {
        border: 1px solid black;
        padding: 8px;
        font-size: 10px;
    }

    .heading {
        font-size: 24px;
        margin-top: 12px;
        margin-bottom: 12px;
        font-family: sans-serif;
    }
    .small-heading {
        font-size: 16px;
        font-family: sans-serif;
    }
    .form-label {
        font-size: 14px;
        font-family: sans-serif;
        font-weight: bold;
    }
    .form-rekening {
        font-size: 11px;
        font-family: sans-serif;
        margin-top: 8px;
    }
    .form-permohonan {
        font-size: 12px;
        font-family: sans-serif;
        margin-top: 9px;
    }
    .form-check-input{
        font-family: sans-serif;
        margin-top: 10px;
    }
    .total-heading {
        font-size: 18px;
        font-weight: 700;
        font-family: sans-serif;
    }
    .responsive {
        width: 100%;
        height: auto;
    }

    .text-start {
        text-align: left;
    }
    .text-end {
        text-align: right;
    }
    .text-center {
        text-align: center;
    }
    .company-data span {
        margin-bottom: 4px;
        display: inline-block;
        font-family: sans-serif;
        font-size: 14px;
        font-weight: 400;
    }
    .no-border {
        border: 1px solid #fff !important;
    }
    .no-left-border{
        border-left: 1px solid #fff !important;
    }
    .no-bottom-border{
        border-bottom:  1px solid #fff !important;
    }
    .bg-blue {
        background-color:darkgray;
        color: black;
    }
    .form-check-input[type="checkbox"] {
        width: 16px; /* Set the desired width */
        height: 16px; /* Set the desired height */
    }
</style>
