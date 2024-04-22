const form = document.getElementById('form_login');

var validator = FormValidation.formValidation(
    form,
    {
        fields: {
            'email': {
                validators: {
                    notEmpty: {
                        message: 'Customer email is required'
                    },
                    emailAddress:{
                        message:"The value is not a valid email address"
                    }
                }
            },
            'password': {
                validators: {
                    notEmpty: {
                        message: 'Password is required'
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
const submitButton = document.getElementById('btnLogin');
submitButton.addEventListener('click', function (e) {
    e.preventDefault();

    if (validator) {
        validator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                submitButton.setAttribute('data-kt-indicator', 'on');

                submitButton.disabled = true;

                setTimeout(function () {
                    submitButton.removeAttribute('data-kt-indicator');

                    submitButton.disabled = false;

                    form.submit();
                }, 2000);
            }
        });
    }
});
