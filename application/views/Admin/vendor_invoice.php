<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>Invoice SHP00#1</title>
        <style type="text/css">
            @media print
            {    
                .no-print, .no-print *
                {
                    display: none !important;
                }
                table{
                    width: 100%;
                }
                table .table-bordered
                {
                    border: 1px solid #777777  !important;

                }
                .table-bordered > thead > tr > th  {

                    background-color: #337ab7 !important;
                    font-weight: bold;
                    color: #fff !important;
                    -webkit-print-color-adjust: exact; 
                }
                .text-info
                {
                    color: #337ab7 !important;
                }

                h5
                {
                    font-size: 12px;
                    font-weight: bold;
                }
                .btn{
                    display: none;
                }
                @page {
                    size: auto;   /* auto is the initial value */
                    margin: 0;  /* this affects the margin in the printer settings */
                }

                h5,p,b{
                    margin: 0px;
                }

            }
            h5,p,b{
                margin: 0px;
            }

        </style>
    </head>

    <body  style="font-family: Roboto, 'Segoe UI', Tahoma, sans-serif;font-size: 14px;">
        <center> <button class="btn" onclick="window.print();">Print</button> </center>
        <?php
        $data = $products[0];
        
        ?>
        <table  style="margin:0 auto; "> 
            <tr>
                <th colspan="20" style="text-align: center"> <h3> Tax Invoice</h3></th>
            </tr>
            <tr>
                <td colspan="15"><p>Pamasha Internet Private Limited</p>
                    <p>House No 602, A Block, Naurang House, 21, K.G.Marg,</p>
                    <p>New Delhi-110001</p>
                    <p>GST NO- 07AAKCP1883H1Z4</p>
                    <p>Contact No-9667274442</p>
                </td>
                <td colspan="5"> </td>
            </tr>

            <tr>
                <td colspan="20">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="12"> <h5> Bill To: <?= $data->company ?>,</h5> </td>

                <td colspan="8" style="text-align: right;padding-right: 8px;"> <span style="border: 1px dashed #777;padding: 3px;">Invoice Number: VSHP/ <?= date("Y", strtotime($data->inv_date)) ?> /00<?=$post["invoice"]?></span> <br /> <br />  Invoice Date : <?=date("d/m/Y");?> </td>
            </tr>

            <tr>
                <td colspan="20" style="font-size: 12px"><i><b> Address: </b> <?= $this->security->xss_clean($data->address) ?>, <?= $data->city ?>, <?= $data->ven_state ?>, <?= $data->zip ?> <br/> <b>Vendor Contact Number</b>
                        <?= $data->contactno ?>
                    </i>
                </td>
            </tr>
            <tr>
                <td colspan="20" style="font-size: 13px"><b>GSTIN -</b> <?= $data->gst ?>  </td>
            </tr>
            <tr style="border-bottom: 1px solid #000"> <td colspan="11"> &nbsp;</td> </tr>

            <tr style="border-top: 1px solid #000;">
                <th>Date</th>
                <th colspan="2">Order Id</th>
                <th colspan="2">Total Transaction Value</th>
                <th colspan="2">Marketplace Fees% Rate</th>
                <th colspan="2">Marketplace Fees Value(A)</th>
                <th colspan="2">Shipping Fees(B)</th>
                <th>Gateway Fees(C)</th>
                <th colspan="2">Per transaction Fees(D)</th>
                <th > Total Fees E(A+B+C+D) </th>
                <th>GST RATE </th>
                <th>IGST </th>
                <th>CGST </th>
                <th colspan="2">SGST </th>


            </tr>

            <tr>
                <td colspan="20" style="border-bottom: 1px solid #000;">&nbsp; </td>
            </tr>
            <?php
            $totalprice = 0.0;
            foreach ($products as $product) {
                ?>
                <tr style="text-align: center;">
                    <td >
                        <?= date("d/M/Y", strtotime($product->inv_date)) ?> 
                    </td>
                    <td  colspan="2"> 
                        <?= $product->order_id ?> 
                    </td>
                    <td  colspan="2"> 
                        <?php echo $prod_price = floatval($product->total_transaction) ?>
                    </td>
                    <td colspan="2"> 
                        <?= $product->market_percentage ?>%
                    </td>

                    <td  colspan="2">
                        <?= $product->market_value ?>
                    </td>

                    <td colspan="2">
                        <?= $product->shipping_fee ?>
                    </td>
                    <td >
                        <?= $product->gateway_fee ?>
                    </td>
                    <td  colspan="2">  
                        <?= $product->per_transaction_fee ?>
                    </td>
                    <td  > <?= $product->total_fees ?> </td>
                    <td style=""> <?= $product->gst_rate ?> %</td>
                    <td style=""> <?= $product->igst ?> </td>
                    <td style=""> <?= $product->cgst ?> </td>
                    <td colspan="2" style=""> <?= $product->sgst ?> </td>
                </tr>
                <?php
                $totalprice = $totalprice + (floatval($product->total_fees) + floatval($product->igst) + floatval($product->cgst) + floatval($product->sgst) );
            }
            ?>
            <tr>
                <td colspan="20" style="border-bottom: 1px solid #000;">&nbsp; </td>
            </tr>
            <tr>

                <td colspan="16" style="text-align: right;">  <h3>Grand Total </h3> </td>

                <td colspan="4" style="text-align: right;"> <h3>₹ <?= number_format($totalprice, 2); ?></h3> </td>
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
                    CIN N0: U51909DL2018PTC341611 | Contact karzanddolls +91 966-727-4442 || support@karzanddolls.com  
                    <p>This is computer generated invoice no need for signature.</p>
                </td>

            </tr> 
        </table>
    </body>
</html>