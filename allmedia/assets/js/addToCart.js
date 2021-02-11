(function() {

    var addToCart = {
        init: function() {
            this.cacheDom();
            this.bindEvents();
            this.updateCardCount();
        },
        updateCardCount: function() {

            this.$base = window.location.origin;

            // if (this.$base == 'http://146.66.68.148') {
            //     this.$base = window.origin + "/~flightfa/demo/karzanddolls/";
            // } else {
            //     this.$base = this.$base + "/";
            // }

            if (this.$base == 'http://localhost:8080') {
                this.$base = this.$base + "/new-paulsons/";
            } else {
                this.$base = this.$base + "/";
            }



        },
        cacheDom: function() {
            // this.create_account = $("#create_account"); 
            this.mobNavClose = $(".mob-nav-close");
            this.mobsearch = $(".search-mob-icon");
            this.addToCart = $(".cart-btn");
            this.wishToCart = $(".wish-btn");
            this.wshCart = $(".wsh-btn"); // in cart page
            this.addSize = $(".pro-size-detail");
            this.locator = $("#locator");
            this.addOwnSize = this.addSize.find("li>a");
            this.btnDiv = $('.btn-addcart-product-detail');
            this.btn = this.btnDiv.find('button');
            this.$all_option = $('#all_option');
            this.$searchBox = $('#searchProduct');
            this.$searchBox1 = $('#searchProduct1');
            this.$price = $('.price_class');
            this.$zip_address = $("#zip_address");
            this.$placeFinalOrder = $('.final-ord');
            this.$user_pin_code = $('input[name="user_pin_code"]');
            this.$selecttion = $('.selection-2');
            this.$card_count = $('.header-icons-noti');
            this.$cartUpdate = $('#cartUpdate');
            this.$cartIcon = $('.header-wrapicon2');
            this.$checkAvail = $('#checkAvail');
            this.mobileLatestFilter = $("#latest");
            this.$firstCategory = $('#firstCategory');
            this.$shopping = $('.table-shopping-cart');
            this.$changeQty = $('.table-row');
            // Address Edit Remove
            this.$address = $('.edit-address');
            this.$addressModal = $('#add-address');
            this.json = {};

            this.$base = window.location.origin;

            // if (this.$base == 'http://146.66.68.148') {
            //     this.$base = window.origin + "/~flightfa/demo/karzanddolls/";
            // } else {
            //     this.$base = this.$base + "/";
            // }

            if (this.$base == 'http://localhost:8080') {
                this.$base = this.$base + "/new-paulsons/";
            } else {
                this.$base = this.$base + "/";
            }


        },
        addOwnSizeKey: function(e) {
            $(".chooseOwnSize").hide();
            if (!$(e.target).hasClass('off-no')) {
                if ($(e.target).parent().find(".lazy").length === 1) {
                    $(e.target).removeClass('my-active');
                    $(e.target).parent().find(".my-active").removeClass("my-active");
                } else {
                    var attr = $(e.target).parent().data("attr");
                    $(e.target).parent().siblings("li").find("a").removeClass("my-active");
                    $(e.target).addClass('my-active');
                }
            }

        },
        myAddToCart: function(e) {

            if (!$(e.target).hasClass("off-no")) {

                if ($(e.target).parent().parent().children().find('.my-active').length === 1) {
                    var prop = $(e.target).parent().parent().children().find('.my-active').parent().data("prop");
                    var attr = $(e.target).parent().parent().children().find('.my-active').parent().data("attr");
                    var product = $(e.target).parent().parent().children().find('.my-active').parent().parent().parent().data("pro");


                    var isInCart = "2";
                    $.ajax({
                        url: addToCart.$base + "Dashboard/isInCart",
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

                            url: addToCart.$base + "Dashboard/addToCart",
                            type: "POST",
                            data: {
                                product: product,
                                attr: attr,
                                prop: prop
                            },
                            success: function(data) {
                                myAlert("Added to cart", "myalert-warning");
                                addToCart.$card_count.text(data);
                            }
                        });
                    } else {
                        myAlert("Added to cart", "myalert-warning");
                        addToCart.$card_count.text(data);
                        return false;
                    }

                } else {

                    $('.chooseOwnSize').html('<h6>Please select a size</h6>');
                }
            } else {

                $('.chooseOwnSize').html('<h6>Please select a size</h6>');
            }
        },
        wishToCartFunctionCheck: function(e) {


            var prop = $(e.target).data("prop");
            var attr = $(e.target).data("attr");
            var product = $(e.target).data("pro");
            $.ajax({
                url: addToCart.$base + "Dashboard/wishlist",
                type: "POST",
                data: {
                    product: product,
                    attr: attr,
                    prop: prop
                },
                success: function(data) {
                    // alert(data);
                    location.reload();
                }
            });


        },

        wishToCartFunction: function(e) {

            if ($(e.target).closest(".pro-addcart-detail").parent().find('.my-active:first').length === 1) {
                var prop = $(e.target).closest(".pro-addcart-detail").parent().find('.my-active').parent().data("prop");
                var attr = $(e.target).closest(".pro-addcart-detail").parent().find('.my-active').parent().data("attr");
                var product = $(e.target).closest(".pro-addcart-detail").parent().find('.my-active').parent().parent().parent().data("pro");

                $.ajax({
                    url: addToCart.$base + "Dashboard/Wish_list",
                    type: "POST",
                    data: {
                        product: product,
                        attr: attr,
                        prop: prop
                    },
                    success: function(data) {

                        var data = JSON.parse(data);
                        if (data.status == 0) {
                            window.location.href = data.url;
                        } else {
                            myAlert("Added to wishlist", "myalert-warning");
                            location.reload();
                        }

                    }
                });

            } else {
                $('.chooseOwnSize').html('<h6>Please select a size</h6>');

            }
        },
        showCartDetails: function(e) {

            window.location.href = addToCart.$base + "Checkout?Step=checkout";
        },
        // showCartDetails: function(e) {
        //     var target = ".header-icon1";

        //     $(target).siblings('.header-dropdown').toggleClass('show-header-dropdown');
        //     if ($(target).siblings('.header-dropdown').hasClass('show-header-dropdown')) {
        //         $.ajax({
        //             url: addToCart.$base + "Dashboard/getCardDetails",
        //             type: 'POST',
        //             beforeSend: function(xhr) {
        //                 $(target).siblings('.header-dropdown').text('loading..');
        //             },
        //             success: function(data, textStatus, jqXHR) {
        //                 $(target).siblings('.header-dropdown').html(data);
        //             }
        //         });
        //     }
        // },
        bindEvents: function() {
            // this.create_account.on("click", this.my_create_account.bind(this));
            this.mobsearch.on("click", this.onMobSearch.bind(this));
            this.mobNavClose.on("click", this.mobileNavClose.bind(this));
            this.addToCart.on("click", this.myAddToCart.bind(this));
            this.wishToCart.on("click", this.wishToCartFunction.bind(this));
            this.wshCart.on("click", this.wishToCartFunctionCheck.bind(this));
            this.addOwnSize.on("click", this.addOwnSizeKey.bind(this));
            this.btn.on('click', this.addToCartEvent.bind(this));
            this.mobileLatestFilter.on("click", this.sortByLatest.bind(this));
            this.$shopping.find('.table-row').delegate("#select_option", 'change', this.changeQtySubmit.bind(this));
            this.$cartIcon.on('click', this.showCartDetails.bind(this));
            this.$cartIcon.children().on('click', this.showCartDetails.bind(this));
            this.$checkAvail.on("click", this.checkAvail.bind(this));
            this.$user_pin_code.on("keyup", this.checkPinCode.bind(this));
            this.$searchBox.on("click", this.onFocusSearch.bind(this));


            this.$searchBox.on("keyup", this.loadProducts.bind(this));

            this.$searchBox1.on("click", this.onFocusSearch.bind(this));
            this.$searchBox1.on("keyup", this.loadProducts.bind(this));
            this.locator.on("keyup", this.loadStore.bind(this));
            this.$address.find(".remove-edit").delegate("button:nth-child(1)", "click", this.removeAddress.bind(this));
            this.$address.find(".remove-edit").delegate("button:nth-child(2)", "click", this.editAddress.bind(this));

            //            this.$shopping.find('.column-6 i').on('click', this.trashItem.bind(this));

        },
        mobileNavClose: function(e) {
            $(e.target).parent().parent().removeClass("navbar-collapse in");
            $(e.target).parent().parent().addClass("navbar-collapse collapse")
                // console.log($(e.target).parent().parent().addClass("navbar-collapse collapse"));
        },
        sortByLatest: function(e) {

        },
        // my_create_account :function(e){
        //     if($("#prime"). prop("checked") == true){
        //         alert("checked");
        //     }else{
        //         alert("unchecked");
        //     }
        // },
        removeAddress: function(e) {
            if (confirm('Are you sure ?')) {
                var data = $(e.target).data("id");
                $.ajax({
                    type: "POST",
                    data: {
                        data: data
                    },
                    url: "./dUA",
                    success: function(data) {


                        $(e.target).parent().parent().remove();
                        location.reload();
                    }
                })

            } else {


                location.reload();
            }

        },
        editAddress: function(e) {

            e.preventDefault();
            var data = $(e.target).data("id");
            var id = data;
            this.$addressModal.modal().show();
            $.ajax({
                url: addToCart.$base + "./Dashboard/getAddressList",
                type: 'POST',
                data: {
                    data: data
                },
                success: function(data, textStatus, jqXHR) {
                    data = JSON.parse(data);


                    addToCart.$addressModal.find("input[name='fname']").val(data.firstname);
                    addToCart.$addressModal.find("input[name='lname']").val(data.lastname);
                    addToCart.$addressModal.find("input[name='phone']").val(data.phone);
                    addToCart.$addressModal.find("input[name='pincode']").val(data.pin_code);
                    addToCart.$addressModal.find("input[name='address']").val(data.address);
                    addToCart.$addressModal.find("input[name='locality']").val(data.locality);
                    addToCart.$addressModal.find("input[name='city']").val(data.city);
                    addToCart.$addressModal.find("input[name='form_id']").remove();
                    addToCart.$addressModal.find("form").append("<input type='hidden' name='form_id' value=" + id + ">");


                    addToCart.$addressModal.find('input:radio[name="address_type"][value=' + data.type + ']').attr('checked', true);

                }
            });
        },

        loadProducts: function(e) {

            if ($(e.target).val().length > 2) {
                $.ajax({
                    url: addToCart.$base + "Dashboard/getProductList",
                    type: 'POST',
                    data: {
                        char: $(e.target).val()
                    },
                    success: function(data, textStatus, jqXHR) {
                        if ($(e.target).val().length > 2) {
                            $(e.target).siblings(".filter_prod").html(data);
                            if (data.search("<li>") != -1) {
                                $('.mob-search-filter').css({
                                    "height": "100vh"
                                });
                            }
                            $(e.target).next("button").next('ul').remove();
                            $(e.target).next("button").after(data);
                        }
                    }
                });

            } else if ($(e.target).val().length == 0) {

                $(e.target).next("button").next('ul').remove();
            }
        },
        onMobSearch: function() {
            $(".mob-search-filter").toggle();
        },
        onFocusSearch: function(e) {
            $(e.target).attr('autocomplete', 'off');

        },
        changeQtySubmit: function(e) {
            this.$cartUpdate.submit();
        },
        addToCartEvent: function(e) {
            var producta = [];
            var productProp = [];
            var qty = $(e.target).parent().prev('div').find('input').val();
            var count = 0;
            this.$selecttion.each(function(i, val) {

                count++;
                if ($(this).val().length > 0 && $(this).val() != '' && $(this).val() != null) {
                    producta.push($(this).val());
                    var key = $(this).data("key");
                    productProp.push({
                        [key]: $(this).val()
                    });
                }
            });

            if (addToCart.$zip_address.val() == '' || addToCart.$zip_address.val() == null) {
                alert("Please enter pin code");
                addToCart.$zip_address.focus();
                return false;
            }
            if (producta.length !== count) {
                alert("Please select all option");
                return false;
            }


            var product = $(e.target).data('bind');
            var ap = parseFloat($(this.$selecttion).parent().parent().parent().data('price'));


            $.ajax({
                url: addToCart.$base + "Dashboard/getQty",
                type: 'POST',
                data: {
                    product: product,
                    data: productProp,
                    qty: qty
                },
                success: function(data, textStatus, jqXHR) {

                    var jsonResponse = JSON.parse(data).response;
                    var jsondata = JSON.stringify(jsonResponse);
                    var last = JSON.parse(data).last;

                    if (jsonResponse.qty == 0) {
                        alert("Out of stock");
                        return false;
                    }
                    if (parseInt(jsonResponse.qty) < parseInt(qty)) {
                        alert("Only " + jsonResponse.qty + " product left ! please modify quantity");
                        return false;
                    }
                    if (parseInt(last) < 0) {
                        alert("This Qty is not available please update quantity!");
                        return false;
                    }

                    // console.log($this.$base);
                    $.ajax({
                        url: addToCart.$base + "Dashboard/addToCart",
                        type: 'POST',
                        async: false,
                        data: {
                            product: product,
                            data: jsondata,
                            qty: qty
                        },

                        success: function(data, textStatus, jqXHR) {

                            addToCart.$card_count.text(data);
                            swal(qty + " " + $(e.target).data('product'), "is added to cart !", "success");

                        }
                    });

                }
            });
        },

        setCartCount: function(length) {
            this.$card_count.text(length);
        },
        loadStore: function(e) {
            if ($(e.target).val() != '' && $(e.target).val() != null) {
                $(".stor-loc").hide();
                $(".stor-loc").filter(function(vas) {
                    var text = $(this).data("text");
                    if (text.indexOf($(e.target).val()) != -1) {


                        return $(this);

                    }

                }).show();

            } else {
                $(".stor-loc").show();
            }
            if (!$('.stor-loc').is(":visible")) {
                // alert("No store found in given zip");
                $("#no-store").text("No store found in given zip");
            }
        },

        changeProperty: function(e) {
            alert();
            var ap = parseFloat($(this.$selecttion).parent().parent().parent().data('price'));
            var total = 0.0;
            this.$selecttion.each(function(i, val) {
                if ($(this).find(":selected").val() !== '') {
                    $.ajax({
                        url: addToCart.$base + "Dashboard/getAttr",
                        type: 'POST',
                        async: false,
                        data: {
                            'red': $(this).find(":selected").val().toString()
                        },
                        success: function(data, textStatus, jqXHR) {

                            total = total + parseFloat(data);
                        }
                    });
                }
            });

            this.$price.text(ap + total);
            return (ap + total);
        },
        checkPinCode: function(e) {
            if ($(e.target).val().length == 6) {
                $.ajax({
                    url: addToCart.$base + "Dashboard/checkAvailability",
                    type: 'POST',
                    async: false,
                    data: {
                        zipAddress: $(e.target).val()
                    },
                    success: function(data, textStatus, jqXHR) {
                        var da = parseInt($.trim(data));
                        if (da > 0) {

                        } else {

                            alert("Delivery is not available in this area");
                            $(e.target).focus();
                            return false;
                        }



                    }
                });
            }
        },
        checkAvail: function(e) {

            $.ajax({
                url: addToCart.$base + "Dashboard/checkAvailability",
                type: 'POST',
                async: false,
                data: {
                    zipAddress: addToCart.$zip_address.val()
                },
                success: function(data, textStatus, jqXHR) {
                    var da = parseInt($.trim(data));
                    if (da > 0) {
                        $(e.target).siblings("p").removeClass("text-danger");
                        $(e.target).siblings("p").removeClass("text-success");
                        $(e.target).siblings("p").addClass("text-success").html('Delivery is available in this area');
                    } else {

                        $(e.target).siblings("p").removeClass("text-danger");
                        $(e.target).siblings("p").removeClass("text-success");
                        $(e.target).siblings("p").addClass("text-danger").html('Delivery is not available in this area');
                    }



                }
            });
        }
    };
    addToCart.init();
})()