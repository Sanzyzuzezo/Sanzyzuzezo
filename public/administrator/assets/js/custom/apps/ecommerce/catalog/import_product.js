const form = document.getElementById('form_add');

var validator = FormValidation.formValidation(
    form,
    {
        fields: {
            'brand': {
                validators: {
                    notEmpty: {
                        message: 'Please select brand'
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
            'file': {
                validators: {
                    notEmpty: {
                        message: 'Please uplod file'
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
const submitButton = document.getElementById('import');
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
