const form = document.getElementById("form_add");

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var validator = FormValidation.formValidation(form, {
    fields: {
        name: {
            validators: {
                notEmpty: {
                    message: "Company name is required !",
                },
            },
        },
        city_id: {
            validators: {
                notEmpty: {
                    message: "Please select regency or city!",
                },
            },
        },
       address: {
            validators: {
                notEmpty: {
                    message: "Address company is required !",
                },
            },
        },
       phone: {
            validators: {
                notEmpty: {
                    message: "No Telephone is required !",
                },
            },
        },
       max_user: {
            validators: {
                notEmpty: {
                    message: "Max user is required !",
                },
            },
        },
       max_warehouse: {
            validators: {
                notEmpty: {
                    message: "Max warehouse is required !",
                },
            },
        },
       max_product: {
            validators: {
                notEmpty: {
                    message: "Max product is required !",
                },
            },
        },
    },

    plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap: new FormValidation.plugins.Bootstrap5({
            rowSelector: ".fv-row",
            eleInvalidClass: "",
            eleValidClass: "",
        }),
    },
});

// Submit button handler
const submitButton = document.getElementById("add_post_category_submit");
submitButton.addEventListener("click", function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (validator) {
        validator.validate().then(function (status) {
            if (status == "Valid") {
                // Show loading indication
                submitButton.setAttribute("data-kt-indicator", "on");

                // Disable button to avoid multiple click
                submitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                setTimeout(function () {
                    // Remove loading indication
                    submitButton.removeAttribute("data-kt-indicator");

                    // Enable button
                    submitButton.disabled = false;

                    form.submit(); // Submit form
                }, 2000);
            }
        });
    }
});