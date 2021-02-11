$.validator.addMethod("pancard", function(value, element) {
    var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/;
    var txtpan = value;
    if (txtpan.length == 10) {
        if (txtpan.match(regExp)) {
            return true;
        } else {
            return false;
        }
    }

}, "Invalid PAN number");
//$.validator.addMethod("imagevalidate", function (value, element) {
//
//}, "Invalid image");
$.validator.addMethod("pwcheck", function(value) {
    return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
        &&
        /[a-z]/.test(value) // has a lowercase letter
        &&
        /\d/.test(value) // has a digit
});
$('#sform2').validate({
    rules: {
        first_name: {
            minlength: 3,
            required: true
        },
        last_name: {
            minlength: 3,
            required: true
        },
        contact_no: {
            minlength: 10,
            maxlength: 10,
            number: true,
            required: true,
        },
        email_id: {
            required: true,
            email: true,
        },
        company: {
            minlength: 3
        },
        cat_image: {
            required: true,
            extension: "png|jpeg|jpg"
        },
        state: {
            required: true
        },
        city: {
            required: true
        },
        category: {
            required: true,

        },
        address: {
            required: true,
        },
        pro_image: {
            required: true,
            extension: "png|jpeg|jpg",
        },
        pan: {
            required: true,
            pancard: true,
        },
        act_price: {
            required: true,
            number: true
        },
        dis_price: {
            number: true
        },
        cat_sub: {
            required: true
        },
        sub_category: {
            required: true
        },
        sub_image: {
            required: true,
            extension: "png|jpeg|jpg",
        },
        product_name: {
            required: true
        },

    },
    highlight: function(element) {
        $(element).parent().addClass('has-error');
    },
    unhighlight: function(element) {
        $(element).parent().removeClass('has-error');
    },
    errorElement: 'span',
    errorClass: 'validation-error-message help-block form-helper bold',
    errorPlacement: function(error, element) {
        if (element.parent('.input-group').length) {
            error.insertAfter(element.parent());
        } else {
            error.insertAfter(element);
        }
    }
});


$('#product_name').keyup(function() {
    var yourInput = $(this).val();
    re = /[`~!@#$%^&*()_|+\=?;:".<>\{\}\[\]\\\/]/gi;
    var isSplChar = re.test(yourInput);
    if (isSplChar) {
        var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
        $(this).val(no_spl_char);

    }
});
//reset_pass

$("#reset_pass").validate({
    rules: {
        password: {
            required: true,
            minlength: 6,
            pwcheck: true
        },

        cpass: {
            equalTo: "#password",
        },

    },



    messages: {
        password: {
            pwcheck: "There should be atleast one character(-@._* A-Z, a-z) "
        },

        cpass: {
            equalTo: "Password value must be same"
        }

    }
});

$('#sform').validate({
    rules: {
        "login[username]": {
            required: true,
            email: true
        },
        "login[password]": {
            required: true,
            minlength: 6,
            pwcheck: true
        },
        "login[cpassword]": {
            equalTo: "#pass",

        },
        "login[fullname]": {
            required: true
        },
        contact: {
            required: true,
            number: true,
            maxlength: 10,
            minlength: 10
        },
        "login[lastname]": {
            required: true
        }
    },
    messages: {
        "login[password]": {
            pwcheck: "There should be atleast one character(-@._* A-Z, a-z) "
        },
        "login[cpassword]": {
            equalTo: "Password value must be same"
        }
    }
});
$('#sform3').validate({
    rules: {
        first_name: {
            minlength: 3,
            required: true
        },
        last_name: {
            minlength: 3,
            required: true
        },
        pro_image: {
            extension: "png|jpeg|jpg",
        },
        cat_image: {
            extension: "png|jpeg|jpg"
        },
        contact_no: {
            minlength: 10,
            maxlength: 10,
            number: true,
            required: true,
        },
        email_id: {
            required: true,
            email: true,
        },
        company: {
            minlength: 3
        },
        state: {
            required: true
        },
        city: {
            required: true
        },
        category: {
            required: true
        },
        address: {
            required: true,

        },
        product_name: {
            required: true
        },
        act_price: {
            required: true
        },
        "file[]": {

        },
        pro_stock: {
            required: true
        },
        pan: {
            required: true,
            pancard: true,
        },
        cat_sub: {
            required: true
        },
        sub_category: {
            required: true
        }
    },

    highlight: function(element) {
        $(element).parent().addClass('has-error');
    },
    unhighlight: function(element) {
        $(element).parent().removeClass('has-error');
    },
    errorElement: 'span',
    errorClass: 'validation-error-message help-block form-helper bold',
    errorPlacement: function(error, element) {
        if (element.parent('.input-group').length) {
            error.insertAfter(element.parent());
        } else {
            error.insertAfter(element);
        }
    }
});
var base = window.location.origin;

if (base == 'http://146.66.68.148') {
    base = window.origin + "/~flightfa/demo/paulsons/";
} else {
    base = this.$base + "/";
}

// if (base == 'http://localhost') {
//     base = 'http://localhost/kartndolls/';
// } else {
//     base = base + "/";
//}

var state = $('#state').val();

$('#state').change(function() {

    var state = $(this).val();
    $.ajax({
        async: true,
        url: base + "Signup/getCity",
        type: 'POST',
        data: { state: state },
        success: function(data, textStatus, jqXHR) {
            $('#city').html(data);
        }
    });
});