 
<?php //error_reporting(0);?>
<html>
    <head>
        <title> Karzanddolls payment gateway</title>
    </head>
    <body>
    <center>

        <?php include('includes/Crypto.php') ?>
        <?php
        
        $tot = 0.0;
        $qty = 0;
        $shipping_charge = 0;
        $ss = $this->session->userdata('addToCart');
        foreach ($ss as $key => $cart) {
            $productdetails = getProduct($cart["product"]);
                
            // $tot = $tot + (round(floatval($productdetails->dis_price) * intval($cart["qty"])));
            $qty += (int) $cart['qty'];
        }
       
        $shipping_charge = ($qty >= 1 && $qty <= 10) ? 150 : (($qty >= 11 && $qty <= 25) ? 300 : ($qty > 25 ? 450 : 0));
        
        $merchant_id = "225171";
        $order_id = $orderId;
        $amount = $amount;
        
        $redirect_url = $successUrl;
        $cancel_url = $cancelUrl;
        $language = "EN";
        
        // echo $amount;
        $data= (array)$data;
        $billing_name = $data['first_name'] . " " . $data['last_name'];
        $billing_address = $data['user_address'];
        $billing_city = $data['user_city'];
        $billing_state = $data['state'];
        $billing_zip = $data['user_pin_code'];
        $billing_country = $data['country'];
        $billing_tel = $data['user_contact'];
        $billing_email = $data['user_email'];
        $delivery_name = $data['first_name'] . " " . $data['last_name'];
        $delivery_address = $data['user_address'];
        $delivery_city = $data['user_city'];
        $delivery_state = $data['state'];
        $delivery_zip = $data['user_pin_code'];
        $delivery_country = $data['country'];
        $delivery_tel = $data['user_contact'];
        $merchant_param1="";
        
        $currency = "INR";
        $merchant_param2="";
        $merchant_param3 ="";
        $merchant_param4="";
        $merchant_param5="";
        $promo_code="";
        $customer_identifier="";

        $working_key = '2278303239916A72ABB47FD268A52B94'; //Shared by CCAVENUES
        $access_code = 'AVCA86GG48AX81ACXA'; //Shared by CCAVENUES

// 
        $merchant_data = 'merchant_id=' . $merchant_id . '&order_id=' . $order_id . '&amount=' . $amount . '&currency=' . $currency . '&redirect_url=' . $redirect_url .
                '&cancel_url=' . $cancel_url . '&language=' . $language . '&billing_name=' . $billing_name . '&billing_address=' . $billing_address .
                '&billing_city=' . $billing_city . '&billing_state=' . $billing_state . '&billing_zip=' . $billing_zip . '&billing_country=' . $billing_country .
                '&billing_tel=' . $billing_tel . '&billing_email=' . $billing_email . '&delivery_name=' . $delivery_name . '&delivery_address=' . $delivery_address .
                '&delivery_city=' . $delivery_city . '&delivery_state=' . $delivery_state . '&delivery_zip=' . $delivery_zip . '&delivery_country=' . $delivery_country .
                '&delivery_tel=' . $delivery_tel . '&merchant_param1=' . $merchant_param1 . '&merchant_param2=' . $merchant_param2 .
                '&merchant_param3=' . $merchant_param3 . '&merchant_param4=' . $merchant_param4 . '&merchant_param5=' . $merchant_param5 . '&promo_code=' . $promo_code .
                '&customer_identifier=' . $customer_identifier;

        $encrypted_data = encrypt($merchant_data, $working_key); // Method for encrypting the data.
        // echo $merchant_data;
        
        ?>
        <form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
            <?php
            echo "<input type=hidden name=command value=$command>";
            echo "<input type=hidden name=encRequest value=$encrypted_data>";
            echo "<input type=hidden name=access_code value=$access_code>";
            ?>
        </form>
    </center>
    <script language='javascript'>document.redirect.submit();</script>
</body>
</html>

