<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Invoice SHP00<?= $data->invoiceid ?></title>
    <style type="text/css">
        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }

            table {
                width: 100%;
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
    <center> <button class="btn" onclick="window.print();">Print</button> </center>
    <?php
    $grand = (floatval($data->pro_price) * floatval($data->pro_qty));
    ?>
    <table width="80%" style="margin:0 auto; ">
        <tr>
            <th colspan="12" style="text-align: center">
                <h3> Tax Invoice</h3>
            </th>
        </tr>
        <tr>
            <td colspan="8">
                <h5> Sold By: <?= $data->company ?>,</h5>
            </td>

            <td colspan="4" style="text-align: right;padding-right: 8px;"> <span style="border: 1px dashed #777;padding: 3px;">Invoice Number: NTNT/2018-19/<?= $data->invoiceid ?></span> </td>
        </tr>

        <tr>
            <td colspan="12" style="font-size: 12px"><i><b> Ship-From: </b> <?= $this->security->xss_clean($data->ship_address) ?>, <?= $data->city ?>, <?= $data->ven_state ?>, <?= $data->zip ?> <br /> <b>Vendor Contact Number</b>
                    <?= $data->contactno ?>
                </i></td>
        </tr>
        <tr>
            <td colspan="12" style="font-size: 13px"><b>GSTIN -</b> <?= $data->gst ?> </td>
        </tr>
        <tr style="border-bottom: 1px solid #000">
            <td colspan="11"> &nbsp;</td>
        </tr>
        <tr>
            <td style="font-size: 14px" colspan="3"> <b>Order ID: 0000<?= $data->or_id ?></b> </td>
            <td style="font-size: 14px;text-align: right" colspan="3"> <b>Bill To</b></td>
            <td style="font-size: 14px;text-align: right" colspan="3"> <b>Ship To</b> </td>
            <td style="font-size: 12px" colspan="3"> &nbsp;</td>

        </tr>
        <tr>
            <td style="font-size: 13px" colspan="3"> <b>Order Date: <?= date("d-m-Y", strtotime($data->pay_date)); ?></b> </td>
            <td style="font-size: 14px;text-align: right" colspan="3"> <b><?= ucfirst($data->first_name) ?> <?= ucfirst($data->last_name) ?></b></td>
            <td style="font-size: 14px;text-align: right" colspan="3"> <b> <?= ucfirst($data->first_name) ?> <?= ucfirst($data->last_name) ?></b> </td>
            <td style="font-size: 11px;text-align: right" colspan="3"> </td>

        </tr>


        <tr>
            <td style="font-size: 13px" colspan="3"> <b>Invoice Date: <?= date("d-m-Y", strtotime($data->pay_date)); ?></b> </td>
            <td style="font-size: 14px;text-align: right" colspan="3"> <?= ucfirst($data->user_address) ?>, </td>
            <td style="font-size: 14px;text-align: right" colspan="3"> <?= ucfirst($data->user_address) ?>, </td>
            <td style="font-size: 11px;text-align: right" colspan="3"> </td>

        </tr>
        <tr>
            <td style="font-size: 13px" colspan="3"> </td>
            <td style="font-size: 14px;text-align: right" colspan="3"> <?= ucfirst($data->user_city) ?>, <?= ucfirst($data->user_pin_code) ?>, </td>
            <td style="font-size: 14px;text-align: right" colspan="3"> <?= ucfirst($data->user_city) ?>, <?= ucfirst($data->user_pin_code) ?>, </td>
            <td style="font-size: 11px;text-align: right" colspan="3"> </td>

        </tr>
        <tr>
            <td style="font-size: 13px" colspan="3"> </td>
            <td style="font-size: 14px;text-align: right" colspan="3"> <?= ucfirst($data->cus_state) ?>, <?= ucfirst($data->country) ?>,<br><b>Contact Number :-</b> <?= $data->user_contact ?> </td>
            <td style="font-size: 14px;text-align: right" colspan="3"> <?= ucfirst($data->cus_state) ?>, <?= ucfirst($data->country) ?>, <br><b>Contact Number :-</b> <?= $data->user_contact ?> </td>
            <td style="font-size: 11px" colspan="3"> </td>
        </tr>
        <tr>
            <td colspan="12">
                <p style="padding-top: 2px;font-size: 14px"> Total Items: <?= $data->pro_qty ?> </p>
            </td>
        </tr>
        <tr style="border-top: 1px solid #000;">
            <th>Product</th>
            <th>Title</th>
            <th>Qty</th>
            <th>Gross Amt ₹</th>
            <th>Discount ₹ </th>
            <th>Taxable Value </th>
            <th>GST % </th>
            <th>IGST ₹ </th>
            <th>SGST ₹</th>
            <th>CGST ₹</th>
            <th colspan="2">Total ₹</th>
        </tr>
        <tr>
            <td colspan="11" style="border-bottom: 1px solid #000;">&nbsp; </td>
        </tr>
        <tr style="text-align: center">
            <td> <?= $data->sub_name ?>
                <?= $data->hsn_code != '' ? "<br>HSN Code:" . $data->hsn_code : "" ?>
            </td>
            <td><b>
                    <?= $data->pro_name ?><br>
                    <?= $data->product_sname ?> <br>
                    ( <?= $data->order_prop ?>
                    : <?= $data->order_attr ?> )
                </b>
                <p><?= $data->sub_desc_p ?></p>
            </td>
            <td><?= $data->pro_qty ?></td>
            <td><?= $data->pro_qty ?> x <?= number_format($data->act_price, 2); ?></td>

            <td>
                <?= $data->pro_qty ?> x <?php
                                        $price = (floatval($data->act_price) - (floatval($data->pro_price)));
                                        echo number_format($price, 2);
                                        ?> </td>
            <td>
                <?php
                $taxable = (($grand * 100) / ((100) + floatval($data->gst_per)));

                echo number_format($taxable, 2);
                ?></td>
            <td><?= $data->gst_per ?></td>
            <td>
                <?php
                if ($data->ven_state != $data->cus_state) {
                    echo number_format(floatval($grand) - floatval($taxable), 2);
                } else {
                    echo "0";
                }
                ?>
            </td>
            <td> <?php
                    if ($data->ven_state != $data->cus_state) {
                        echo "0";
                    } else {
                        echo number_format(((floatval($grand) - floatval($taxable)) / 2), 2);
                    }
                    ?> </td>
            <td> <?php
                    if ($data->ven_state != $data->cus_state) {
                        echo "0";
                    } else {
                        echo number_format(((floatval($grand) - floatval($taxable)) / 2), 2);
                    }
                    ?></td>
            <td colspan="2"><?= number_format(floatval($data->pro_act_p) * floatval($data->pro_qty), 2); ?> <i style="font-size: 12px">(Inclusive GST)</i> </td>
        </tr>
        <?php
        $shipping_charge = 0;
        if ($grand <= 275) {
            $shipping_charge = 65;
            ?>
            <tr>

                <td colspan="4" style="text-align: right">
                    <h3>Shipping Charges </h3>
                </td>
                <td style="text-align: center" colspan="">INR <?= 65 ?> </td>
                <td style="text-align: center"> <?php
                                                $taxableship = ((65 * 100) / ((100) + floatval($data->gst_per)));

                                                echo number_format($taxableship, 2);
                                                ?></td>
                <td style="text-align: center"><?= $data->gst_per ?></td>
                <td style="text-align: center">
                    <?php
                    if ($data->ven_state != $data->cus_state) {
                        echo number_format(floatval(65) - floatval($taxableship), 2);
                    } else {
                        echo "0";
                    }
                    ?>
                </td>
                <td style="text-align: center"> <?php
                                                if ($data->ven_state != $data->cus_state) {
                                                    echo "0";
                                                } else {
                                                    echo number_format(((floatval(65) - floatval($taxableship)) / 2), 2);
                                                }
                                                ?> </td>
                <td style="text-align: center"> <?php
                                                if ($data->ven_state != $data->cus_state) {
                                                    echo "0";
                                                } else {
                                                    echo number_format(((floatval(65) - floatval($taxableship)) / 2), 2);
                                                }
                                                ?>
                </td>
                <td style="text-align: center" colspan="2"><?= $shipping_charge ?> <i style="font-size: 12px">(Inclusive GST)</i> </td>
            </tr>
        <?php } ?>
        <tr>

            <td colspan="6" style="<?= $data->pro_act_p == $data->pro_price ? ('text-align: right;border-bottom: 1px solid #000;border-top: 1px solid #000') : 'text-align: right;border-top: 1px solid #000' ?>">
                <h3><?= $data->pro_act_p == $data->pro_price ? "Grand Total" : "Total Value" ?> </h3>
            </td>
            <td colspan="5" style="<?= $data->pro_act_p == $data->pro_price ? ('text-align: right;border-bottom: 1px solid #000;border-top: 1px solid #000') : 'text-align: right;border-top: 1px solid #000' ?>">
                <h3> INR <?= number_format((floatval($data->pro_act_p) * floatval($data->pro_qty)) + floatval($shipping_charge), 2); ?></h3>
            </td>


        </tr>
        <?php
        if ($data->pro_act_p != $data->pro_price) {
            ?>
            <tr>

                <td colspan="6" style="text-align: right;">
                    <h3>Offer Discount @40%</h3>
                </td>
                <td colspan="5" style="text-align: right">
                    <h3> - INR <?= number_format((floatval($data->pro_act_p) * floatval($data->pro_qty)) + floatval($shipping_charge), 2) - (number_format((floatval($data->pro_price) * floatval($data->pro_qty)) + floatval($shipping_charge), 2)); ?></h3>
                </td>


            </tr>
            <tr>

                <td colspan="6" style="text-align: right;border-bottom: 1px solid #000;border-top: 1px solid #000">
                    <h3>Grand Total</h3>
                </td>
                <td colspan="5" style="text-align: right;border-bottom: 1px solid #000;border-top: 1px solid #000">
                    <h3> INR <?= (number_format((floatval($data->pro_price) * floatval($data->pro_qty)) + floatval($shipping_charge), 2)); ?></h3>
                </td>


            </tr>
        <?php } ?>
        <tr>
            <td colspan="9"></td>


            <td colspan="2" style="text-align: center"><?= $data->company ?> </td>
        </tr>
        <tr>
            <td colspan="9"></td>
            <td colspan="2" style="text-align: center"> <img width="300" height="100" src="<?= base_url('uploads/signature/') ?><?= $data->signature ?>" alt="vendor signature" /> </td>
        </tr>
        <tr>
            <td colspan="9"></td>
            <td colspan="2" style="text-align: center"> <i> Authorized Signatory </i> </td>
        </tr>
        <tr>
            <td colspan="8"> &nbsp;</td>

        </tr>



        <tr>
            <td colspan="11"> <img src="https://www.karzanddolls.com/bootstrap/images/shp.png" width="200"></td>

        </tr>
        <tr>
            <td colspan="1"> &nbsp;</td>

        </tr>
        <tr>
            <td colspan="11" style="border-bottom: 1px dashed #777">
                CIN N0: U51909DL2018PTC341611 | Contact Karzanddolls +91 97160-90101 || hello@paulsonsonline.com
                <p>*Keep this invoice and manufacturer box for warranty purposes</p>
            </td>

        </tr>
    </table>
</body>

</html>