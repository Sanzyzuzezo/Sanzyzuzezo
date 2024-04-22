@extends('administrator.layouts.main')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Accurate</h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">Token</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="post d-flex flex-column-fluid">
            <div id="kt_content_container" class="container-xxl">
                <form  id="form" class="form d-flex flex-column flex-lg-row"
                    action="{{ route('admin.accurate.token.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Token</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                {{-- <div class="mb-10 fv-row">
                                    <label class="required form-label">Plain Text</label>
                                    <input type="text" name="plain_text" class="form-control mb-2" autocomplete="off"
                                        placeholder="Time now" value="{{ date('d/m/Y H:i:s', strtotime(now())) }}" />
                                    <div class="text-muted fs-7"></div>
                                </div> --}}
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Screet Key</label>
                                    <input type="text" name="secret_key" class="form-control mb-2"
                                        placeholder="Secret Key" autocomplete="off"
                                        value="{{ array_key_exists('secret_key', $settings) ? $settings['secret_key'] : '' }}" />
                                    <div class="text-muted fs-7"></div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">CryptoGrapich Hash</label>
                                    <select class="form-select btn-sm form-select-solid" name="cryptograpich_hash"
                                        data-control="select2" data-hide-search="true" id="cryptograpich_hash">
                                        <option value="sha256"
                                            {{ (array_key_exists('cryptograpich_hash', $settings) ? $settings['cryptograpich_hash'] : '') === 'sha256' ? 'selected' : '' }}>
                                            SHA-256</option>
                                        <option value="sha512"
                                            {{ (array_key_exists('cryptograpich_hash', $settings) ? $settings['cryptograpich_hash'] : '') === 'sha512' ? 'selected' : '' }}>
                                            SHA-512</option>
                                    </select>
                                    <div class="text-muted fs-7"></div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Output Text Format</label>
                                    <select class="form-select btn-sm form-select-solid" name="output_hash"
                                        data-control="select2" data-hide-search="true" id="output_text_format">
                                        <option value="hex"
                                            {{ (array_key_exists('output_hash', $settings) ? $settings['output_hash'] : '') === 'hex' ? 'selected' : '' }}>
                                            Hex</option>
                                        <option value="base64"
                                            {{ (array_key_exists('output_hash', $settings) ? $settings['output_hash'] : '') === 'base64' ? 'selected' : '' }}>
                                            Base64</option>
                                    </select>
                                    <div class="text-muted fs-7"></div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="form-label">Hashed Output</label>
                                    <input type="text" class="form-control mb-2" placeholder="Site Name"
                                        value="{{ array_key_exists('plain_text', $settings) ? $settings['plain_text'] : '' }}"
                                        readonly />
                                    <input type="text" class="form-control mb-2" placeholder="Site Name"
                                        value="{{ array_key_exists('hashed_output', $settings) ? $settings['hashed_output'] : '' }}"
                                        readonly />
                                    <div class="text-muted fs-7"></div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" id="triggerSubmit" class="btn btn-primary">
                                <span class="indicator-label">Save Changes</span>
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
    <script src="{{ asset_administrator('assets/js/custom/documentation/documentation.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/search.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/forms/select2.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>

    <script type="text/javascript">
        // Define form element
        const form = document.getElementById("form");

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(form, {
            fields: {
                // plain_text: {
                //     validators: {
                //         notEmpty: {
                //             message: "Plain text is required",
                //         },
                //     },
                // },
                secret_key: {
                    validators: {
                        notEmpty: {
                            message: "Secret key is required",
                        },
                    },
                },
                cryptograpich_hash: {
                    validators: {
                        notEmpty: {
                            message: "Cryptograpich hash is required",
                        },
                    },
                },
                output_hash: {
                    validators: {
                        notEmpty: {
                            message: "Output text format is required",
                        },
                    },
                },
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".fv-row",
                    eleInvalidClass: "",
                    eleValidClass: "",
                }),
            },
        });

        // Submit button handler
        const submitButton = document.getElementById("triggerSubmit");
        submitButton.addEventListener("click", function(e) {
            // Prevent default button action
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function(status) {
                    if (status == "Valid") {
                        let stat = true;

                        if (stat == true) {
                            // Show loading indication
                            submitButton.setAttribute("data-kt-indicator", "on");

                            // Disable button to avoid multiple click
                            submitButton.disabled = true;

                            // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                            setTimeout(function() {
                                // Remove loading indication
                                submitButton.removeAttribute("data-kt-indicator");

                                // Enable button
                                submitButton.disabled = false;

                                form.submit(); // Submit form
                            }, 2000);
                        } else {
                            return false;
                        }
                    }
                });
            }
        });
    </script>
@endpush
