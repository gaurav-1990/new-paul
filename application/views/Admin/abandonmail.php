<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abandon Cart</title>
</head>
<body>
    <p>YOUR SHOPPING CART IS MISSING YOU</p>
    <p>We noticed that you left a few items in your cart. They're not reserved so they could sell out. <br>We've seen it happen before and it's not pretty.<br>Here's a link to quickly get you back so you can complete your purchase: <a href='<?=base_url("Checkout")?>'>Cart</a></p>
    <p>
    <?php
    if($abandon->product!=null){
foreach (json_decode($abandon->product) as $car) {
    $pro = getProduct($car->product);

    ?>  <?=strtolower($pro->pro_name)?> x <?=$car->qty?>
    <br>
     <?php } }?>
    </p>
<h4>Team Paulsons</h4>

</body>
</html>