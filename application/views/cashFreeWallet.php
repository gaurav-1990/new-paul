

  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Paulsons Payment page</title>
  </head>
  <body>
  <h1 style="text-align: center;">Please wait, do not refresh this page</h1>
  <?php

$tot = 0.0;
 
 
 
$order_id = $orderId;
$amount = $amount;

$redirect_url = $successUrl;
$cancel_url = $cancelUrl;
$language = "EN";

// echo $amount;
$data = (array) $data;

$billing_name = $data['user_name'] . " " . $data['lastname'];
 
 
$billing_tel = $data['user_contact'];
$billing_email = $data['user_email'];
$delivery_name = $data['user_name'] . " " . $data['lastname'];
 
$delivery_tel = $data['user_contact'];
$secretKey = "40c89bee71f13330f0430c1d2c9d307cc38703bd";  // CASHFREE_KEY;
$postData = array(
    "appId" => '65136e68375c7d282aad623e963156',  // CASHFREE_APPID
    "orderId" => $order_id,
    "orderAmount" => $amount,
    "orderCurrency" => "INR",
    "orderNote" => $order_id,
    "customerName" => $delivery_name,
    "customerPhone" => $delivery_tel,
    "customerEmail" => $billing_email,
    "returnUrl" => $successUrl,
    "notifyUrl" => $successUrl,
);
// get secret key from your config
ksort($postData);
  

$signatureData = "";
foreach ($postData as $key => $value) {
    $signatureData .= $key . $value;
}

 
$signature = hash_hmac('sha256', $signatureData, $secretKey, true);
$signature = base64_encode($signature);
 
?>
  <form id="redirectForm" method="post" action="https://www.cashfree.com/checkout/post/submit">
    <input type="hidden" name="appId" value="65136e68375c7d282aad623e963156"/>
    <input type="hidden" name="orderId" value="<?=$order_id?>"/>
    <input type="hidden" name="orderAmount" value="<?=$amount?>"/>
    <input type="hidden" name="orderCurrency" value="INR"/>
    <input type="hidden" name="orderNote" value="<?=$order_id?>"/>
    <input type="hidden" name="customerName" value="<?=$delivery_name?>"/>
    <input type="hidden" name="customerEmail" value="<?=$billing_email?>"/>
    <input type="hidden" name="customerPhone" value="<?=$delivery_tel?>"/>
    <input type="hidden" name="returnUrl" value="<?=$successUrl?>"/>
    <input type="hidden" name="notifyUrl" value="<?=$successUrl?>"/>
    <input type="hidden" name="signature" value="<?=$signature?>"/>
    <input type="submit" style="display:none" value="Pay">
  </form>
  </body>
  </html>
  
  <script>document.getElementById("redirectForm").submit();</script>