@extends('administrator.layouts.main')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Toolbar-->
        <div class="toolbar" id="kt_toolbar">
            <!--begin::Container-->
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <!--begin::Title-->
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Supplier</h1>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <!--end::Separator-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.supplier') }}" class="text-muted text-hover-primary">Supplier
                            </a>
                        </li>
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-dark">Edit</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <form id="form_add" class="form d-flex flex-column flex-lg-row" action="{{ route('admin.supplier.update', $supplier->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>General</h2>
                                </div>
                            </div>
                            <input type="hidden" value="{{ $supplier->id }}" name="id">
                            <div class="card-body pt-0">
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Name Supplier</label>
                                    <input type="text" value="{{ $supplier->name }}" name="name" class="form-control mb-2" placeholder="Name Supplier" value="" />
                                    <div class="text-muted fs-7"></div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Regency / City</label>
                                    <select name="city_id" class="form-select" data-control="select2" data-placeholder="Select Regency / City">
                                        <option value="">Select Regency / City</option>"
                                        @foreach ($cities as $city)
                                            @if (isset($supplier->city_id) && $supplier->city_id == $city->city_id)
                                                <option selected value="{{ $city->city_id }}">{{ $city->title }}</option>
                                            @else
                                                <option value="{{ $city->city_id }}">{{ $city->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="text-muted fs-7"></div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Detail Address Supplier</label>
                                    <textarea name="detail_address" id="detail_address" class="form-control mb-2">{{ $supplier->detail_address }}</textarea>
                                    <div class="text-muted fs-7"></div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="form-label">No Telephone / HP</label>
                                    <input type="text" value="{{ $supplier->phone }}" name="phone" class="form-control mb-2" placeholder="No Telephone / HP" value="" />
                                    <div class="text-muted fs-7"></div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="form-label">Contact Pic</label>
                                    <input type="text" value="{{ $supplier->contact_pic }}" name="contact_pic" class="form-control mb-2" placeholder="Contact Pic" />
                                    <div class="text-muted fs-7"></div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="form-label">No Telephone / HP Pic</label>
                                    <input type="text" value="{{ $supplier->pic_phone }}" name="pic_phone" class="form-control mb-2" placeholder="No Telephone / HP Pic" />
                                    <div class="text-muted fs-7"></div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="form-label">Email</label>
                                    <input type="email" value="{{ $supplier->email }}" name="email" class="form-control mb-2" placeholder="Email" value="" />
                                    <div class="text-muted fs-7"></div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="form-label">Note</label>
                                    <textarea name="note" id="note" class="form-control mb-2">{{ $supplier->note }}</textarea>
                                    <div class="text-muted fs-7"></div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="form-label">Status</label>
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" id="status" name="status" {{ $supplier->status == 1 ? 'checked="checked"' : '' }} />
                                        <label class="form-check-label fw-bold text-gray-400 ms-3" for="status">Active</label>
                                    </div>
                                    <div class="text-muted fs-7"></div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.supplier') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
                            <button type="submit" id="add_post_category_submit" class="btn btn-primary">
                                <span class="indicator-label">Save</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="items-data" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog mw-650px">
            <div class="modal-content">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset_administrator('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
<script src="{{ asset_administrator('assets/js/custom/apps/ecommerce/supplier/supplier.js') }}"></script>
<script src="{{ asset_administrator('assets/js/custom/documentation/documentation.js') }}"></script>
<script src="{{ asset_administrator('assets/js/custom/documentation/search.js') }}"></script>
{{-- <script src="{{ asset_administrator('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script> --}}
    <script type="text/javascript">
        $(document).ready(function() {
            class MyUploadAdapter {
                constructor(loader) {
                    // CKEditor 5's FileLoader instance.
                    this.loader = loader;

                    // URL where to send files.
                    this.url = 'https://example.com/image/upload/path';
                }

                // Starts the upload process.
                upload() {
                    return new Promise((resolve, reject) => {
                        this._initRequest();
                        this._initListeners(resolve, reject);
                        this._sendRequest();
                    });
                }

                // Aborts the upload process.
                abort() {
                    if (this.xhr) {
                        this.xhr.abort();
                    }
                }

                // Example implementation using XMLHttpRequest.
                _initRequest() {
                    const xhr = this.xhr = new XMLHttpRequest();

                    xhr.open('POST', this.url, true);
                    xhr.responseType = 'json';
                }

                // Initializes XMLHttpRequest listeners.
                _initListeners(resolve, reject) {
                    const xhr = this.xhr;
                    const loader = this.loader;
                    const genericErrorText = 'Couldn\'t upload file:' + ` ${ loader.file.name }.`;

                    xhr.addEventListener('error', () => reject(genericErrorText));
                    xhr.addEventListener('abort', () => reject());
                    xhr.addEventListener('load', () => {
                        const response = xhr.response;

                        if (!response || response.error) {
                            return reject(response && response.error ? response.error.message :
                                genericErrorText);
                        }

                        // If the upload is successful, resolve the upload promise with an object containing
                        // at least the "default" URL, pointing to the image on the server.
                        resolve({
                            default: response.url
                        });
                    });

                    if (xhr.upload) {
                        xhr.upload.addEventListener('progress', evt => {
                            if (evt.lengthComputable) {
                                loader.uploadTotal = evt.total;
                                loader.uploaded = evt.loaded;
                            }
                        });
                    }
                }

                // Prepares the data and sends the request.
                _sendRequest() {
                    const data = new FormData();

                    data.append('upload', this.loader.file);

                    this.xhr.send(data);
                }
            }

            function MyCustomUploadAdapterPlugin(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                    return new MyUploadAdapter(loader);
                };
            }

        });
    </script>
@endpush