@foreach ($orders as $order)
    <div class="card">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between">
                <div>
                    {{ $order->transaction_date }}
                </div>
                <div>
                    @if ($order->status == 'processed')
                        <span class="badge text-white bg-secondary">{{ __('order_history.Processed') }}</span>
                    @elseif($order->status == 'waiting_for_confirmation')
                        <span class="badge text-white btn-primary">{{ __('order_history.Waiting_For_Confirmation') }}</span>
                    @elseif($order->status == 'shipping')
                        <span class="badge text-white bg-secondary">{{ __('order_history.Shipping') }}</span>
                    @elseif($order->status == 'finished')
                        <span class="badge text-white bg-success">{{ __('order_history.Finished') }}</span>
                    @elseif($order->status == 'complain')
                        <span class="badge text-white bg-danger">{{ __('order_history.Complain') }}</span>
                    @elseif($order->status == 'failed')
                        <span class="badge text-white bg-danger">Failed</span>
                    @else
                        <span class="badge text-white btn-primary">{{ __('order_history.Waiting_For_Payment') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <a href="{{ route('order_history_detail', $order->invoice_number) }}"><b class="card-text">#{{ $order->invoice_number }}</b></a><br/>
                    <span>Rp. {{ number_format($order->total+$order->cost, 0, '.', ',') }}</span>
                </div>
                <div>
                    <a href="{{ route('order_history_detail', $order->invoice_number) }}" class="btn btn-sm btn-secondary">Detail</a>
                    <?php
                        if ($order->payment_data != 'manual_bank_transfer' && $order->status == 'waiting_for_payment') {
                            $billing = (array) json_decode($order->payment_data);
                            if(isset($billing['snap_token'])){
                    ?>
                        <input type="hidden" value="{{ $billing['snap_token'] }}" id="snap_token">
                        <a class="btn btn-sm btn-secondary" id="payment" href="#">{{ __('order_history.Payment') }}</a>
                    <?php }} ?>
                </div>
            </div>
        </div>
    </div><br/>
@endforeach
<div class="ec-pro-pagination">
    {{ $orders->links('vendor.pagination.custom') }}
</div>
