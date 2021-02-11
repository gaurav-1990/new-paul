<div class="container">
    <div class="condition">
        <div class="col-lg-12 col-md-12">
            <h1 class="content-title">Contact Us</h1>
            <div class="contact-us">
                <div class="row">

                    <div class="col-md-5 col-xs-12">
                        <ul>
                            <li>
                                <span>
                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                    Crown Plaza Mall, Sector-15, Mathura Road,
                                    Faridabad-121007
                                </span>
                            </li>
                            <li>
                                <a href="tel:97160-90101">
                                    <i class="fa fa-phone" aria-hidden="true"></i>

                                    +91 74282-11662
                                </a>

                            </li>
                            <li>
                                <b>For sales queries:</b> <br />
                                <a href="mailto:support@paulsonsonline.com">
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>

                                    support@paulsonsonline.com
                                </a>

                            </li>
                            <li>
                                <b>For any other queries: </b> <br />
                                <a href="mailto:support@paulsonsonline.com">
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>

                                    support@paulsonsonline.com
                                </a>

                            </li>
                        </ul>

                    </div>
                    

                    <div class="col-md-7 col-xs-12">
                    <?= $this->session->flashdata('msg'); ?>
                    <?= form_open('Myaccount/contactus', array('id' => 'contactus', 'method' => 'POST', 'autocomplete' => 'off')) ?>                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" class="form-control" name="name" required />
                                        <?php echo form_error('name'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Email ID</label>
                                        <input type="email" class="form-control" name="email" required />
                                        <?php echo form_error('email'); ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Phone No:</label>
                                        <input type="text" class="form-control" name="mobile" required />
                                        <?php echo form_error('mobile'); ?>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Add Comment</label>
                                        <textarea class="form-control" name="comments" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" name="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                       <?=form_close()?>

                    </div>

                </div>



            </div>













        </div>

    </div>
</div>