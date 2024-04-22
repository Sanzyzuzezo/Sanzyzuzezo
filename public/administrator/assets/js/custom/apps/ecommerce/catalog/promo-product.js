// const form = document.getElementById('form');
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('form');

    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    var validator = FormValidation.formValidation(
        form,
        {
            fields: {
                'promo_type': {
                    validators: {
                        notEmpty: {
                            message: 'Please select promo type'
                        }
                    }
                },
                'title': {
                    validators: {
                        notEmpty: {
                            message: 'Title is required'
                        }
                    }
                },
                'start_at': {
                    validators: {
                        notEmpty: {
                            message: 'Start at is required'
                        }
                    }
                },
                'start_date': {
                    validators: {
                        notEmpty: {
                            message: 'Start date is required'
                        }
                    }
                },
                'end_date': {
                    validators: {
                        notEmpty: {
                            message: 'End Date is required'
                        }
                    }
                },
                'promo_products': {
                    validators: {
                        notEmpty: {
                            message: 'Please select product'
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
            const submitButton = document.getElementById('promo-product_submit');
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
    
});