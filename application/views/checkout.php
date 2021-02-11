<div class="check-out-page">
    <div class="container">
        <div class="check-out-page-in">
            <div class="col-sm-7 check-form">
                <h3>
                    Contact Information
                </h3>
                <ul class="text-danger">
                    <?= validation_errors(); ?>
                </ul>
                <?= form_open('Myaccount/checkout') ?>
                <div class="row">
                    <div class="col-sm-12 ">
                        <div class="form-group required">
                            <span>* Email</span>
                            <input type="text" value="<?= set_value('user_email', $this->session->userdata('myaccount')) ?>" name="user_email" autocomplete="off" class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class=" col-sm-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" autocomplete="off" class="custom-control-input" id="defaultUnchecked">
                            <label class="custom-control-label" for="defaultUnchecked"> Get info on new arrivals and exclusive offers.</label>
                        </div>
                    </div>
                </div>
                <h4> Shipping address </h4>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group required">
                            <span>* First Name</span>
                            <input type="text" autocomplete="off" value="<?= set_value('first_name', explode(' ', $profile->user_name)[0]) ?>" name="first_name" class="form-control" placeholder="First Name">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group required">
                            <span>* Last Name</span>
                            <input type="text" autocomplete="off" value="<?= isset(explode(' ', $profile->user_name)[1]) ? set_value('last_name', explode(' ', $profile->user_name)[1]) : "" ?>" name="last_name" class="form-control" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group required">
                            <span>*Shipping Address</span>
                            <input type="text" autocomplete="off" name="user_address" value="<?= set_value('user_address'); ?>" class="form-control" placeholder="Shipping Address">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group required">
                            <span>* Country</span>
                            <select name="country" class="form-control">
                                <option value="India">India</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="form-group required">
                            <span>* State</span>
                            <select name="state" required="" class="form-control">
                                <option value="">Select State</option>
                                <?php
                                foreach ($state as $key => $value) {
                                    $stateName = strtoupper($value->StateName);
                                    echo "<option   value='$stateName'>$stateName</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group required">
                            <span>* Pin Code</span>
                            <input type="text" name="user_pin_code" value="<?= set_value('user_pin_code'); ?>" class="form-control" maxlength="6" minlength="5" placeholder="Pin Code">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group required">
                            <span>* City</span>
                            <input type="text" autocomplete="off" name="user_city" <?= set_value('user_city'); ?> class="form-control" placeholder="City">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group required mob">
                            <label class="pull-left">+91</label>
                            <div class="inp pull-right">
                                <span>* Contact Number</span>
                                <input type="text" value="<?= set_value("user_contact", $profile->user_contact) ?>" name="user_contact" class="form-control" placeholder="Contact Number"></div>

                        </div>
                    </div>
                    <div class=" col-sm-12">

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="defaultUnchecked2">
                            <label class="custom-control-label" for="defaultUnchecked2"> Save this information for next time</label>
                        </div>
                    </div>
                    <div class=" col-sm-12">
                        <button type="submit">Continue to payment Method</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-5 pull-right ">
                <div class="side-cart">
                    <h2>Cart</h2>
                    <?php
                    $revet = 0.0;
                    $tot = 0.0;
                    $ss = $this->session->userdata('addToCart');
                    foreach ($ss as $key => $cart) {
                    ?>
                        <div class="cart-info">
                            <span class="cart-img"> <img src="<?= base_url('uploads/original/') ?><?= getProductImage($cart['product']); ?>"></span>
                            <span class="cart-name"> <?= getProduct($cart['product'])->pro_name ?>
                                <?php
                                $properties = json_decode($cart["prop"]);
                                if ($properties->attribute != NULL) {
                                    foreach ($properties->attribute as $attr) {
                                        $Pkey = key((array) $attr);
                                        echo "<br><b>(" . $Pkey . "= " . $attr->$Pkey . ")</b>";
                                    }
                                }
                                ?>
                            </span>
                            <?php
                            $amt = $cart['qty'] * $cart['total'];
                            $tot = $tot + ($cart['qty'] * $cart['total']);
                            ?>
                            <span class="cart-price">INR <?= $cart['total'] ?> x <?= $cart['qty'] ?></span>
                        </div>
                    <?php } ?>
                    <div class="sub-total">
                        <?php
                        $shipping_charge = $tot > 275 ? 0.0 : 65;
                        ?>
                        <ul>
                            <li>Subtotal
                                <span> INR <?= $tot ?></span>
                            </li>
                            <li>Shipping
                                <span>INR <?= $shipping_charge ?></span>
                            </li>
                            <li>Offers
                                <span><?php
                                        if ($checkoutUser != 1) {
                                            echo '40% off';
                                            $revet = round($tot * 40 / 100);
                                        } else {

                                            echo ' Not Available';
                                        }
                                        ?></span>
                            </li>
                        </ul>

                    </div>
                    <div class="total">
                        Total
                        <span>INR <?= $tot + $shipping_charge - $revet ?></span>
                    </div>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>

</div>