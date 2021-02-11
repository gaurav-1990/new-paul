<?php //
if (count($user) > 0) {
    ?>
    <div class="dashboard-set">
        <div class="container">

            <div class="dashboard-set-in">
                <?= $this->session->flashdata('msg'); ?>
                <ul>

                    <?php foreach ($user as $order_Data) {


                        ?>
                        <li>
                            <div class="col-sm-5">
                                <div class="pro-detail">

                                    <img src="<?= base_url('uploads/original/') ?><?= load_images($order_Data->pro_id) ?>" alt="IMG-BENNER">
                                    <div class="right-detal">
                                        <h3>
                                            <?= $order_Data->pro_name ?> <br>
                                            <b><?= $order_Data->order_prop ?> : <?= $order_Data->order_attr ?></b>
                                        </h3>
                                        <p> Qty :<?= $order_Data->pro_qty ?></p>
                                        <p>

                                            <strong> Supply status : <?= $order_Data->deliver == 0 ? "Pending" : ($order_Data->deliver == 1 ? "Dispatched" : ($order_Data->deliver == 2 ? "Delivered" : ($order_Data->deliver == 3 ? "Cancellation requested" : ($order_Data->deliver == 4 ? "Re-Dispatched" : ($order_Data->deliver == 5 ? "Canceled" : ""))))); ?> </strong>
                                            <br>
                                            <strong> Booking Time : </strong> <?= date("D d M, Y, H:i", strtotime($order_Data->pay_date)) ?>
                                        </p>
                                        <p> <strong> Order Number</strong> 0000<?= $order_Data->or_id ?></p>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="address">
                                    <h3>Address:</h3>
                                    <p> <?= $order_Data->user_address ?></p>
                                    <span>
                                        <small>Buyer name</small></br>
                                        <?= $order_Data->first_name ?>
                                        <?= $order_Data->last_name ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2 cancel-btn">
                                <?php
                                $your_date = $order_Data->pay_date;

                                $now = time(); // or your date as well
                                $your_date = strtotime($your_date);
                                $datediff = $now - $your_date;
                                $days = round($datediff / (60 * 60 * 24));
                                ?>
                                <?php
                                if ($order_Data->deliver != 3 && $order_Data->cancel_comments == "" && floatval($days) <= 7) {
                                    ?>
                                    <button class="btn btn-warning btn-xs" onclick="window.location.href = '<?= base_url('Myaccount/cancelThis/') ?><?= encode($this->encryption->encrypt($order_Data->or_id)) ?>'"> Cancel This Order</button><br>
                                <?php } ?>

                                <br>
                                <?php if ($order_Data->deliver == 1 || $order_Data->deliver == 4) { ?>
                                    <button class="btn btn-success btn-xs" target='_blank' onclick="window.location.href = '<?= base_url("Myaccount/trackOrder/") ?><?= encode($this->encryption->encrypt($order_Data->or_id)) ?>'"> Track Your Order </button>
                                <?php } ?>

                                <button class="btn btn-success btn-xs" target='_blank' onclick="window.location.href = '<?= base_url("Myaccount/getInvoice/") ?><?= encode($this->encryption->encrypt($order_Data->or_id)) ?>'"> Get Invoice </button>
                                <!------------Rahman code ------------------->
                                <?php
                                $res = getReview($order_Data->pro_id, $order_Data->registered_user);
                                if ($res != 1) {
                                    ?>

                                    <a data-toggle="modal" href="#myModal<?= $order_Data->pro_id ?>" class="btn btn-info btn-xs">Write your review </a>
                                <?php } ?>

                                <div class="modal" id="myModal<?= $order_Data->pro_id ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Write your review </h4>
                                            </div>
                                            <div class="container"></div>
                                            <div class="modal-body">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <form class="form-horizontal" action="<?= base_url("Dashboard/reviewSubmit") ?>" method="post">
                                                                <fieldset>
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label" for="name">Full Name</label>
                                                                        <div class="col-md-9">
                                                                            <input id="name" name="name" type="text" required="" autocomplete="off" readonly="" value="<?= $order_Data->first_name ?> <?= $order_Data->last_name  ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label" for="email">Your E-mail</label>
                                                                        <div class="col-md-9">
                                                                            <input type="hidden" name="pro" value="<?= encode($this->encryption->encrypt($order_Data->pro_id)); ?>" />
                                                                            <input id="email" name="email" type="text" readonly="" autocomplete="off" required="" value="<?= $order_Data->registered_user ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label" for="message">Your message</label>
                                                                        <div class="col-md-9">
                                                                            <textarea class="form-control" id="message" autocomplete="off" name="message" required="" minlength="10" placeholder="Please enter your feedback here..." rows="5"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label" for="rating">Your rating</label>
                                                                        <div class="col-md-9">
                                                                            <select required="" class="form-control" name="rating" id="rating">
                                                                                <option value="1">1 star</option>
                                                                                <option value="1.5">1.5 star</option>
                                                                                <option value="2">2 star</option>
                                                                                <option value="2.5">2.5 star</option>
                                                                                <option selected="" value="3">3 star</option>
                                                                                <option value="3.5">3.5 star</option>
                                                                                <option value="4">4 star</option>
                                                                                <option value="4.5">4.5 star</option>
                                                                                <option value="5">5 star</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="col-md-9 pull-right">
                                                                            <button type="submit" class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">Submit</button>
                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <!--			      <a href="#" data-dismiss="modal" class="btn">Close</a>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!------------Rahman code End------------------->

                            </div>
                            <div class="col-sm-2">
                                <div class="price-part">
                                    <div class="row">
                                        <span class="price-set pull-right">
                                            <h3>
                                                <small>Total</small></br>
                                                INR <?= number_format(floatval($order_Data->pro_price), 2, '.', '') ?>
                                            </h3>
                                        </span>
                                    </div>
                                    <span class="supply-part">
                                        <small>Vendor:</small></br>
                                        <?= $order_Data->company ?>

                                    </span>
                                </div>


                            </div>


                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
<?php } else {
    ?>
    <div class="dashboard-set">
        <div class="container">
            <div class="dashboard-set-in">
                <ul>
                    <li>
                        <center>There is no order in your account</center>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php } ?>