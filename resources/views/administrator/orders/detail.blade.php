@extends('administrator.layouts.main')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Orders</h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.orders') }}" class="text-muted text-hover-primary">Orders</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">Detail</li>
                    </ul>
                </div>
            </div>
        </div>
		<div class="post d-flex flex-column-fluid">
			<div id="kt_content_container" class="container-xxl">
				<div class="card">
					<div class="card-body p-lg-20">
						<div class="d-flex justify-content-end flex-wrap pb-4">
                            <a href="#" class="btn btn-sm btn-light-success mx-2" onclick="printInvoice('printarea', 'Invoice - {{ $orders->invoice_number }}');">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path opacity="0.3"
                                            d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14V4H6V20H18V8H20V21C20 21.6 19.6 22 19 22Z"
                                            fill="black" />
                                        <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
                                    </svg>
                                </span>
                                Print Invoice
                            </a>
							@if($order_shipping == true && $order_shipping->resi != null)
								<a href="#" class="btn btn-sm btn-light-success mx-2" onclick="printResi('printresiarea', 'Resi - {{ $order_shipping == true ? $order_shipping->resi : '' }}')">
									<span class="svg-icon svg-icon-2">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
											fill="none">
											<path opacity="0.3"
												d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14V4H6V20H18V8H20V21C20 21.6 19.6 22 19 22Z"
												fill="black" />
											<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
										</svg>
									</span>
									Print Resi
								</a>
							@endif
                        </div>
						<div class="row" id="printarea">
							<div class="col-lg-8 mb-10 mb-xl-0">
								<div class="mt-n1">
									<div class="d-flex flex-stack pb-10">
										<div class="fw-bolder fs-3 text-gray-800">Invoice #{{ $orders->invoice_number }}</div>
										@if($orders->status == 'processed')
											<div class="badge badge-light-primary">Processed</div>
										@elseif($orders->status == 'shipping')
											<div class="badge badge-light-info">Shipping</div>
										@elseif($orders->status == 'finished')
											<div class="badge badge-light-success">Finished</div>
										@elseif($orders->status == 'complain')
											<div class="badge badge-light-danger">Complain</div>
										@else
											<div class="badge badge-light-warning">Waiting For Payment</div>
										@endif
									</div>
									<div class="m-0">
										<div class="row g-5 mb-11">
											<div class="col-sm-6">
												<div class="fw-bold fs-7 text-gray-600 mb-1">Customer Name:</div>
												<div class="fw-bolder fs-6 text-gray-800">{{ $orders->cust_name }}</div>
											</div>
											<div class="col-sm-6">
												<div class="fw-bold fs-7 text-gray-600 mb-1">Transaction Date:</div>
												<div class="fw-bolder fs-6 text-gray-800">{{ date('d M Y - h:i:s', strtotime($orders->transaction_date)) }}</div>
											</div>
											<div class="col-sm-6">
												<div class="fw-bold fs-7 text-gray-600 mb-1">Note:</div>
												<div class="fw-bolder fs-6 text-gray-800">{{ $orders->note == null ? '-' : $orders->note }}</div>
											</div>
											<div class="col-sm-6">
												<div class="fw-bold fs-7 text-gray-600 mb-1">Store:</div>
                                                @php
                                                    $shipping = $order_shipping == true ? json_decode($order_shipping->address) : null;
                                                    $store_name = @$shipping[0]->store_name;
                                                @endphp
												<div class="fw-bolder fs-6 text-gray-800">{{ $store_name }}</div>
											</div>
											<div class="col-sm-6">
												<div class="fw-bold fs-7 text-gray-600 mb-1">Received Name:</div>
                                                @php
                                                    $reveived_name = @$shipping[0]->reveived_name;
                                                @endphp
												<div class="fw-bolder fs-6 text-gray-800">{{ $reveived_name }}</div>
											</div>
											<div class="col-sm-6">
												<div class="fw-bold fs-7 text-gray-600 mb-1">Address:</div>
												<div class="fw-bolder fs-6 text-gray-800">{{ @$shipping[0]->address }}</div>
												<div class="fw-bolder fs-6 text-gray-800">{{ @$shipping[0]->province }} - {{ @$shipping[0]->city }} - {{ @$shipping[0]->distric }} - {{ @$shipping[0]->postalcode }}</div>
											</div>
										</div>
										<div class="flex-grow-1">
											<div class="table-responsive border-bottom mb-9">
												<table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
													<thead>
														<tr class="border-bottom fs-6 fw-bolder">
															<th class="min-w-150px pb-2">Products</th>
															<th class="pb-2 text-end">Price</th>
															<th class="pb-2 text-end">QTY</th>
															<th class="pb-2 text-end">Disc</th>
															<th class="pb-2 text-end">Total</th>
														</tr>
													</thead>
													<tbody class="fw-bold text-gray-600">
														<?php
														$subtotal = 0;
														$subtotal1 = 0;
														?>
														@foreach($order_items as $item)
														<?php

														$subtotal += $item->discount_price == 0 ? $item->price * $item->quantity : $item->discount_price * $item->quantity;
														$subtotal1 = $item->grand_total;
														?>
															<tr>
																<td>
																	<div class="d-flex justify-content-start flex-column">
																		<a href="#" class="text-dark fw-bolder text-hover-primary fs-6">{{ $item->product_name }}</a>
																		<span class="text-muted fw-bold text-muted d-block fs-7">SKU : {{ $item->sku }}</span>
																		<span class="text-muted fw-bold text-muted d-block fs-7">Variant : {{ $item->variant_name }}</span>
																		<span class="text-muted fw-bold text-muted d-block fs-7">Noted : {{ $item->noted }}</span>
																	</div>
																</td>
																<td class="text-end">{{ number_format($item->product_price,0,".",",") }}</td>
																<td class="text-end">{{ $item->quantity }}</td>
																<td class="text-danger text-end">
																	{{ number_format($item->product_price - $item->price,0,".",",") }}<br/>
																	@if(($item->product_price - $item->price) > 0 )
																		@if($item->product_discount_price == $item->price)
																			<small class="badge bg-danger">Discount Product</small>
																		@else
																			<small class="badge bg-danger">Discount Customer</small>
																		@endif
																	@endif
																</td>
																<td class="text-end">{{ $item->discount_price == 0 ? number_format(($item->price * $item->quantity),0,'.',',') : number_format(($item->discount_price * $item->quantity),0,'.',',') }}</td>
															</tr>
														@endforeach
														<tr>
															<td colspan="4" class="text-end">Subtotal</td>
															<td class="text-end">{{ number_format($subtotal1,0,".",",") }}</td>
														</tr>
														{{--<tr>
															<td colspan="4" class="text-end text-danger">Discount</td>
															<td class="text-end text-danger">{{ number_format($orders->old_total - $orders->total, 0, '.', ',') }}</td>
														</tr>--}}
														<tr>
															<?php $order_shipping == true ? $cost = $order_shipping->cost : $cost = 0 ?>
															<td colspan="4" class="text-end">Shipping Cost</td>
															<td class="text-end">{{ number_format($cost,0,".",",") }}</td>
														</tr>
														<tr>
															<td colspan="4" class="fs-3 text-dark fw-bolder text-end">Grand Total</td>
															<td class="text-dark fs-3 fw-boldest text-end">{{ number_format($orders->total-($orders->total*$orders->discount_order/100)-($orders->total*$orders->discount_customer/100)+$cost,0,".",",") }}</td>
															{{-- <td class="text-dark fs-3 fw-boldest text-end">{{ number_format($orders->total-($orders->total*$orders->discount_order/100)-($orders->total*$orders->discount_customer/100)+$cost,0,".",",") }}</td> --}}
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 m-0">
								<div class="border border-dashed border-gray-300 card-rounded h-lg-100 min-w-md-250px p-9 bg-lighten">
									<h6 class="mb-6 fw-boldest text-gray-600 text-hover-primary">SHIPMENT</h6>
									<div class="mb-3">
										<div class="fw-bold text-gray-600 fs-7">Resi:</div>
										<div class="fw-bolder text-gray-800 fs-6">{{ $order_shipping == true ? $order_shipping->resi : '-' }}</div>
									</div>
									<div class="mb-3">
										<div class="fw-bold text-gray-600 fs-7">Courier:</div>
										<div class="fw-bolder text-gray-800 fs-6">{{ $order_shipping == true ? $order_shipping->courier : '-' }}</div>
									</div>
									<div class="mb-3">
										<div class="fw-bold text-gray-600 fs-7">Service:</div>
										<div class="fw-bolder text-gray-800 fs-6">{{ $order_shipping == true ? $order_shipping->service : '-' }}</div>
									</div>
									<div class="mb-3">
										<div class="fw-bold text-gray-600 fs-7">Weight:</div>
										<div class="fw-bolder text-gray-800 fs-6">{{ $order_shipping == true ? $order_shipping->weight.' gr' : '-' }}</div>
									</div>
									<div class="mb-3">
										<div class="fw-bold text-gray-600 fs-7">Dimensions:</div>
										<div class="fw-bolder text-gray-800 fs-6">
											<?php
											if($order_shipping == true){
												$dimensions = (array) json_decode($order_shipping->dimensions);
												if(!empty($dimensions)){
													echo $dimensions["length"].' x '.$dimensions["width"].' x '.$dimensions["height"];
												}
											}else{
												echo "-";
											}
											?>
										</div>
									</div>
									<div class="mb-3">
										<div class="fw-bold text-gray-600 fs-7">Cost:</div>
										<div class="fw-bolder text-gray-800 fs-6">{{ $order_shipping == true ? number_format($order_shipping->cost,0,".",",") : '-' }}</div>
									</div>
									<hr/>
									<h6 class="mb-6 fw-boldest text-gray-600 text-hover-primary">PAYMENT</h6>
									<div class="mb-3">
										<div class="fw-bold text-gray-600 fs-7">Payment Method:</div>
										<div class="fw-bolder text-gray-800 fs-6 text-capitalize">
											<?php
											if($order_billing == true){
												$label = "";
												if ($order_billing->payment_method != null) {

													$billing = (array) json_decode($order_billing->data);
													if ($order_billing->payment_method == 'manual_bank_transfer') {
														$label .= 'Manual Bank Transfer<br>';
													} else {
														if (array_key_exists('payment_type', $billing)) {
															$label .= '' . ucwords(str_replace('_', ' ', $billing['payment_type'])) . ' (Virtual Acccount)<br>';

														} else {
															$label .= 'Other';
														}
													}
												} else {
													$label .= "-";
												}

												echo $label;
											}else{
												echo "-";
											}
											?>
										</div>
									</div>
									<div class="mb-3">
										<div class="fw-bold text-gray-600 fs-7">Account:</div>
										<div class="fw-bolder text-gray-800 fs-6">
											<?php
											if($order_billing == true){
												$label = "";
												if ($order_billing->payment_method != null) {

													$billing = (array) json_decode($order_billing->data);
													if ($order_billing->payment_method == 'manual_bank_transfer') {
														$label .= strtoupper($billing['bank_name'] . ' - ' . $billing['account_number'] . ' an ' . $billing['account_owner']);
													} else {
														if (array_key_exists('payment_type', $billing)) {
															if ($billing['payment_type'] == 'bank_transfer') {
																foreach ($billing['va_numbers'] as $row) {
																	$label .= strtoupper($row->bank . ' - ' . $row->va_number);
																}
															} elseif ($billing['payment_type'] == 'cstore') {
																$label .= strtoupper($billing['store'] . ' - ' . $billing['payment_code']);
															}
														} else {
															$label .= '-';
														}
													}
												} else {
													$label .= "-";
												}

												echo $label;
											}else{
												echo "-";
											}
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row d-none" id="printresiarea">
							<div class="col-lg-12 bg-light mb-10 mb-xl-0 pt-5">
								<div class="mt-n1">
									<div class="d-flex flex-stack justify-content-center">
										@php $navbar = Layout::getLayout() @endphp
										<img alt="Logo" src="{{ img_src($navbar['settings']['logo'], "logo") }}" style="max-width: 7% !important"/>
									</div>
									<div class="d-flex flex-stack pb-10">
										<div class="fw-bolder fs-3 text-gray-800">Invoice #{{ $orders->invoice_number }}</div>
										<div class="fw-bolder fs-3 text-gray-800">{{ $order_shipping == true ? $order_shipping->resi : '-' }}</div>
									</div>
									<div class="m-0">
										<div class="row g-5 mb-11">
											<div class="col-sm-6 mb-5">
												<div class="fw-bolder fs-5">Receiver</div>
                                                @php
                                                    $reveived_name = @$shipping[0]->reveived_name;
                                                    $shipping = $order_shipping == true ? json_decode($order_shipping->address) : null;
                                                    $store_name = @$shipping[0]->store_name;
                                                @endphp
												<div class="fw-bold fs-7 text-gray-600 mb-1">Name: {{ $reveived_name }}</div>
												<div class="fw-bold fs-7 text-gray-600 mb-1">Phone Number: {{ $orders->phone != null ? $orders->phone : '=' }}</div>
												<div class="fw-bold fs-7 text-gray-600 mb-1">Address:</div>
												<div class="fw-bold fs-7 text-gray-600 mb-1">{{ @$shipping[0]->address }}</div>
												<div class="fw-bold fs-7 text-gray-600 mb-1">{{ @$shipping[0]->province }} - {{ @$shipping[0]->city }} - {{ @$shipping[0]->distric }} - {{ @$shipping[0]->postalcode }}</div>
											</div>
											<div class="col-sm-6 mb-5">
												<div class="fw-bolder fs-5">Sender</div>
												<div class="fw-bold fs-7 text-gray-600 mb-1">Store: {{ $store_name }}</div>
												<div class="fw-bold fs-7 text-gray-600 mb-1">Phone Number: {{ @$store_data->phone == null ? '-' : @$store_data->phone }}</div>
												<div class="fw-bold fs-7 text-gray-600 mb-1">Address:</div>
												<div class="fw-bold fs-7 text-gray-600 mb-1">{{ @$store_data->detail_address.' - '.@$store_data->province_name.' - '.@$store_data->city_name }}</div>
											</div>
											<div class="col-sm-6">
												<div class="fw-bold fs-7 text-gray-600 mb-1">Transaction Date: {{ date('d M Y - h:i:s', strtotime($orders->transaction_date)) }}</div>
												<div class="fw-bold text-gray-600 fs-7 mb-1">Payment Method:
													<?php
														if($order_billing == true){
															$label = "";
															if ($order_billing->payment_method != null) {

																$billing = (array) json_decode($order_billing->data);
																if ($order_billing->payment_method == 'manual_bank_transfer') {
																	$label .= 'Manual Bank Transfer<br>';
																} else {
																	if (array_key_exists('payment_type', $billing)) {
																		$label .= '' . ucwords(str_replace('_', ' ', $billing['payment_type'])) . ' (Virtual Acccount)<br>';

																	} else {
																		$label .= 'Other';
																	}
																}
															} else {
																$label .= "-";
															}

															echo $label;
														}else{
															echo "-";
														}
													?>
												</div>
												<div class="fw-bold fs-7 text-gray-600 mb-1">Note: {{ $orders->note == null ? '-' : $orders->note }}</div>
											</div>
											<div class="col-sm-6">
												<div class="fw-bold text-gray-600 fs-7 mb-1">Weight: {{ $order_shipping == true ? $order_shipping->weight.' gr' : '-' }}</div>
												<div class="fw-bold text-gray-600 fs-7 mb-1">Dimensions:
													<?php
														if($order_shipping == true){
															$dimensions = (array) json_decode($order_shipping->dimensions);
															if(!empty($dimensions)){
																echo $dimensions["length"].' x '.$dimensions["width"].' x '.$dimensions["height"];
															}
														}else{
															echo "-";
														}
													?>
												</div>
												<div class="fw-bold fs-7 text-gray-600 mb-1">Courier: {{ @$order_shipping->courier == null ? '-' : @$order_shipping->courier }}</div>
												<div class="fw-bold fs-7 text-gray-600 mb-1">Service: {{ @$order_shipping->service == null ? '-' : @$order_shipping->service }}</div>
											</div>
										</div>
										<div class="flex-grow-1">
											<div class="table-responsive border-bottom mb-9">
												<table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
													<thead>
														<tr class="border-bottom fs-6 fw-bolder">
															<th class="min-w-150px pb-2">Products</th>
															<th class="min-w-150px pb-2">Variant</th>
															<th class="min-w-150px pb-2">Quantity</th>
														</tr>
													</thead>
													<tbody class="fw-bold text-gray-600">
														<?php
														$subtotal = 0;
														?>
														@foreach($order_items as $item)
														<?php

														$subtotal += (($item->price-$item->price*$item->discount_product/100)*$item->quantity);
														?>
															<tr>
																<td>
																	<div class="d-flex justify-content-start flex-column">
																		<a href="#" class="text-dark fw-bold text-hover-primary fs-7">{{ $item->product_name }}</a>
																		<span class="text-muted fw-bold text-muted d-block fs-8">{{ $item->noted != null ? "Noted : $item->noted" : ""}}</span>
																	</div>
																</td>
																<td>
																	<div class="d-flex justify-content-start flex-column">
																		<a href="#" class="text-dark fw-bold text-hover-primary fs-7">{{ $item->variant_name }}</span>
																	</div>
																</td>
																<td>
																	<div class="d-flex justify-content-start flex-column">
																		<a href="#" class="text-dark fw-bold text-hover-primary fs-7">{{ $item->quantity }}</span>
																	</div>
																</td>
															</tr>
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6"></div>
						</div><br>
						<div class="d-flex justify-content-end">
							<a href="{{ route('admin.orders') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {});

        function printInvoice(divID, title) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
			document.title = title;
            document.body.innerHTML =
                "<html><head><title></title><style>.col-lg-8{-webkit-box-flex: 0;-ms-flex: 0 0 auto;flex: 0 0 auto; width: 69%} .col-lg-4{-webkit-box-flex: 0;-ms-flex: 0 0 auto;flex: 0 0 auto; width:29%; background-color: rgba(245,248,250,.5)!important;}</style></head><body><div class='row'>" +
                divElements + "</div></body></html>";
            //console.log(divElements);

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;
        }
		
        function printResi(divID , title) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
			document.title = title;
            document.body.innerHTML =
                "<html><head><title></title><style>.col-lg-8{-webkit-box-flex: 0;-ms-flex: 0 0 auto;flex: 0 0 auto; width: 69%} .col-lg-4{-webkit-box-flex: 0;-ms-flex: 0 0 auto;flex: 0 0 auto; width:29%; background-color: rgba(245,248,250,.5)!important;}</style></head><body><div class='row'>" +
                divElements + "</div></body></html>";
            //console.log(divElements);

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;
        }
    </script>
@endpush
