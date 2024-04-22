const form = document.getElementById('form');

var validator = FormValidation.formValidation(
    form,
    {
        fields: {
            'item_id': {
                validators: {
                    notEmpty: {
                        message: 'Item is required'
                    }
                }
            },
            'item_variant_id': {
                validators: {
                    notEmpty: {
                        message: 'Item variant is required'
                    }
                }
            },
            'quantity': {
                validators: {
                    notEmpty: {
                        message: 'Quantity is required'
                    }
                }
            },
            'new_quantity': {
                validators: {
                    notEmpty: {
                        message: 'New Quantity is required'
                    }
                }
            },
            'new_unit': {
                validators: {
                    notEmpty: {
                        message: 'New Unit is required'
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

const submitButton = document.getElementById('unit_conversions_submit');
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

