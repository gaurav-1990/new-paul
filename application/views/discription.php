<?php

if ($subcat != NULL) {


    ?>
<section class="bg-title-page p-t-50 p-b-40 flex-col-c-m" style="<?php if ($subcat[0]->cat_image != '') { ?>
                                                            background-image: url(<?= base_url() ?>uploads/category/original/<?= $subcat[0]->cat_image ?>);" <?php } else { ?>background-image: url(<?= base_url() ?>bootstrap/images/slider/home1.jpg);" <?php } ?>>
</section>

<section class="product-category-first">
    <div class="container">
        <div class="row">
<!--            <div class="col-sm-6 col-md-6 col-lg-9 p-b-50">-->
            <div class="col-sm-12 col-md-12 col-lg-12 p-b-50">
<section class="all-pro-set  p-t-30">

<div class="head-title">
<h2>Our Collection </h2>

<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
</div>

<div class="for-scroll" xss="removed">
<div class="all-pro-set-in">
    <div class="pro-block"><a href="#"><img alt="IMG-BENNER" class="lazy" data-src="<?= base_url()?>bootstrap/images/readymades/suit5.jpg"> <div class="pro-heading"><h2>Kurti</h2><p>Amet. Consectetur Adipiscing Elit.</p></div></a></div>

<div class="pro-block"><a href="#"><img alt="IMG-BENNER" class="lazy" data-src="<?= base_url()?>bootstrap/images/sarees/silk-banarasi.jpg"> <div class="pro-heading"><h2>Saree</h2><p>Amet. Consectetur Adipiscing Elit.</p></div></a></div>

<div class="pro-block"><a href="#"><img alt="IMG-BENNER" class="lazy" data-src="<?= base_url()?>bootstrap/images/readymades/suit3.jpg"> <div class="pro-heading"><h2>Dress</h2><p>Amet. Consectetur Adipiscing Elit.</p></div></a></div>

<div class="pro-block"><a href="#"><img alt="IMG-BENNER" class="lazy" data-src="<?= base_url()?>bootstrap/images/readymades/suit4.jpg"> <div class="pro-heading"><h2>Suit</h2><p>Amet. Consectetur Adipiscing Elit.</p></div></a></div>

</div>
</div>

</section>
                
                
<!--                <div class="product-category-head">
                    <h2>#<?= $subcat[0]->cat_name ?> </h2>
                    <p><?php echo  $subcat[0]->cat_desc != '' ? $subcat[0]->cat_desc : "" ?></p>
                </div>-->

<!--                <div class="row">
                    <div class="product-category-show">
                        <?php foreach ($subcat as $sub) { ?>
                        <div class="col-sm-6 col-xs-12 col-md-8 col-lg-6 ">
                            <div class="show-cat-block">
                               <img onclick="window.location.href='<?= base_url("details/".urlencode(strtolower($sub->cat_name)) . "/" . cleanUrl($sub->sub_name)) ?>/<?= encode($this->encryption->encrypt($sub->subid)) ?>'" class="lazy" data-src="<?= base_url("uploads/subcategory/") ?><?= $sub->sub_img ?>" alt="" />
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>-->
            </div>
<!--            <div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
                <div class="leftbar p-r-0-sm">
                    <h4 class=" in-category">
                        Categories
                    </h4>
                    <ul>
                        <?php foreach ($subcat as $su) { ?>
                        <?php
           

                                ?>
                        <li class="">
                            <a href="<?= base_url('details/'.urlencode(strtolower($su->cat_name)) . "/" . cleanUrl($su->sub_name)) ?>/<?= encode($this->encryption->encrypt($su->subid)) ?>" class="s-text13 active1">
                                <?= $su->sub_name ?>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>-->
        </div>
    </div>
</section>
<?php } else {
    ?>
<section class="bgwhite p-t-55 p-b-65">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 p-b-50">
                <div class="leftbar p-r-20 p-r-0-sm">
                    <h4>
                        <center>! Currently There is no Product Here !</center>
                    </h4>
                </div>

            </div>

        </div>

    </div>
</section>
<?php } ?>