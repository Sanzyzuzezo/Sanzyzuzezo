// Define form element
const form = document.getElementById('form_add');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var validator = FormValidation.formValidation(
    form,
    {
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'User group name is required'
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

// Submit button handler
const submitButton = document.getElementById('kt_ecommerce_add_user_group_submit');
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

// Onload
$(document).ready(function() {
    $('.permission-list').each(function() {
        var that = this;
        var key_all = $(this).find(".check_all").data('key_all');

        $(this).find(".check_all").on("click", function() {
            if ($(this).is(':checked') == false) {
                $(that).find('.access_' + $(this).val()).prop('checked', false);
            } else {
                $(that).find('.access_' + $(this).val()).prop('checked', true);
            }
        });

        $(this).find(".access_" + key_all).on("click", function() {
            if (!$(this).is(':checked')) {
                $(that).find('.check_all').prop('checked', false);
            }

            total_access = $(that).find(".access_" + key_all).length;
            total_given_access = $(that).find(".access_" + key_all + ":checked").length;

            if(total_access != 0 && total_access == total_given_access){
                $(that).find('.check_all').prop('checked', true);
            }
        });

        total_access = $(that).find(".access_" + key_all).length;
        total_given_access = $(that).find(".access_" + key_all + ":checked").length;

        if(total_access != 0 && total_access == total_given_access){
            $(that).find('.check_all').prop('checked', true);
        }
    });
});

