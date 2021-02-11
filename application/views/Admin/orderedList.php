<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Order Details PAUL/2020-21/<?= $data[0]->order_id ?></title>
    <style type="text/css">
        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }

            table {
                width: 100%;
            }

            table {
                border: 1px solid #777777 !important;

            }

            th {

                background-color: #337ab7 !important;
                font-weight: bold;
                font-size: 11px;
                color: #fff !important;
                -webkit-print-color-adjust: exact;
            }

            td {


                font-size: 11px;

            }

            .text-info {
                color: #337ab7 !important;
            }

            h5 {
                font-size: 12px;
                font-weight: bold;
            }

            .btn {
                display: none;
            }

            @page {
                size: auto;
                /* auto is the initial value */
                margin: 0;
                /* this affects the margin in the printer settings */
            }

            body {
                margin: 1.2cm;

            }

            h5,
            p,
            b {
                margin: 0px;
            }

        }

        h5,
        p,
        b {
            margin: 0px;
        }
    </style>
</head>

<body style="font-family: Roboto, 'Segoe UI', Tahoma, sans-serif;font-size: 14px;">
    <?php

    $invoice_date = date("Y", strtotime($data[0]->pay_date)) . "-" . date('y', strtotime('+ 1 year', strtotime($data[0]->pay_date)));
    if ((date("Y", strtotime($data[0]->pay_date))) == date("Y") && intval(date("m", strtotime($data[0]->pay_date))) < 5) {
        $invoice_date = date('y', strtotime('-1 year', strtotime($data[0]->pay_date))) . "-" . date("Y", strtotime($data[0]->pay_date));
    }
    ?>
    <table width="80%" style="margin:0 auto; ">
        <tr>
            <th colspan="8" style="text-align: center">
                <h3> Order details</h3>
            </th>
        </tr>
        <tr>
            <td colspan="4">
                <h5> Sold By: <?= $data[0]->company ?>,
                    <b> Ship-From: </b> <?= $this->security->xss_clean($data[0]->ship_address) ?>, <?= $data[0]->city ?>, <?= $data[0]->ven_state ?>, <?= $data[0]->zip ?> <br /> <b>Vendor Contact Number</b>
                    <!-- <?= $data[0]->contactno ?> -->
                    </i>
                </h5>
            </td>

            <td colspan="4" style="text-align: right;padding-right: 8px;"> <span style="border: 1px dashed #777;padding: 3px;">Order Number: PAUL/<?= $invoice_date ?>/<?= $data[0]->order_id ?></span> </td>
        </tr>




        <tr>
            <td style="font-size: 14px" colspan="2"> <b>Order ID: 0000<?= $data[0]->order_id ?></b> </td>
            <td colspan=""> </td>

            <!-- <td style="font-size: 14px;text-align: right" colspan="2"> <b>Bill To</b></td>
            <td style="font-size: 14px;text-align: right" colspan="2"> <b>Ship To</b> </td>
            <td style="font-size: 12px" colspan=""> &nbsp;</td> -->

        </tr>
        <tr>
            <td style="font-size: 13px" colspan="2"> <b>Order Date: <?= date("d-m-Y", strtotime($data[0]->pay_date)); ?></b> </td>
            <td colspan=""> </td>


            <!-- <td style="font-size: 14px;text-align: right" colspan="2"> <b><?= ucfirst($data[0]->first_name) ?> <?= ucfirst($data[0]->last_name) ?></b> (<?= $data[0]->user_email ?>)</td>
            <td style="font-size: 14px;text-align: right" colspan="2"> <b> <?= ucfirst($data[0]->first_name) ?> <?= ucfirst($data[0]->last_name) ?></b> (<?= $data[0]->user_email ?>) </td>
            <td style="font-size: 11px;text-align: right" colspan=""> </td> -->

        </tr>



        <tr>
            <td style="font-size: 13px" colspan="2"> </td>
            <td colspan=""> </td>

            <!-- <td style="font-size: 14px;text-align: right" colspan="2"> <?= ucfirst($data[0]->user_address) ?>, <?= ucfirst($data[0]->user_city) ?>, <?= ucfirst($data[0]->user_pin_code) ?>, </td>
            <td style="font-size: 14px;text-align: right" colspan="2"> <?= ucfirst($data[0]->user_address) ?>, <?= ucfirst($data[0]->user_city) ?>, <?= ucfirst($data[0]->user_pin_code) ?>, </td>
            <td style="font-size: 11px;text-align: right" colspan=""> </td> -->

        </tr>
        <tr>
            <!-- <td style="font-size: 13px" colspan="2"><b>GSTIN -</b> <?= $data[0]->gst ?> </td>
            <td colspan=""> </td> -->
            <!-- <td style="font-size: 14px;text-align: right" colspan="2"> <?= ucfirst($data[0]->cus_state) ?>, <?= ucfirst($data[0]->country) ?>,<b>Contact Number :-</b> <?= $data[0]->user_contact ?> </td>
            <td style="font-size: 14px;text-align: right" colspan="2"> <?= ucfirst($data[0]->cus_state) ?>, <?= ucfirst($data[0]->country) ?>, <b>Contact Number :-</b> <?= $data[0]->user_contact ?> </td>
            <td style="font-size: 11px" colspan=""> </td> -->
        </tr>

        <tr>
            <th style="border-top: 1px solid #000;border-bottom: 1px solid #000;">Product</th>
            <th style="border-top: 1px solid #000;border-bottom: 1px solid #000;">Title</th>
            <th style="border-top: 1px solid #000;border-bottom: 1px solid #000;">Qty</th>
            <th style="border-top: 1px solid #000;border-bottom: 1px solid #000;">Gross Amt ₹</th>
            <th style="border-top: 1px solid #000;border-bottom: 1px solid #000;">Taxable Value </th>
            <th style="border-top: 1px solid #000;border-bottom: 1px solid #000;">GST % </th>
            <th style="border-top: 1px solid #000;border-bottom: 1px solid #000;" colspan="2">Total ₹</th>
        </tr>

        <?php
        $qty = 0;
        $grand = 0.0;


        foreach ($data as $key => $val) {
            $grand += (floatval($val->pro_act_p) * floatval($val->pro_qty));
            $image = getProductImage($val->pro_id);
            // echo "<pre>";
            // print_r($val);
            // die;
            
            ?>
            <tr style="text-align: center">

                <td> <img src="<?= base_url("uploads/original/$image"); ?>" width="50" alt="">
                    <?= $val->hsn_code != '' ? "<br>SKU:" . $val->sku : "" ?>

                </td>
                <td><b><?= $val->pro_name ?>  </b>
                    <p><?= $val->sub_desc_p ?></p>
                </td>
                <?php
                    $qty += (int) $val->pro_qty;
                    ?>
                <td><?= $val->pro_qty ?></td>
                <td><?= $val->pro_qty ?> x <?= number_format($val->dis_price, 2); ?></td>



                <td>
                    <?php
                        $taxable = (($grand * 100) / ((100) + floatval($val->gst_per)));

                        echo number_format($taxable, 2);
                        ?></td>
                <td><?= $val->gst_per ?></td>

                <td colspan="2"><?= number_format(floatval($val->pro_act_p) * floatval($val->pro_qty), 2); ?> <i style="font-size: 12px">(Inclusive GST)</i> </td>
            </tr>
        <?php
        } ?>
        <?php
         $shipping_charge = $val->shipping;
        //$shipping_charge = ($qty >= 1 && $qty <= 10) ? 150 : (($qty >= 11 && $qty <= 25) ? 300 : ($qty > 25 ? 450 : 0));
        ?>
        <tr>

            <td style="text-align: right;border-top: 1px solid #000;padding:0;margin: 0"" colspan=" 4">
                <h3 style="padding:0;margin: 0""><?= "Subtotal " ?> </h3>
            </td>
            <td colspan=" 4" style="<?= $data[0]->pro_act_p == $data[0]->pro_price ? ('text-align: right;border-top: 1px solid #000;padding:0;margin: 0"') : 'text-align: right;border-top: 1px solid #000;padding:0;margin: 0"' ?>">
                    <h3 style=";padding:0;margin: 0"> INR <?= round($grand); ?></h3> for <?= $qty ?> items
            </td>


        </tr>
        
        <tr>

            <td style="text-align: right;border-top: 1px solid #000;padding:0;margin: 0" colspan="4">
                <?php if ($data[0]->pay_method != "cash") { ?>

                    <h4 style="padding:0;margin: 0"> <?= "Shipping Charges: " ?> </h4>
                <?php } else { ?> <h4 style="padding:0;margin: 0"><?= " Pick from Shop" ?> </h4> <?php } ?>
            </td>
            <td colspan="4" style="<?= $data[0]->pro_act_p == $data[0]->pro_price ? ('text-align: right;border-top: 1px solid #000') : 'text-align: right;border-top: 1px solid #000;padding:0;margin: 0"' ?>">
                <?php if ($data[0]->pay_method != "cash") { ?>
                    <h4 style="padding:0;margin: 0"> INR <?= round($shipping_charge); ?></h4>
                <?php } else { ?> <h4 style="padding:0;margin: 0"> INR <?= $shipping_charge = 0 ?> </h4> <?php } ?>
            </td>


        </tr>

        <?php 
        if($data[0]->offer_code != ''){?>
        <tr>
            <td style="text-align: right;border-top: 1px solid #000;padding:0;margin: 0" colspan="4">
                <h4 style="padding:0;margin: 0"> <?= "Offer Code & Value: " ?><?=$data[0]->offer_code?> </h4>
            </td>
            <td colspan="4" style="text-align: right;border-top: 1px solid #000;padding:0;margin: 0">
                <h4 style="padding:0;margin: 0"> INR <?= round($data[0]->total_offer); ?></h4>
            </td>
        </tr>
        <?php } ?>

        <?php 
        if($data[0]->gift_price != 0){?>
        <tr>
            <td style="text-align: right;border-top: 1px solid #000;padding:0;margin: 0" colspan="4">
                <h4 style="padding:0;margin: 0"> <?= "Gift Price: " ?> </h4>
            </td>
            <td colspan="4" style="text-align: right;border-top: 1px solid #000;padding:0;margin: 0">
                <h4 style="padding:0;margin: 0"> INR <?=$data[0]->gift_price?></h4>
            </td>
        </tr>
        <?php } ?>

        <tr>

            <td colspan="4" style="<?= $data[0]->pro_act_p == $data[0]->pro_price ? ('text-align: right;border-bottom: 1px solid #000;border-top: 1px solid #000;padding:0;margin:0') : 'text-align: right;border-top: 1px solid #000;padding:0;margin:0' ?>">
                <h3 style="margin: 0"><?= "Grand Total" ?> </h3>
            </td>
            <td colspan="4" style="<?= $data[0]->pro_act_p == $data[0]->pro_price ? ('text-align: right;border-bottom: 1px solid #000;border-top: 1px solid #000;padding:0') : 'text-align: right;border-top: 1px solid #000;padding:0' ?>">
                <h3 style="padding:0;margin: 0"> INR <?= round(round($grand) + round($shipping_charge) - $data[0]->total_offer + $data[0]->gift_price); ?></h3>
            </td>


        </tr>
       

        <tr>
            <td colspan="6">Paulsons</td>
            <td colspan="2" style="text-align: center"><?= $data[0]->company ?> </td>
        </tr>
        <tr>
            <td colspan="6"><img src="<?=base_url()?>bootstrap/images/logo.png" width="150"></td>
            <td colspan="2" style="text-align: center"> <img width="300" height="100" src="<?= base_url('uploads/signature/') ?><?= $data[0]->signature ?>" alt="vendor signature" /> </td>
        </tr>
        <tr>
            <td colspan="6"></td>
            <td colspan="2" style="text-align: center"> <i> Authorized Signatory </i> </td>
        </tr>
        <tr>
            <td colspan="8" style="border-bottom: 1px dashed #777">
                CIN N0: "" | Contact Paulsons +91 74282-11662 || retail.paulsons@gmail.com
                <p>*Keep this invoice and manufacturer box for warranty purposes</p>
            </td>

        </tr>
    </table>
</body>

</html>