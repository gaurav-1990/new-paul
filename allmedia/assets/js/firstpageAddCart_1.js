var click = 0;
$(function() {
    $('.header-clearAllBtn').click(function() {
        $("input:checkbox").prop('checked', false);
    });
    $('.mob-clearBtn').click(function() {
        $("input:checkbox").prop('checked', false);
    });
    var base = window.location.origin;

    // if (base == 'http://146.66.68.148') {
    //     base = window.origin + "/~flightfa/demo/paulsons/";
    // } else {
    //     base = base + "/";
    // }

    if (base == 'http://localhost') {
        base = window.origin + "/paulsons/";
    } else {
        base = base + "/";
    }
    //hang on event of form with id=myform

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

(function() {
    var firstCart = {
        init: function() {
            this.cacheDom();
            this.bindDom();

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
            this.getCoupon = this.myCoupon.find("a");
            this.mainDiv = $('.product-show-right');
            this.removeCoupon = this.myCoupon.find(".remove_coupon");
            this.addToCart = $(".add-cart");
            this.addTopSize = $(".add-top-size");
            this.addSizeBu = this.addTopSize.find("li");
            this.loader = $(".load");
            this.$filterDiv = $('.myfilter');
            this.$card_count = $('.header-icons-noti');
            this.$cart_module = $(".order-left");
            this.$sizeModal = $("#size-set");
            this.$qtyModal = $("#qty-set");
            this.$addMoreWish = $(".add-wish-set");
            this.$removePop = $("#rmv-bag");
            this.$totalPrice = $("#total");
            this.$customCheckbox = $('.custom-checkbox');
            this.$attribute = [];
            this.$total = 0.00;
            this.$placeOrder = $('.palce-ord');
            this.$sidePrice = $(".price-detail");
            this.updateTotalPrice();
            this.$base = window.location.origin;

            // if (this.$base == 'http://146.66.68.148') {
            //     this.$base = window.origin + "/~flightfa/demo/paulsons/";
            // } else {
            //     this.$base = this.$base + "/";
            // }

            if (this.$base == 'http://localhost') {
                this.$base = this.$base + "/paulsons/";
            } else {
                this.$base = this.$base + "/";
            }
        },

        viewSimilarProd: function() {

            var id = $(".view-rlt").find("a").data("prod");
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
        filterAll: function() {

            var selectedFilters = {};
            var allFilters = [];
            firstCart.$checkCounter = 0;
            var $filterCheckboxes = this.$filterDiv.find('input[type="checkbox"]');

            $filterCheckboxes.each(function(i, val) {

                allFilters.push($(val).attr("name"));

            });


            $filterCheckboxes.filter(':checked').each(function(i, val) {
                if (!selectedFilters.hasOwnProperty(this.name)) {
                    selectedFilters[this.name] = [];
                }
                selectedFilters[this.name].push(this.value);
                firstCart.$checkCounter++;

            });


            var myNewArray = allFilters.filter(function(elem, index, self) {
                return index === self.indexOf(elem);
            });
            var $filteredResults = firstCart.mainDiv.find(".row>.mob-col-pad");
            $.each(selectedFilters, function(name, filterValues) {
                $filteredResults = $filteredResults.filter(function() {

                    var matched = false;
                    var currentFilterValues = [];
                    myNewArray.map((val2) => {

                        if ($(this).data(val2) != undefined) {
                            currentFilterValues.push($(this).data(val2).toString());
                        }
                    });

                    $.each(currentFilterValues, function(_, currentFilterValue) {

                        filterValues.map((val) => {
                            if (val.includes("|")) {
                                var arr = val.split("|");

                                if (parseFloat(arr[0]) <= parseFloat(currentFilterValue) && parseFloat(arr[1]) > parseFloat(currentFilterValue)) {
                                    matched = true;
                                    return false;
                                }
                            } else if (val.includes("|") == false) {

                                if ($.inArray(currentFilterValue, filterValues) != -1) {

                                    matched = true;
                                    return false;
                                }
                            }

                        });
                    });
                    return matched;
                });
            });
            //   console.log($filteredResults.length);
            $("#prod_count").text(' - ' + $filteredResults.length + ' ' + 'items');

            $.when(firstCart.mainDiv.find(".row>.mob-col-pad").hide().filter($filteredResults).show());

        },
        bindDom: function() {
            this.loadPrice();
            this.viewSimilar.on("click", this.viewSimilarProd.bind(this));
            this.viewSimilarOnMob.on("click", this.viewSimilarProdMob.bind(this));
            this.inputCoup.on("click", this.inputCoupon.bind(this));
            this.show_More.on("click", this.show_More_disp.bind(this));
            this.$checkCounter = 0;
            this.removeCoupon.on("click", this.removeAllCoupon.bind(this));
            this.removeWish.on("click", this.removeWishProduct.bind(this));
            this.applyCoup.delegate(".best-coupon>a>span:nth-child(2)", "click", this.applyCoupSet.bind(this));
            this.mainDiv.delegate(".row>.mob-col-pad>.show-product-small-bx>.add-wish-prod>span>.add-cart", "click", this.showSizeMethod.bind(this));
            this.mainDiv.delegate(".row>.mob-col-pad>.show-product-small-bx>.add-wish-prod>span>.right-wish", "click", this.showSizeMethodWish.bind(this));
            this.secCoupon.on("click", this.secCouponApply.bind(this));
            this.getCoupon.on("click", this.getAllCoupons.bind(this));
            this.$cart_module.find(".item-check-show>.order-details>.detail-set").delegate(".change-size", "click", this.showSizeModal.bind(this));
            this.$cart_module.find(".item-check-show>.order-details>.detail-set").delegate(".change-qty", "click", this.showQtyModal.bind(this));
            this.$sizeModal.find(".modal-body").delegate("li", "click", this.selectSize.bind(this));
            this.$qtyModal.find(".modal-body").delegate("li", "click", this.selectQty.bind(this));
            this.$cart_module.find(".item-check-show>.order-details>.remove-set").delegate("button.rmv-btn", "click", this.deleteItem.bind(this));
            this.$placeOrder.on("click", this.goToAddressPage.bind(this));
            this.$customCheckbox.find(".custom-control-input").on("click", this.filterAll.bind(this));
        },
        removeWishProduct: function(e) {
            var id = $(e.target).parent().data("id");
            var prop = $(e.target).parent().data("prop");
            var attr = $(e.target).parent().data("attr");
            var target = $(e.target);

            $.ajax({
                type: "POST",
                data: {
                    id: id,
                    prop: prop,
                    attr: attr
                },
                url: firstCart.$base + "Wish_list/remove",
                success: function(data) {
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

            var first = 0;
            var second = 0;
            var third = 0;
            var fourth = 0;
            var fifth = 0;
            var six = 0;

            this.mainDiv.find(".mob-col-pad").each((i, val) => {

                var price = parseFloat($(val).data("price"));
                if (price >= 199 && price <= 499) {
                    first++;
                } else if (price >= 500 && price < 1000) {
                    second++;
                } else if (price >= 1000 && price < 1500) {
                    third++;
                } else if (price >= 1500 && price < 2000) {
                    fourth++;
                } else if (price >= 2000 && price < 2599) {
                    fifth++;
                } else if (price >= 15000 && price <= 25000) {
                    six++;
                }
            });

            if (first == 0) {
                $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[0]).remove();
            }
            if (second == 0) {
                $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[1]).hide();
            }
            if (third == 0) {
                $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[2]).hide();
            }
            if (fourth == 0) {
                $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[3]).hide();
            }
            if (fifth == 0) {
                $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[4]).hide();
            }
            if (six == 0) {
                $(this.$filterDiv.find("div:nth-child(2)").find(".custom-checkbox")[5]).hide();
            }


            $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[0]).find("small").text("(" + first + ")")
            $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[1]).find("small").text("(" + second + ")")
            $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[2]).find("small").text("(" + third + ")")
            $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[3]).find("small").text("(" + fourth + ")")
            $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[4]).find("small").text("(" + fifth + ")")
            $(this.$filterDiv.find("div:nth-child(1)").find(".custom-checkbox")[5]).find("small").text("(" + six + ")")

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
                $('.coupon_error').html("<h5 style='text-align:center ; color: #f9108d;'>Please Entered the valid coupon code ! </h5>");
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
                    console.log(data);
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
            firstCart.updateCart(val, text, current);
        },
        selectSize: function(e) {
            const val = $(e.target).data("attr");
            const current = $(e.target).data("key");
            if ($(e.target).attr("style") == undefined) {
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
                this.updateCart($(e.target).data("attr"), qty.replace(/^\D+/g, ''), current);
            }

        },
        updateCart: function(attr, qty, key) {
            $.ajax({
                type: "POST",
                data: {
                    attr: attr,
                    qty: qty,
                    key: key
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
                    var subtotal = data.prices[key].dis_price * data.prices[key].qty;
                    var grandtotal = data.prices[key].act_price * data.prices[key].qty;
                    firstCart.$cart_module.find(".item-check-show>.order-details[data-key=" + key + "]").find(".real-price").html("<i class='fa fa-inr'></i> " + subtotal);
                    firstCart.$cart_module.find(".item-check-show>.order-details[data-key=" + key + "]").find(".cut-price").html("<i class='fa fa-inr'></i> " + grandtotal);
                    firstCart.$totalPrice.text(data.dis_price);
                    firstCart.$sidePrice.find("ul>li:nth-child(1)").find("span").html("<i class='fa fa-inr'></i> " + (data.act_price).toLocaleString());
                    firstCart.$sidePrice.find("ul>li:nth-child(2)").find("span").html("<i class='fa fa-inr'></i> " + (data.act_price - data.dis_price).toLocaleString());
                    firstCart.$sidePrice.find("ul>li:nth-child(3)").find("span").html("<i class='fa fa-inr'></i> " + (data.tax).toLocaleString());
                    firstCart.$sidePrice.find("ul>li:nth-child(5)").find("span").html("<i class='fa fa-inr'></i> " + (data.shipping).toLocaleString());
                    firstCart.$sidePrice.siblings(".total-prc").find("span").html("<i class='fa fa-inr'></i> " + (data.dis_price + data.shipping).toLocaleString());
                    location.reload();
                }
            })

        },

        deleteCart: function(attr, qty, key) {
            $.ajax({
                type: "POST",
                data: {
                    attr: attr,
                    qty: qty,
                    key: key
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
                        const Size = JSON.parse(data);
                        firstCart.$sizeModal.find(".modal-body").html("<ul></ul>");
                        var qty = 0;
                        Size.response.map((attr) => {

                            attr.attribute.map((attval) => {
                                qty = attr.qty;
                                if (attrval === attval.Size) {
                                    firstCart.$sizeModal.find(".modal-body ul").append("<li data-pro=" + pro + " data-prop=" + prop + "   data-key=" + key + " data-attr=" + attval.Size + ">" + attval.Size + '<span> <i class="fa fa-check" aria-hidden="true"></i></span> </li>');
                                } else {
                                    if (qty > 0) {
                                        firstCart.$sizeModal.find(".modal-body ul").append("<li data-pro=" + pro + " data-prop=" + prop + "  data-key=" + key + " data-attr=" + attval.Size + ">" + attval.Size + "</li>");
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


            const pro = $(e.target).data("pro");
            const prop = $(e.target).data("prop");
            const attrval = $(e.target).data("attr");

            const key = $(e.target).data("key");

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
                    const Size = JSON.parse(data);
                    var qty = 0;
                    Size.response.map((attr) => {

                        attr.attribute.map((attval) => {
                            if (attrval === attval.Size) {
                                qty = attr.qty

                                return false;
                            }
                        });

                    });

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
        },
        showSizeMethodWish: function(e) {

            var base = window.location.origin;

            // if (base == 'http://146.66.68.148') {
            //     base = window.origin + "/~flightfa/demo/paulsons/";
            // } else {
            //     base = base + "/";
            // }

            if (base == 'http://localhost') {
                base = window.origin + "/paulsons/";
            } else {
                base = base + "/";
            }
            $.ajax({
                type: 'POST',
                url: base + "Myaccount/previousUrl",
                success: function(data) {
                    console.log(data);
                }
            });

            $(".add-top-size").css({
                "visibility": "hidden"
            });
            $('.block-active').removeAttr("style");
            $(e.target).parent().parent('.add-wish').show();
            $(e.target).parent().parent().parent().addClass('product-isActive');
            if (firstCart.bindWishtocart == 0) {
                firstCart.mainDiv.delegate(".row>.mob-col-pad>.show-product-small-bx>.add-top-size>ul>li", "click", firstCart.addToWishByKey.bind(this));
                bindWishtocart = 1;
            }
            $(e.target).parent().parent().siblings(".add-top-size").css({
                "visibility": "visible",
                "margin-bottom": "0"
            });

            $(e.target).parent().parent().siblings(".block-active").css({
                opacity: 0.5
            });
        },

        addToCartByKey: function(e) {
            var prop = $(e.target).parent().data("prop");
            var attr = $(e.target).parent().data("attr");
            var product = $(e.target).parent().parent().parent().data("pro");
            var target = $(e.target);
            var target2 = $(e);
            if (!target.hasClass("off-no")) {
                if (!$(e.target).is("img")) {
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

                            return false;

                        }
                    });
                }
            }
        },

        addToWishByKey: function(e) {

            var prop = $(e.target).parent().data("prop");
            var attr = $(e.target).parent().data("attr");

            var product = $(e.target).parent().parent().parent().data("pro");
            var target = $(e.target);
            if (!target.hasClass("off-no")) {
                if (!$(e.target).is("img")) {
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

                            target.css({
                                "background-color": "#afafaf"
                            });
                            //   target.parent().parent().parent().siblings(".add-wish-prod").hide();
                            firstCart.loader.hide();


                            target.closest(".add-top-size").parent().removeClass("product-isActive");
                            target.closest(".add-top-size").parent().find(".block-active").removeAttr("style");

                            myAlert(data, "myalert-warning");
                            return false;
                        }
                    });
                }
            }
        }

    }
    firstCart.init();
})();

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

    if (base == 'http://localhost') {
        base = window.origin + "/paulsons/";
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

function exchangeProducts(OID) {
    base = window.location.origin;

    // if (base == 'http://146.66.68.148') {
    //     base = window.origin + "/~flightfa/demo/paulsons/";
    // } else {
    //     base = base + "/";
    // }

    if (base == 'http://localhost') {
        base = window.origin + "/paulsons/";
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

function reviewProducts(OID) {
    base = window.origin
        // if (base == 'http://146.66.68.148') {
        //     base = window.origin + "/~flightfa/demo/karzaanddolls/";
        // } else {
        //     base = base + "/";
        // }

    if (base == 'http://localhost') {
        base = window.origin + "/paulsons/";
    } else {
        base = base + "/";
    }
    $.ajax({
        type: "POST",
        data: {
            order_id: OID
        },
        url: base + "Myaccount/orderReview",
        success: function(data) {
            $('.my_return').html(data);
        }
    })
}

function cancelRequest(e) {
    $('#cancelForm').find("input[type='hidden']").remove();
    $('#cancelForm').append($('<input />', { type: 'hidden', name: 'data', class: '', value: $(e).data("key") }));

}