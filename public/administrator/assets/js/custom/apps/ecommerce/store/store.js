// Define form element
const form = document.getElementById("form_add");

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var validator = FormValidation.formValidation(form, {
    fields: {
        name: {
            validators: {
                notEmpty: {
                    message: "Store name is required!",
                },
            },
        },
        code: {
            validators: {
                notEmpty: {
                    message: "Store Code is required",
                },
            },
        },
        province_id: {
            validators: {
                notEmpty: {
                    message: "Please select province !",
                },
            },
        },
        city_id: {
            validators: {
                notEmpty: {
                    message: "Please select city !",
                },
            },
        },
        subdistrict_id: {
            validators: {
                notEmpty: {
                    message: "Please select subdistrict !",
                },
            },
        },
        detail_address: {
            validators: {
                notEmpty: {
                    message: "Detail addres is required !",
                },
            },
        },
        warehouse_data: {
            validators: {
                notEmpty: {
                    message: "Please select warehouse !",
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
