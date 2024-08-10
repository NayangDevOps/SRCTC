$(document).ready(function($) {
    $("#form_signup").validate({
        rules: {
            first_name: "required",
            last_name: "required",
            email: {
                required: true,
                email: true
            },
            mobile_no:"required",
            password: {
                required: true,
            },
            cpassword:{
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            first_name: "Please specify First Name.",
            last_name: "Please specify Last Name.",
            email: {
                required: "Please enter Email Address.",
                email: "Please enter valid Email Address..!"
            },
            mobile_no:"Enter your mobile number.",
            password:{
                required: "Please enter password."
            },
            cpassword:{
                required: "Please re enter password.",
                equalTo: "Confirm password is not matching."
            }
        },
        errorClass: 'help-block',
        errorElement: 'span',
        highlight: function(element, errorClass, validClass) {
            $(element).parents('#form_signup').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('#form_signup').removeClass('has-error').addClass('has-success');
        }
    });
    $("#form_signin").validate({
        rules: {
            username: {
                required: true,
                email: true
            },
            password: {
                required: true,
            },
        },
        messages: {
            username: {
                required: "Please enter Email Address.",
                email: "Please enter valid Email Address..!"
            },
            password:{
                required: "Please enter Password."
            },
        },
        errorClass: 'help-block',
        errorElement: 'span',
        highlight: function(element, errorClass, validClass) {
            $(element).parents('#form_signup').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('#form_signup').removeClass('has-error').addClass('has-success');
        }
    });
});