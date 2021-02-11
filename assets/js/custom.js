var base = window.location.origin;

//var base = window.location.origin;
// if (base == 'http://146.66.68.148') {
//     base = window.origin + "/~flightfa/demo/karzanddolls/";
// } else {
//     base = $base + "/";
// }

if (base == 'http://localhost') {
    base = base + '/karzanddolls/';
} else {
    base = base + "/";
}

var state = $('#state').val();
$.ajax({
    async: true,
    url: base + "Signup/getCity",
    type: 'POST',
    data: { state: state },
    success: function(data, textStatus, jqXHR) {
        $('#city').html(data);
    }
});
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
$.validator.addMethod("gstno", function(value, element) {
    var regExp = /^([0][1-9]|[1-2][0-9]|[3][0-5])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/;
    var txtpan = value;
    if (txtpan.length == 10) {
        if (txtpan.match(regExp)) {
            return true;
        } else {
            return false;
        }
    }

}, "Invalid GST number");