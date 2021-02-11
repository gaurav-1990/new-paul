<div class="order-check-set">
    <div class="container">
        <div class="order-check-set-in">
            <?php if ($this->session->userdata("addToCart") != null) {
                ?>
                <div class="col-md-9">
                    <?php
                    $qtyval = 0;
                    foreach ($this->session->userdata("addToCart") as $qty) {
                        $qtyval += ($qty["qty"]);
                    }
                    ?>
                    <div class="load">
                        <img src="<?= base_url() ?>bootstrap/images/svg-icons/generator.svg" style="display: block" class="header-icon1" alt="ICON">
                    </div>
                    <div class="order-left ">
                    <div class="order-offer">
                            <h3>Offer</h3>
                            <ul class="show_More2">
                                <li><span>10% Cashback on first ever transaction via FreeCharge. TCA</span></li>              
                            </ul>
                            <ul class="show_More2" style="display:none">
                                <li><span>10% Cashback on first ever transaction via FreeCharge. TCA</span></li>
                                <li><span>10% Cashback on first ever transaction via FreeCharge. TCA</span></li>
                                <li><span>10% Cashback on first ever transaction via FreeCharge. TCA</span></li>
                            </ul>
                            <a href="#" class="show_More">Show More <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                    </div>
                      

<div class="payment-set">
  
    <h2 class="payhead">Choose Payment Mode</h2>

  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Credit/Dabit Card</a></li>
    <li><a data-toggle="tab" href="#menu1">Net banking</a></li>
    <li><a data-toggle="tab" href="#menu2">Cash/Card on Delivery</a></li>
    <li><a data-toggle="tab" href="#menu3">Wallets</a></li>
    <li><a data-toggle="tab" href="#menu4">Gift Card</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane credit-card fade in active">
  
       <div class="head-pay">
            <h3>Credit/Dabit Card</h3>
          
        </div>
      <div class="form-group col-md-12">
    <label for="email">Card Number*</label>
    <input type="email" class="form-control" id="email">
    <span class="card-num"></span>
  </div>
      <div class="form-group col-md-12">
    <label for="email">Name on Card*</label>
    <input type="email" class="form-control" id="email">
  </div>
      <div class="form-group col-md-6">
    <label for="email">Expiry Month*</label>
     <select class="form-control" id="exampleFormControlSelect1">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  </div>
      <div class="form-group col-md-6">
    <label for="email">Expiry Year*</label>
   <select class="form-control" id="exampleFormControlSelect1">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  </div>
       <div class="form-group col-md-3">
    <label for="email">CVV*</label>
    <input type="email" class="form-control" id="email">
  </div>
       <div class="form-group col-md-9">
           <span class="cvv">Last 3 digits printed on the back of the card</span>
   
  </div>
   <div class="form-group col-md-9">
                                       
                                        <label class="check ">Save this card for faster payments
                                            <input checked type="checkbox" value="1" id="default_add" name="default_add">
                                            <span class="checkmark"></span>
                                            <span class="pay-tip"><i class="fa fa-question-circle" aria-hidden="true" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"></i></span> 
                                        </label>
       <div class="collapse info-show" id="collapseExample">
                                             <div class=" info-show-in" >


                                                 <p>
                                                     Save your credit card information with us to make your next purchase quick and easy.
                                                     Your credit card information will be encrypted and is safe with us. We do not store
                                                     CVV number.
                                                 </p>


 

                                             </div>
                                             </div>
                                    </div>
      
      
      <div class="form-group col-md-12"> 
          <button class="pay-btn"> PAY NOW</button>
      </div>

    
    </div>
    <div id="menu1" class="tab-pane credit-card fade">
 
       <div class="head-pay">
            <h3>Net Banking</h3>
          
        </div>
    
   
           <div class="col-md-4">
               <div class="logo-set">
               <div class="im-set">
                   
                   <img data-src="<?= base_url() ?>bootstrap/images/bank/axis.png"  class="lazy"   alt="IMG-BENNER">
               </div>
                   <span class="bank-nm">Axis Bank </span>
               </div>
           </div>
           <div class="col-md-4">
               <div class="logo-set">
                   <div class="im-set">
                   <img data-src="<?= base_url() ?>bootstrap/images/bank/citi.png"  class="lazy"   alt="IMG-BENNER">
                   </div>
                   <span class="bank-nm">Citi Bank </span>
               </div>
           </div>
           <div class="col-md-4">
               <div class="logo-set">
                   <div class="im-set">
                   <img data-src="<?= base_url() ?>bootstrap/images/bank/hdfc.png"  class="lazy"   alt="IMG-BENNER">
                   </div>
                   <span class="bank-nm">HDFC Bank </span>
               </div>
           </div>
           <div class="col-md-4">
               <div class="logo-set">
                   <div class="im-set">
                   <img data-src="<?= base_url() ?>bootstrap/images/bank/icici.png"  class="lazy"   alt="IMG-BENNER">
               </div>
                   <span class="bank-nm">ICICI Bank </span>
               </div>
           </div>
           <div class="col-md-4">
               <div class="logo-set">
                   <div class="im-set">
                   <img data-src="<?= base_url() ?>bootstrap/images/bank/kotak.png"  class="lazy"   alt="IMG-BENNER">
                   </div>
                   <span class="bank-nm">Kotak </span>
               </div>
           </div>
           <div class="col-md-4">
               <div class="logo-set">
                   <div class="im-set">
                   <img data-src="<?= base_url() ?>bootstrap/images/bank/sbi.png"  class="lazy"   alt="IMG-BENNER">
                   </div>
                   <span class="bank-nm">SBI Bank </span>
               </div>
           </div>
       
      
      <div class="form-group col-md-12">
    <label for="email">Expiry Year*</label>
   <select class="form-control" id="exampleFormControlSelect1">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  </div>
      <div class="form-group col-md-12">
          <span class="note" >We will redirect you to your bank website to authorize the payment.</span>
  
  </div>
           
       
      
      <div class="form-group col-md-12"> 
          <button class="pay-btn"> PAY NOW</button>
      </div>
    
    </div>
    <div id="menu2" class="tab-pane credit-card fade">
        <div class="head-pay">
            <h3>Cash/Card on Delivery</h3>
            <p>Pay with Cash or Card when your order is delivered</p>
        </div>
        
         
         <div class="cod-set">
             <h4>Verify Contact Number</h4>
             <p>Please verify the mobile number associated with the delivery address</p>
             <h6>+91 456-789-4561</h6>
         </div>
        <div class="otp-set">
            <h3>Enter OTP</h3>
           <input id="partitioned" type="text" maxlength="4" />
        </div>
        
        <div class="form-group col-md-12"> 
          <button class="pay-btn"> PAY NOW</button>
      </div>
      
    </div>
    <div id="menu3" class="tab-pane credit-card fade">
       
    
           <div class="col-md-4">
               <div class="logo-set">
               <div class="im-set">
                   
                   <img data-src="<?= base_url() ?>bootstrap/images/bank/pay.png"  class="lazy"   alt="IMG-BENNER">
               </div>
                 
               </div>
           </div>
           <div class="col-md-4">
               <div class="logo-set">
                   <div class="im-set">
                   <img data-src="<?= base_url() ?>bootstrap/images/bank/airtel.png"  class="lazy"   alt="IMG-BENNER">
                   </div>
                 
               </div>
           </div>
           <div class="col-md-4">
               <div class="logo-set">
                   <div class="im-set">
                   <img data-src="<?= base_url() ?>bootstrap/images/bank/free.png"  class="lazy"   alt="IMG-BENNER">
                   </div>
               
               </div>
           </div>
           <div class="col-md-4">
               <div class="logo-set">
                   <div class="im-set">
                   <img data-src="<?= base_url() ?>bootstrap/images/bank/payz.png"  class="lazy"   alt="IMG-BENNER">
               </div>
                 
               </div>
           </div>
           <div class="col-md-4">
               <div class="logo-set">
                   <div class="im-set">
                   <img data-src="<?= base_url() ?>bootstrap/images/bank/m.png"  class="lazy"   alt="IMG-BENNER">
                   </div>
                  
               </div>
           </div>
           <div class="form-group col-md-12">
          <span class="note" >We will redirect you to your bank website to authorize the payment.</span>
  
  </div>
            <div class="form-group col-md-12"> 
          <button class="pay-btn"> PAY NOW</button>
      </div>
        
    
    </div>
    <div id="menu4" class="tab-pane credit-card fade">
         <div class="head-pay">
            <h3>ENTER GIFTCARD DETAILS</h3>
         
        </div>
    <div class="page-wrap">


                        <div class="styled-input">
                            <input name="fname" id="fname" value="" type="text" required="">
                            <label>Gift Card Number</label>
                        </div>
                        <div class="styled-input">
                            <input name="lname" id="lname" value="" type="text" required="">
                            <label>Gift Card Pin</label>
                        </div>
    </div>
            <div class="form-group col-md-12"> 
          <button class="pay-btn"> Add to Karzanddolls Card</button>
      </div>
    </div>
  </div>
</div>

                     
                        <?php

                        $total = 0;
                        $MRPtotal = 0;
                        $tax = 0.0;
                        foreach ($this->session->userdata("addToCart") as $key => $cartItem) {
                            $productdetails = getProduct($cartItem["product"]);
                            $proImage = getProductImage($cartItem["product"]);
                            $total += floatval($productdetails->dis_price) * intval($cartItem["qty"]);
                            $MRPtotal += floatval($productdetails->act_price) * intval($cartItem["qty"]);
                            $tax = (floatval($productdetails->dis_price) * intval($cartItem["qty"]) * floatval($productdetails->gst)) / 100;

                            ?>
                         
                                   
                                        <?php
                                        $decrease = floatval($productdetails->act_price) - floatval($productdetails->dis_price);
                                        $percentage = round($decrease / floatval($productdetails->act_price) * 100);
                                        ?>
                               
                        <?php } ?>
                      
                      



                    </div>

                </div>
                <div class="col-md-3">
                    <div class="order-right">
                      

                        <div class="price-detail">
                            <h2>Payment Details</h2>
                            <ul>
                                <li>
                                    <h3>Total MRP</h3>
                                    <span><i class="fa fa-inr" aria-hidden="true"></i> <?= number_format($MRPtotal) ?></span>
                                </li>
                                <li>
                                    <h3>Bag Discount</h3>
                                    <span style="color: #50c792;"><i class="fa fa-inr" aria-hidden="true"></i> <?= number_format($MRPtotal - $total) ?></span>
                                </li>
                                <li>
                                    <h3>Tax</h3>
                                    <span><i class="fa fa-inr" aria-hidden="true"></i> <?= number_format($tax) ?></span>
                                </li>
                                <li>
                                    <h3>Coupon Discont</h3>
                                    <a href="" data-toggle="modal" data-target="#apply-coupon">Apply Coupon</a>
                                </li>
                                <li>
                                    <h3>Delivery</h3>
                                    <span>Free</span>
                                </li>
                            </ul>

                        </div>

                        <div class="total-prc">
                            <h3>Total <span><i class="fa fa-inr" aria-hidden="true"></i> <?= number_format($total) ?></span></h3>
                        </div>
                       
                        <div class="address-change">
                            <h3>Deliver to</h3>
                            <h4>Saurabh (Default)</h4>
                            <p>palam dabri road  D 69<br>
                                mahavir enclave<br>
                                South west delhi <br>
                                110045 New Delhi<br>
                                
                            </p>
                            <p><b>Mobile:</b> +91 9560292954</p>
                            <a href="#">Change Address</a>
                            <span>Office</span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

 

    </div>
</div>
 
    
 
<!-- Modal -->








