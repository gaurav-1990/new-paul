<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Invoice Karzanddolls-<?= $invoice ?></title>
    <style type="text/css">
        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }

            table {
                width: 100%;
            }

            td {
                padding: 2px
            }

            table .table-bordered {
                border: 1px solid #777777 !important;

            }

            .table-bordered>thead>tr>th {

                background-color: #337ab7 !important;
                font-weight: bold;
                color: #fff !important;
                -webkit-print-color-adjust: exact;
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
                margin: 1cm;

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
    <center> <button class="btn" onclick="window.print();">Print</button> </center>

    <!-- <table width="80%" style="margin:0 auto; ">
        <tr>
            <th colspan="8" style="text-align: center">
                <h3> Tax Invoice</h3>
            </th>
        </tr>
        <tr>
            <td colspan="4">
                <h5> Sold By: <?= $data[0]->company ?>,</h5>
            </td>

            <td colspan="4" style="text-align: right;padding-right: 8px;"> <span style="border: 1px dashed #777;padding: 3px;">Invoice Number: KRZ/<?= $invoice_date ?>/<?= $invoice ?></span> </td>
        </tr>

        <tr>
            <td colspan="8" style="font-size: 12px"><i><b> Ship-From: </b> <?= $this->security->xss_clean($data[0]->ship_address) ?>, <?= $data[0]->city ?>, <?= $data[0]->ven_state ?>, <?= $data[0]->zip ?> <br /> <b>Vendor Contact Number</b>
                    <?= $data[0]->contactno ?>
                </i></td>
        </tr>
        <tr>
            <td colspan="8" style="font-size: 13px"><b>GSTIN -</b> <?= $data[0]->gst ?> </td>
        </tr>
        <tr style="border-bottom: 1px solid #000">
            <td colspan="8"> &nbsp;</td>
        </tr>
        <tr>
            <td style="font-size: 14px" colspan="2"> <b>Order ID: 0000<?= $data[0]->order_id ?></b> </td>
            <td colspan=""> </td>

            <td style="font-size: 14px;text-align: right" colspan="2"> <b>Bill To</b></td>
            <td style="font-size: 14px;text-align: right" colspan="2"> <b>Ship To</b> </td>
            <td style="font-size: 12px" colspan=""> &nbsp;</td>

        </tr>
        <tr>
            <td style="font-size: 13px" colspan="2"> <b>Order Date: <?= date("d-m-Y", strtotime($data[0]->pay_date)); ?></b> </td>
            <td colspan=""> </td>


            <td style="font-size: 14px;text-align: right" colspan="2"> <b><?= ucfirst($data[0]->first_name) ?> <?= ucfirst($data[0]->last_name) ?></b> (<?= $data[0]->user_email ?>)</td>
            <td style="font-size: 14px;text-align: right" colspan="2"> <b> <?= ucfirst($data[0]->first_name) ?> <?= ucfirst($data[0]->last_name) ?></b> (<?= $data[0]->user_email ?>) </td>
            <td style="font-size: 11px;text-align: right" colspan=""> </td>

        </tr>


        <tr>
            <td style="font-size: 13px" colspan="2"> <b>Invoice Date: <?= date("d-m-Y", strtotime($data[0]->pay_date)); ?></b> </td>
            <td colspan=""> </td>

            <td style="font-size: 14px;text-align: right" colspan="2"> <?= ucfirst($data[0]->user_address) ?>, </td>
            <td style="font-size: 14px;text-align: right" colspan="2"> <?= ucfirst($data[0]->user_address) ?>, </td>
            <td style="font-size: 11px;text-align: right" colspan=""> </td>

        </tr>
        <tr>
            <td style="font-size: 13px" colspan="4"> </td>
            <td colspan=""> </td>

            <td style="font-size: 14px;text-align: right" colspan="2"> <?= ucfirst($data[0]->user_city) ?>, <?= ucfirst($data[0]->user_pin_code) ?>, </td>
            <td style="font-size: 14px;text-align: right" colspan="2"> <?= ucfirst($data[0]->user_city) ?>, <?= ucfirst($data[0]->user_pin_code) ?>, </td>
            <td style="font-size: 11px;text-align: right" colspan=""> </td>

        </tr>
        <tr>
            <td style="font-size: 13px" colspan="2"> </td>
            <td colspan=""> </td>

            <td style="font-size: 14px;text-align: right" colspan="2"> <?= ucfirst($data[0]->cus_state) ?>, <?= ucfirst($data[0]->country) ?>,<br><b>Contact Number :-</b> <?= $data[0]->user_contact ?> </td>
            <td style="font-size: 14px;text-align: right" colspan="2"> <?= ucfirst($data[0]->cus_state) ?>, <?= ucfirst($data[0]->country) ?>, <br><b>Contact Number :-</b> <?= $data[0]->user_contact ?> </td>
            <td style="font-size: 11px" colspan=""> </td>
        </tr>

        <tr style="border-top: 1px solid #000;">
            <th>Product</th>
            <th>Title</th>
            <th>Qty</th>
            <th>Gross Amt ₹</th>
            <th>Taxable Value </th>
            <th>GST % </th>
            <th colspan="2">Total ₹</th>
        </tr>
        <tr>
            <td colspan="13" style="border-bottom: 1px solid #000;">&nbsp; </td>
        </tr>
        <?php
        $qty = 0;
        $grand = 0.0;


        foreach ($data as $key => $val) {
            $grand += (floatval($val->pro_price) * floatval($val->pro_qty));
            $image = getProductImage($val->pro_id);

            ?>
            <tr style="text-align: center">

                <td> <img src="<?= base_url("uploads/original/$image"); ?>" width="50" alt="">
                    <?= $val->hsn_code != '' ? "<br>SKU Code:" . $val->sku : "" ?>

                </td>
                <td><b><?= $val->pro_name ?> <?php
                                                    $attribute = json_decode($val->order_prop)->attribute;
                                                    if ($attribute != null) {
                                                        foreach ($attribute as $prop) {
                                                            $key1 = str_replace("_", " ", key((array) $prop));
                                                            $key = key((array) $prop);
                                                            echo "<br><small><b>$key1 : </b>";
                                                            print_r($prop->$key);
                                                            echo "</small>";
                                                        }
                                                    }
                                                    ?> </b>
                    <p><?= $val->sub_desc_p ?></p>
                </td>
                <?php
                    $qty += (int) $val->pro_qty;
                    ?>
                <td><?= $val->pro_qty ?></td>
                <td><?= $val->pro_qty ?> x <?= number_format($val->act_price, 2); ?></td>



                <td>
                    <?php
                        $taxable = (($grand * 100) / ((100) + floatval($val->gst_per)));

                        echo number_format($taxable, 2);
                        ?></td>
                <td><?= $val->gst_per ?></td>

                <td colspan="2"><?= number_format(floatval($val->pro_price) * floatval($val->pro_qty), 2); ?> <i style="font-size: 12px">(Inclusive GST)</i> </td>
            </tr>
        <?php
        } ?>
        <?php
        $shipping_charge = ($qty >= 1 && $qty <= 10) ? 120 : (($qty >= 11 && $qty <= 25) ? 250 : ($qty > 25 ? 350 : 0));
        ?>
        <tr>

            <td style="text-align: right;border-top: 1px solid #000" colspan="4">
                <h3><?= "Subtotal " ?> </h3>
            </td>
            <td colspan="4" style="<?= $data[0]->pro_act_p == $data[0]->pro_price ? ('text-align: right;border-top: 1px solid #000') : 'text-align: right;border-top: 1px solid #000' ?>">
                <h3> INR <?= round($grand); ?></h3> for <?= $qty ?> items
            </td>


        </tr>
        <?php
        $offerPrice = 0;
        $offer = $data[0]->offer_data != '' ? json_decode($data[0]->offer_data) : "";

        if ($offer != '') {
            ?>
            <tr>

                <td style="text-align: right;border-top: 1px solid #000" colspan="4">
                    <h3><?= "Offer Price" ?> </h3>
                </td>
                <td colspan="4" style="text-align: right;border-top: 1px solid #000">
                    <h3> INR <?php
                                    $offerTotal = 0.0;

                                    if (is_array($offer)) {
                                        if ($offer[0]->offer_type == 1) {


                                            foreach ($offer as $key => $offers) {
                                                $offerTotal += floatval($offers->total);
                                            }
                                            $offerPrice = $offer[0]->offer_val * $offerTotal  / 100;
                                            echo round($offer[0]->offer_val * $offerTotal / 100);
                                        } else {
                                            foreach ($offer as $key => $offers) {
                                                $offerTotal += floatval($offers->offer_val);
                                            }
                                            $offerPrice = $offerTotal;
                                            echo round($offerTotal);
                                        }
                                    } else {
                                        if ($offer->offer_type == 1) {


                                            echo round($offer[0]->offer_val *  floatval($offers->total) / 100);
                                        } else {
                                            $offerTotal = floatval($offer->offer_val);
                                            $offerPrice = $offerTotal;
                                            echo round($offerTotal);
                                        }
                                    }
                                    ?>
                    </h3>
                </td>


            </tr>
        <?php
        }
        ?>
        <tr>

            <td style="text-align: right;border-top: 1px solid #000" colspan="4">
                <?php if ($data[0]->pay_method != "cash") { ?>

                    <h4><?= "Shipping Charges: " ?><?= $data[0]->pay_method ?> </h4>
                <?php } else { ?> <h4><?= " Pick from Shop" ?> </h4> <?php } ?>
            </td>
            <td colspan="4" style="<?= $data[0]->pro_act_p == $data[0]->pro_price ? ('text-align: right;border-top: 1px solid #000') : 'text-align: right;border-top: 1px solid #000' ?>">
                <?php if ($data[0]->pay_method != "cash") { ?>
                    <h4> INR <?= round($shipping_charge); ?></h4>
                <?php } else { ?> <h4> INR <?= $shipping_charge = 0 ?> </h4> <?php } ?>
            </td>


        </tr>
        <tr>

            <td colspan="4" style="<?= $data[0]->pro_act_p == $data[0]->pro_price ? ('text-align: right;border-bottom: 1px solid #000;border-top: 1px solid #000') : 'text-align: right;border-top: 1px solid #000' ?>">
                <h3><?= "Grand Total" ?> </h3>
            </td>
            <td colspan="4" style="<?= $data[0]->pro_act_p == $data[0]->pro_price ? ('text-align: right;border-bottom: 1px solid #000;border-top: 1px solid #000') : 'text-align: right;border-top: 1px solid #000' ?>">
                <h3> INR <?= round($grand) + round($shipping_charge) - $offerPrice; ?></h3>
            </td>


        </tr>

        <tr>
            <td colspan="6"></td>
            <td colspan="2" style="text-align: center"><?= $data[0]->company ?> </td>
        </tr>
        <tr>
            <td colspan="6"></td>
            <td colspan="2" style="text-align: center"> <img width="300" height="100" src="<?= base_url('uploads/signature/') ?><?= $data[0]->signature ?>" alt="vendor signature" /> </td>
        </tr>
        <tr>
            <td colspan="6"></td>
            <td colspan="2" style="text-align: center"> <i> Authorized Signatory </i> </td>
        </tr>
        <tr>
            <td colspan="8"> &nbsp;</td>

        </tr>



        <tr>
            <td colspan="8"> <img src="https://www.karzanddolls.com/bootstrap/images/shp.png" width="200"></td>

        </tr>
        <tr>
            <td colspan="8"> &nbsp;</td>

        </tr>
        <tr>
            <td colspan="8" style="border-bottom: 1px dashed #777">
                CIN N0: "" | Contact Karzanddolls +91 97160-90101 || hello@paulsonsonline.com
                <p>*Keep this invoice and manufacturer box for warranty purposes</p>
            </td>

        </tr>
    </table> -->

    <table width="80%" style="margin:0 auto;border-collapse: collapse">
        <tr>
            <td colspan="10" style="text-align:center"> <b> TAX INVOICE</b> </td>
        </tr>
        <tr>
            <td colspan="4">
                To,<br>
                <?= ucfirst($data[0]->first_name) ?> <?= ucfirst($data[0]->last_name) ?><br>
                <?= $this->security->xss_clean($data[0]->ship_address) ?> <br>
                <?= $data[0]->city ?> <br>
                <?= $data[0]->ven_state ?><br>
                India - <?= $data[0]->zip ?>

            </td>
            <td style="text-align:right" colspan="6">
                <img src="<?= base_url("bootstrap/images/logo.png") ?>" alt="" width="200">
                <?= ($invoiceBar) ?>

                <span style="display:block;"> <?= $invoice ?></span>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <b>Invoice No.: <?= $invoice ?></b> <br>
                Mobile No.: <?= $data[0]->contactno ?> <br>
                Order No.: <?= $data[0]->order_id ?> <br>
                Order Date: <?= date("d-m-Y H:i", strtotime($data[0]->pay_date)) ?> <br>
                Invoice Date: <?= date("d-m-Y", strtotime($data[0]->invoice_date)) ?> <br>
                <?php
                $qty = 0;
                foreach ($data as  $or) {
                    $qty += floatval($or->pro_qty);
                }
                ?>

                Total No. of Items: <?= $qty ?><br>
                Shipment ID: <?= $data[0]->shipping_awb ?>
            </td>
            <td style="text-align: right" colspan="6">

                Omega Designs Private Limited<br>
                Basement and Ground<br>
                Floor Plot No.32 Sector-32 Institutional Area<br>
                Gurgaon Haryana 122003

            </td>
        </tr>
        <tr>
            <td colspan="4"> </td>
            <td style="text-align: right" colspan="6"> <b> GST <?= $data[0]->gst ?> </b> <br>
                Customer Care: <small> +91-0124-2852000</small>
            </td>
        </tr>
        <tr>
            <th style="border:1px solid;padding: 8px;">Item Code</th>
            <th style="border:1px solid;padding: 8px;">Item Name</th>
            <th style="border-left:1px solid;border-top:1px solid;border-bottom:1px solid;padding: 8px;">Item Description </th>
            <th style="border-top:1px solid;border-bottom:1px solid;padding: 8px;">Qty</th>
            <th style="border-top:1px solid;border-right:1px solid;border-bottom:1px solid;padding: 8px;">HSNCode</th>
            <th style="border-top:1px solid;border-left:1px solid;border-bottom:1px solid;padding: 8px;">MRP</th>
            <th style="border-top:1px solid;border-right:1px solid;border-bottom:1px solid;padding: 8px;">Total Discount</th>
            <th style="border-top:1px solid;border-left:1px solid;border-bottom:1px solid;padding: 8px;">IGST Rate</th>
            <th style="border-top:1px solid;border-right:1px solid;border-bottom:1px solid;padding: 8px;">IGST Amount </th>
            <th style="border:1px solid;padding: 8px;">Sub Total (Including Tax) </th>

        </tr>
        <?php
        $qty = 0;
        $grand = 0.0;
        $igst = 0;
        foreach ($data as $key => $val) {
            $grand += (floatval($val->pro_price) * floatval($val->pro_qty));
            $igst = $igst + number_format(floatval($val->dis_price) * floatval($val->gst_per) / 100, 2, '.', '');
            ?>
            <tr>
                <td style="border:1px solid;text-align:center"><?= $val->sku ?> </td>
                <td style="border:1px solid;text-align:center"><?= $val->pro_name ?></td>
                <td style="border:1px solid;text-align:center"> <b> <?= ucfirst($val->order_prop) ?>: </b> <?= $val->order_attr ?>
                </td>
                <td style="border:1px solid;text-align:center"> <?= $val->pro_qty ?></td>
                <td style="border:1px solid;text-align:center"><?= $val->hsn_code ?></td>
                <td style="border:1px solid;text-align:right"><?= $val->act_price ?></td>
                <td style="border:1px solid;text-align:right"><?= floatval($val->dis_price) - number_format(floatval($val->dis_price) * floatval($val->gst_per) / 100, 2, '.', '')  ?></td>
                <td style="border:1px solid;text-align:right"><?= $val->gst_per ?></td>
                <td style="border:1px solid;text-align:right"><?= number_format(floatval($val->dis_price) * floatval($val->gst_per) / 100, 2, '.', '') ?></td>
                <td style="border:1px solid;text-align:right"><?= $val->dis_price ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="9" style="text-align:right;border:1px solid #000">Total IGST Amount : </td>
            <td style="text-align:right;border:1px solid #000"> <?= $igst ?> </td>
        </tr>
        <tr>
            <td colspan="9" style="text-align:right;border:1px solid #000">Shipping Charges: </td>
            <td style="text-align:right;border:1px solid #000"> <?= number_format($data[0]->shipping, 2, '.', '') ?> </td>
        </tr>
        <tr>
            <td colspan="9" style="text-align:right;border:1px solid #000">Total Offer: </td>
            <td style="text-align:right;border:1px solid #000"> - <?= number_format($data[0]->total_offer, 2, '.', '') ?> </td>
        </tr>
        <tr>
            <td colspan="9" style="text-align:right;border:1px solid #000">Total Amount (Including Tax): </td>
            <td style="text-align:right;border:1px solid #000"> <?= number_format(floatval($data[0]->total_order_price), 2, '.', '') ?> </td>
        </tr>
        <tr>
            <td colspan="9" style="text-align:right;border:1px solid #000">Grand Total: </td>
            <td style="text-align:right;border:1px solid #000"> <?= number_format(floatval($data[0]->total_order_price), 2, '.', '') ?> </td>
        </tr>
        <tr>
            <td colspan="10">&nbsp; </td>

        </tr>
        <tr>
            <td colspan="9" style="text-align:center;">
                <h4>Not for Resale</h4>
            </td>
            <td colspan="">
                <h3>06AIM</h3>
            </td>

        </tr>
        <tr>
            <td colspan="10">&nbsp; </td>

        </tr>
        <tr>
            <td colspan="10"> <small>This is a computer generated invoice and requires no signature & Stamp </small> </td>

        </tr>
        <tr>
            <td colspan="10">&nbsp; </td>

        </tr>
        <tr>
            <td colspan="10">
                <small>

                    <b> Registered Office</b>:- Omega Designs Private Limited - Basement and Ground Floor Plot No.32 Sector-32 Institutional Area,<br>
                    Gurgaon Haryana 122003 GSTIN : 06AAACO0253E1Z1 PAN :AAACO0253E <b> CIN</b>:- U74899DL1994PTC059516
                </small>
            </td>

        </tr>

    </table>

</body>

</html>