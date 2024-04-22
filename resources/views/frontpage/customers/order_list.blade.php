<table class="table ec-table">
    <thead>
        <tr>

            <th scope="col"> {{ __('order_history.Invoice_Number') }} </th>
            <th scope="col"> {{ __('order_history.Customer_Name') }} </th>
            <th scope="col"> {{ __('order_history.Status') }} </th>
            <th scope="col"> {{ __('order_history.Shipping') }} </th>
            <th scope="col"> {{ __('order_history.Payment') }} </th>
            <th scope="col"> {{ __('order_history.Total') }} </th>
            <th scope="col"> {{ __('order_history.Actions') }} </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <th scope="row"><span>{{ $order->invoice_number }}</span></th>
                <td><span>{{ $order->customer_name }}</span></td>
                <td>
                    <span>
                        @if ($order->status == 'processed')
                            {{ __('order_history.Processed') }}
                            <div class="badge badge-light-primary">{{ __('order_history.Processed') }}</div>
                        @elseif($order->status == 'waiting_for_confirmation')
                            {{ __('order_history.Waiting_For_Confirmation') }}
                            <div class="badge badge-light-danger">{{ __('order_history.Waiting_For_Confirmation') }}</div>
                        @elseif($order->status == 'shipping')
                            {{ __('order_history.Shipping') }}
                            <div class="badge badge-light-info">{{ __('order_history.Shipping') }}</div>
                        @elseif($order->status == 'finished')
                            {{ __('order_history.Finished') }}
                            <div class="badge badge-light-success">{{ __('order_history.Finished') }}</div>
                        @elseif($order->status == 'complain')
                            {{ __('order_history.Complain') }}
                            <div class="badge badge-light-danger">{{ __('order_history.Complain') }}</div>
                        @else
                            {{ __('order_history.Waiting_For_Payment') }}
                            <div class="badge badge-light-warning">{{ __('order_history.Waiting For Payment') }}</div>
                        @endif
                    </span>
                </td>
                <td>
                    <span>
                        @if ($order->courier != null && $order->resi != null)
                            {{ $order->courier . ' - ' . $order->resi }}
                        @else
                            -
                        @endif
                    </span>
                </td>
                <td>
                    <span>
                        @if ($order->payment_method != null)
                            <?php

                            $billing = (array) json_decode($order->payment_data);
                            if ($order->payment_method == 'manual_bank_transfer') {
                                echo 'Manual Bank Transfer<br>';
                                echo strtoupper($billing['bank_name'] . ' - ' . $billing['account_number'] . ' an ' . $billing['account_owner']);
                            } else {
                                if (array_key_exists('payment_type', $billing)) {
                                    echo '' . ucwords(str_replace('_', ' ', $billing['payment_type'])) . ' (Virtual Acccount)<br>';
                                    if ($billing['payment_type'] == 'bank_transfer') {
                                        foreach ($billing['va_numbers'] as $row) {
                                            echo strtoupper($row->bank . ' - ' . $row->va_number);
                                        }
                                    } elseif ($billing['payment_type'] == 'cstore') {
                                        echo strtoupper($billing['store'] . ' - ' . $billing['payment_code']);
                                    }
                                } else {
                                    echo 'Other';
                                }
                            }

                            ?>
                        @else
                            -
                        @endif
                    </span>
                </td>
                <td><span>{{ number_format($order->total, 0, '.', ',') }}</span></td>
                <td><span class="tbl-btn"><a class="btn btn-lg btn-primary"
                            href="{{ route('order_history_detail', $order->invoice_number) }}">{{ __('order_history.view') }}</a></span></td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="ec-pro-pagination">
    {{ $orders->links('vendor.pagination.custom') }}
</div>
