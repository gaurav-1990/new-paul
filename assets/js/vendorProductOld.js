

function callProductDetails()
{
    $('.product_details_class').show();
    $('.heading_class li').removeClass('active');
    $('#product_details').addClass('active');
    $('.product_price_class').hide();
    $('.product_properties_class').hide();
    $('.product_images_class').hide();

}
$('.fileEdit').change(function () {
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
    $(this).siblings("div#abcd").on('click', '#upload', function (e) {
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
            beforeSend: function (xhr) {
                $(e.target).text('Uploading..');
            },
            success: function (data) {

                var mess = data;
                if (data.trim() === '0')
                {
                    mess = "Not able to save the uploaded file !";
                } else if (data.trim() === '1')
                {
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
$('#pro_image1').on('change', function () {
    var file = this.files[0];
    var fileType = file["type"];
    var ValidImageTypes = ["image/jpeg", "image/png", "application/pdf"];
    if ($.inArray(fileType, ValidImageTypes) < 0) {
        alert('Please select valid image: PNG,JPG,JPEG');
        return false;
    }
});
$('#pro_image2').on('change', function () {
    var file = this.files[0];
    var fileType = file["type"];
    var ValidImageTypes = ["image/jpeg", "image/png", "application/pdf"];
    if ($.inArray(fileType, ValidImageTypes) < 0) {
        alert('Please select valid image: PNG,JPG,JPEG');
        return false;
    }
});
function deleteMe(e)
{
    $(e).parent().parent().parent().remove();
    return false;
}
$('#pro_image3').on('change', function () {
    var file = this.files[0];
    var fileType = file["type"];
    var ValidImageTypes = ["image/jpeg", "image/png", "application/pdf"];
    if ($.inArray(fileType, ValidImageTypes) < 0) {
        alert('Please select valid image: PNG,JPG,JPEG');
        return false;
    }
});
$('#pro_image4').on('change', function () {
    var file = this.files[0];
    var fileType = file["type"];
    var ValidImageTypes = ["image/jpeg", "image/png", "application/pdf"];
    if ($.inArray(fileType, ValidImageTypes) < 0) {
        alert('Please select valid image: PNG,JPG,JPEG');
        return false;
    }
});
$('#pro_image5').on('change', function () {
    var file = this.files[0];
    var fileType = file["type"];
    var ValidImageTypes = ["image/jpeg", "image/png", "application/pdf"];
    if ($.inArray(fileType, ValidImageTypes) < 0) {
        alert('Please select valid image: PNG,JPG,JPEG');
        return false;
    }
});



function addProp()
{
    var category = $('#category').val();
    var subcategory = $('#sub_category_ven').val();
    $.ajax({
        url: "addProperties",
        type: 'POST',
        data: {category: category, subcategory: subcategory},
        success: function (data, textStatus, jqXHR) {
            $('.pb').prepend(data);
        }
    });
}
function submitVenForm()
{
    var category = $('#category').val();
    var sub_category = $('#sub_category_ven').val();
    $.ajax({
        url: "getAllProp",
        type: 'POST',
        data: {category: category, sub_category: sub_category},
        success: function (data, textStatus, jqXHR) {
            data = JSON.parse(data);
            var backProp = [];
            $.each(data, function (i, val) {
                backProp.push(val.id);
            });
            backProp.sort();

            if (backProp.length > 0)
            {
                var prop = [];
                $("select#pd_prop").each(function (i, sel) {
                    if ($(sel).val() === '')
                    {
                        alert("Please select the property field");
                        $(sel).focus();
                        return false;
                    } else
                    {
                        var selectedVal = $(sel).val();
                        console.log($('pd_attr[]').val());
                        prop.push(selectedVal);
                    }
                });
                return false;
                var prop = $.unique(prop);
                prop.sort();
                backProp = backProp.filter(function (val) {
                    return prop.indexOf(val) == -1;
                });



                $("select#pd_attr").each(function (i, sel) {
                    if ($(sel).val() === '')
                    {
                        alert("Please select the attribute field");
                        $(sel).focus();
                        return false;
                    }
                });

                if (backProp.length <= 0)
                {
                    var data = JSON.stringify($('#sform2').serializeArray());
                    $.ajax({
                        type: 'POST',
                        url: "getVendorData",
                        data: {"vendor": data, pro_desc: CKEDITOR.instances['pro_desc'].getData()},
                        success: function (data, textStatus, jqXHR) {
                            $('.loaded').append(data);
                        }
                    });
                } else
                {
                    alert("Please fill all mandatory properties");
                    return false;
                }
            } else
            {

                $("select#pd_prop").each(function (i, sel) {
                    if ($(sel).val() === '')
                    {
                        alert("Please select the property field");
                        $(sel).focus();
                        return false;
                    }
                });
                $("select#pd_attr").each(function (i, sel) {
                    if ($(sel).val() === '')
                    {
                        alert("Please select the attribute field");
                        $(sel).focus();
                        return false;
                    }
                });
                var data = JSON.stringify($('#sform2').serializeArray());
                $.ajax({
                    type: 'POST',
                    url: "getVendorData",
                    data: {"vendor": data, pro_desc: CKEDITOR.instances['pro_desc'].getData()},
                    success: function (data, textStatus, jqXHR) {

                        $('.loaded').append(data);
                    }
                });

            }
        }
    })
}

function getProp(e)
{
     
    $.ajax({
        type: 'POST',
        url: "getSubcategory",
        data: {cat_id: $(e).val()},
        success: function (data, textStatus, jqXHR) {
            $('#sub_cat').html(data);
        }
    });
}

function getSubAttr(e)
{

  
    $.ajax({
        url: "getAttribute",
        type: 'POST',
        data: {category: category},
        success: function (data, textStatus, jqXHR) {
            $(e).parent().next().find('#pd_attr').html(data);
        }
    })
}
function callProductPrice()
{
    if ($('#category').val() == '')
    {
        alert('Please select category');
        $('#category').focus();
        return false;
    }
    if ($('#sub_category').val() === '')
    {
        alert('Please select subcategory');
        $('#sub_category').focus();
        return false;
    }
    if ($('#product_name').val() == '')
    {
        alert('Please enter product name');
        $('#product_name').focus();
        return false;
    }

    $('.heading_class li').removeClass('active');
    $('.product_details_class').hide();
    $('#product_price').addClass('active');
    $('.product_price_class').show();
    $('.product_properties_class').hide();
    $('.product_images_class').hide();
}
function callProductProperties()
{
    if ($('#category').val() == '')
    {
        alert('Please select category');
        $('#category').focus();
        return false;
    }
    if ($('#sub_category').val() === '')
    {
        alert('Please select subcategory');
        $('#sub_category').focus();
        return false;
    }
    if ($('#product_name').val() == '')
    {
        alert('Please enter product name');
        $('#product_name').focus();
        return false;
    }
    if ($('#act_price').val() == '')
    {
        alert('Please enter product price');
        $('#act_price').focus();
        return false;
    }
    if ($('#pro_stock').val() == '')
    {
        alert('Please enter product quantity');
        $('#pro_stock').focus();
        return false;
    }
    if ($('#gst').val() == '')
    {
        alert('Please enter GST rates');
        $('#gst').focus();
        return false;
    }

    $('.heading_class li').removeClass('active');
    $('.product_details_class').hide();
    $('#product_properties').addClass('active');
    $('.product_price_class').hide();
    $('.product_properties_class').show();
    $('.product_images_class').hide();
}

if ($('#add_proof').length)
{

    $('#add_proof').on('change', function () {
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
        $(this).siblings("div#abcd").on('click', '#upload', function (e) {

            var file_data = file;
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('type', "addProof");
            form_data.append('hd_im', hd_im);
            var path = window.location.pathname;
            var url = '../uploadDocs';
            if (path.indexOf("editProfile") != -1)
            {
                url = './uploadDocs';
            }

            $.ajax({
                url: url,
                type: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function (xhr) {
                    $(e.target).text('Uploading..');
                },
                success: function (data) {
                    var mess = data;
                    if (data.trim() == '0')
                    {
                        mess = "Not able to save the uploaded file !";
                    } else if (data.trim() == '1')
                    {
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

    $('#pan_number').on('change', function () {
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
        $(this).siblings("div#abcd").on('click', '#uploadPan', function (e) {

            var file_data = file;
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('type', "panCard");
            form_data.append('hd_im', hd_im);
            var path = window.location.pathname;
            var url = '../uploadDocs';
            if (path.indexOf("editProfile") != -1)
            {
                url = './uploadDocs';
            }

            $.ajax({
                url: url,
                type: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function (xhr) {
                    $(e.target).text('Uploading..');
                },
                success: function (data) {
                    var mess = data;
                    if (data.trim() == '0')
                    {
                        mess = "Not able to save the uploaded file !";
                    } else if (data.trim() == '1')
                    {
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



    $('#profile_pic').on('change', function () {
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
        $(this).siblings("div#abcd").on('click', '#uploadProfile', function (e) {

            var file_data = file;
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('type', "profilePic");
            form_data.append('hd_im', hd_im);
            var path = window.location.pathname;
            var url = '../uploadDocs';
            if (path.indexOf("editProfile") != -1)
            {
                url = './uploadDocs';
            }

            $.ajax({
                url: url,
                type: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function (xhr) {
                    $(e.target).text('Uploading..');
                },
                success: function (data) {
                    var mess = data;
                    if (data.trim() == '0')
                    {
                        mess = "Not able to save the uploaded file !";
                    } else if (data.trim() == '1')
                    {
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
    $('#gst_doc').on('change', function () {
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
        $(this).siblings("div#abcd").on('click', '#uploadGst', function (e) {

            var file_data = file;
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('type', "gstDoc");
            form_data.append('hd_im', hd_im);
            var path = window.location.pathname;
            var url = '../uploadDocs';
            if (path.indexOf("editProfile") != -1)
            {
                url = './uploadDocs';
            }

            $.ajax({
                url: url,
                type: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function (xhr) {
                    $(e.target).text('Uploading..');
                },
                success: function (data) {
                    var mess = data;
                    if (data.trim() == '0')
                    {
                        mess = "Not able to save the uploaded file !";
                    } else if (data.trim() == '1')
                    {
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
    $('#signature').on('change', function () {
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
        $(this).siblings("div#abcd").on('click', '#uploadSign', function (e) {
            var file_data = file;
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('type', "signature");
            form_data.append('hd_im', hd_im);
            var path = window.location.pathname;
            var url = '../uploadDocs';
            if (path.indexOf("editProfile") != -1)
            {
                url = './uploadDocs';
            }

            $.ajax({
                url: url,
                type: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function (xhr) {
                    $(e.target).text('Uploading..');
                },
                success: function (data) {
                    var mess = data;
                    if (data.trim() == '0')
                    {
                        mess = "Not able to save the uploaded file !";
                    } else if (data.trim() == '1')
                    {
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
    $('#can_cheque').on('change', function () {
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
        $(this).siblings("div#abcd").on('click', '#uploadCheque', function (e) {
            var file_data = file;
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('type', "cancelCheck");
            form_data.append('hd_im', hd_im);
            var path = window.location.pathname;
            var url = '../uploadDocs';
            if (path.indexOf("editProfile") != -1)
            {
                url = './uploadDocs';
            }

            $.ajax({
                url: url,
                type: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function (xhr) {
                    $(e.target).text('Uploading..');
                },
                success: function (data) {
                    var mess = data;
                    if (data.trim() == '0')
                    {
                        mess = "Not able to save the uploaded file !";
                    } else if (data.trim() == '1')
                    {
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
    function removeMe(e)
    {
        e.parent().remove()
        $('#add_proof').show();
    }
    function removeMe2(e)
    {
        e.parent().remove()
        $('#pan_number').show();
    }
    function removeMe3(e)
    {
        e.parent().remove()
        $('#profile_pic').show();
    }
    function removeMe4(e)
    {
        e.parent().remove()
        $('#gst_doc').show();
    }
    function removeMe5(e)
    {
        e.parent().remove()
        $('#signature').show();
    }
    function removeMe6(e)
    {
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