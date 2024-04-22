const form = document.getElementById('form');
var pass = document.getElementById('password');

var validator = FormValidation.formValidation(
    form,
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
            // 'email': {
            //     validators: {
            //         notEmpty: {
            //             message: 'Customer email is required'
            //         },
            //         emailAddress:{
            //             message:"The value is not a valid email address"
            //         }
            //     }
            // },
            // 'password': {
            //     validators: {
            //         notEmpty: {
            //             message: 'Password is required'
            //         }
            //     }
            // },
            // 'confirm_password': {
            //     validators:{
            //         notEmpty:{
            //             message:"Confirm Password is required"
            //         },
            //         identical:{
            //             compare:function(){
            //                 return pass.value
            //             },
            //             message:"The password and its confirm are not the same"
            //         }
            //     }
            // },
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
const submitButton = document.getElementById('customer_submit');
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