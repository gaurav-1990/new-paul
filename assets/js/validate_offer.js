$(".sform2").validate({
    rules: {
        offer_name: {
            required: true,
            minlength: 3,
            maxlength: 50,
            lettersonly: true
        },

        offer_code: {
            required: true,
            minlength: 3,
            maxlength: 50,
            lettersonly: true
        },
        
        offer_val: {
            required: true,
            number: true
        }
    },

    messages: {
        offer_name: {
            required: "Please enter  Offer Name",
            minlength: "Your username must consist of at least 3 characters",
            maxlength: "Your username must must not be greater than 50 characters",
            lettersonly: "Only alphabets are allowed"
        },

        offer_code: {
            required: "Please enter Offer Code",
            minlength: "Your username must consist of at least 3 characters",
            maxlength: "Your username must must not be greater than 50 characters",
            lettersonly: "Only alphabets are allowed"
        },
        
        offer_val:{
            required: "Please enter Offer Value",
            number: "Only digits are allowed"
        }
    }
});