const form_edit = document.getElementById('form');

var validator_edit = FormValidation.formValidation(
    form_edit,
    {
        fields: {
            'customer_group': {
                validators: {
                    notEmpty: {
                        message: 'Customer group is required'
                    }
                }
            },
            'name': {
                validators: {
                    notEmpty: {
                        message: 'Customer name is required'
                    }
                }
            },
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
            'confirm_password': {
                validators:{
                    identical:{
                        compare:function(){
                            return pass.value
                        },
                        message:"The password and its confirm are not the same"
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
const editButton = document.getElementById('customer_submit');
editButton.addEventListener('click', function (e) {
   
    e.preventDefault();

    if (validator_edit) {
        validator_edit.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                editButton.setAttribute('data-kt-indicator', 'on');

                editButton.disabled = true;

                setTimeout(function () {
                    editButton.removeAttribute('data-kt-indicator');

                    editButton.disabled = false;

                    form.submit();
                }, 2000);
            }
        });
    }
});