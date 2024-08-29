! function ($) {
    "use strict";

    $.validator.addMethod("emailRegex", function (value, element) {
        return this.optional(element) || /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i.test(value);
    }, "Invalid Email Address");
    $.validator.addMethod("onlyWhiteSpaceField", function (value, element) {
        return this.optional(element) || value.trim().length != 0;
    }, "This field is required");

    var form = $('#studentRegisterForm');
    form.validate({
        errorElement: 'div',
        errorClass: 'error-message',
        rules: {
            register_firstname: {
                required: true,
                onlyWhiteSpaceField: true,
            },
            register_lastname: {
                required: true,
                onlyWhiteSpaceField: true,
            },
            register_username: {
                required: true,
                remote: {
                    onkeyup: false,
                    url: ajaxObj.ajaxurl,
                    type: "post",
                    data: {
                       'register_username': function() {
                            return $( "#register_username" ).val();
                        },
                       'action': 'check_user_name'
        
                    },
                    beforeSend: function () {
                        $(".next").attr("disabled", true);
                    },
                    complete: function () {
                        $(".next").attr("disabled", false);
                    }
                }
            },
            register_email: {
                required: true,
                emailRegex: true,
                remote: {
                    onkeyup: false,
                    url: ajaxObj.ajaxurl,
                    type: "post",
                    data: {
                       'register_email': function() {
                            return $( "#register_email" ).val();
                        },
                       'action': 'check_user_email'
        
                    },
                    beforeSend: function () {
                        $(".next").attr("disabled", true);
                    },
                    complete: function () {
                        $(".next").attr("disabled", false);
                    }
                }
            },
            register_sociallink: {
                required: false,
            },
            register_region: {
                required: true,
            },
            register_city: {
                required: true,
                onlyWhiteSpaceField: true,
            },
            register_motivation: {
                required: true,
                onlyWhiteSpaceField: true,
            },
            register_experience: {
                required: true,
                onlyWhiteSpaceField: true,
            },
            register_history: {
                required: true,
                onlyWhiteSpaceField: true,
            },
            register_obstacles: {
                required: true,
                onlyWhiteSpaceField: true,
            },
            prefered_language: {
                required: true,
                onlyWhiteSpaceField: true,
            },
            track: {
                required: true,
                onlyWhiteSpaceField: true,
            },
            curriculum: {
                required: true,
                onlyWhiteSpaceField: true,
            },
            instructor: {
                required: true,
            }
        },
        errorPlacement: function(error, element) 
        {
            if ( element.is(":radio") ) 
            {
                error.appendTo( element.parents('.non-form-floating') );
            }
            else 
            { // This is the default behavior 
                error.insertAfter( element );
            }
        },
        messages: {
            register_email: {
                remote: "This email already exists"
            },
            register_username: {
                remote: "This username already exists"
            },
            instructor: {
            required: "Please select anyone instructor",
           },      
        },
        highlight: function (element, errorClass, validClass) {
            $(element).closest('.form-floating').addClass("has-error");
            $(element).closest('.non-form-floating').addClass("has-error");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.form-floating').removeClass("has-error");
            $(element).closest('.non-form-floating').removeClass("has-error");
        },
    });
    /**
     * Define a function to navigate betweens form steps.
     * It accepts one parameter. That is - step number.
     */
    const navigateToFormStep = (stepNumber) => {
        /**
         * Hide all form steps.
         */
        document.querySelectorAll(".form-step").forEach((formStepElement) => {
            formStepElement.classList.add("d-none");
        });
        /**
         * Mark all form steps as unfinished.
         */
        document.querySelectorAll(".form-stepper-list").forEach((formStepHeader) => {
            formStepHeader.classList.add("form-stepper-unfinished");
            formStepHeader.classList.remove("form-stepper-active", "form-stepper-completed");
        });
        /**
         * Show the current form step (as passed to the function).
         */
        document.querySelector("#step-" + stepNumber).classList.remove("d-none");
        /**
         * Select the form step circle (progress bar).
         */
        const formStepCircle = document.querySelector('li[step="' + stepNumber + '"]');
        /**
         * Mark the current form step as active.
         */
        formStepCircle.classList.remove("form-stepper-unfinished", "form-stepper-completed");
        formStepCircle.classList.add("form-stepper-active");
        /**
         * Loop through each form step circles.
         * This loop will continue up to the current step number.
         * Example: If the current step is 3,
         * then the loop will perform operations for step 1 and 2.
         */
        for (let index = 0; index < stepNumber; index++) {
            /**
             * Select the form step circle (progress bar).
             */
            const formStepCircle = document.querySelector('li[step="' + index + '"]');
            /**
             * Check if the element exist. If yes, then proceed.
             */
            if (formStepCircle) {
                /**
                 * Mark the form step as completed.
                 */
                formStepCircle.classList.remove("form-stepper-unfinished", "form-stepper-active");
                formStepCircle.classList.add("form-stepper-completed");
            }
        }
    };
    /**
     * Select all form navigation buttons, and loop through them.
     */
    document.querySelectorAll(".next").forEach((formNavigationBtn) => {
        /**
         * Add a click event listener to the button.
         */
        formNavigationBtn.addEventListener("click", () => {
            /**
             * Get the value of the step.
             */
            const stepNumber = parseInt(formNavigationBtn.getAttribute("step_number"));
            // console.log('next clicked');
            /**
             * Call the function to navigate to the target form step.
             */
           
            if (form.valid() === true) {
                navigateToFormStep(stepNumber);
            }
        });
    });

    document.querySelectorAll(".back").forEach((formNavigationBtn) => {
        /**
         * Add a click event listener to the button.
         */

        formNavigationBtn.addEventListener("click", () => {
            /**
             * Get the value of the step.
             */
            const stepNumber = parseInt(formNavigationBtn.getAttribute("step_number"));

            /**
             * Call the function to navigate to the target form step.
             */
            // console.log('back clicked');
            navigateToFormStep(stepNumber);
        });
    });

}(jQuery);