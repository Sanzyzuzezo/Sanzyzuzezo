// Define form element
const form = document.getElementById('form_add');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var validator = FormValidation.formValidation(
    form,
    {
        fields: {
            'user_group': {
                validators: {
                    notEmpty: {
                        message: 'Please select user group'
                    }
                }
            },
            'name': {
                validators: {
                    notEmpty: {
                        message: 'Name is required'
                    }
                }
            },
            'email': {
                validators: {
                    notEmpty: {
                        message: 'E-mail is required'
                    }
                }
            },
            'password': {
                validators: {
                    notEmpty: {
                        message: 'Password is required'
                    },
                    stringLength: {
                        min: 8,
                        message: 'Password must be at least 8 characters long',
                    },
                }
            },
            'password_confirmation': {
                validators: {
                    notEmpty: {
                        message: 'Password confirmation is required'
                    },
                    identical: {
                        compare: function () {
                            return form.querySelector('[name="password"]').value;
                        },
                        message: 'The password and its confirm are not the same',
                    },
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
const submitButton = document.getElementById('kt_ecommerce_add_user_admins_submit');
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

