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
            'ingredient': {
                validators: {
                    notEmpty: {
                        message: 'Ingredient is empty'
                    }
                }
            },
            'information': {
                validators: {
                    notEmpty: {
                        message: 'information is empty'
                    },
                    remote: {
                        message: 'Data ini sudah dipakai',
                        method: 'POST',
                        url: '/admin/ingredients/isExistInformation',
                        data: function(){
                            return {
                                _token: document.getElementById('csrf'),
                                information: document.getElementById('information'),
                                id: document.getElementById('id'),
                            }
                        },
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

const submitButton = document.getElementById('ingredients_submit');
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

