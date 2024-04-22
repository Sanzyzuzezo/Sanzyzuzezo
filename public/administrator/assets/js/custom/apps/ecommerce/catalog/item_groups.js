const form = document.getElementById('form');

var validator = FormValidation.formValidation(
    form,
    {
        fields: {
            'code': {
                validators: {
                    notEmpty: {
                        message: 'Item Group code is required'
                    }
                }
            },
            'name': {
                validators: {
                    notEmpty: {
                        message: 'Item Group name is required'
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

const submitButton = document.getElementById('item_groups_submit');
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
