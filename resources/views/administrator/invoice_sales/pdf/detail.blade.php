<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Detail</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(3) {
            text-align: right;
            width: 10%;
        }

        .invoice-box table tr td:nth-child(4) {
            text-align: right;
            width: 35%;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2),
        .invoice-box table tr.total td:nth-child(3) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }


        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(4) {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="https://sparksuite.github.io/simple-html-invoice-template/images/logo.png"
                                    style="width: 100%; max-width: 300px" />
                            </td>

                            <td>
                                Invoice #: {{$data->invoice_sales_number}}<br />
                                Created: {{ date('d-m-Y', strtotime($data->date)) }}<br />
                                Due: {{ date('d-m-Y', strtotime($data->date . ' +7 days')) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                {{ $data->customer_name }}.<br />
                                {{ $data->customer_phone }}<br />
                                {{ $data->customer_address }}
                            </td>

                            <td>
                                {{array_key_exists('site_name', $settings) ? $settings['site_name'] : 'Basecode'}}.<br />
                                {{array_key_exists('whatsapp', $settings) ? $settings['whatsapp'] : '+62 345 6789 1234'}}<br />
                                {{array_key_exists('email', $settings) ? $settings['email'] : 'info@diantara.id'}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Image</td>
                <td>Item Variant</td>
                <td>Quantity</td>
                <td>Amount</td>
            </tr>
            @foreach ($data_detail as $row)
            <tr class="item">
                <td><img src="https://sparksuite.github.io/simple-html-invoice-template/images/logo.png" style="width: 100%; max-width: 300px" alt="sas"></td>
                <td>{{ $row->nama_item_variant }}</td>
                <td>{{ $row->quantity }}</td>
                <td>Rp {{ number_format($row->total_payment, 0, ',', '.') }}</td>
            </tr>
            @endforeach

            <tr class="total">
                <td colspan="2"></td>
                <td>Subtotal</td>
                <td>Rp {{ number_format($data->total_payment_amount, 0, ',', '.') }}</td>
            </tr>
            <tr class="total">
                <td colspan="2"></td>
                <td>TAX 0%</td>
                <td>Rp 0</td>
            </tr>
            <tr class="total">
                <td colspan="2"></td>
                <td>Subtotal + TAX</td>
                <td>Rp {{ number_format($data->total_payment_amount, 0, ',', '.') }}</td>
            </tr>
            <tr class="total">
                <td colspan="2"></td>
                <td>Total</td>
                <td>Rp {{ number_format($data->total_payment_amount, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
