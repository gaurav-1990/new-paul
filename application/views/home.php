<section class="slide1 ">
<div class="owl-main-slide owl-carousel">
<div><a href='#'><img  class="lazy" data-src="<?=base_url()?>bootstrap/images/slider/banner.jpg"></a></div>
<div><img class="lazy" data-src="<?=base_url()?>bootstrap/images/slider/banner.jpg"></div>
<div><img class="lazy" data-src="<?=base_url()?>bootstrap/images/slider/banner.jpg"></div>
</div>


</section>

<section class="aboutus">
    <div class="container">
        <div class="home-text">
            <div class="col-lg-12 col-md-12">
                <div class="text-block">
                    <h2>FINE SHOPPING EXPERIENCE</h2>
                    <p>paulsonsonline.com is a step ahead in the voyage of evolving and reaffirming our value system of Comfort, Trust & quality which is being woven Since 1984.</p>
                    <p>Our hand-picked and carefully crafted products are designed to fulfil the innate desires of today’s evolved shoppers. Our aspiration at all times is to delight you with collection that is <em><b>Fashionable yet Relatable, Modern yet Rooted in our Ethos & of Finest Quality yet Reasonably Priced.</b></em></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="all-pro-set offset-bg p-t-30">
<div class="container">
<div class="head-title">
<h2>Our Collection </h2>

<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
</div>

<div class="for-scroll" xss="removed">
<div class="all-pro-set-in">
<div class="owl-carousel3 owl-carousel">
    <div class="pro-block"><a href="#"><img alt="IMG-BENNER" class="lazy" data-src="<?=base_url()?>bootstrap/images/readymades/suit5.jpg"> <div class="pro-heading"><h2>Kurti</h2></div></a></div>

<div class="pro-block"><a href="#"><img alt="IMG-BENNER" class="lazy" data-src="<?=base_url()?>bootstrap/images/sarees/silk-banarasi.jpg"> <div class="pro-heading"><h2>Saree</h2></div></a></div>

<div class="pro-block"><a href="#"><img alt="IMG-BENNER" class="lazy" data-src="<?=base_url()?>bootstrap/images/readymades/suit3.jpg"> <div class="pro-heading"><h2>Dress</h2></div></a></div>

<div class="pro-block"><a href="#"><img alt="IMG-BENNER" class="lazy" data-src="<?=base_url()?>bootstrap/images/readymades/suit4.jpg"> <div class="pro-heading"><h2>Suit</h2></div></a></div>
  <div class="pro-block"><a href="#"><img alt="IMG-BENNER" class="lazy" data-src="<?=base_url()?>bootstrap/images/readymades/suit5.jpg"> <div class="pro-heading"><h2>Kurti</h2></div></a></div>

<div class="pro-block"><a href="#"><img alt="IMG-BENNER" class="lazy" data-src="<?=base_url()?>bootstrap/images/sarees/silk-banarasi.jpg"> <div class="pro-heading"><h2>Saree</h2></div></a></div>

<div class="pro-block"><a href="#"><img alt="IMG-BENNER" class="lazy" data-src="<?=base_url()?>bootstrap/images/readymades/suit3.jpg"> <div class="pro-heading"><h2>Dress</h2></div></a></div>

<div class="pro-block"><a href="#"><img alt="IMG-BENNER" class="lazy" data-src="<?=base_url()?>bootstrap/images/readymades/suit4.jpg"> <div class="pro-heading"><h2>Suit</h2></div></a></div>
</div>

</div>
</div>
</div>
</section>


        <!--Start Brand Section-->
        <section class="brand p-t-30">
            <div class="container">
                <div class="row justify-content-center">
                      <div class="col-md-5">
                        <div class="new-arriv">
                            <img class="lazy" data-src="<?=base_url()?>bootstrap/images/arrivals/lady-gown.jpg">
                            <div class="new-arriv-bg">

                            </div>
                            <div class="new-arriv-sec">
                                <div class="arriv-sec-head">
                                   <img class="lazy" data-src="<?=base_url()?>bootstrap/images/logo.png">
                                </div>
                                <!-- <div class="arriv-sec-body">
                                    <h3>PAULSONS</h3>
                                    <h2>Collection</h2>
                                 
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="new-ariv-right ">
                        <div class="head-title2">
                            <h2>NEW ARRIVALS </h2>
                            <a href="http://localhost:8080/new-paulsons/details/shop/new-arrivals/8f298811b626c25a62871631be62a5f04eb2d830215b46d1f8849e8060f2d82fdbdb65173cd50abefc751a72fff1022faebc1fce5d7c2fac96c6890a59672fd4bU8_d+7EJ3xfSvgmXzrOpGHH4jjiGyNQAn0cGrxkZYE-">VIEW ALL</a>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's </p>
                        </div>
                        <div class="owl-carousel45 owl-carousel">
                            <?php
foreach ($cars as $val) {
    // echo "<pre>";
    // print_r($val);
    $sub_name = cleanUrl($val->sub_name);
    $pro_name = cleanUrl($val->pro_name);
    $img = getProductImage($val->PID);
    ?>

                                <div class="item1">
                                    <div class="note-alert"><p>New</p></div>
                                        <!-- <div class="discount"><p>20%</p><span>Off</span></div> -->
                                    <div class="for-im">
                                        <div class="brand-image">
                                            <img class="lazy" data-src="<?=base_url()?>uploads/original/<?=$img?>" alt="<?= $val->pro_name ?>" title="<?= $val->pro_name ?>">
                                        </div>


                                    <button onclick="window.location.href='<?=base_url()?>product/<?=$sub_name?>/<?=$pro_name?>/<?=encode($this->encryption->encrypt($val->PID))?>'" > Shop Now</button>

                                    </div>
                                    <div class="brand-detail">
                                        <h3><?=$val->pro_name?></h3>
                                        <div class="price">
                                            <span><i class="fa fa-inr" aria-hidden="true"></i><?=$val->dis_price?></span>
                                            <span class="cut-price"><?=($val->act_price == $val->dis_price) ? "" : '<i class="fa fa-inr" aria-hidden="true"></i>'?><?=($val->act_price == $val->dis_price) ? "" : $val->act_price?></span>
                                        </div>
                                    </div>
                                    <div class="shp">
                                        <a href="<?=base_url()?>product/<?=$sub_name?>/<?=$pro_name?>/<?=encode($this->encryption->encrypt($val->PID))?>">SHOP NOW</a>
                                    </div>
                                </div>
<?php }?>
                        </div>
                    </div>

                </div>
            </div>

        </section>
         <!--End Brand Section-->



<!--
<section class="all-pro-offer p-t-15">
<div class="container" xss="removed">
<div class="head-title">
<h2>Car Collection</h2>

<p>Handpicked favourites just for you</p>
</div>

<div class="all-pro-offer-in">
<div class="col-md-6 big-block"><a href="<?=base_url()?>details/greenlight/classics/b40c3231c154ca6b528ef6d6750908f6d8b9bd34bb5bc5b9aca26bcd7ffe5ff6d69e0be8750f6dba2deb13c23732863f6a50eaa257dd183672edec8646a8de59lxZd+BejmGtYrrd8mXCA7fT4zS3Vj_f_w5fBzDEJxKw-"><img alt="IMG-BENNER" class="lazy" data-retina="<?=base_url()?>bootstrap/images/cars/below.jpg" data-src="<?=base_url()?>bootstrap/images/cars/cars-bg1.jpg"></a></div>

<div class="col-md-6 big-block2">
<div class="row">
<div class="col-md-12"><a href="<?=base_url()?>details/greenlight/classics/b40c3231c154ca6b528ef6d6750908f6d8b9bd34bb5bc5b9aca26bcd7ffe5ff6d69e0be8750f6dba2deb13c23732863f6a50eaa257dd183672edec8646a8de59lxZd+BejmGtYrrd8mXCA7fT4zS3Vj_f_w5fBzDEJxKw-"><img alt="IMG-BENNER" class="lazy" data-retina="<?=base_url()?>bootstrap/images/cars/cars-mob1.jpg" data-src="<?=base_url()?>bootstrap/images/cars/cars-side1.jpg"></a></div>

<div class="col-md-12 big-block4 "><a href="<?=base_url()?>dolls/barbie-doll/0355c486f022658814e32eaec1bd46c786a5096798160b9f23d47964b00db3f2c87aa55d77860213e8d2a821d8a190420403584a311cc29b729d9fc9bfc22f72IOIpDHiwEdbfH49tzefHS1Qb611wmmdq2yiZYaeCrWg-"><img alt="IMG-BENNER" class="lazy" data-src="<?=base_url()?>bootstrap/images/cars/cars-bg3.jpg"></a></div>
</div>
</div>
</div>
</div>
</section>

-->

<!-- <section class="slider-bottom-off offer-dispaly">
<div class="container">
<div class="slider-bottom-off-in">
<div class="offer-set"><img alt="IMG-BENNER" class="lazy" data-retina="<?=base_url()?>bootstrap/images/offer/mob/offer-mob1.jpg" data-src="<?=base_url()?>bootstrap/images/offer/offer1.jpg"></div>

<div class="offer-set"><img alt="IMG-BENNER" class="lazy" data-retina="<?=base_url()?>bootstrap/images/offer/mob/offer-mob2.jpg" data-src="<?=base_url()?>bootstrap/images/offer/offer2.jpg"></div>

<div class="offer-set"><img alt="IMG-BENNER" class="lazy" data-retina="<?=base_url()?>bootstrap/images/offer/mob/offer-mob1.jpg" data-src="<?=base_url()?>bootstrap/images/offer/offer3.jpg"></div>

<div class="offer-set"><img alt="IMG-BENNER" class="lazy" data-retina="<?=base_url()?>bootstrap/images/offer/mob/offer-mob2.jpg" data-src="<?=base_url()?>bootstrap/images/offer/offer4.jpg"></div>
</div>
</div>
</section> -->


<section class="best-seller-section p-t-15">


<div class="container" xss="removed">
<div class="head-title">
<h2>Best Sellers</h2>
<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
</div>

<div class="for-scroll">
<div class="best-seller-section-in">
    
<?php foreach ($trending as $val) {
    $sub_name = cleanUrl($val->sub_name);
    $pro_name = cleanUrl($val->pro_name);
    $img = getProductImage($val->PID);
    ?>
    <div class="pro-block">
        <div class="image-bt">
            <div class="img-section">
                <img alt="<?= $val->pro_name ?>" class="lazy" data-src="<?=base_url()?>uploads/original/<?=$img?>" title="<?= $val->pro_name ?>">
            </div>
            <button onclick="window.location.href='<?=base_url()?>product/<?=$sub_name?>/<?=$pro_name?>/<?=encode($this->encryption->encrypt($val->PID))?>'">SHOP NOW</button>
        </div>
        <div class="pro-price-details"><h2><?= $val->pro_name?></h2 >
            <span class="pss-rate">Rs <?=$val->dis_price?>/- </span>
            <span style='<?=((float) $val->act_price == (float)$val->dis_price) ? "display:none" : ""?>' class="mrp-rate">Rs <?=$val->act_price?>/-</span>
        </div>
    </div>
<?php }?>
<div class="load-more">
    <a href="http://localhost:8080/new-paulsons/details/shop/best-seller/7483517de538abd0a8ba3ea00b92b1dbdbb0bd20e504c674a3ae8b912ec818931f2d946827bee098cb22276d8d08fce4313b23f748b4e9ada05d712a6db0e8f0Wf+fXUtk3KaCEF8DrZ8shpdwaJ040clqLTje5g65nuU-">VIEW ALL</a>
</div>
</div>
</div>
</div>
    <div class="specility">
        <div class="container">
    <ul>
        <li>
            <div class="specility-inner">
                <div class="specility-icon"><i class="fa fa-truck fa-flip-horizontal" aria-hidden="true"></i></div>
                <div class="specility-details"><h4>FREE SHIPPING</h4><p>Across India. Shop as much as you want</p></div>
            </div>
        </li>
       <li>
            <div class="specility-inner">
                <div class="specility-icon"><i class="fa fa-tachometer" aria-hidden="true"></i></div>
                <div class="specility-details"><h4>QUICK DELIVERY</h4><p>Evey item is packed with love & care . With all safety measures followed.</p></div>
            </div>
        </li>
        <li>
            <div class="specility-inner">
                <div class="specility-icon"><i class="fa fa-credit-card-alt" aria-hidden="true"></i></div>
                <div class="specility-details"><h4>SECURE PAYMENT</h4><p>Following best industry-wide practices to ensure safest browsing & shopping.</p></div>
            </div>
        </li>
    </ul>
    </div>
    </div>
</section>


        <!--Start Brand Section-->
		<?php // if($dolls != NULL){?>
			<!-- <section class="brand">
             <div class="container">

					<div class="row justify-content-center">

						<div class="col-md-12">

					<div class="head-title">
					<h2>NEW ARRIVAL DOLLS</h2>

					<p>Show Some Brand Love</p>
                    </div>
                    <div class="owl-carousel45 owl-carousel">
					<?php // foreach($dolls as $val1){

// $sub_name = cleanUrl($val1->sub_name);
// $pro_name = cleanUrl($val1->pro_name);
// $img = getProductImage($val1->PID);
?>
						<div class="item1">
						<a href="<?=base_url()?>product/<?=$sub_name?>/<?=$pro_name?>/<?=encode($this->encryption->encrypt($val1->PID))?>">
                            <div class="brand-image">
                                <img src="<?=base_url()?>uploads/resized/resized_<?=$img?>" alt="<?=$img?>">
                            </div>
                            <div class="shp">
                                <a href="<?=base_url()?>product/<?=$sub_name?>/<?=$pro_name?>/<?=encode($this->encryption->encrypt($val1->PID))?>">SHOP NOW</a>
                            </div>
							</a>
						</div>
					<?php // } ?>
					</div>
						</div>
					</div>
			</div>

			</section> -->
					<?php // } ?>
         <!--End Brand Section-->


<!--
<section class="all-pro-offer p-t-15">
<div class="container" xss="removed">
<div class="head-title">
<h2>DOLLS NEW ARRIVALS</h2>

<p>Sunny days and sizzling dolls are here again!</p>
</div>

<div class="all-pro-offer-in">
<div class="col-md-6 big-block"><a href="<?=base_url()?>details/dolls/barbie-doll/0355c486f022658814e32eaec1bd46c786a5096798160b9f23d47964b00db3f2c87aa55d77860213e8d2a821d8a190420403584a311cc29b729d9fc9bfc22f72IOIpDHiwEdbfH49tzefHS1Qb611wmmdq2yiZYaeCrWg-"><img alt="IMG-BENNER" class="lazy" data-retina="<?=base_url()?>bootstrap/images/dolls/doll-mob-2.jpg" data-src="<?=base_url()?>bootstrap/images/dolls/doll-bg.jpg"></a></div>

<div class="col-md-6 big-block2">
<div class="row">
<div class="col-md-12 "><a href="<?=base_url()?>details/dolls/barbie-doll/0355c486f022658814e32eaec1bd46c786a5096798160b9f23d47964b00db3f2c87aa55d77860213e8d2a821d8a190420403584a311cc29b729d9fc9bfc22f72IOIpDHiwEdbfH49tzefHS1Qb611wmmdq2yiZYaeCrWg-"><img alt="IMG-BENNER" class="lazy" data-retina="<?=base_url()?>bootstrap/images/dolls/doll-mob-1.jpg" data-src="<?=base_url()?>bootstrap/images/dolls/doll-bg2.jpg"></a></div>

<div class="col-md-12 big-block4 "><a href=" <?=base_url()?>details/dolls/barbie-doll/0355c486f022658814e32eaec1bd46c786a5096798160b9f23d47964b00db3f2c87aa55d77860213e8d2a821d8a190420403584a311cc29b729d9fc9bfc22f72IOIpDHiwEdbfH49tzefHS1Qb611wmmdq2yiZYaeCrWg-"><img alt="IMG-BENNER" class="lazy" data-src="<?=base_url()?>bootstrap/images/dolls/doll-bg3.jpg"></a></div>
</div>
</div>
</div>
</div>
</section>
-->

<!--<section class="brand">
             <div class="container">

					<div class="row justify-content-center">

						<div class="col-md-12">

					<div class="head-title">
					<h2>TRENDING NOW</h2>
					<img src="<?=base_url()?>assets/images/karz-border.png">
					<p>From the runway to your home</p>
                    </div>
                    <div class="owl-carousel4 owl-carousel">

                    <?php foreach ($trending as $val) {
    // echo "<pre>";
    // print_r($val);
    $sub_name = cleanUrl($val->sub_name);
    $pro_name = cleanUrl($val->pro_name);
    $img = getProductImage($val->PID);
    ?>

                        <div class="item1">
                        <div class="for-im">
                            <div class="brand-image">
                                <img class="lazy" data-src="<?=base_url()?>uploads/original/<?=$img?>" alt="<?=$img?>">
							</div>
							</div>
							<div class="brand-detail">
								<h3><?=$val->pro_name?></h3>
								<div class="price">
									<span><i class="fa fa-inr" aria-hidden="true"></i><?=$val->dis_price?></span>
									<span class="cut-price"><?=($val->act_price == $val->dis_price) ? "" : '<i class="fa fa-inr" aria-hidden="true"></i>'?><?=($val->act_price == $val->dis_price) ? "" : $val->act_price?></span>
								</div>
							</div>
                            <div class="shp">
                                <a href="<?=base_url()?>product/<?=$sub_name?>/<?=$pro_name?>/<?=encode($this->encryption->encrypt($val->PID))?>">SHOP NOW</a>
                            </div>

                        </div>

                    <?php }?>
					</div>
						</div>
					</div>
			</div>

			</section>-->





        <!--Start Brand Section-->
<!--			<section class="brands">
             <div class="container">

					<div class="row justify-content-center">

						<div class="col-md-12">

					<div class="head-title">
					<h2>OUR BRANDS</h2>
					<img src="<?=base_url()?>assets/images/karz-border.png">

                    </div>

							<div class="owl-carousel3 owl-carousel">
							  <div class="item1">
							  	<div class="brand-image">
							<img class="lazy" data-src="bootstrap/images/brands/01.jpg" alt="01">
							</div>
						</div>
						  <div class="item1">
							  	<div class="brand-image">
							<img class="lazy" data-src="bootstrap/images/brands/02.jpg" alt="01">
							</div>
						</div>
							  <div class="item1">
							  	<div class="brand-image">
							<img class="lazy" data-src="bootstrap/images/brands/03.jpg" alt="01">
							</div>
						</div>
							  <div class="item1">
							  	<div class="brand-image">
							<img class="lazy" data-src="bootstrap/images/brands/04.jpg" alt="01">
							</div>
						</div>
						<div class="item1">
							  	<div class="brand-image">
							<img class="lazy" data-src="bootstrap/images/brands/05.jpg" alt="01">
							</div>
						</div>
							  <div class="item1">
							  	<div class="brand-image">
							<img class="lazy" data-src="bootstrap/images/brands/06.jpg" alt="01">
							</div>
						</div>
						  <div class="item1">
							  	<div class="brand-image">
							<img class="lazy" data-src="bootstrap/images/brands/07.jpg" alt="01">
							</div>
						</div>
							  <div class="item1">
							  	<div class="brand-image">
							<img class="lazy" data-src="bootstrap/images/brands/08.jpg" alt="01">
							</div>
						</div>
	                                                  <div class="item1">
							  	<div class="brand-image">
							<img class="lazy" data-src="bootstrap/images/brands/09.jpg" alt="01">
							</div>
						</div>
                                                          <div class="item1">
							  	<div class="brand-image">
							<img class="lazy" data-src="bootstrap/images/brands/10.jpg" alt="01">
							</div>
						</div>
                                                         <div class="item1">
							  	<div class="brand-image">
							<img class="lazy" data-src="bootstrap/images/brands/11.jpg" alt="01">
							</div>
						</div>
                                                         <div class="item1">
							  	<div class="brand-image">
							<img class="lazy" data-src="bootstrap/images/brands/12.jpg" alt="01">
							</div>
						</div>
                                                            <div class="item1">
							  	<div class="brand-image">
							<img class="lazy" data-src="bootstrap/images/brands/13.jpg" alt="01">
							</div>
						</div>
							</div>
						</div>
					</div>
			</div>

			</section>-->
         <!--End Brand Section-->
         <section class="brands">
             <div class="container">
                 <div class="newslatter">
                     <div class="row  news-in">
                         <h3>Never miss our updates about <br>new arrivals and special offers</h3>
                         <form action="" method="POST">
                             <input type="email" name="email" required="" placeholder="Email Address">
                             <div class="subcrip">
                                 <button type="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> SUBSCRIBE</button>
                             </div>
                         </form>
                     </div>
                 </div>
                 <div class="news-social">
                 <a href="https://www.instagram.com/paulsonsshop/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                 <a href="https://www.facebook.com/paulsonsonline/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                 </div>
             </div>
         </section>