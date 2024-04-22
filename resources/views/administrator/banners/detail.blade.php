@extends('administrator.layouts.main')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Banners</h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.banners') }}" class="text-muted text-hover-primary">Banners</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">Detail</li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                </div>
            </div>
        </div>
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="card mb-5 mb-xl-10">
                    <div class="card-header cursor-pointer">
                        <div class="card-title m-0">
                            <h3 class="fw-bolder m-0">Detail</h3>
                        </div>
                    </div>
                    <div class="card-body p-9">
                        <div class="row">
                            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#default_language">Default Language</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#another_language">Another Language</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="default_language" role="tabpanel">
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">Title</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $banners->title }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">Caption</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $banners->caption }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">Description</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $banners->description }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">Button</label>
                                        @if($banners->show_button == 1)
                                            <div class="col-lg-8">
                                                <span class="badge badge-success">Show</span>
                                            </div>
                                        @else
                                            <div class="col-lg-8">
                                                <span class="badge badge-danger">Hide</span>
                                            </div>
                                        @endif
                                    </div>
                                    @if($banners->show_button == 1)
                                    @php
                                        $buttontext = json_decode($banners->button_text);
                                        $button_text = $buttontext->button_text;
                                        $button_text_an = $buttontext->button_text_an;
                                    @endphp
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">Button Text</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $button_text }}</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="another_language" role="tabpanel">
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">Same As Default</label>
                                        @if($banners->same_as_default == 1)
                                            <div class="col-lg-8">
                                                <span class="badge badge-success">Yes</span>
                                            </div>
                                        @else
                                            <div class="col-lg-8">
                                                <span class="badge badge-danger">No</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">Title An</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $banners->title_an }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">Caption An</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $banners->caption_an }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">Description An</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $banners->description_an }}</span>
                                        </div>
                                    </div>
                                    @if($banners->show_button == 1)
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-bold text-muted">Button Text An</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bolder fs-6 text-gray-800">{{ $button_text_an }}</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if($banners->show_button == 1)
                        <div class="row mb-7">
                            <label class="col-lg-4 fw-bold text-muted">Button URL</label>
                            <div class="col-lg-8">
                                <span class="fw-bolder fs-6 text-gray-800">{{ $banners->button_url }}</span>
                            </div>
                        </div>
                        @endif
                        @if($banners->image != null)
                            <div class="row mb-7">
                                <label class="col-lg-4 fw-bold text-muted">Image</label>
                                <div class="col-lg-8">
                                    <img class="col-lg-12" src="{{asset_administrator("assets/media/banners/$banners->image")}}" />
                                </div>
                            </div>
                        @endif
                        <div class="row mb-7">
                            <label class="col-lg-4 fw-bold text-muted">Status</label>
                            @if($banners->status == 1)
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
        </div>
    </div>
@endsection

@push('scripts')

@endpush
