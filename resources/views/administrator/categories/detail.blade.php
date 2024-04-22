@extends('administrator.layouts.main')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Categories</h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.categories') }}" class="text-muted text-hover-primary">Categories</a>
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
            <div class="card mb-xl-10">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-250px">Category Name</th>
                                    <th class="min-w-250px">Child</th>
                                    <th class="min-w-100px">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <div class="text-dark fw-bolder text-hover-primary d-block">{{ $category->name }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <ul>
                                                @foreach($category->childCategories as $child_category)
                                                    <li>
                                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                            <a href="{{ route('admin.categories.detail',$child_category->id) }}"><div class="text-dark fw-bolder text-hover-primary d-block">{{ $child_category->name }}</div></a>
                                                        </div>
                                                    </li>
                                                    <ul>
                                                        @foreach($child_category->categories as $child)
                                                            <li>
                                                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                                    <a href="{{ route('admin.categories.detail',$child->id) }}"><div class="text-dark fw-bolder text-hover-primary d-block">{{ $child->name }}</div></a>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            @if($category->status == 1)
                                                <div class="badge badge-light-success">Active</div>
                                            @else
                                                <div class="badge badge-light-danger">Inactive</div>
                                            @endif
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
@endsection

@push('scripts')

@endpush
