// Define form element
const form = document.getElementById('form_add');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var validator = FormValidation.formValidation(
    form,
    {
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'Item name is required'
                    }
                }
            },
            'category': {
                validators: {
                    notEmpty: {
                        message: 'Please select category'
                    }
                }
            },
            'brand': {
                validators: {
                    notEmpty: {
                        message: 'Please select brand'
                    }
                }
            },
            'variants[0][sku]': {
                validators: {
                    notEmpty: {
                        message: 'SKU is required'
                    }
                }
            },
            'variants[0][name]': {
                validators: {
                    notEmpty: {
                        message: 'Name is required'
                    }
                }
            },
            'variants[0][weight]': {
                validators: {
                    notEmpty: {
                        message: 'Weight is required'
                    }
                }
            },
            'variants[0][price]': {
                validators: {
                    notEmpty: {
                        message: 'Price is required'
                    }
                }
            },
            'variants[0][minimal_stock]': {
                validators: {
                    notEmpty: {
                        message: 'Minimal Stock is required'
                    }
                }
            },
            // 'variants[0][stock]': {
            //     validators: {
            //         notEmpty: {
            //             message: 'Stock is required'
            //         }
            //     }
            // }
            
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
const submitButton = document.getElementById('kt_ecommerce_add_item_submit');
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

