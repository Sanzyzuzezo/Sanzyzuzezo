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
                            {{-- <img src="{{ array_key_exists('logo', $settings) ? img_src($settings['logo'], 'settings') : '' }}" width="25%" height="10%"> --}}
                        </div>
                        <div class="card-title" style="margin-left:150pt; margin-bottom:50pt;">
                            <h2>Recap of sale invoices</h2>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">

                        <div class="row" style="margin-bottom: 30px !important">
                            <table class="table" style="width: 100%; !important" id="putih">
                                <tbody>
                                    <tr style="vertical-align: top;">
                                        <td>
                                            {{-- <div class="form-permohonan">
                                                <span>Tanggal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ date('d F Y', strtotime($data->date)) }}</span>
                                            </div>
                                            <div class="form-permohonan">
                                                <span>Customer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->customer_name }}</span>
                                            </div>
                                            <div class="form-permohonan">
                                                <span>Sales Number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->sales_number }}</span>
                                            </div>
                                            <div class="form-permohonan">
                                                <span>Delivery Note Number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->delivery_note_number }}</span>
                                            </div>
                                            <div class="form-permohonan">
                                                <span>License Plate Number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->license_plate_number }}</span>
                                            </div>
                                            <div class="form-permohonan">
                                                <span>Weather&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->weather }}</span>
                                            </div>
                                            <div class="form-permohonan">
                                                <span>Informasi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->information }}</span>
                                            </div> --}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mb-10 fv-row" style="margin-bottom: 30px !important">
                            <!--begin::Label-->
                            <label class="form-label">Invoice</label><br/><br/>
                            <!--end::Label-->
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table detail gy-3 fs-7">
                                        <thead style="vertical-align: top;">
                                            <tr class="fw-bolder bg-light detail">
                                                <th class="p-2 detail">No</th>
                                                <th class="p-2 detail">Invoice Sales Number</th>
                                                <th class="p-2 detail">Date</th>
                                                <th class="p-2 detail">Invoice Type</th>
                                                <th class="p-2 detail">Customer</th>
                                                <th class="p-2 detail">Total Payment Amount</th>
                                                <th class="p-2 detail">Payment Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $key => $row)
                                                <tr>
                                                    <td class="p-2 detail">{{ ($key + 1) }}</td>
                                                    <td class="p-2 detail">{{ $row['invoice_sales_number'] }}</td>
                                                    <td class="p-2 detail">{{ date('d-m-Y', strtotime($row['date'])) }}</td>
                                                    <td class="p-2 detail">{{ ($row['sales_id'] !== 0 ? 'Sales' : 'Delivery Note') }}</td>
                                                    <td class="p-2 detail text-end">{{ $row['customer_name'] }}</td>
                                                    <td class="p-2 detail text-end">Rp {{ number_format($row->total_payment_amount, 0, ',', '.') }}</td>
                                                    <td class="p-2 detail text-end">{{ ($row['payment_status'] === 0 ? 'UnPaid' : 'Paid') }}</td>
                                                </tr>
                                            @endforeach
                                            {{-- <tr class="fw-bold">
                                                <th class="p-2 detail text-end" colspan="6">Total Keseluruhan</th>
                                                <th class="p-2 detail text-end">{{ $data->delivery_note_number }}</th>
                                            </tr> --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--end::Input-->
                        </div>
                        {{-- <div class="row" style="clear:both; position:relative;margin-top:7pt;">
                            <div class="col-sm-3 fs-6" style="position:absolute; left:0pt; width:292pt;">
                                <label class="form-label">Rekening Penerima</label>
                                <br>
                                <div class="form-rekening">
                                    <span>Bank&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </span>
                                </div>
                                <div class="form-rekening">
                                    <span>No. Rekening&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </span>
                                </div>
                                <div class="form-rekening">
                                    <span>Pemilik Rekening&nbsp;&nbsp;: </span>
                                </div>
                            </div>  
                            <div class="col-sm-3" style="margin-left:200pt;">
                                <table class="table detail gy-3 fs-7">
                                    <thead style="vertical-align: top;">
                                        <td class="fs-6">
                                            <div class="d-flex justify-content-between">
                                                <span class="fw-bold text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pengirim&nbsp;</span>
                                            </div>
                                        </td>
                                        <td class="fs-6">
                                            <div class="d-flex justify-content-between">
                                                <span class="fw-bold text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Penerima&nbsp;</span>
                                            </div>
                                        </td>
                                    </tr>
                                </thead>
                                    <tbody style="border: 1px solid;">
                                        <tr class="detail">
                                            <td class="p-2 detail" style="height: 100px !important; margin-left: 10px !important"></td>
                                            <td class="p-2 detail" style="height: 100px !important; margin-left: 10px !important"></td>
                                        </tr>
                                        <tr class="detail">
                                            <td class="p-2 detail" style="height: 10px !important; margin-left: 10px !important"></td>
                                            <td class="p-2 detail" style="height: 10px !important; margin-left: 10px !important"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> --}}
                        <!--end::Input group-->
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
