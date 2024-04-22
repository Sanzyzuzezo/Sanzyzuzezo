@extends('administrator.layouts.main')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Pages</h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.pages') }}" class="text-muted text-hover-primary">Pages</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">Form</li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                </div>
            </div>
        </div>
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <form class="form d-flex flex-column flex-lg-row" id="form" method="post" enctype="multipart/form-data" action="{{ route('admin.pages.update', $pages->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>General</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#default_language">Default Language</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#another_language">Another Language</a>
                                    </li> --}}
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade active show" id="default_language" role="tabpanel">
                                        <div class="fv-row py-3">
                                            <label class="form-label required">Title</label>
                                            <input type="text" name="title" class="form-control mb-2" placeholder="Title" value="{{ $pages->title }}"/>
                                        </div>
                                        <div class="fv-row py-3">
                                            <label class="form-label required">Description</label>
                                            <textarea name="description" class="description" id="description">{{ $pages->description }}</textarea>
                                        </div>
                                    </div>
                                    {{-- <div class="tab-pane fade" id="another_language" role="tabpanel">
                                        <div class="form-check form-check-custom form-check-solid py-3">
                                            <input class="form-check-input" type="checkbox" value="1" id="status" name="same_as_default" @if($pages->same_as_default == 1) checked="checked" @endif />
                                            <label class="form-check-label fw-bold text-gray-400 ms-3" for="status">Same As Default</label>
                                        </div>
                                        <div class="fv-row py-3">
                                            <label class="form-label">Title (An)</label>
                                            <input type="text" name="title_an" class="form-control mb-2" placeholder="Title" value="{{ $pages->title_an }}"/>
                                        </div>
                                        <div class="fv-row py-3">
                                            <label class="form-label">Description (An)</label>
                                            <textarea name="description_an" class="description_an" id="description_an">{{ $pages->description_an }}</textarea>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="fv-row">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control mb-2" placeholder="Meta Title" value="{{ $pages->meta_title }}"/>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="fv-row">
                                    <label class="form-label">Meta Description</label>
                                    <textarea class="form-control" name="meta_description" placeholder="Meta Description">{{ $pages->meta_description }}</textarea>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="fv-row">
                                    <label class="form-label">Image</label>
                                    <input type="file" name="image" class="form-control mb-2" value="" />
                                </div>
                                <div class="overflow-auto py-2">
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
                                @if($pages->image != null)
                                    <div class="row col-md-6 py-2">
                                        <img src="{{asset_administrator("assets/media/pages/$pages->image")}}" />
                                    </div>
                                @endif
                            </div>
                            <div class="card-body pt-0">
                                <div class="fv-row">
                                    <label class="required form-label">Status</label>
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" id="status" name="status" @if($pages->status == 1) checked="checked" @endif />
                                        <label class="form-check-label fw-bold text-gray-400 ms-3" for="status">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.pages') }}" class="btn btn-light me-5">Cancel</a>
                            <button type="submit" id="page_submit" class="btn btn-primary">
                                <span class="indicator-label">Save</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset_administrator('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/pages.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/documentation.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/search.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/forms/select2.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
    <script>
        const url = `{!! url('/') !!}`;
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
        //         this.url = 'https://example.com/image/upload/path';
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
        //     .create(document.querySelector('#description_an'), {
        //         extraPlugins: [MyCustomUploadAdapterPlugin]
        //     })
        //     .then(editor => {
        //         console.log(editor);
        //     })
        //     .catch(error => {
        //         console.error(error);
        //     });
    </script>

@endpush
