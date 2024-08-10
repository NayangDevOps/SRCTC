$(document).ready(function($){
    function fetchTicketData(filter) {
        $.ajax({
            url: SiteURL+'/tickets-data/' + filter,
            method: 'GET',
            success: function(data) {
                $('#total_tickets').text(data.total_tickets);
                $('#filter-title').text('| ' + filter.charAt(0).toUpperCase() + filter.slice(1));
            },
            error: function() {
                console.error('Failed to fetch data.');
            }
        });
    }
    fetchTicketData('today');
    $('.filter-option').on('click', function(e) {
        e.preventDefault();
        var filter = $(this).data('filter');
        fetchTicketData(filter);
    });
    function fetchRevenueData(filter) {
        $.ajax({
            url: SiteURL+'/revenue-data/' + filter,
            method: 'GET',
            success: function(data) {
                if (data.total_revenue != null && data.total_revenue != undefined) {
                    $('#total_revenue').text('₹' + data.total_revenue);
                } else {
                    $('#total_revenue').text('₹0');
                }                                
                $('#revenue-filter-title').text('| ' + filter.charAt(0).toUpperCase() + filter.slice(1));
            },
            error: function() {
                console.error('Failed to fetch data.');
            }
        });
    }
    fetchRevenueData('today');
    $('.filter-options').on('click', function(e) {
        e.preventDefault();
        var filter = $(this).data('filter');
        fetchRevenueData(filter);
    });
    window.onload = function(){
        if (document.getElementById('trainCodeInput')) {
            generateTrainCode();
        }
    }    
    function generateTrainCode(){
        var digits = '0123456789';
        var trainCode = '';      
        for (var index = 0; index < 6; index++) {
            trainCode += digits.charAt(Math.floor(Math.random() * digits.length));        
        }            
        trainCode = shuffle(trainCode);    
        document.getElementById('trainCodeInput').value = trainCode;
    }
    function shuffle(string) {
        var array = string.split('');
        var currentIndex = array.length, temporaryValue, randomIndex;   
        while (0 !== currentIndex) {
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;    
            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;
        }   
        return array.join('');
    }    
    $('#user_type').select2({
        language: {
            noResults: function() {
                return 'No result found';
            }
        },
        formatNoMatches: function() {
            return 'Select an option';
        }
    });
    $('#trainSelect').select2({
        language: {
            noResults: function() {
                return 'No result found';
            }
        },
        formatNoMatches: function() {
            return 'Select an option';
        }
    });
    $('#startPoint').select2({
        language: {
            noResults: function() {
                return 'No result found';
            }
        },
        formatNoMatches: function() {
            return 'Select an option';
        }
    });
    $('#endPoint').select2({
        language: {
            noResults: function() {
                return 'No result found';
            }
        },
        formatNoMatches: function() {
            return 'Select an option';
        }
    });
    if ($('#travel_date').length) {
        var today = new Date().toISOString().split('T')[0];
        document.getElementById('travel_date').setAttribute('min', today);
    }
    $('#book_ticket').validate({
        ignore: [],
        rules: {
            start_point: {
                required: true
            },
            end_point: {
                required: true
            },
            travel_date: {
                required: true,
                date: true
            }
        },
        messages: {
            start_point: {
                required: "Please select a departure station."
            },
            end_point: {
                required: "Please select an arrival station."
            },
            travel_date: {
                required: "Please select a travel date.",
                date: "Please enter a valid date."
            }
        },
        errorClass: 'help-block',
        errorElement: 'span',
        highlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        errorPlacement: function(error, element) {
            if (element.hasClass('select2-hidden-accessible')) {
                error.insertAfter(element.next('span.select2'));
            } else {
                error.insertAfter(element);
            }
        }
    });
    $("#add_train").validate({
        rules: {
            train_code: "required",
            train_name: "required",
			rate: "required",
            release_date:"required",
        },
        messages: {
            train_code: "Please enter Train Code.",
            train_name: "Please enter Train Name.",
			rate: "Please enter Rate As Per KM.",
            release_date:"Please enter Release Date.",
        },
        errorClass: 'help-block',
        errorElement: 'span',
        highlight: function(element, errorClass, validClass) {
            $(element).parents('#profile-form').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('#profile-form').removeClass('has-error').addClass('has-success');
        }
    });
    $("#add_route").validate({
        rules: {
            train_id: "required",
            start_point: "required",
			end_point: "required",
        },
        messages: {
            train_id: "Please select Train.",
            start_point: "Please select Start Point.",
			end_point: "Please select End Point."
        },
        errorClass: 'help-block',
        errorElement: 'span',
        highlight: function(element, errorClass, validClass) {
            $(element).parents('#profile-form').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('#profile-form').removeClass('has-error').addClass('has-success');
        }
    });
    $("#profile-form").validate({
        rules: {
            first_name: "required",
            last_name: "required",
			display_name: "required",
            email: {
                required: true,
                email: true
            },
            mobile_no:"required",
        },
        messages: {
            first_name: "Please enter specify First Name.",
            last_name: "Please enter specify Last Name.",
			display_name: "Please enter specify Display Name.",
            email: {
                required: "Please enter Email Address.",
                email: "Please enter valid Email Address..!"
            },
            mobile_no:"Enter your mobile number.",
        },
        errorClass: 'help-block',
        errorElement: 'span',
        highlight: function(element, errorClass, validClass) {
            $(element).parents('#profile-form').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('#profile-form').removeClass('has-error').addClass('has-success');
        }
    });
    $("#add_user").validate({
        rules: {
            first_name: "required",
            last_name: "required",
			display_name: "required",
            user_type: "required",
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
            first_name: "Please enter specify First Name.",
            last_name: "Please enter specify Last Name.",
			display_name: "Please enter specify Display Name.",
            user_type: "Please select User Type.",
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
            $(element).parents('#profile-form').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('#profile-form').removeClass('has-error').addClass('has-success');
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "user_type") {
                error.insertAfter(element.next('.select2'));
            } else {
                error.insertAfter(element);
            }
        }
    });
});
function closePopup(id) {
    $('#' + id).modal('hide');
}