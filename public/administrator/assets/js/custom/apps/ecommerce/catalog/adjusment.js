const form = document.getElementById('form');

var validator = FormValidation.formValidation(
    form,
    {
        fields: {
            'date': {
                validators: {
                    notEmpty: {
                        message: 'Date is required'
                    }
                }
            },
            'warehouse_id': {
                validators: {
                    notEmpty: {
                        message: 'Warehouse is required'
                    }
                }
            },
            'adjusments': {
                validators: {
                    notEmpty: {
                        message: 'Item is empty'
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

const submitButton = document.getElementById('adjusment_submit');
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

