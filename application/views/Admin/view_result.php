<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
 

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">

<main class="main-container">

    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#"> Users</a>
                        </li>
                        <li class="active"><span>View</span></li>


                    </ol>

                    <div class="page-header">
                        <?= $this->session->flashdata('msg') ?>
                        <?= $this->session->flashdata('insert') ?>

                    </div>
                    <!-- /Page header -->

                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid">

        <div class="section">

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel  panel-white">

                        <div class="panel-body">

                            <div class="table-responsive">

                                <table id="example" class="table table-bordered table-striped table-nowrap no-mb">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order ID</th>
                                            <th>Purchase Date</th>
                                            <th>Ship to Name</th>
                                            <th>State/City</th>
                                            <th>Billing Address</th>
                                            <th>Payment Status</th>
                                            <th>Payment Method</th>
                                            <th>Order Status</th>
                                            <th>Invoice ID</th>
                                            <th>Shipping AWB</th>
                                            <th>Invoice Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;

                                        foreach ($res as $user) {
                                            // echo "<pre>";
                                            // print_r($user);
                                            // die;
                                            if ($user->pay_method == 0) {
                                                $pmt = "COD";
                                            } else {
                                                $pmt = "ONLINE";
                                            }
                                            if ($user->pay_sta == 1) {
                                                $pst = "PAID";
                                            } else {
                                                $pst = "UNPAID";
                                            }
                                            if ($user->order_sta == 0) {
                                                $ost = "PENDING";
                                            } else if ($user->order_sta == 1) {
                                                $ost = "DISPATCHED";
                                            } else if ($user->order_sta == 2) {
                                                $ost = "REFUND";
                                            } else if ($user->order_sta == 3) {
                                                $ost = "EXCHANGE";
                                            }
                                            ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td><?= "10000" . $user->id ?></td>
                                                <td><?= $user->pay_date ?></td>
                                                <td><?= $user->first_name . "<br>" . $user->user_email . "<br>" . $user->user_contact ?></td>
                                                <td><?= $user->state . "/" . $user->user_city ?></td>
                                                <td><?= $user->user_address ?></td>
                                                <td><?= $pst ?></td>
                                                <td><?= $pmt ?></td>
                                                <td><?= $ost ?></td>
                                                <td><?= $user->invoice_id ?></td>
                                                <td><?= $user->shipping_awb ?></td>
                                                <td><?= $user->invoice_date ?></td>
                                            </tr>
                                        <?php
                                            $count++;
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>



                </div>


            </div>
        </div>

        <div id="setMe"></div>

    </div>


</main>


<!-- Scripts -->


<script src="<?= base_url() ?>allmedia/assets/js/jquery-2.2.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>allmedia/assets/components/jquery-ui-1.12.1/jquery-ui.min.js"></script>
<link href="<?= base_url() ?>allmedia/chosen/chosen.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url() ?>allmedia/chosen/chosen.jquery.js" type="text/javascript"></script>
<script src="<?= base_url() ?>allmedia/assets/components/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>allmedia/chosen/init.js" type="text/javascript"></script>
<script src="<?= base_url() ?>allmedia/assets/components/malihu-custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?= base_url() ?>allmedia/assets/js/circle-progress.min.js"></script>
<script src="<?= base_url() ?>allmedia/assets/js/calendar.js"></script>
<script src="<?= base_url() ?>allmedia/assets/js/general.js"></script>
<script src="<?= base_url() ?>allmedia/assets/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>allmedia/assets/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>allmedia/assets/js/myvalidation.js" type="text/javascript"></script>

<script src="<?= base_url() ?>allmedia/assets/js/validate_offer.js" type="text/javascript"></script>

<script src="<?= base_url() ?>allmedia/assets/js/bootstrap-notify.js" type="text/javascript"></script>
<script src="<?= base_url() ?>allmedia/assets/js/vendorProduct.js" type="text/javascript"></script>
<script src="<?= base_url() ?>allmedia/assets/js/extremeObfuscatemyscript.js" type="text/javascript"></script>



</body>

</html>

<script>
    $(document).ready(function() {
    $('.modal-toggle').on('click', function(e) {
    e.preventDefault();
    $('.modal').toggleClass('is-visible');
    });


    $('#example').DataTable({
    dom: 'Bfrtip',
    buttons: [
    'csv'
    ]
    });

    $('#offer_validity_from,#offer_validity_to').datepicker({
    dateFormat: 'dd-mm-yy'
    });$('[data-toggle="tooltip"]').tooltip();
    });


    </script>