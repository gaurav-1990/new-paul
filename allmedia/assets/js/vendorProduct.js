function callProductDetails() {
    $('.product_details_class').show();
    $('.heading_class li').removeClass('active');
    $('#product_details').addClass('active');
    $('.product_price_class').hide();
    $('.product_properties_class').hide();
    $('.product_images_class').hide();

}

function chk(id, e) {

    var base = window.location.origin;
    // if (base == 'http://146.66.68.148') {
    //     base = window.origin + "/~flightfa/demo/paulsons/";
    // } else {
    //     base = this.$base + "/";
    // }

    if (base == 'http://localhost:8080') {
        base = base + '/new-paulsons/';
    } else {
        base = base + "/";
    }

    //var id = $(this).data('id');

    if ($(e).prop("checked") == true) {
        $.ajax({
            method: 'POST',
            url: base + "Admin/SadminLogin/saving_session",
            data: {
                "pid": id
            },
            success: function(data) {
                console.log(data);

            }
        });
    } else if ($(e).prop("checked") == false) {
        $.ajax({
            method: 'POST',
            url: base + "Admin/SadminLogin/deleting_session",
            data: {
                "pid": id
            },
            success: function(data) {
                console.log(data);
            }
        });
    }
}
// $('.prod_name').click(function() {

// });


function check_condition(e) {
    var base = window.location.origin;
    var prop = [];
    // if (base == 'http://146.66.68.148') {
    //     base = window.origin + "/~flightfa/demo/paulsons/";
    // } else {
    //     base = this.$base + "/";
    // }

    if (base == 'http://localhost:8080') {
        base = base + '/new-paulsons/';
    } else {
        base = base + "/";
    }
    if ($("#condition").val() == '') {
        $(".which_price").show();
        $("#products").hide();
        $("#category").hide();
    }
    if ($("#condition").val() == 1) {

        $("#products").hide();
        $(".which_price").hide();
        $("#category").show();
    } else {
        if ($("#condition").val() == 2) {
            $("#category").hide();
            $(".which_price").hide();
            $("#products").show();
        }

    }
    $.ajax({
        type: "POST",
        url: base + "Admin/SadminLogin/loadAllProducts",
        success: function(data) {
            $('#dynamic_prod').html(data);

            $('#myproduct').DataTable({
                "destroy": true, //use for reinitialize datatable
            });
        }
    })

}

function customerGroup() {
    if ($("#selectAll").prop("checked") == true) {
        $("input[type=checkbox]").prop("checked", true);
    } else if ($("#selectAll").prop("checked") == false) {
        $("input[type=checkbox]").prop("checked", false);
    }
}

function singleCustomer(c) {
    if ($("#user_name_" + c).prop("checked") == false) {
        $("#selectAll").prop("checked", false);
    }
}

function get_prop() {
    var base = window.location.origin;
    var prop = [];
    // if (base == 'http://146.66.68.148') {
    //     base = window.origin + "/~flightfa/demo/paulsons/";
    // } else {
    //     base = this.$base + "/";
    // }

    if (base == 'http://localhost:8080') {
        base = base + '/new-paulsons/';
    } else {
        base = base + "/";
    }

    $("#attributes:checked").each(function() {
        prop.push(this.value);
    });
    $.ajax({
        type: "POST",
        url: base + "Admin/Vendor/get_selected_prop",
        data: {
            pid: prop
        },
        success: function(data) {

            $('.mydiv').html(data);
        }
    })
}

function getval() {

    if ($("#my-swatches").val() == 2) {

        $(".my-color").show();
    }

}

$('#cat_sub').change(function() {
    var cat_sub = $(this).val();


    var base = window.location.origin;
    // if (base == 'http://146.66.68.148') {
    //     base = window.origin + "/~flightfa/demo/paulsons/";
    // } else {
    //     base = this.$base + "/";
    // }

    if (base == 'http://localhost:8080') {
        base = base + '/new-paulsons/';
    } else {
        base = base + "/";
    }
    $.ajax({
        type: "POST",
        url: base + "Admin/SadminLogin/loadChildSub",
        data: {
            cid: cat_sub
        },
        success: function(data) {
            $('#c_sub_category').html(data);
        }
    })
});

$("#selectBox").click(function() {
    $('#pin_codes').find('input:checkbox').not(this).prop('checked', this.checked);
});



$('#userOrderModule').find('tr').delegate("#delivery_option", "change", function() {
    var obj = $(this);

    if ($(this).val() == 6) {
        $('#awb_div_' + obj.data("or") + '').remove();
        $(this).parent().append('<div id="can_div_' + obj.data('or') + '"><input name="cancel_no" id="can_no_' + obj.data('or') + '" placeholder="cancel notes"  type="text"><br><input type="button" onclick="setCancel(' + obj.data('or') + ')" value="save" class="btn btn-xs btn-success"> </div>');
    } else if ($(this).val() == 9) {
        $('#awb_div_' + obj.data("or") + '').remove();
        $(this).parent().append('<div id="can_div_' + obj.data('or') + '"><input name="cancel_no" id="can_no_' + obj.data('or') + '" placeholder="Reason"  type="text"><br><input type="button" onclick="exchangeRequested(' + obj.data('or') + ')" value="save" class="btn btn-xs btn-success"> </div>');
    } else if ($(this).val() == 1) {
        $('#awb_div_' + obj.data("or") + '').remove();
        $('#can_div_' + obj.data("or") + '').remove();
        $(this).parent().append('<div id="awb_div_' + obj.data('or') + '"><input name="track" id="track' + obj.data('or') + '" placeholder="AWB No"  type="text"><br><input type="button" onclick="setAwbOtherShip(' + obj.data('or') + ')" value="save" class="btn btn-xs btn-success"> </div>');
    } else {
        $('#awb_div_' + obj.data("or") + '').remove();
        $('#can_div_' + obj.data("or") + '').remove();
        $(this).parent().append('<div id="awb_div_' + obj.data('or') + '"><input type="button" onclick="setAwbOther(' + obj.data('or') + ')" value="save" class="btn btn-xs btn-success"> </div>');
    }
});

$('#userOrderModule').find('tr').delegate("#bag_option", "change", function() {
    var obj = $(this);
    if ($(this).val() == 2) {
        // $('#bagModal').modal('show');
        $(".bag_form_" + obj.data('or')).show();
    } else {
        $(".bag_form_" + obj.data('or')).hide();
    }

});

function setCancel(id) {

    var msg = $('#can_no_' + id).val();
    $.ajax({
        url: "./cancelOrder",
        type: "POST",
        data: {
            id: id,
            msg: msg
        },
        success: function(data) {

            location.reload();
        }
    });
}

function exchangeRequested(id) {
    var msg = $('#can_no_' + id).val();
    $.ajax({
        url: "./exchangeRejected",
        type: "POST",
        data: {
            id: id,
            msg: msg
        },
        success: function(data) {

            location.reload();
        }
    });
}

function getSimilar(id) {
    $('#exampleModal3').modal("show");
    $.ajax({
        url: "./loadSimilarProducts",
        type: "POST",
        data: {
            id: id
        },
        beforeSend: function() {
            $('.modal-body').text("Loading..");
        },
        success: function(data) {
            $('.modal-body').html(data);
        }
    });
}

function getCrosssell(id) {

}

function setAwb(id) {

    var base = window.location.origin;

    // if (base == 'http://146.66.68.148') {
    //     base = window.origin + "/~flightfa/demo/paulsons/";
    // } else {
    //     base = this.$base + "/";
    // }

    if (base == 'http://localhost:8080') {
        base = base + '/new-paulsons/';
    } else {
        base = base + "/";
    }


    var awb = $('#awb_no_' + id + '').val();
    var delsta = $('#awb_div_' + id + '').siblings('#delivery_option[data-or=' + id + ']').val();

    if (isNaN(awb) || awb.length < 8) {
        alert('Invalid AWB');
        return false;
    }

    $.ajax({

        url: base + "Admin/Vendor/addAWB",
        type: "POST",
        data: {
            orid: id,
            awb: awb,
            delsta: delsta
        },
        beforeSend: function(xhr) {
            $('#awb_no_' + id + '').next('br').next('input').val('Loading');
        },
        success: function(data, textStatus, jqXHR) {
            $('#awb_no_' + id + '').next('br').next('input').val('saved');


            location.reload();
        }
    });
}

function setAwbOtherShip(id) {
    var base = window.location.origin;

    // if (base == 'http://146.66.68.148') {
    //     base = window.origin + "/~flightfa/demo/paulsons/";
    // } else {
    //     base = this.$base + "/";
    // }

    if (base == 'http://localhost:8080') {
        base = base + '/new-paulsons/';
    } else {
        base = base + "/";
    }

    var status = $('#awb_div_' + id + '').siblings('#delivery_option[data-or=' + id + ']').val();
    var awb = $('#track' + id).val();
    $.ajax({
        url: base + "Admin/Vendor/setAwbOtherShiped",
        //url: './addAWBOther',
        type: "POST",
        data: {
            orid: id,
            status: status,
            awb: awb
        },
        beforeSend: function(xhr) {
            $('#awb_no_' + id + '').next('br').next('input').val('Loading');
        },
        success: function(data, textStatus, jqXHR) {
            // console.log(data);
            // return false;
            $('#awb_no_' + id + '').next('br').next('input').val('saved');

            location.reload();
        }
    });


}

function setAwbOther(id) {

    var base = window.location.origin;

    // if (base == 'http://146.66.68.148') {
    //     base = window.origin + "/~flightfa/demo/paulsons/";
    // } else {
    //     base = this.$base + "/";
    // }

    if (base == 'http://localhost:8080') {
        base = base + '/new-paulsons/';
    } else {
        base = base + "/";
    }


    var delsta = $('#awb_div_' + id + '').siblings('#delivery_option[data-or=' + id + ']').val();

    $.ajax({
        url: base + "Admin/Vendor/addAWBOther",
        //url: './addAWBOther',
        type: "POST",
        data: {
            orid: id,
            delsta: delsta
        },
        beforeSend: function(xhr) {
            $('#awb_no_' + id + '').next('br').next('input').val('Loading');
        },
        success: function(data, textStatus, jqXHR) {

            // console.log(data);
            // return false;
            $('#awb_no_' + id + '').next('br').next('input').val('saved');

            location.reload();
        }
    });
}



function isBrand(e) {
    if ($(e).val() === '1') {
        $('#show_brand').show();
    } else {
        $('#show_brand').hide();
    }
}


function getChildCategory(va) {
    var base = window.location.origin;
    // if (base == 'http://146.66.68.148') {
    //     base = window.origin + "/~flightfa/demo/paulsons/";
    // } else {
    //     base = this.$base + "/";
    // }
    if (base == 'http://localhost:8080') {
        base = base + '/new-paulsons/';
    } else {
        base = base + "/";
    }

    $.ajax({
        url: base + "Admin/Vendor/getSubChildCategory",
        type: "POST",
        data: {
            _child: va
        },
        success: function(data) {
            $('#child_category_ven').html(data);

        }
    });

}

$('.fileEdit').change(function() {
    var file = this.files[0];
    var fileType = file["type"];
    var ValidImageTypes = ["image/jpeg", "image/png", "application/pdf"];
    if ($.inArray(fileType, ValidImageTypes) < 0) {
        alert('Please select valid image: PNG,JPG,JPEG');
        return false;
    }
    var x = $(this).parent().find('#previewimg').remove();
    $(this).before("<div id='abcd'  class='abcd'>  \n\
<a href='javascript:void(0)' id='upload' class='btn btn-xs btn-success'>Upload</a> </div>");
    $(this).hide();
    $(this).siblings("div#abcd").on('click', '#upload', function(e) {
        var file_data = file;
        var form_data = new FormData();
        var name = $(this).parent().siblings('input').data('name');
        form_data.append('name', name);
        form_data.append('file', file);
        $.ajax({
            url: '../editProductImage',
            type: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function(xhr) {
                $(e.target).text('Uploading..');
            },
            success: function(data) {

                var mess = data;
                if (data.trim() === '0') {
                    mess = "Not able to save the uploaded file !";
                } else if (data.trim() === '1') {
                    mess = "Image Has Been Updated!";
                    $(e.target).remove();
                }
                $.notify({
                    icon: 'glyphicon glyphicon-star',
                    message: mess,
                });
                $(e.target).text('Upload');
                location.reload();
                return false;
            }
        });

    });

});
$('#ship_state').change(function() {
    $.ajax({
        type: 'POST',
        url: "getShippingCity",
        data: {
            name: $(this).val()
        },
        success: function(data, textStatus, jqXHR) {
            $('#pin_codes').html('');
            $('#ship_city').trigger("chosen:updated");
            $('#ship_city').html('<option value="">Select City</option>');
            $('#ship_city').html(data);
            $('#ship_city').trigger("chosen:updated");
        }
    });
});

$('#ship_city').change(function() {
    $.ajax({
        type: 'POST',
        url: "getCityPin",
        data: {
            name: $(this).val()
        },
        beforeSend: function(xhr) {
            $('#pin_codes').html('<tr><td colspan="5">Loading..</td></tr>');
        },
        success: function(data, textStatus, jqXHR) {
            $('#pin_codes').html('');
            $('#pin_codes').html(data);
        }
    });
});

$('#pro_image1').on('change', function() {
    var file = this.files[0];
    var fileType = file["type"];
    var ValidImageTypes = ["image/jpeg", "image/png", "application/pdf"];
    if ($.inArray(fileType, ValidImageTypes) < 0) {
        alert('Please select valid image: PNG,JPG,JPEG');
        return false;
    }
});
$('#pro_image2').on('change', function() {
    var file = this.files[0];
    var fileType = file["type"];
    var ValidImageTypes = ["image/jpeg", "image/png", "application/pdf"];
    if ($.inArray(fileType, ValidImageTypes) < 0) {
        alert('Please select valid image: PNG,JPG,JPEG');
        return false;
    }
});

function deleteMe(e) {
    $(e).parent().parent().parent().remove();
    return false;
}
$('#pro_image3').on('change', function() {
    var file = this.files[0];
    var fileType = file["type"];
    var ValidImageTypes = ["image/jpeg", "image/png", "application/pdf"];
    if ($.inArray(fileType, ValidImageTypes) < 0) {
        alert('Please select valid image: PNG,JPG,JPEG');
        return false;
    }
});
$('#pro_image4').on('change', function() {
    var file = this.files[0];
    var fileType = file["type"];
    var ValidImageTypes = ["image/jpeg", "image/png", "application/pdf"];
    if ($.inArray(fileType, ValidImageTypes) < 0) {
        alert('Please select valid image: PNG,JPG,JPEG');
        return false;
    }
});
$('#pro_image6').on('change', function() {
    var file = this.files[0];
    var fileType = file["type"];
    var ValidImageTypes = ["image/jpeg", "image/png", "application/pdf"];
    if ($.inArray(fileType, ValidImageTypes) < 0) {
        alert('Please select valid image: PNG,JPG,JPEG,PDF');
        return false;
    }
});
$('#pro_image5').on('change', function() {
    var file = this.files[0];
    var fileType = file["type"];
    var ValidImageTypes = ["image/jpeg", "image/png", "application/pdf"];
    if ($.inArray(fileType, ValidImageTypes) < 0) {
        alert('Please select valid image: PNG,JPG,JPEG');
        return false;
    }
});

function choose_prop() {
    var row = $("#prop_id").val();
    var nm = row.split('_');
    var res = nm[1].toLowerCase();
    if (res == 2) {
        $('.my-color').show();
    } else {
        $('.my-color').hide();
    }

}

function addProp() {

    var totalStock = parseInt($('#pro_stock').val());
    var total = 0;
    var qty = 0;
    var qt = 0;

    $('.pb').find('.panel-body').each(function(i, val) {
        if ($(this).find('#quantity').val().length > 0) {
            qty = parseInt($(this).find('#quantity').val());
        } else {
            alert('Fill Quantity field');
            qt = 1;
            $(this).find('#quantity').focus();
            return false;

        }

        total = total + qty;
    });

    if (total >= totalStock) {
        alert('You can not add more than this because quantity increased in comparison to product stock ');
        return false;
    }
    if (qt === 0) {
        var category = $('#category').val();
        var subcategory = $('#sub_category_ven').val();
        var count = $('.pb').find('.panel-body').length;

        $.ajax({
            url: "addProperties",
            type: 'POST',
            data: {
                category: 2,
                subcategory: 1,
                count: count
            },
            success: function(data, textStatus, jqXHR) {

                $('.pb').prepend(data);
            }
        });
    }
}

function addEditProp() {

    var totalStock = parseInt($('#pro_stock').val());
    var total = 0;
    var qty = 0;
    var qt = 0;
    var flag = 0;
    var count = 0;
    $('#editAtt').find("tr#qtyval").each(function(i, val) {
        if ($(this).find('#quantity').val().length > 0) {
            qty = parseInt($(this).find('#quantity').val());
            count++;
        } else {
            alert('Fill Quantity field');
            qt = 1;
            $(this).find('#quantity').focus();
            flag = 1;
            return false;

        }

        total = total + qty;
    });



    if (total > totalStock) {
        alert('You can not add more than this because quantity increased in comparison to prduct stock ');
        flag = 1;
        return false;
    }
    $("select#pd_attr").each(function(i, sel) {
        if ($(sel).val() === '') {
            alert("Please select the attribute field");
            $(sel).focus();
            flag = 1;
            return false;
        }
    });

    if (flag == 0) {
        var category = $('#category').val();
        var subcategory = $('#subcategory').val();
        var co = count;

        $.ajax({
            url: "../vendoraddproperties",
            type: 'POST',
            data: {
                category: category,
                co: co,
                subcategory: subcategory
            },
            success: function(data, textStatus, jqXHR) {

                $('.pb').append(data);
            }
        });
    }


}

function submitVenForm() {

    if ($('#hsn_code').val() == '') {
        alert('Please enter HSN Code');
        $('#hsn_code').focus();
        return false;
    }
    var totalStock = parseInt($('#pro_stock').val());
    var total = 0;

    var qty = 0;
    var qt = 0;
    $('.pb').find('.panel-body').each(function(i, val) {
        if ($(this).find('#quantity').val().length > 0) {
            qty = parseInt($(this).find('#quantity').val());
        } else {
            alert('Fill Quantity field');
            qt = 1;
            $(this).find('#quantity').focus();
            return false;

        }

        total = total + qty;
    });

    if (total > totalStock) {
        alert('You can not add more than this because quantity increased in comparison to prduct stock ');
        return false;
    }

    var category = $('#category').val();
    var sub_category = $('#sub_category_ven').val();
    var shortDes = CKEDITOR.instances['sort_pro_desc'].getData();

    var sizeChart = "";
    if (CKEDITOR.instances['size_chart']) {
        sizeChart = CKEDITOR.instances['size_chart'].getData();
    }

    $.ajax({
        url: "getAllProp",
        type: 'POST',
        data: {
            category: category,
            sub_category: sub_category
        },
        success: function(data, textStatus, jqXHR) {
            data = JSON.parse(data);
            var backProp = [];



            if (backProp.length > 0) {
                var prop = [];
                $("select#pd_prop").each(function(i, sel) {
                    if ($(sel).val() === '') {
                        alert("Please select the property field");
                        $(sel).focus();
                        return false;
                    } else {
                        var selectedVal = (($(sel).val().trim()).split('_'))[0];
                        prop.push(selectedVal);
                    }
                });

                var prop = $.unique(prop);
                prop.sort();


                backProp = backProp.filter(function(val) {
                    return prop.indexOf(val) == -1;
                });


                $("select#pd_attr").each(function(i, sel) {
                    if ($(sel).val() === '') {
                        alert("Please select the attribute field");
                        $(sel).focus();
                        return false;
                    }
                });


                if (backProp.length <= 0) {
                    var data = JSON.stringify($('#sform2').serializeArray());

                    $.ajax({
                        type: 'POST',
                        url: "getVendorData",
                        data: {
                            "vendor": data,
                            pro_desc: CKEDITOR.instances['pro_desc'].getData(),
                            sizeChart: sizeChart,
                            shortDes: shortDes
                        },
                        success: function(data, textStatus, jqXHR) {
                            $('.loaded').append(data);
                        }
                    });
                } else {
                    alert("Please fill all mandatory properties");
                    return false;
                }
            } else {

                $("select#pd_prop").each(function(i, sel) {

                    if ($(sel).val() === '') {
                        alert("Please select the property field");
                        $(sel).focus();
                        return false;
                    }
                });



                var data = JSON.stringify($('#sform2').serializeArray());

                $.ajax({
                    type: 'POST',
                    url: "getVendorData",
                    data: {
                        "vendor": data,
                        pro_desc: CKEDITOR.instances['pro_desc'].getData(),
                        sizeChart: sizeChart,
                        shortDes: shortDes
                    },
                    success: function(data, textStatus, jqXHR) {

                        $('.loaded').append(data);
                    }
                });

            }
        }
    })
}

function deleteThis(e) {

    $(e).parent().parent("tr").remove();

}

function getProp(e) {

    $.ajax({
        type: 'POST',
        url: "getSubcategory",
        data: {
            cat_id: $(e).val()
        },
        success: function(data, textStatus, jqXHR) {
            $('#sub_cat').html(data);
        }
    });
}

function getSubAttr(e) {
    var category2 = $(e).val();
    category2.trim();
    category2 = category2.split('_');
    var category = category2[1];

    $.ajax({
        url: "getAttribute",
        type: 'POST',
        data: {
            category: category
        },
        success: function(data, textStatus, jqXHR) {
            $(e).parent().next().find('#pd_attr').html(data);
        }
    })
}



function callProductPrice() {
    // if ($('#category').val() == '') {
    //     alert('Please select category');
    //     $('#category').focus();
    //     return false;
    // }
    // if ($('#sub_category').val() === '') {
    //     alert('Please select subcategory');
    //     $('#sub_category').focus();
    //     return false;
    // }
    if ($('#product_name').val() == '') {
        alert('Please enter product name');
        $('#product_name').focus();
        return false;
    }


    if ($('#brand_doc').is(":visible") === true) {
        if ($('#brand_name').val() == '') {
            alert('Please enter brand name');
            $('#brand_name').focus();
            return false;
        }
        if ($('#brand_doc').val() == '') {
            alert('Please choose brand documents');
            $('#brand_doc').focus();
            return false;
        }
    }
    var checkedNum = $('input[name="sub_cat[]"]:checked').length;
    if (!checkedNum) {
        alert('Please select category');
        window.scrollBy(0, 100);
        return false;
    }

    $.ajax({
        type: "POST",
        url: "./getSizeChart",
        async: true,
        data: {
            sub: $('#sub_category_ven').val()
        },
        success: function(response) {
            $('.size_chart').show();
        }
    });

    $('.heading_class li').removeClass('active');
    $('.product_details_class').hide();
    $('#product_price').addClass('active');
    $('.product_price_class').show();
    $('.product_properties_class').hide();
    $('.product_images_class').hide();
}

function callProductProperties() {

    // if ($('#category').val() == '') {
    //     alert('Please select category');
    //     $('#category').focus();
    //     return false;
    // }
    // if ($('#sub_category').val() === '') {
    //     alert('Please select subcategory');
    //     $('#sub_category').focus();
    //     return false;
    // }

    addProp();

    if ($('#product_name').val() == '') {
        alert('Please enter product name');
        $('#product_name').focus();
        return false;
    }
    if ($('#act_price').val() == '') {
        alert('Please enter product price');
        $('#act_price').focus();
        return false;
    }
    if ($('#pro_stock').val() == '') {
        alert('Please enter product quantity');
        $('#pro_stock').focus();
        return false;
    }
    if ($('#gst').val() == '') {
        alert('Please enter GST rates');
        $('#gst').focus();
        return false;
    }

    if ($('#hsn_code').val() == '') {
        alert('Please enter HSN Code');
        $('#hsn_code').focus();
        return false;
    }
    if ($('#brand_doc').is(":visible") === true) {
        if ($('#brand_name').val() == '') {
            alert('Please enter brand name');
            $('#brand_name').focus();
            return false;
        }
        if ($('#brand_doc').val() == '') {
            alert('Please choose brand documents');
            $('#brand_doc').focus();
            return false;
        }
    }

    $('.heading_class li').removeClass('active');
    $('.product_details_class').hide();
    $('#product_properties').addClass('active');
    $('.product_price_class').hide();
    $('.product_properties_class').show();
    $('.product_images_class').hide();
}

if ($('#add_proof').length) {

    $('#add_proof').on('change', function() {
        var file = this.files[0];
        var fileType = file["type"];
        var ValidImageTypes = ["image/jpeg", "image/png", "application/pdf"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            alert('Please select valid image: PNG,JPG,JPEG');
            return false;
        }
        var x = $(this).parent().find('#previewimg').remove();
        $(this).before("<div id='abcd'  class='abcd'><img id='previewimg' src='' style='width:40%; height:40%;'/>  <a onclick='removeMe($(this))' class='btn btn-danger closeId btn-xs'> <i class='fa fa-trash'></i> </a> \n\
<a href='javascript:void(0)' id='upload' class='btn btn-xs btn-success'>Upload</a> </div>");
        var hd_im = $('#hidden_id').val();
        $(this).siblings("div#abcd").on('click', '#upload', function(e) {

            var file_data = file;
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('type', "addProof");
            form_data.append('hd_im', hd_im);
            var path = window.location.pathname;
            var url = '../uploadDocs';
            if (path.indexOf("editProfile") != -1) {
                url = './uploadDocs';
            }

            $.ajax({
                url: url,
                type: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(xhr) {
                    $(e.target).text('Uploading..');
                },
                success: function(data) {
                    var mess = data;
                    if (data.trim() == '0') {
                        mess = "Not able to save the uploaded file !";
                    } else if (data.trim() == '1') {
                        mess = "Address Proof Has Been Uploaded Successfully!";
                        $(e.target).remove();
                    }
                    $.notify({
                        icon: 'glyphicon glyphicon-star',
                        message: mess,
                    });
                    return false;
                }
            });
        });
        var reader = new FileReader();
        reader.onload = imageIsLoaded;
        reader.readAsDataURL(this.files[0]);
        $(this).hide();
        return false;
    });

    $('#pan_number').on('change', function() {
        var file = this.files[0];
        var fileType = file["type"];
        var ValidImageTypes = ["image/jpeg", "image/png", "application/pdf"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            alert('Please select valid image: PNG,JPG,JPEG');
            return false;
        }
        var x = $(this).parent().find('#previewimg2').remove();
        $(this).before("<div id='abcd'  class='abcd'><img id='previewimg2' src='' style='width:40%; height:40%;'/>  <a onclick='removeMe2($(this))' class='btn btn-danger closeId btn-xs'> <i class='fa fa-trash'></i> \n\
</a> <a href='javascript:void(0)' id='uploadPan' class='btn btn-xs btn-success'> Upload </a> </div>");
        var hd_im = $('#hidden_id').val();
        $(this).siblings("div#abcd").on('click', '#uploadPan', function(e) {

            var file_data = file;
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('type', "panCard");
            form_data.append('hd_im', hd_im);
            var path = window.location.pathname;
            var url = '../uploadDocs';
            if (path.indexOf("editProfile") != -1) {
                url = './uploadDocs';
            }

            $.ajax({
                url: url,
                type: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(xhr) {
                    $(e.target).text('Uploading..');
                },
                success: function(data) {
                    var mess = data;
                    if (data.trim() == '0') {
                        mess = "Not able to save the uploaded file !";
                    } else if (data.trim() == '1') {
                        mess = "Pan Card Has Been Uploaded Successfully!";
                        $(e.target).remove();
                    }
                    $.notify({
                        icon: 'glyphicon glyphicon-star',
                        message: mess,
                    });
                    return false;
                }
            });
        });
        var reader = new FileReader();
        reader.onload = imageIsLoaded2;
        reader.readAsDataURL(this.files[0]);
        $(this).hide();
        return false;
    });



    $('#profile_pic').on('change', function() {
        var file = this.files[0];
        var fileType = file["type"];
        var ValidImageTypes = ["image/jpeg", "image/png", "application/pdf"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            alert('Please select valid image: PNG,JPG,JPEG');
            return false;
        }
        var x = $(this).parent().find('#previewimg3').remove();
        $(this).before("<div id='abcd'  class='abcd'><img id='previewimg3' src='' style='width:40%; height:40%;'/>  <a onclick='removeMe3($(this))' class='btn btn-danger closeId btn-xs'> <i class='fa fa-trash'></i> </a> <a   href='javascript:void(0)' id='uploadProfile' class='btn btn-xs btn-success'> Upload </a>  </div>");
        var hd_im = $('#hidden_id').val();
        $(this).siblings("div#abcd").on('click', '#uploadProfile', function(e) {

            var file_data = file;
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('type', "profilePic");
            form_data.append('hd_im', hd_im);
            var path = window.location.pathname;
            var url = '../uploadDocs';
            if (path.indexOf("editProfile") != -1) {
                url = './uploadDocs';
            }

            $.ajax({
                url: url,
                type: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(xhr) {
                    $(e.target).text('Uploading..');
                },
                success: function(data) {
                    var mess = data;
                    if (data.trim() == '0') {
                        mess = "Not able to save the uploaded file !";
                    } else if (data.trim() == '1') {
                        mess = "Profile Pic Has Been Uploaded Successfully!";
                        $(e.target).remove();
                    }
                    $.notify({
                        icon: 'glyphicon glyphicon-star',
                        message: mess,
                    });
                    return false;
                }
            });
        });
        var reader = new FileReader();
        reader.onload = imageIsLoaded3;
        reader.readAsDataURL(this.files[0]);
        $(this).hide();
    });
    $('#gst_doc').on('change', function() {
        var file = this.files[0];
        var fileType = file["type"];
        var ValidImageTypes = ["image/jpeg", "image/png", "application/pdf"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            alert('Please select valid image: PNG,JPG,JPEG');
            return false;
        }
        var x = $(this).parent().find('#previewimg4').remove();
        $(this).before("<div id='abcd'  class='abcd'><img id='previewimg4' src='' style='width:40%; height:40%;'/>  <a onclick='removeMe4($(this))' class='btn btn-danger closeId btn-xs'> <i class='fa fa-trash'></i> </a> <a   href='javascript:void(0)' id='uploadGst' class='btn btn-xs btn-success'> Upload </a> </div>");
        var hd_im = $('#hidden_id').val();
        $(this).siblings("div#abcd").on('click', '#uploadGst', function(e) {

            var file_data = file;
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('type', "gstDoc");
            form_data.append('hd_im', hd_im);
            var path = window.location.pathname;
            var url = '../uploadDocs';
            if (path.indexOf("editProfile") != -1) {
                url = './uploadDocs';
            }

            $.ajax({
                url: url,
                type: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(xhr) {
                    $(e.target).text('Uploading..');
                },
                success: function(data) {
                    var mess = data;
                    if (data.trim() == '0') {
                        mess = "Not able to save the uploaded file !";
                    } else if (data.trim() == '1') {
                        mess = "GST Doc Has Been Uploaded Successfully!";
                        $(e.target).remove();
                    }
                    $.notify({
                        icon: 'glyphicon glyphicon-star',
                        message: mess,
                    });
                    return false;
                }
            });
        });
        var reader = new FileReader();
        reader.onload = imageIsLoaded4;
        reader.readAsDataURL(this.files[0]);
        $(this).hide();
    });
    $('#signature').on('change', function() {
        var file = this.files[0];
        var fileType = file["type"];
        var ValidImageTypes = ["image/jpeg", "image/png", "application/pdf"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            alert('Please select valid image: PNG,JPG,JPEG');
            return false;
        }
        var x = $(this).parent().find('#previewimg5').remove();
        $(this).before("<div id='abcd'  class='abcd'><img id='previewimg5' src='' style='width:40%; height:40%;'/>  <a onclick='removeMe5($(this))' class='btn btn-danger closeId btn-xs'> <i class='fa fa-trash'></i> </a> <a   href='javascript:void(0)' id='uploadSign' class='btn btn-xs btn-success'> Upload </a> </div>");
        var hd_im = $('#hidden_id').val();
        $(this).siblings("div#abcd").on('click', '#uploadSign', function(e) {
            var file_data = file;
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('type', "signature");
            form_data.append('hd_im', hd_im);
            var path = window.location.pathname;
            var url = '../uploadDocs';
            if (path.indexOf("editProfile") != -1) {
                url = './uploadDocs';
            }

            $.ajax({
                url: url,
                type: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(xhr) {
                    $(e.target).text('Uploading..');
                },
                success: function(data) {
                    var mess = data;
                    if (data.trim() == '0') {
                        mess = "Not able to save the uploaded file !";
                    } else if (data.trim() == '1') {
                        mess = "Signature Has Been Uploaded Successfully!";
                        $(e.target).remove();
                    }
                    $.notify({
                        icon: 'glyphicon glyphicon-star',
                        message: mess,
                    });
                    return false;
                }
            });
        });
        var reader = new FileReader();
        reader.onload = imageIsLoaded5;
        reader.readAsDataURL(this.files[0]);
        $(this).hide();
    });
    $('#can_cheque').on('change', function() {
        var file = this.files[0];
        var fileType = file["type"];
        var ValidImageTypes = ["image/jpeg", "image/png", "application/pdf"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            alert('Please select valid image: PNG,JPG,JPEG');
            return false;
        }
        var x = $(this).parent().find('#previewimg6').remove();
        $(this).before("<div id='abcd'  class='abcd'><img id='previewimg6' src='' style='width:40%; height:40%;'/>  <a onclick='removeMe6($(this))' class='btn btn-danger closeId btn-xs'> <i class='fa fa-trash'></i> </a> <a   href='javascript:void(0)' id='uploadCheque' class='btn btn-xs btn-success'> Upload </a> </div>");
        var hd_im = $('#hidden_id').val();
        $(this).siblings("div#abcd").on('click', '#uploadCheque', function(e) {
            var file_data = file;
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('type', "cancelCheck");
            form_data.append('hd_im', hd_im);
            var path = window.location.pathname;
            var url = '../uploadDocs';
            if (path.indexOf("editProfile") != -1) {
                url = './uploadDocs';
            }

            $.ajax({
                url: url,
                type: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(xhr) {
                    $(e.target).text('Uploading..');
                },
                success: function(data) {
                    var mess = data;
                    if (data.trim() == '0') {
                        mess = "Not able to save the uploaded file !";
                    } else if (data.trim() == '1') {
                        mess = "Cheque Has Been Uploaded Successfully!";
                        $(e.target).remove();
                    }
                    $.notify({
                        icon: 'glyphicon glyphicon-star',
                        message: mess,
                    });
                    return false;
                }
            });
        });
        var reader = new FileReader();
        reader.onload = imageIsLoaded6;
        reader.readAsDataURL(this.files[0]);
        $(this).hide();
    });


    function removeMe(e) {
        e.parent().remove()
        $('#add_proof').show();
    }

    function removeMe2(e) {
        e.parent().remove()
        $('#pan_number').show();
    }

    function removeMe3(e) {
        e.parent().remove()
        $('#profile_pic').show();
    }

    function removeMe4(e) {
        e.parent().remove()
        $('#gst_doc').show();
    }

    function removeMe5(e) {
        e.parent().remove()
        $('#signature').show();
    }

    function removeMe6(e) {
        e.parent().remove()
        $('#can_cheque').show();
    }

    function imageIsLoaded2(e) {
        $('#previewimg2').attr('src', e.target.result);
    }

    function imageIsLoaded3(e) {
        $('#previewimg3').attr('src', e.target.result);
    }

    function imageIsLoaded4(e) {
        $('#previewimg4').attr('src', e.target.result);
    }

    function imageIsLoaded5(e) {
        $('#previewimg5').attr('src', e.target.result);
    }

    function imageIsLoaded6(e) {
        $('#previewimg6').attr('src', e.target.result);
    }

    function imageIsLoaded(e) {
        $('#previewimg').attr('src', e.target.result);
    }



}

$(document).ready(function() {
    $(".tbl-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#userOrderModule tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
})