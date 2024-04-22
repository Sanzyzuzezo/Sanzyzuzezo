const form = document.getElementById('form');

var validator = FormValidation.formValidation(
    form,
    {
        fields: {
            'tanggal': {
                validators: {
                    notEmpty: {
                        message: 'Date required'
                    }
                }
            },
            'gudang': {
                validators: {
                    notEmpty: {
                        message: 'Warehouse required'
                    }
                }
            },
            'supplier': {
                validators: {
                    notEmpty: {
                        message: 'Supplier required'
                    }
                }
            },
            'total_keseluruhan': {
                validators: {
                    notEmpty: {
                        message: 'Total required'
                    }
                }
            },
            'items': {
                validators: {
                    notEmpty: {
                        message: 'items required'
                    }
                }
            },
            'status_nomor_pembelian': {
                validators: {
                    notEmpty: {
                        message: 'Number has been used!'
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

const submitButton = document.getElementById('stock_card_submit');
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

