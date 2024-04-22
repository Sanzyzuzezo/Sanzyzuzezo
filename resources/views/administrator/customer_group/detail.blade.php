@extends('administrator.layouts.main')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Customers</h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.customer_group') }}" class="text-muted text-hover-primary">Customer Group</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">Detail</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container row col-12">
            <div class="col-lg-4">
                <div class="card mb-5 mb-xl-10">
                    <div class="card-header cursor-pointer">
                        <div class="card-title m-0">
                            <h3 class="fw-bolder m-0">Detail</h3>
                        </div>
                    </div>
                    <div class="card-body p-9">
                        <div class="row mb-7">
                            <label class="col-lg-4 fw-bold text-muted">Name</label>
                            <div class="col-lg-8">
                                <span class="fw-bolder fs-6 text-gray-800">{{ $customer_group->name }}</span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-4 fw-bold text-muted">Status</label>
                            @if($customer_group->status == 1)
                                <div class="col-lg-8">
                                    <span class="badge badge-success">Active</span>
                                </div>
                            @else
                                <div class="col-lg-8">
                                    <span class="badge badge-danger">Inactive</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mb-5 mb-xl-10">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">{{ $customer_group->name }}</span>
                        </h3>
                    </div>
                    <div class="card-body py-3">
                        <form method="post" enctype="multipart/form-data" action="{{ route('admin.customer_group.categories') }}">
                            {{ csrf_field() }}
                            <div class="table-responsive">
                                <table class="table align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bolder text-muted bg-light">
                                            <th class="ps-4 min-w-250px rounded-start">Category</th>
                                            <th class="min-w-100px rounded-end">Discount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categories as $category)
                                            <?php $key = array_search($category->id, array_column($customer_group_categories, 'category_id'));?>
                                            <tr>
                                                <td class="px-4">
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input widget-13-check" type="checkbox" value="1" name="category-{{ $category->id }}" {{ $key !== false ? 'checked' : '' }}/>
                                                        <div class="text-dark fw-bolder text-hover-primary d-block fs-6 ps-4">{{ $category->name }}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @foreach($brands as $brand)
                                                @if ($category->id == $brand->id)
                                                    <?php $key = array_search($category->id, array_column($customer_group_categories, 'category_id')); ?>
                                                    <tr>
                                                        <td class="px-6">
                                                            <div class="form-check form-check-sm form-check-custom form-check-solid mx-4">
                                                                <div class="text-dark text-hover-primary d-block fs-6 ps-4">
                                                                    {{ $brand->brand_name }}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                                @if($key !== false)
                                                                    @php
                                                                        $data = $customer_group_categories[$key]['discount'];
                                                                        $d = (array) json_decode($data, true);
                                                                        $status_brand = array_search($brand->brand_id, array_column($d, 'id'))
                                                                    @endphp
                                                                    <input class="form-check-input" type="checkbox" value="1" id="status" name="status-{{ $category->id }}-{{ $brand->brand_id }}" {{ $status_brand !== false  ? 'checked' : '' }}/>
                                                                    <div class="fv-row col-5 px-3">
                                                                        <input type="number" name="discount-{{ $category->id }}-{{ $brand->brand_id }}" class="form-control form-control-sm" placeholder="%" min="0" max="100" value="{{ $status_brand !== false ? $d[$status_brand]['discount'] : '' }}"/>
                                                                    </div>
                                                                @else
                                                                    <input class="form-check-input" type="checkbox" value="1" id="status" name="status-{{ $category->id }}-{{ $brand->brand_id }}"/>
                                                                    <div class="fv-row col-5 px-3">
                                                                        <input type="number" name="discount-{{ $category->id }}-{{ $brand->brand_id }}" class="form-control form-control-sm" placeholder="%" min="0" max="100" value=""/>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            @foreach($category->childCategories as $child_category)
                                                <?php $key = array_search($child_category->id, array_column($customer_group_categories, 'category_id')); ?>
                                                @foreach ($child_category->products as $product)
                                                    <tr>
                                                        <td class="px-5">
                                                            <div class="form-check form-check-sm form-check-custom form-check-solid px-5">
                                                                <input class="form-check-input widget-13-check" type="checkbox" value="1" name="category-{{ $child_category->id }}" {{ $key !== false ? 'checked' : '' }}/>
                                                                <div class="text-dark fw-bolder text-hover-primary d-block fs-6 ps-4">{{ $child_category->name }}</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    {{-- {{ count($child_category) }} --}}
                                                    @foreach($brands as $brand)
                                                        @if ($child_category->id == $brand->id)
                                                            <tr>
                                                                <td class="px-5">
                                                                    <div class="form-check form-check-sm form-check-custom form-check-solid mx-6 px-5">
                                                                        <div class="text-dark text-hover-primary d-block fs-6 ps-4">{{ $brand->brand_name }}</div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                                                        @if($key !== false)
                                                                            @php
                                                                                $data = $customer_group_categories[$key]['discount'];
                                                                                $d = (array) json_decode($data, true);
                                                                                $status_brand = array_search($brand->brand_id, array_column($d, 'id'))
                                                                            @endphp
                                                                            <input class="form-check-input" type="checkbox" value="1" id="status" name="status-{{ $child_category->id }}-{{ $brand->brand_id }}" {{ $status_brand !== false  ? 'checked' : '' }}/>
                                                                            <div class="fv-row col-5 px-3">
                                                                                <input type="number" name="discount-{{ $child_category->id }}-{{ $brand->brand_id }}" class="form-control form-control-sm" placeholder="%" min="0" max="100" value="{{ $status_brand !== false ? $d[$status_brand]['discount'] : '' }}"/>
                                                                            </div>
                                                                        @else
                                                                            <input class="form-check-input" type="checkbox" value="1" id="status" name="status-{{ $child_category->id }}-{{ $brand->brand_id }}"/>
                                                                            <div class="fv-row col-5 px-3">
                                                                                <input type="number" name="discount-{{ $child_category->id }}-{{ $brand->brand_id }}" class="form-control form-control-sm" placeholder="%" min="0" max="100" value=""/>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    @foreach($child_category->categories as $child)
                                                        <?php $key = array_search($child->id, array_column($customer_group_categories, 'category_id')); ?>
                                                        <tr>
                                                            <td class="px-5">
                                                                <div class="form-check form-check-sm form-check-custom form-check-solid px-5 mx-5">
                                                                    <input class="form-check-input widget-13-check" type="checkbox" value="1" name="category-{{ $child->id }}" {{ $key !== false ? 'checked' : '' }}/>
                                                                    <div class="text-dark fw-bolder text-hover-primary d-block fs-6 ps-4">{{ $child->name }}</div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @foreach($brands as $brand)
                                                            @if ($child->id == $brand->id)
                                                                <tr>
                                                                    <td class="px-6">
                                                                        <div class="form-check form-check-sm form-check-custom form-check-solid mx-3 px-6">
                                                                            <div class="text-dark text-hover-primary d-block fs-6 ps-10">{{ $brand->brand_name }}</div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                                                            @if($key !== false)
                                                                                @php
                                                                                    $data = $customer_group_categories[$key]['discount'];
                                                                                    $d = (array) json_decode($data, true);
                                                                                    $status_brand = array_search($brand->brand_id, array_column($d, 'id'))
                                                                                @endphp
                                                                                <input class="form-check-input" type="checkbox" value="1" id="status" name="status-{{ $child->id }}-{{ $brand->brand_id }}" {{ $status_brand !== false  ? 'checked' : '' }}/>
                                                                                <div class="fv-row col-5 px-3">
                                                                                    <input type="number" name="discount-{{ $child->id }}-{{ $brand->brand_id }}" class="form-control form-control-sm" placeholder="%" min="0" max="100" value="{{ $status_brand !== false ? $d[$status_brand]['discount'] : '' }}"/>
                                                                                </div>
                                                                            @else
                                                                                <input class="form-check-input" type="checkbox" value="1" id="status" name="status-{{ $child->id }}-{{ $brand->brand_id }}"/>
                                                                                <div class="fv-row col-5 px-3">
                                                                                    <input type="number" name="discount-{{ $child->id }}-{{ $brand->brand_id }}" class="form-control form-control-sm" placeholder="%" min="0" max="100" value=""/>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                @endforeach

                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end py-2">
                                <!--end::General options-->
                                <div class="d-flex justify-content-end">
                                    <!--begin::Button-->
                                    <a href="{{ route('admin.customer_group') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-secondary me-5">Cancel</a>
                                    <!--end::Button-->
                                </div>
                                <input type="hidden" name="customer_group_id" value="{{ $customer_group->id }}" />
                                <button type="submit" id="kt_ecommerce_edit_customer_group_submit" class="btn btn-primary">
                                    <span class="indicator-label">Save</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush
