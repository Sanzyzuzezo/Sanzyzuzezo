// Define form element
const form = document.getElementById('form_add');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var validator = FormValidation.formValidation(
    form,
    {
        fields: {
            site_name: {
                validators: {
                    notEmpty: {
                        message: 'Nama Situs Wajib Diisi !'
                    }
                }
            },
            default_language: {
                validators: {
                    notEmpty: {
                        message: ' Pilih Bahasa Default !'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'Email Wajib Diisi !'
                    }
                }
            },
            // address: {
            //     validators: {
            //         notEmpty: {
            //             message: 'Alamat Detail Wajib Diisi !'
            //         }
            //     }
            // },
            min_purchase: {
                validators: {
                    notEmpty: {
                        message: 'Minimal harga pembelian Wajib Diisi !'
                    }
                }
            },
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: '.fv-row',
                eleInvalidClass: '',
                eleValidClass: ''
            })
        }
    }
);

// Submit button handler
const submitButton = document.getElementById('kt_ecommerce_add_category_submit');
submitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (validator) {
        validator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                submitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                submitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                setTimeout(function () {
                    // Remove loading indication
                    submitButton.removeAttribute('data-kt-indicator');

                    // Enable button
                    submitButton.disabled = false;

                    form.submit(); // Submit form
                }, 2000);
            }
        });
    }
});

