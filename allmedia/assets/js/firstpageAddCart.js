var click = 0;
$(function() {
    $('.header-clearAllBtn').click(function() {
        $("input:checkbox").prop('checked', false);
    });
    $('.mob-clearBtn').click(function() {
        $("input:checkbox").prop('checked', false);
    });
    var base = window.location.origin;


    if (base == 'http://localhost:8080') {
        base = window.origin + "/new-paulsons/";
    } else {
        base = base + "/";
    }
    //hang on event of form with id=myform
    $('.captcha-refresh').on('click', function() {
        $.get('./refresh', function(data) {
            $('#image_captcha').html(data);
        });
    });

    $("#giftCheck").click(function() {



        if ($("#giftCheck:checkbox:checked").length == 1) {
            $('#giftwrap').modal("show");
        } else {
            $.ajax({
                type: 'POST',
                url: base + "Checkout/removeGift",
                success: function(data) {
                    location.reload();
                    // $('#giftCheck').prop("checked", false);

                }
            });

        }
    });


    $("#submitGiftForm").click(function(e) {
        var recp = $('#recipient').val();
        var msg = $('#msg').val();
        var sender_name = $('#sender_name').val();
        if (recp == '' && msg == '') {
            $("#error1").text("Recipient Name is Required .");
            $("#error2").text("Message is Required .");
            $("#error3").text("Sender Name is Required .");
            return false;
        }
        $.ajax({
            type: 'POST',
            data: {
                recp: recp,
                msg: msg,
                sender_name: sender_name
            },
            url: base + "Checkout/myGift",

            success: function(data) {
                //  $('#giftCheck').attr("checked", "checked");
                $("#giftwrap").modal("hide");
                location.reload();
            }
        });




    });
});

function clickTopFilters(i, val) {


    if (click == 0) {
        $('.open-drop' + val).show();
        click = val;
        $('#icon_' + click).removeClass();
        $('#icon_' + click).addClass("fa fa-angle-down");
    } else if (click != 0 && click != val) {
        $('.open-drop' + click).hide();
        $('#icon_' + click).removeClass();
        $('#icon_' + click).addClass("fa fa-angle-up");
        $('.open-drop' + val).find("i").show();
        $('#icon_' + val).removeClass();
        $('#icon_' + val).addClass("fa fa-angle-down");
        click = val;
    } else {

        $('.open-drop' + click).hide();
        $('#icon_' + click).removeClass();
        $('#icon_' + click).addClass("fa fa-angle-up");
        click = 0;
    }

}



var firstCart = {
    init: function() {
        this.cacheDom();
        this.bindDom();
        $('[data-toggle="tooltip"]').tooltip();
    },
    viewSimilarProd: function(e) {
        var id = $(e).data("latest"); // $(".sim_prd").data("prod");

        $.ajax({
            type: "POST",
            data: {
                id: id,
            },
            url: firstCart.$base + "Dashboard/similarProduct",
            success: function(data) {
                $(".simProd").html(data);
            }
        })

    },
    cacheDom: function() {
        this.bindAddtocart = 0;
        this.bindWishtocart = 0;
        this.viewSimilar = $(".view-rlt");
        this.viewSimilarOnMob = $(".view-related");
        this.inputCoup = $(".apply-set").find("span");
        this.removeWish = $('.wish-block').find(".cross-in");
        this.show_More = $(".show_More");
        this.applyCoup = $(".bindCoupon");
        this.secCoupon = $(".price-detail").find("a");
        this.myCoupon = $(".first-coupen");
        this.$mobileUrl = "";
        this.paymentMethod = $('.payment-mth');
        this.getCoupon = this.myCoupon.find("a");
        this.mainDiv = $('.product-show-right');
        this.removeCoupon = this.myCoupon.find(".remove_coupon");
        this.addToCart = $(".add-cart");
        this.addTopSize = $(".add-top-size");
        this.addSizeBu = this.addTopSize.find("li");
        this.loader = $(".load");
        this.$filterDiv = $('.myfilter');
        this.$filterDivMobile = $('.myfilterMobile');
        this.$card_count = $('.header-icons-noti');
        this.$cart_module = $(".order-left");
        this.$sizeModal = $("#size-set");
        this.$qtyModal = $("#qty-set");
        this.$addMoreWish = $(".add-wish-set");
        this.$mobileFilterApply = $('#applyMobileFilter');
        this.$removePop = $("#rmv-bag");
        this.$totalPrice = $("#total");
        this.$customCheckbox = $('.custom-checkbox');
        this.$attribute = [];
        this.$total = 0.00;
        this.$placeOrder = $('.palce-ord');
        // this.$addbox = $('.add-to-box');
        this.$sidePrice = $(".price-detail");
        this.$walletLink = $('#wallet_checkbox');
        this.updateTotalPrice();
        this.$base = window.location.origin;
        // if (this.$base == 'http://146.66.68.148') {
        //     this.$base = window.origin + "/~flightfa/demo/paulsons/";
        // } else {
        //     this.$base = this.$base + "/";
        // }

        if (this.$base == 'http://localhost:8080') {
            this.$base = this.$base + "/new-paulsons/";
        } else {
            this.$base = this.$base + "/";
        }
    },

    viewSimilarProdMob: function() {

        var id = $(".view-related").find("button").data("prod");
        $.ajax({
            type: "POST",
            data: {
                id: id,
            },
            url: firstCart.$base + "Dashboard/similarProductMob",
            success: function(data) {


                $(".simProdMob").html(data);
                // console.log(data);
            }
        })

    },
    getUrlParameter: function(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;
        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
    },
    // filterAll: function() {
    //
    //     var selectedFilters = {};
    //     var allFilters = [];
    //     firstCart.$checkCounter = 0;
    //     var $filterCheckboxes = this.$filterDiv.find('input[type="checkbox"]');
    //     $filterCheckboxes.each(function(i, val) {
    //         allFilters.push($(val).attr("name"));
    //     });
    //     $filterCheckboxes.filter(':checked').each(function(i, val) {
    //         if (!selectedFilters.hasOwnProperty(this.name)) {
    //             selectedFilters[this.name] = [];
    //         }
    //         selectedFilters[this.name].push(this.value);
    //         firstCart.$checkCounter++;
    //     });
    //
    //
    //     var myNewArray = allFilters.filter(function(elem, index, self) {
    //         return index === self.indexOf(elem);
    //     });
    //     var $filteredResults = firstCart.mainDiv.find(".row>.mob-col-pad");
    //     $.each(selectedFilters, function(name, filterValues) {
    //         $filteredResults = $filteredResults.filter(function() {
    //
    //             var matched = false;
    //             var currentFilterValues = [];
    //             myNewArray.map((val2) => {
    //
    //                 if ($(this).data(val2) != undefined) {
    //                     currentFilterValues.push($(this).data(val2).toString());
    //                 }
    //             });
    //
    //             $.each(currentFilterValues, function(_, currentFilterValue) {
    //
    //                 filterValues.map((val) => {
    //                     if (val.includes("|")) {
    //                         var arr = val.split("|");
    //
    //                         if (parseFloat(arr[0]) <= parseFloat(currentFilterValue) && parseFloat(arr[1]) > parseFloat(currentFilterValue)) {
    //                             matched = true;
    //                             return false;
    //                         }
    //                     } else if (val.includes("|") == false) {
    //
    //                         if ($.inArray(currentFilterValue, filterValues) != -1) {
    //
    //                             matched = true;
    //                             return false;
    //                         }
    //                     }
    //
    //                 });
    //             });
    //             return matched;
    //         });
    //     });
    //     //   console.log($filteredResults.length);
    //     $("#prod_count").text(' - ' + $filteredResults.length + ' ' + 'items');
    //
    //     $.when(firstCart.mainDiv.find(".row>.mob-col-pad").hide().filter($filteredResults).show());
    //
    // },
    filterAllMobileMethod: function(e) {

        var selectedFilters = {};
        firstCart.$checkCounter = 0;
        var $filterCheckboxes = this.$filterDivMobile.find('input[type="checkbox"]');
        $filterCheckboxes.filter(':checked').each(function(i, val) {
            if (!selectedFilters.hasOwnProperty(this.name)) {
                selectedFilters[this.name] = [];
            }
            selectedFilters[this.name].push(this.value);
            firstCart.$checkCounter++;
        });
        var page = this.getUrlParameter('page') != undefined ? this.getUrlParameter('page') : 1;
        var term = this.getUrlParameter('term') != undefined ? this.getUrlParameter('term') : '';
        selectedFilters = JSON.stringify(selectedFilters);
        $.ajax({
            url: firstCart.$base + "Dashboard/createUrl",
            type: 'POST',
            data: { selectedFilter: selectedFilters, term: term, page: page, url: window.location.href },
            beforeSend: function(xhr) {

            },
            success: function(data, textStatus, jqXHR) {
                firstCart.$mobileUrl = data;
                //window.location.replace(data);

            }
        });
        var $filteredResults = firstCart.mainDiv.find(".row>.mob-col-pad");
        //   console.log($filteredResults.length);
        //  $("#prod_count").text(' - ' + $filteredResults.length + ' ' + 'items');
        $.when(firstCart.mainDiv.find(".row>.mob-col-pad").hide().filter($filteredResults).show());
    },

    applyFilter: function(e) {
        if (firstCart.$mobileUrl == "") {
            location.reload();
        } else {
            window.location.replace(firstCart.$mobileUrl);
        }
    },

    filterAll: function(e) {


        var selectedFilters = {};
        firstCart.$checkCounter = 0;
        var $filterCheckboxes = this.$filterDiv.find('input[type="checkbox"]');
        $filterCheckboxes.filter(':checked').each(function(i, val) {
            if (!selectedFilters.hasOwnProperty(this.name)) {
                selectedFilters[this.name] = [];
            }
            selectedFilters[this.name].push(this.value);
            firstCart.$checkCounter++;
        });
        var page = this.getUrlParameter('page') != undefined ? this.getUrlParameter('page') : 1;
        var term = this.getUrlParameter('term') != undefined ? this.getUrlParameter('term') : '';

        selectedFilters = JSON.stringify(selectedFilters);
        $.ajax({
            url: firstCart.$base + "Dashboard/createUrl",
            type: 'POST',
            data: { selectedFilter: selectedFilters, term: term, page: page, url: window.location.href },
            beforeSend: function(xhr) {

            },
            success: function(data, textStatus, jqXHR) {
                window.location.replace(data);

            }
        });
        var $filteredResults = firstCart.mainDiv.find(".row>.mob-col-pad");
        //   console.log($filteredResults.length);
        //  $("#prod_count").text(' - ' + $filteredResults.length + ' ' + 'items');
        $.when(firstCart.mainDiv.find(".row>.mob-col-pad").hide().filter($filteredResults).show());
    },
    bindDom: function() {
        this.loadPrice();
        // this.viewSimilar.on("click", this.viewSimilarProd.bind(this));
        this.viewSimilarOnMob.on("click", this.viewSimilarProdMob.bind(this));
        this.inputCoup.on("click", this.inputCoupon.bind(this));
        this.show_More.on("click", this.show_More_disp.bind(this));
        this.$checkCounter = 0;

        this.removeCoupon.on("click", this.removeAllCoupon.bind(this));
        this.removeWish.on("click", this.removeWishProduct.bind(this));
        this.applyCoup.delegate(".best-coupon>a>span:nth-child(2)", "click", this.applyCoupSet.bind(this));
        this.mainDiv.delegate(".row>.mob-col-pad>.show-product-small-bx>.add-wish-prod>span>.add-cart", "click", this.showSizeMethod.bind(this));
        this.mainDiv.delegate(".row>.mob-col-pad>.show-product-small-bx>span>.right-wish", "click", this.showSizeMethodWish.bind(this));
        this.secCoupon.on("click", this.secCouponApply.bind(this));
        this.getCoupon.on("click", this.getAllCoupons.bind(this));
        this.$walletLink.on('click', this.calculateWallet.bind(this));
        this.$cart_module.find(".item-check-show>.order-details>.detail-set").delegate(".change-size", "click", this.showSizeModal.bind(this));
        this.$cart_module.find(".item-check-show>.order-details>.detail-set").delegate(".change-qty", "click", this.showQtyModal.bind(this));
        this.$sizeModal.find(".modal-body").delegate("li", "click", this.selectSize.bind(this));
        this.$qtyModal.find(".modal-body").delegate("li", "click", this.selectQty.bind(this));
        this.$cart_module.find(".item-check-show>.order-details>.remove-set").delegate("button.rmv-btn", "click", this.deleteItem.bind(this));
        this.$placeOrder.on("click", this.goToAddressPage.bind(this));
        // this.$addbox.on("click", this.goToAddressPage.bind(this));
        this.$filterDiv.find(".custom-control-input").on("click", this.filterAll.bind(this));
        this.$filterDivMobile.find(".custom-control-input").on("click", this.filterAllMobileMethod.bind(this));
        this.$mobileFilterApply.on("click", this.applyFilter.bind(this));
    },

    calculateWallet: function(e) {
        var wallet = $('#wallet').data('wallet');
        var total = $('#wallet').data('total');
        var grand = parseFloat(total);
        var grandAfterWallet = parseFloat(total) - parseFloat(wallet);
        var wallet = $('#wallet').data('wallet');

        if ($(e.target).is(":checked")) {
            if ($('input[name="pay_method"]:checked').val() == 'bag') {
                var ship = parseFloat($('#delivery-price').data('ship'));


                $(".total-prc").find("span").html("<i class='fa fa-inr'></i> " + (grandAfterWallet - ship));
                $('#wallet').show();
            } else {
                $(".total-prc").find("span").html("<i class='fa fa-inr'></i> " + grandAfterWallet);
                $('#wallet').show();
            }

        } else {
            $(".total-prc").find("span").html("<i class='fa fa-inr'></i> " + grand);
            $('#wallet').hide();
        }
    },

    removeWishProduct: function(e) {
        var id = $(e.target).parent().data("id");
        var prop = $(e.target).parent().data("prop");
        var attr = $(e.target).parent().data("attr");
        // console.log(id);
        // return false;
        var target = $(e.target);
        $.ajax({
            type: "POST",
            url: firstCart.$base + "Wish_list/remove",
            data: {
                id: id,
                prop: prop,
                attr: attr
            },
            success: function(data) {
                //console.log(data);
                // return false;
                target.parent().parent().hide();
                location.reload();
            }
        })
    },
    sortByPrice: function(e) {
        alert("Price");
    },
    sortByColor: function(e) {
        alert("Color");
    },
    loadPrice: function(e) {
        //
        // var first = 0;
        // var second = 0;
        // var third = 0;
        // var fourth = 0;
        // var fifth = 0;
        // var six = 0;
        // this.mainDiv.find(".mob-col-pad").each((i, val) => {
        //
        //     var price = parseFloat($(val).data("price"));
        //     if (price >= 199 && price <= 499) {
        //         first++;
        //     } else if (price >= 500 && price < 1000) {
        //         second++;
        //     } else if (price >= 1000 && price < 1500) {
        //         third++;
        //     } else if (price >= 1500 && price < 2000) {
        //         fourth++;
        //     } else if (price >= 2000 && price < 2599) {
        //         fifth++;
        //     } else if (price >= 15000 && price <= 25000) {
        //         six++;
        //     }
        // });
        // if (first == 0) {
        //     $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[0]).remove();
        //     $(this.$filterDivMobile.find("div:nth-child(1)").find(".custom-checkbox")[0]).remove();
        // }
        // if (second == 0) {
        //     $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[1]).hide();
        //     $(this.$filterDivMobile.find("div:nth-child(1)").find(".custom-checkbox")[1]).hide();
        // }
        // if (third == 0) {
        //     $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[2]).hide();
        //     $(this.$filterDivMobile.find("div:nth-child(1)").find(".custom-checkbox")[2]).hide();
        // }
        // if (fourth == 0) {
        //     $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[3]).hide();
        //     $(this.$filterDivMobile.find("div:nth-child(1)").find(".custom-checkbox")[3]).hide();
        // }
        // if (fifth == 0) {
        //     $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[4]).hide();
        //     $(this.$filterDivMobile.find("div:nth-child(1)").find(".custom-checkbox")[4]).hide();
        // }
        // if (six == 0) {
        //     $(this.$filterDiv.find("div:nth-child(2)").find(".custom-checkbox")[5]).hide();
        //     $(this.$filterDivMobile.find("div:nth-child(2)").find(".custom-checkbox")[5]).hide();
        // }
        //
        //
        // $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[0]).find("small").text("(" + first + ")");
        // $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[1]).find("small").text("(" + second + ")");
        // $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[2]).find("small").text("(" + third + ")");
        // $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[3]).find("small").text("(" + fourth + ")");
        // $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[4]).find("small").text("(" + fifth + ")");
        // $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[5]).find("small").text("(" + six + ")");
        //
        //
        // $(this.$filterDivMobile.find("div:nth-child(1)").find(".custom-checkbox")[0]).find("small").text("(" + first + ")");
        // $(this.$filterDivMobile.find("div:nth-child(1)").find(".custom-checkbox")[1]).find("small").text("(" + second + ")");
        // $(this.$filterDivMobile.find("div:nth-child(1)").find(".custom-checkbox")[2]).find("small").text("(" + third + ")");
        // $(this.$filterDivMobile.find("div:nth-child(1)").find(".custom-checkbox")[3]).find("small").text("(" + fourth + ")");
        // $(this.$filterDivMobile.find("div:nth-child(1)").find(".custom-checkbox")[4]).find("small").text("(" + fifth + ")");
        // $(this.$filterDivMobile.find("div:nth-child(1)").find(".custom-checkbox")[5]).find("small").text("(" + six + ")");
    },
    inputCoupon: function(e) {
        var code = $(e.target).parent().find("input").val();
        var tot = $('.add-wish-set').data('total');
        if (code != '') {
            $.ajax({
                type: "POST",
                data: {
                    coupon_code: code,
                    total: tot
                },
                url: firstCart.$base + "Wish_list/getInputCoupon",
                success: function(data) {

                    if (data != '1') {
                        if (data == '0') {
                            $('.coupon_error').html("<h5 style='text-align:center ; color: #f9108d;'>Coupon not applied because of less Bag price !</h5>");
                        } else {
                            $('.coupon_error').html("<h5 style='text-align:center ; color: #f9108d;'>Invalid Coupon</h5>");
                        }

                    } else {

                        location.reload();
                    }


                }
            })
        } else {
            $('.coupon_error').html("<h5 style='text-align:center ; color: #f9108d;'>Please Enter a valid coupon code ! </h5>");
        }
    },
    removeAllCoupon: function() {

        $.ajax({
            type: "POST",
            url: firstCart.$base + "Wish_list/removeCoupon",
            success: function(data) {
                location.reload();
            }
        })
    },
    show_More_disp: function() {
        $(".show_More2").toggle();
    },
    applyCoupSet: function(e) {

        var offer_id = $(e.target).data("offer");
        var tot = $(".total-prc").find("span").text();
        // var tot = $('.add-wish-set').data('total');

        $.ajax({
            type: "POST",
            data: {
                id: offer_id,
                total: tot
            },
            url: firstCart.$base + "Wish_list/couponSession",
            success: function(data) {
                // console.log(data);
                // return false;
                if (data == '0') {
                    $('.coupon_error').html("<h5 style='text-align:center ; color: #f9108d;'> Coupon not applied because of less Bag price ! </h5>");
                } else {
                    location.reload();
                }

            }
        })
    },
    secCouponApply: function(e) {

        $.ajax({
            type: "POST",
            url: firstCart.$base + "Wish_list/getCoupon",
            success: function(data) {
                // console.log(data);
                // return false;
                if (data != 0) {
                    $(".bindCoupon").html(data);
                } else {
                    $('.apply-set').html('<div class="best-coupon">  <h3> No Coupon available<h3> </div>');
                    $('.coupon_error').html("<h5 style='text-align:center ; color: #f9108d;'>Already Coupon used .</h5>");
                }
            }
        })
    },
    getAllCoupons: function(e) {

        $.ajax({
            type: "POST",
            url: firstCart.$base + "Wish_list/getCoupon",
            success: function(data) {

                if (data != 0) {
                    $(".bindCoupon").html(data);
                } else {
                    $('.apply-set').html('<div class="best-coupon">  <h3> No Coupon available<h3> </div>');
                    $('.coupon_error').html("<h5 style='text-align:center ; color: #f9108d;'>Already Coupon used .</h5>");
                }
            }
        })
    },
    // end the offer codes.
    goToAddressPage: function(e) {
        window.location.href = firstCart.$base + "Checkout/setStepAddress"
    },
    updateTotalPrice: function(e) {
        var total = this.$addMoreWish.data("total");
        this.$totalPrice.text(total);
    },
    removeProduct: function(e, key, target) {
        //  console.log(e, key, target);
        return false;
    },
    deleteItem: function(e) {
        var key = $(e.target).data("key");
        var target = $(e.target);
        var src = $(e.target).parent().parent().siblings(".img-check").find("img").attr("src");
        this.$removePop.modal("show");
        this.$removePop.find(".modal-body").find("img").attr("src", src);
        this.$removePop.find(".modal-footer").find(".rmove-btn").data("pro", key);
        this.$removePop.find(".modal-footer").find(".rmove-btn").on("click", function() {
            $.ajax({
                type: "POST",
                data: {
                    key: key
                },
                url: "Checkout/removeProduct",
                beforeSend: function() {
                    $('.load').css({
                        "display": "flex"
                    });
                },
                success: function(data) {
                    $('.load').css({
                        "display": "none"
                    });
                    target.parent().parent().parent().remove();
                    location.reload();
                }
            })
        });
    },
    selectQty: function(e) {
        const val = $(e.target).data("attr");
        const current = $(e.target).data("key");
        const prod = $(e.target).data("pro");
        var text = $(e.target).text();
        var target = this.$cart_module.find(".item-check-show>.order-details>.detail-set").find(".change-qty")[current];
        $(target).html("Qty: " + text + ' <i class="fa fa-angle-down" aria-hidden="true"></i>');
        $(e.target).closest("#qty-set").modal("toggle");
        firstCart.updateCart(val, text, current, prod, "qty");
    },
    selectSize: function(e) {
        const val = $(e.target).data("attr");
        const current = $(e.target).data("key");
        if ($(e.target).attr("style") == undefined && $(e.target).hasClass("notchecked") == true) {
            $(e.target).siblings("li").find("span").remove();
            firstCart.$attribute = val;
            $(e.target).html(val + '<span> <i class="fa fa-check" aria-hidden="true"></i></span>');
            var target1 = this.$cart_module.find(".item-check-show>.order-details>.detail-set").find(".change-size")[current];
            var target2 = this.$cart_module.find(".item-check-show>.order-details>.detail-set").find(".change-qty")[current];
            $(target1).html("size: " + val + ' <i class="fa fa-angle-down" aria-hidden="true"></i>');
            $(target1).data("attr", $(e.target).data("attr"));
            $(target2).data("attr", $(e.target).data("attr"));

            $(e.target).closest("#size-set").modal("toggle");
            var qty = $(target2).text().toString();
            this.updateCart($(e.target).data("attr"), qty.replace(/^\D+/g, ''), current, $(e.target).data("pro"), "size");
        }

    },
    updateCart: function(attr, qty, key, pro, action) {
        $.ajax({
            type: "POST",
            data: {
                attr: attr,
                qty: qty,
                key: key,
                pro: pro,
                action: action
            },
            url: firstCart.$base + "Checkout/updateCartAjax",
            beforeSend: function() {
                $('.load').css({
                    "display": "flex"
                });
            },
            success: function(data) {

                $('.load').css({
                    "display": "none"
                });
                var data = JSON.parse(data);
                var qty = data.qty;
                var s = parseInt(qty) > 1 ? "s" : "";
                firstCart.$cart_module.find(".item-head h3").text("My Shopping Bag ( " + qty + " Item" + s + ")");
                location.reload();
            }
        })

    },
    deleteCart: function(attr, qty, key, pro) {
        $.ajax({
            type: "POST",
            data: {
                attr: attr,
                qty: qty,
                key: key,
                pro: pro
            },
            url: firstCart.$base + "Checkout/updateCartAjax",
            beforeSend: function() {
                $('.load').css({
                    "display": "flex"
                });
            },
            success: function(data) {
                $('.load').css({
                    "display": "none"
                });
            }
        })
    },
    showSizeModal: function(e) {
        const pro = $(e.target).data("pro");
        const prop = $(e.target).data("prop");
        const attrval = $(e.target).data("attr");
        const key = $(e.target).data("key");
        this.$sizeModal.modal("show");
        $.ajax({
            type: "POST",
            url: firstCart.$base + "Checkout/getSize",
            data: {
                pro: pro,
                prop: prop,
                attr: attrval
            },
            beforeSend: function() {

            },
            success: function(data) {
                if (data != null) {
                    var Size = JSON.parse(data);
                    var attr_var = JSON.parse(Size.response);
                    firstCart.$sizeModal.find(".modal-body").html("<ul></ul>");
                    var qty = 0;
                    attr_var.response.map((attr) => {

                        attr.attribute.map((attval) => {
                            qty = attr.qty;
                            if (attrval.toLowerCase() === attval.Size.toLowerCase()) {
                                firstCart.$sizeModal.find(".modal-body ul").append("<li data-pro=" + pro + " data-prop=" + prop + "   data-key=" + key + " data-attr=" + attval.Size + ">" + attval.Size + '<span> <i class="fa fa-check" aria-hidden="true"></i></span> </li>');
                            } else {
                                if (qty > 0) {
                                    firstCart.$sizeModal.find(".modal-body ul").append("<li class='notchecked' data-pro=" + pro + " data-prop=" + prop + "  data-key=" + key + " data-attr=" + attval.Size + ">" + attval.Size + "</li>");
                                } else {
                                    firstCart.$sizeModal.find(".modal-body ul").append("<li style='text-decoration:line-through' data-pro=" + pro + " data-prop=" + prop + " data-key=" + key + " data-attr=" + attval.Size + ">" + attval.Size + "</li>");
                                }
                            }

                        });
                    });
                }

            }
        })
    },
    showQtyModal: function(e) {


        var target = $(e.target);
        if (target.is("i")) {
            target = target.parent(".change-qty");
        }

        const pro = $(target).data("pro");
        const prop = $(target).data("prop");
        const attrval = $(target).data("attr");
        const key = $(target).data("key");

        this.$qtyModal.modal("show");
        $.ajax({
            type: "POST",
            data: {
                pro: pro,
                prop: prop,
                attr: attrval
            },
            url: firstCart.$base + "Checkout/getSize",
            beforeSend: function() {

            },
            success: function(data) {
                var Size = JSON.parse(data);
                var attr_var = JSON.parse(Size.response);
                var max_limit = Size.add_limit;

                var qty = 0;
                attr_var.response.map((attr) => {

                    attr.attribute.map((attval) => {
                        if (attrval.toLowerCase() === attval.Size.toLowerCase()) {
                            qty = attr.qty

                            return false;
                        }
                    });
                });
                if (max_limit != 0) {
                    qty = max_limit;
                }
                firstCart.$qtyModal.find(".modal-body").html("<ul></ul>");
                if (qty > 0) {
                    for ($i = 1; $i <= qty; $i++) {
                        firstCart.$qtyModal.find(".modal-body ul").append("<li data-pro=" + pro + " data-prop=" + prop + "   data-key=" + key + " data-attr=" + attrval + ">" + $i + '</li>');
                    }
                }


            }
        })
    },
    updateView: function(pro, qty) {
        //  console.log(pro, qty);

    },
    showSizeMethod: function(e) {
        var top = $(e.target).position().top + 10;
        $(".add-top-size").css({
            "visibility": "hidden"
        });

        $('.block-active').removeAttr("style");
        $(e.target).parent().parent('.add-wish').show();
        $(e.target).parent().parent().parent().addClass('product-isActive');
        var count = $(e.target).parent().parent('.add-wish-prod').siblings('.add-top-size').find("ul");

        // var count = firstCart.mainDiv.delegate(".row>.mob-col-pad>.show-product-small-bx>.add-top-size>ul").find("li");
        //console.log(firstCart.mainDiv.delegate(".row>.mob-col-pad>.show-product-small-bx>.add-top-size>ul").find("li"));
        this.addToCartByKeyDirect(count);
        return false;
        if (count.length == 1) {

        } else {
            if (firstCart.bindAddtocart == 0) {
                firstCart.mainDiv.delegate(".row>.mob-col-pad>.show-product-small-bx>.add-top-size>ul>li", "click", firstCart.addToCartByKey.bind(this));
                firstCart.bindAddtocart = 1;
            }

            $(e.target).parent().parent().siblings(".add-top-size").css({
                "visibility": "visible",
                "margin-bottom": "0"
            });
            $(e.target).parent().parent().siblings(".block-active").css({
                opacity: 0.5
            });
        }
    },
    showSizeMethodWish: function(e) {

        var base = window.location.origin;

        if (base == 'http://localhost:8080') {
            base = window.origin + "/new-paulsons/";
        } else {
            base = base + "/";
        }
        var target = $(e.target);

        if (target.is("i")) {
            target = target.closest("span");
        }

        $(".add-top-size").css({
            "visibility": "hidden"
        });
        $('.block-active').removeAttr("style");
        target.parent().parent('.add-wish').show();
        target.parent().parent().parent().addClass('product-isActive');

        if (firstCart.bindWishtocart == 0) {

            var count = target.siblings('.add-top-size').find("ul");


            firstCart.addToWishByKey(count);
            return false;
            firstCart.mainDiv.delegate(".row>.mob-col-pad>.show-product-small-bx>.add-top-size>ul>li", "click", firstCart.addToWishByKey.bind(this));
            bindWishtocart = 1;
        }
        target.parent().parent().siblings(".add-top-size").css({
            "visibility": "visible",
            "margin-bottom": "0"
        });
        target.parent().parent().siblings(".block-active").css({
            opacity: 0.5
        });
    },
    addToCartByKeyDirect: function(e) {



        var target = e.find("li:first");


        if (target.is("li")) {
            target = target.find('a');
        }

        var product = target.parent().parent().parent().data("pro");
        var attr = target.parent().data("attr");
        var prop = target.parent().data("prop");




        var target2 = target;

        if (!target.hasClass("off-no")) {

            if (!target.is("img")) {
                var isInCart = "2";
                $.ajax({
                    url: firstCart.$base + "Dashboard/isInCart",
                    type: "POST",
                    async: false,
                    data: {
                        product: product,
                        attr: attr,
                        prop: prop
                    },
                    success: function(data) {
                        // console.log(data);
                        // return false;
                        isInCart = data;

                    }
                });
                if (isInCart == "2") {
                    $.ajax({
                        url: firstCart.$base + "Dashboard/addToCart",
                        type: "POST",
                        data: {
                            product: product,
                            attr: attr,
                            prop: prop
                        },
                        beforeSend: function() {
                            target.css({
                                "background-color": "#afafaf"
                            });
                            firstCart.loader.css({
                                "display": "flex"
                            });
                        },
                        success: function(data) {

                            target.css({
                                "background-color": "#afafaf"
                            });
                            //   target.parent().parent().parent().siblings(".add-wish-prod").hide();
                            firstCart.loader.hide();
                            target.closest(".add-top-size").parent().removeClass("product-isActive");
                            target.closest(".add-top-size").parent().find(".block-active").removeAttr("style");
                            target.closest(".add-top-size").removeAttr("style").fadeOut();
                            firstCart.$card_count.text(data);
                            myAlert("Added to cart", "myalert-warning");
                            isInCart = 2;
                            return false;
                        }
                    });
                } else {
                    myAlert("Added to cart", "myalert-warning");
                    return false;
                }
            }
        }
    },
    addToCartByKey: function(e) {
        var target = $(e.target);
        if (target.is("li")) {
            target = target.find('a');
        }

        var product = target.parent().parent().parent().data("pro");
        var attr = target.parent().data("attr");
        var prop = target.parent().data("prop");




        var target2 = target;

        if (!target.hasClass("off-no")) {

            if (!target.is("img")) {
                var isInCart = "2";
                $.ajax({
                    url: firstCart.$base + "Dashboard/isInCart",
                    type: "POST",
                    async: false,
                    data: {
                        product: product,
                        attr: attr,
                        prop: prop
                    },
                    success: function(data) {
                        isInCart = data;

                    }
                });
                if (isInCart == "2") {
                    $.ajax({
                        url: firstCart.$base + "Dashboard/addToCart",
                        type: "POST",
                        data: {
                            product: product,
                            attr: attr,
                            prop: prop
                        },
                        beforeSend: function() {
                            target.css({
                                "background-color": "#afafaf"
                            });
                            firstCart.loader.css({
                                "display": "flex"
                            });
                        },
                        success: function(data) {
                            // console.log(data);
                            // return false;
                            target.css({
                                "background-color": "#afafaf"
                            });
                            //   target.parent().parent().parent().siblings(".add-wish-prod").hide();

                            firstCart.loader.hide();
                            target.closest(".add-top-size").parent().removeClass("product-isActive");
                            target.closest(".add-top-size").parent().find(".block-active").removeAttr("style");
                            target.closest(".add-top-size").removeAttr("style").fadeOut();
                            firstCart.$card_count.text(data);
                            myAlert("Added to cart", "myalert-warning");
                            return false;
                        }
                    });
                } else {
                    myAlert("Added to cart", "myalert-warning");
                    return false;
                }
            }
        }
    },
    addToWishByKey: function(e) {

        var target = $(e).find("li:first");



        if (target.is("a")) {
            target = target.parent('li');
        }

        var product = target.parent().parent().data("pro");


        var attr = target.data("attr");
        var prop = target.data("prop");

        if (!target.hasClass("off-no")) {
            if (!$(e).is("img")) {
                $.ajax({
                    url: firstCart.$base + "Dashboard/wishlist",
                    type: "POST",
                    data: {
                        product: product,
                        attr: attr,
                        prop: prop
                    },
                    beforeSend: function() {
                        target.css({
                            "background-color": "#afafaf"
                        });
                        firstCart.loader.css({
                            "display": "flex"
                        });
                    },
                    success: function(data) {
                        var data = JSON.parse(data);
                        if (data.status == 0) {
                            window.location.href = data.url;
                        } else {
                            target.css({
                                "background-color": "#afafaf"
                            });
                            //   target.parent().parent().parent().siblings(".add-wish-prod").hide();
                            firstCart.loader.hide();
                            target.closest(".add-top-size").parent().removeClass("product-isActive");
                            target.closest(".add-top-size").parent().find(".block-active").removeAttr("style");
                            myAlert("Added to wishlist", "myalert-warning");
                            location.reload();
                        }


                    }
                });
            }
        }
    }

};
firstCart.init();

const closeEffect = (e) => {
    $(e).closest(".add-top-size").parent().removeClass("product-isActive");
    $(e).closest(".add-top-size").parent().find(".block-active").removeAttr("style");
    $(e).closest(".add-top-size").removeAttr("style").css({
        "visibility": "hidden",
    });
}

function returnProducts(OID) {
    base = window.location.origin;

    // if (base == 'http://146.66.68.148') {
    //     base = window.origin + "/~flightfa/demo/paulsons/";
    // } else {
    //     base = base + "/";
    // }

    if (base == 'http://localhost:8080') {
        base = window.origin + "/new-paulsons/";
    } else {
        base = base + "/";
    }
    $.ajax({
        type: "POST",
        data: {
            order_id: OID
        },
        url: base + "Myaccount/orderReturn",
        success: function(data) {
            $('.my_return').html(data);
        }
    })
}

function returnProductsPrime(OID) {
    base = window.location.origin;

    // if (base == 'http://146.66.68.148') {
    //     base = window.origin + "/~flightfa/demo/paulsons/";
    // } else {
    //     base = base + "/";
    // }

    if (base == 'http://localhost:8080') {
        base = window.origin + "/new-paulsons/";
    } else {
        base = base + "/";
    }
    $.ajax({
        type: "POST",
        data: {
            order_id: OID
        },
        url: base + "Myaccount/orderReturnPrime",
        success: function(data) {
            $('.my_return').html(data);
        }
    })
}

function exchangeProducts(OID) {
    base = window.location.origin;

    // if (base == 'http://146.66.68.148') {
    //     base = window.origin + "/~flightfa/demo/paulsons/";
    // } else {
    //     base = base + "/";
    // }

    if (base == 'http://localhost:8080') {
        base = window.origin + "/new-paulsons/";
    } else {
        base = base + "/";
    }
    $.ajax({
        type: "POST",
        data: {
            order_id: OID
        },
        url: base + "Myaccount/orderExchange",
        success: function(data) {
            $('.my_return').html(data);
        }
    })
}

function reviewProducts(OID, PID) {
    base = window.location.origin;

    if (base == 'http://localhost:8080') {
        base = window.origin + "/new-paulsons/";
    } else {
        base = base + "/";
    }
    $.ajax({
        type: "POST",
        data: {
            order_id: OID,
            PID: PID
        },
        url: base + "Myaccount/orderReview",
        success: function(data) {
            $('.my_return').html(data);
        }
    })
}

function cancelRequest(e) {

    $.post("./cancelPop", { key: $(e).data('key') }).done(function(data) {
        $('.my_cancel').html(data);
    });

}

function addAccountDetails(e) {

    $('#account_details').remove();
    $(e).parent().append(`<div id="account_details" class="form-group"><label for="">Account Details (Account no.,IFSC,Name etc)</label><textarea class="form-control" required name='account_details' rows="3"></textarea></div>`);
}


function selectCOD(e) {

    var wallet = $('#wallet').data('wallet');
    var total = $('#wallet').data('total');
    var grand = parseFloat(total);
    var grandAfterWallet = parseFloat(total) - parseFloat(wallet);
    if ($(e).val() == "cod") {
        $("#wallet_checkbox").prop("checked", false);
        $("#wallet_checkbox").attr("disabled", true);
        var grandAfterWallet = parseFloat(total) - parseFloat($('#delivery-price').data('ship'));

        $(".total-prc").find("span").html("<i class='fa fa-inr'></i> " + grandAfterWallet);
        $("#sub-tot").html("<i class='fa fa-inr'></i> " + grandAfterWallet);
        $('#delivery-price').hide();
        $('#wallet').hide();

    } else if ($(e).val() == "paytm") {
        $("#wallet_checkbox").prop("checked", false);
        $(".total-prc").find("span").html("<i class='fa fa-inr'></i> " + grand);
        $("#sub-tot").html("<i class='fa fa-inr'></i> " + grand);

        $('#wallet').hide();
        $('#delivery-price').show();

    } else if ($(e).val() == "bag") {
        $("#wallet_checkbox").prop("checked", false);
        var grandAfterWallet = parseFloat(total) - parseFloat($('#delivery-price').data('ship'));


        $("#sub-tot").html("<i class='fa fa-inr'></i> " + grandAfterWallet);
        $(".total-prc").find("span").html("<i class='fa fa-inr'></i> " + grandAfterWallet);
        $('#wallet').hide();
        $('#delivery-price').hide();

    } else {
        $("#sub-tot").html("<i class='fa fa-inr'></i> " + grand);
        $(".total-prc").find("span").html("<i class='fa fa-inr'></i> " + grand);

        $('#delivery-price').show();
        $("#wallet_checkbox").prop("checked", false);
        $("#wallet_checkbox").removeAttr("disabled");
        $('#wallet').hide();

    }
}

var base = window.location.origin;

// if (base == 'http://146.66.68.148') {
//         base = window.origin + "/~flightfa/demo/paulsons/";
//     } else {
//         base = base + "/";
//     }

if (base == 'http://localhost:8080') {
    base = window.origin + "/new-paulsons/";
} else {
    base = base + "/";
}

function addTobox(e) {
    var key = $(e).data('key');
    var val = $(e).data('val');

    $.ajax({
        type: 'POST',
        data: {
            key: key,
            val: val
        },
        url: base + "Checkout/addtobox",

        success: function(data) {


            location.reload();
        }
    });
}

function rmvfromBox(e) {
    var key = $(e).data('key');
    var val = $(e).data('val');

    $.ajax({
        type: 'POST',
        data: {
            key: key,
            val: val
        },
        url: base + "Checkout/Removefrombox",

        success: function(data) {
            location.reload();
        }
    });
}

function addinBox(e) {

    shippingCharge = $('.del_ship').find('span').text();
    total = $('.total-prc').find('span').text();
    grandtotal = 0;

    if ($(e).val() == "adb") {
        grandtotal = total - shippingCharge;
        $(".total-prc").find("span").html("<i class='fa fa-inr'></i> " + grandtotal);
        $('.del_ship').hide();
    } else {
        grandtotal = total + shippingCharge;
        $(".total-prc").find("span").html("<i class='fa fa-inr'></i> " + grandtotal);
        $(".del_ship").show();
    }
}

$('.empty-cart').click(function() {
    var user = $(this).data('user');
    $.ajax({
        url: base + "Checkout/emptyFullcart",
        type: "POST",
        data: {
            user: user
        },
        success: function(data) {
            // console.log(data);
            // return false;
            location.reload();
        }
    });
});

function return_Product(OID, oid) { // using static functionality for paulsons
    base = window.location.origin;

    if (base == 'http://localhost:8080') {
        base = window.origin + "/new-paulsons/";
    } else {
        base = base + "/";
    }
    $.ajax({
        type: "POST",
        data: {
            order_id: OID,
            o_id: oid
        },
        url: base + "Myaccount/Returnproduct",
        success: function(data) {
            // console.log(data);
            // return false;
            $(".prod_return").css("color", "red");
            $('#myModal30').modal('show');
        }
    })
}

function exchange_Product(OID, oid) { // using static functionality for paulsons
    base = window.location.origin;

    if (base == 'http://localhost:8080') {
        base = window.origin + "/new-paulsons/";
    } else {
        base = base + "/";
    }
    $.ajax({
        type: "POST",
        data: {
            order_id: OID,
            o_id: oid
        },
        url: base + "Myaccount/Exchangeproduct",
        success: function(data) {
            // console.log(data);
            // return false;
            $(".prod_exch").css("color", "red");
            $('#myModal31').modal('show');
        }
    })
}

$('.close').click(function() {
    location.reload();
});

$('.empty-cart').click(function() {
    var user = $(this).data('user');
    $.ajax({
        url: base + "Checkout/emptyFullcart",
        type: "POST",
        data: {
            user: user
        },
        success: function(data) {
            // console.log(data);
            // return false;
            location.reload();
        }
    });
});


// $('.more_best').click(function() {
//     var base_url = 'http://localhost:8080/new-paulsons/';
//     var img_url = 'http://localhost:8080/new-paulsons/uploads/original/';
//     $.ajax({
//         url: base_url + "Dashboard/getAlltrending/",
//         type: "POST",
//         success: function(data) {

//             var result = JSON.parse(data);
//             var prod = result.prod;
//             var img = result.img;
//             // console.log(img);
//             // return false;
//             var images = "";
//             var master_res = "";

//             ar = $.map(img, function(n, i) {
//                 images += `<img alt="IMG-BENNER" class="lazy" data-src="` + img_url + n + `">`;
//             });

//             arr = $.map(prod, function(n, i) {

//                 master_res += `<div class="image-bt">
//                                     <div class="img-section">
//                                         ${images}
//                                     </div>
//                                     <button onclick="window.location.href='<?=base_url()?>product/<?=$sub_name?>/<?=$pro_name?>/<?=encode($this->encryption->encrypt($val->PID))?>'">SHOP NOW</button>
//                                 </div>
//                                 <div class="pro-price-details"><h2><?= $val->pro_name?></h2 >
//                                     <span class="pss-rate">Rs <?=$val->dis_price?>/- </span>
//                                     <span style='<?=((float) $val->act_price == (float)$val->dis_price) ? "display:none" : ""?>' class="mrp-rate">Rs <?=$val->act_price?>/-</span>
//                                 </div>`;
//             });

//             $('.pro-block').html(`<br>${master_res}`);

//         }
//     });
// });