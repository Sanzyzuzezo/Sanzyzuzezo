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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Article</h1>
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
                            <a href="{{ route('admin.article') }}" class="text-muted text-hover-primary">Article
                            </a>
                        </li>
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-dark">Add</li>
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
                <form id="form_add" class="form d-flex flex-column flex-lg-row" action="{{ route('admin.article.add') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Main column-->
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <!--begin::General options-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>General</h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">

                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="required form-label">Category</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="category" class="form-select" data-control="select2">
                                        <option value="">Please Select</option>
                                        @foreach ($categories as $row)
                                            {
                                            <option value="{{ $row->id }}"> {{ $row->name }} </option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#default_language">Default
                                            Language</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#another_language">Another
                                            Language</a>



                                    </li>
                                    <li>

                                    </li> --}}
                                </ul>
                                <!--begin::Tab Content-->
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="default_language" role="tabpanel">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Title</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="title" class="form-control mb-2" placeholder="Title"
                                                value="" />
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">
                                            </div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Description</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea name="description" id="description" class="description"></textarea>
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">
                                            </div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    {{-- <div class="tab-pane fade" id="another_language" role="tabpanel">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <div class="d-flex">
                                                <div class="form-check form-check-custom form-check-solid form-check-sm">
                                                    <input class="form-check-input" type="checkbox" name="same_as_default"
                                                        value="1" id="sameasdefault" />
                                                    <label class="form-check-label" for="sameasdefault">
                                                        Same as default
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Title (An)</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="title_an" class="form-control mb-2" placeholder="Title"
                                                value="" />
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">
                                            </div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Description (An)</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea name="description_an" id="description_an"
                                                class="description"></textarea>
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">
                                            </div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->
                                    </div> --}}

                                </div>

                                {{-- <div data-kt-buttons="true">

                                </div> --}}

                                <div class="mb-10 fv-row">
                                    <div class="d-flex">

                                        <label class="btn btn-outline d-flex flex-stack text-start p-6 mb-5">
                                            <div class="d-flex align-items-center me-2">
                                                <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                    <input id="upload" class="form-check-input" type="radio" name="plan" checked="checked" value="upload"/>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h2 class="d-flex align-items-center fs-3 fw-bolder flex-wrap"> Upload Media </h2>
                                                </div>
                                            </div>
                                        </label>

                                        <label class="btn btn-outline d-flex flex-stack text-start p-6 mb-5 active">
                                            <div class="d-flex align-items-center me-2">
                                                <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                    <input id="embed" class="form-check-input" type="radio" name="plan" value="embed"/>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h2 class="d-flex align-items-center fs-3 fw-bolder flex-wrap"> Embed Youtube </h2>
                                                </div>
                                            </div>
                                        </label>

                                    </div>
                                    <label class="form-label">Media</label>
                                    <div class="overflow-auto py-2 bestresolution">
                                        <div class="notice d-flex bg-light-dark rounded border-dark border border-dashed min-w-lg-600px flex-shrink-0 p-6">
                                            <span class="svg-icon svg-icon-2tx svg-icon-dark me-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 28 28" fill="none">
                                                    <path opacity="0.3" d="M5.78001 21.115L3.28001 21.949C3.10897 22.0059 2.92548 22.0141 2.75004 21.9727C2.57461 21.9312 2.41416 21.8418 2.28669 21.7144C2.15923 21.5869 2.06975 21.4264 2.0283 21.251C1.98685 21.0755 1.99507 20.892 2.05201 20.7209L2.886 18.2209L7.22801 13.879L10.128 16.774L5.78001 21.115Z" fill="black"/>
                                                    <path d="M21.7 8.08899L15.911 2.30005C15.8161 2.2049 15.7033 2.12939 15.5792 2.07788C15.455 2.02637 15.3219 1.99988 15.1875 1.99988C15.0531 1.99988 14.92 2.02637 14.7958 2.07788C14.6717 2.12939 14.5589 2.2049 14.464 2.30005L13.74 3.02295C13.548 3.21498 13.4402 3.4754 13.4402 3.74695C13.4402 4.01849 13.548 4.27892 13.74 4.47095L14.464 5.19397L11.303 8.35498C10.1615 7.80702 8.87825 7.62639 7.62985 7.83789C6.38145 8.04939 5.2293 8.64265 4.332 9.53601C4.14026 9.72817 4.03256 9.98855 4.03256 10.26C4.03256 10.5315 4.14026 10.7918 4.332 10.984L13.016 19.667C13.208 19.859 13.4684 19.9668 13.74 19.9668C14.0115 19.9668 14.272 19.859 14.464 19.667C15.3575 18.77 15.9509 17.618 16.1624 16.3698C16.374 15.1215 16.1932 13.8383 15.645 12.697L18.806 9.53601L19.529 10.26C19.721 10.452 19.9814 10.5598 20.253 10.5598C20.5245 10.5598 20.785 10.452 20.977 10.26L21.7 9.53601C21.7952 9.44108 21.8706 9.32825 21.9221 9.2041C21.9737 9.07995 22.0002 8.94691 22.0002 8.8125C22.0002 8.67809 21.9737 8.54505 21.9221 8.4209C21.8706 8.29675 21.7952 8.18392 21.7 8.08899Z" fill="black"/>
                                                </svg>
                                            </span>
                                            <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                                <div class="mb-3 mb-md-0 fw-bold">
                                                    <h4 class="text-gray-900 fw-bolder">Best Resolution Image Display:</h4>
                                                    <div class="fs-6 text-gray-700 pe-7">
                                                        <ul class="m-0">
                                                            <li>Landscape image</li>
                                                            <li>752 X 440 px</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail mb20" data-trigger="fileinput"
                                            style="width: 100%; height: 150px;"></div>
                                        <div>
                                            <a href="#" class="btn btn-light fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            <span class="btn btn-light btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="image">
                                            </span>
                                        </div>
                                    </div>
                                    <input style="display: none;" type="text" name="media_link" class="fileembeded form-control mb-2" placeholder="Link Youtube" value="" />
                                    <div class="text-muted fs-7"> </div>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label">Meta Title</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="meta_title" class="form-control mb-2" placeholder="Meta Title"
                                        value="" />
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label">Meta Description</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <textarea name="meta_description" id="meta_description"
                                        class="form-control mb-2 description"></textarea>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label">Status</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" id="status" name="status"
                                            checked="checked" />
                                        <label class="form-check-label fw-bold text-gray-400 ms-3"
                                            for="status">Active</label>
                                    </div>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->

                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="{{ route('admin.article') }}" id="kt_ecommerce_add_product_cancel"
                                class="btn btn-light me-5">Cancel</a>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="add_post_category_submit" class="btn btn-primary">
                                <span class="indicator-label">Save</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Button-->
                        </div>
                    </div>
                    <!--end::Main column-->
                </form>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
@endsection

@push('scripts')
    <script src="{{ asset_administrator('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/post_categories.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/documentation.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/search.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/forms/select2.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
    <script src="{{ url('administrator\ckeditor\ckeditor.js') }}"></script>
    {{-- <script src="{{ asset_administrator('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script> C:\laragon\www\e-commerce-kijang-mas\public\administrator\ckeditor\ckeditor.js--}}
    <script type="text/javascript">
        const url = `{!! url('/') !!}`;
        $(document).ready(function() {

            $('#embed').click(function (e) {
                // console.log('embed');
                $('.fileinput').hide();
                $('.fileembeded').show();
                $('.bestresolution').hide();
            });

            $('#upload').click(function (e) {
                // console.log('upload');
                $('.fileembeded').hide();
                $('.fileinput').show();
                $('.bestresolution').show();
            });
            CKEDITOR.replace('description',{
                filebrowserBrowseUrl : url+'/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                filebrowserUploadUrl : url+'/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                filebrowserImageBrowseUrl : url+'/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
            });
            CKEDITOR.replace('description_an',{
                filebrowserBrowseUrl : url+'/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                filebrowserUploadUrl : url+'/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                filebrowserImageBrowseUrl : url+'/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
            });
            // class MyUploadAdapter {
            //     constructor(loader) {
            //         // CKEditor 5's FileLoader instance.
            //         this.loader = loader;

            //         // URL where to send files.
            //         // this.url = 'https://example.com/image/upload/path';
            //         this.url = `{!! url('articles') !!}`;
            //     }

            //     // Starts the upload process.
            //     upload() {
            //         return new Promise((resolve, reject) => {
            //             this._initRequest();
            //             this._initListeners(resolve, reject);
            //             this._sendRequest();
            //         });
            //     }

            //     // Aborts the upload process.
            //     abort() {
            //         if (this.xhr) {
            //             this.xhr.abort();
            //         }
            //     }

            //     // Example implementation using XMLHttpRequest.
            //     _initRequest() {
            //         const xhr = this.xhr = new XMLHttpRequest();

            //         xhr.open('POST', this.url, true);
            //         xhr.responseType = 'json';
            //     }

            //     // Initializes XMLHttpRequest listeners.
            //     _initListeners(resolve, reject) {
            //         const xhr = this.xhr;
            //         const loader = this.loader;
            //         const genericErrorText = 'Couldn\'t upload file:' + ` ${ loader.file.name }.`;

            //         xhr.addEventListener('error', () => reject(genericErrorText));
            //         xhr.addEventListener('abort', () => reject());
            //         xhr.addEventListener('load', () => {
            //             const response = xhr.response;

            //             if (!response || response.error) {
            //                 return reject(response && response.error ? response.error.message :
            //                     genericErrorText);
            //             }

            //             // If the upload is successful, resolve the upload promise with an object containing
            //             // at least the "default" URL, pointing to the image on the server.
            //             resolve({
            //                 default: response.url
            //             });
            //         });

            //         if (xhr.upload) {
            //             xhr.upload.addEventListener('progress', evt => {
            //                 if (evt.lengthComputable) {
            //                     loader.uploadTotal = evt.total;
            //                     loader.uploaded = evt.loaded;
            //                 }
            //             });
            //         }
            //     }

            //     // Prepares the data and sends the request.
            //     _sendRequest() {
            //         const data = new FormData();

            //         data.append('upload', this.loader.file);

            //         this.xhr.send(data);
            //     }
            // }

            // function MyCustomUploadAdapterPlugin(editor) {
            //     editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            //         return new MyUploadAdapter(loader);
            //     };
            // }

            // ClassicEditor
            //     .create(document.querySelector('#description'), {
            //         extraPlugins: [MyCustomUploadAdapterPlugin]
            //     })
            //     .then(editor => {
            //         console.log(editor);
            //     })
            //     .catch(error => {
            //         console.error(error);
            //     });

            // ClassicEditor
                // .create(document.querySelector('#description_an'), {
                //     extraPlugins: [MyCustomUploadAdapterPlugin]
                // })
                // .then(editor => {
                //     console.log(editor);
                // })
                // .catch(error => {
                //     console.error(error);
                // });

        });
    </script>
@endpush
