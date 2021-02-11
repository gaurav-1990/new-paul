<?php

if ($products !== null) {
    ?>

    <section class="inner-slider-set"
             style="background-image: url(<?=base_url()?>uploads/subcategory/<?=$products[0]->sub_img?>);">

        <h2 class="l-text2 t-center">

            <?=$products[0]->cat_desc != '' ? $products[0]->cat_name : ""?>
        </h2>
        <p class="m-text13 t-center">
            <?=$products[0]->cat_desc?>
        </p>
    </section>

    <div class="firstAddToCart"></div>
    <section class="product-show-set">
        <div class="product-show-heading">
            <div class="myNav">
                <?php
$cat_url = base_url('shop/') . cleanUrl($products[0]->cat_name) . "/" . encode($this->encryption->encrypt($products[0]->cat_id));
    $sub_url = base_url("details/" . urlencode(strtolower($products[0]->cat_name))) . "/" . cleanUrl($products[0]->sub_name) . "/" . encode($this->encryption->encrypt($products[0]->sub_id));
    if (isset($products[0]->child_id) && ($products[0]->child_id != 0)) {
        $getChild = getChild($products[0]->child_id);
        $child_url = base_url("Dashboard/p_/") . cleanUrl($getChild->sub_name) . "/" . encode($this->encryption->encrypt($getChild->id));
    }
    ?>
                <a href="<?=base_url();?>"> Home /</a>
                <a href="<?=$cat_url?>"><?=$products[0]->cat_name?> <?=($products[0]->cat_name != null) ? '/' : ''?> </a>
                <a href="<?=$sub_url?>"><?=$products[0]->sub_name?> <?=(isset($getChild)) ? '/' : ''?></a>
                <!-- <a href="<?=(isset($child_url)) ? $child_url : '#'?>">
                <?=(isset($getChild) && $getChild->sub_name != null) ? $getChild->sub_name : ''?> </a> -->
                <span> <?=(isset($getChild) && $getChild->sub_name != null) ? $getChild->sub_name : ''?></span>
            </div>
            <div class="top-item-show">
                <h2>
                    <?=isset($products[0]->sub_name) ? $products[0]->sub_name : ''?><span
                            id="prod_count"> <?=($totalPro)?> items
                    </span></h2>
            </div>
            <?php
?>
            <div class="filter-head">
                <div class="row">
                    <div class="col-md-2 col-xs-12">
                        <h2>Filters <span onclick="window.location.href='<?=current_url();?>'"
                                          class="header-clearAllBtn">CLEAR ALL</span></h2>
                    </div>
                    <!-- <div  class="col-md-7 col-xs-12">
                        <div class="product-short">
                            <ul>
                                <?php

    if ($products[0]->child_id == 0) {
        $sid = encode($this->encryption->encrypt($products[0]->sub_id));

        $res = getSpecification($sid);
    } else {

        $sid = encode($this->encryption->encrypt($products[0]->child_id));
        $res = getChildSpecif($sid);
    }

    $response = array_unique($res);
    $counters = 1;
    $counters2 = 1;
    foreach ($response as $fil) {
        ?>
                                    <li data-val="<?=$fil?>" id="prop_<?=$counters?>"
                                        onclick="clickTopFilters(this, '<?=$counters?>')">

                                        <a href="javascript:void(0);">
                                            <?=$fil?>
                                            <i class="fa fa-angle-up"  id="icon_<?=$counters?>" aria-hidden="true"></i>
                                        </a>

                                    </li>


                                    <?php
$counters++;
    }
    ?>
                            </ul>
                            <?php foreach ($response as $fil2) {?>

                                <div class="open-drop<?=$counters2?> open-drop myfilter" style="display:none">
                                    <?php dynFilter($fil2, $counters2, $this->input->get());?>
                                </div>
                                <?php
$counters2++;
    }
    ?>
                        </div>
                    </div> -->


                    <div class="col-sm-3 col-xs-6 col-md-3 col-lg-2 pull-right">
                        <div class=" default-sort">
                            <select class="selection-2" name="sorting" id="test22">
                                <option value="def">Sort by : Recommended</option>
                                <option value="l2h">Price: low to high</option>
                                <option value="h2l">Price: high to low</option>
                                <option value="n2o">New to Old</option>
                                <option value="o2n">Old to New</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="product-show-bottom">
            <div class="row">
                <?php
if (!isMobile() || isTablet() == true) {

        ?>
                    <div class="product-show-filter myfilter">

                        <?php
$arrayPrice = $this->input->get("price") != null ? $this->input->get("price") : null;
        $arrayPrice = explode(":", $arrayPrice);

        ?>
                        <div>

                            <h3>Price </h3>

                            <div <?php $priceCount = $products[0]->child_id != 0 ? getPriceCountChild($products[0]->child_id, 500, 2500) : getPriceCount($products[0]->sub_id, 500, 2500); ($priceCount == 0 ? "style='display:none'" : "")?> class="custom-control custom-checkbox">
                                <input type="checkbox"
                                       data-from="500" <?=in_array("500|2500", $arrayPrice) ? "checked" : ""?>
                                       value="500|2500"  name="price" data-to="2500" class="custom-control-input"
                                       id="defaultUnchecked">

                                <label class="custom-control-label" for="defaultUnchecked">Rs. 500 to Rs.
                                    2500 </label>
                                <span class="text-right">(<?=$priceCount?>)</span>
                            </div>

                            <div <?php $priceCount = $products[0]->child_id != 0 ? getPriceCountChild($products[0]->child_id, 2501, 5000) : getPriceCount($products[0]->sub_id, 2501, 5000); ($priceCount == 0 ? "style='display:none'" : "")?>  class="custom-control custom-checkbox">
                                <input type="checkbox"
                                       data-from="2501" <?=in_array("2501|5000", $arrayPrice) ? "checked" : ""?>
                                       value="2501|5000" name="price" data-to="5000" class="custom-control-input"
                                       id="defaultUnchecked1">
                                <label class="custom-control-label" for="defaultUnchecked1">Rs. 2501 Rs.
                                    5000</label>
                                <span class="text-right">(<?=$priceCount?>)</span>
                            </div>

                            <div  <?php $priceCount = $products[0]->child_id != 0 ? getPriceCountChild($products[0]->child_id, 5001, 7500) : getPriceCount($products[0]->sub_id, 5000, 7500); ($priceCount == 0 ? "style='display:none'" : "")?>  class="custom-control custom-checkbox">
                                <input type="checkbox"
                                       data-from="5001" <?=in_array("5001|7500", $arrayPrice) ? "checked" : ""?>
                                       value="5001|7500" name="price" data-to="7500" class="custom-control-input"
                                       id="defaultUnchecked2">
                                <label class="custom-control-label" for="defaultUnchecked2">Rs. 5000 Rs.
                                    7500</label>
                                <span class="text-right">(<?=$priceCount?>)</span>
                            </div>
                            <div <?php $priceCount = $products[0]->child_id != 0 ? getPriceCountChild($products[0]->child_id, 7501, 10000) : getPriceCount($products[0]->sub_id, 7501, 10000); ($priceCount == 0 ? "style='display:none'" : "")?> class="custom-control custom-checkbox">
                                <input type="checkbox"
                                       data-from="7501" <?=in_array("7501|10000", $arrayPrice) ? "checked" : ""?>
                                       value="7501|10000" name="price" data-to="10000" class="custom-control-input"
                                       id="defaultUnchecked3">
                                <label class="custom-control-label" for="defaultUnchecked3">Rs. 7501 Rs.
                                    10000</label>
                                <span class="text-right">(<?=$priceCount?>)</span>
                            </div>
                            <div class="custom-control custom-checkbox"  <?php
$priceCount = $products[0]->child_id != 0 ? getPriceCountChild($products[0]->child_id, 10001, 20000) : getPriceCount($products[0]->sub_id, 10001, 20000);
        ($priceCount == 0 ? "style='display:none'" : $priceCount);
        ?>>
                                <input type="checkbox"
                                       data-from="10001" <?=in_array("10001|20000", $arrayPrice) ? "checked" : ""?>
                                       value="10001|20000" name="price" data-to="20000" class="custom-control-input"
                                       id="defaultUnchecked4">
                                <label class="custom-control-label" for="defaultUnchecked4">Rs. 10001 Rs.
                                20000</label>
                                <span class="text-right">(<?=$priceCount?>)</span>
                            </div>

                        </div>
                        <div>
                            <?php
if ($propertyName != null) {
            $cou = 1;
            foreach ($propertyName as $prop_name) {

                if ($prop_name->id != 2) {
                    $attribute = getAttributes($prop_name->id);
                    ?>
                                        <h3><?=$prop_name->pop_name?></h3>
                                        <?php
}
                $onlyShow = 10; // handle view more
                if (isset($attribute) && $attribute != null) {

                    foreach ($attribute as $on => $attr) {

                        if ($prop_name->catalog_type == 1) {

                            $attArr = null;
                            if ($this->input->get(strtolower(str_replace(" ", "", $prop_name->pop_name)))) {
                                $attArr = explode(":", $this->input->get(strtolower(str_replace(" ", "", $prop_name->pop_name))));
                            }

                            ?>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" <?=$attArr != null ? (in_array(strtolower(str_replace(" ", "", $attr->attr_name)), $attArr) == 1 ? "checked" : "") : ""?>
                                                           name="<?=strtolower(str_replace(" ", "", $prop_name->pop_name))?>"
                                                           value="<?=strtolower(str_replace(" ", "", $attr->attr_name));?>"
                                                           class="custom-control-input"
                                                           id="defaultcUnchecked<?=$cou?>">
                                                    <label class="custom-control-label"
                                                           for="defaultcUnchecked<?=$cou?>"><?=$attr->attr_name?>
                                                    </label>
                                                    <span class="text-right"> </span>
                                                </div>

                                                <?php
} else {
                            $arrColor1 = $this->input->get("color") ? explode(":", $this->input->get("color")) : [];
                            $arrColor = [];
                            foreach ($arrColor1 as $co) {
                                $arrColor[] = "#" . $co;
                            }

                            if ($onlyShow > $on) {

                                ?>
                                                    <div <?=$co = $products[0]->child_id != 0 ? getColorcountChild($products[0]->child_id, $attr->color_code) : getColorcount($products[0]->sub_id, $attr->color_code)?>  <?=$co == 0 ? "style='display:none'" : ""?> class="custom-control custom-checkbox">
                                                        <input type="checkbox"
                                                               name="<?=strtolower(str_replace(" ", "", $prop_name->pop_name))?>" <?=$arrColor != null ? (in_array($attr->color_code, $arrColor) ? "checked" : "") : ""?>
                                                               value="<?=$attr->color_code?>"
                                                               class="custom-control-input"
                                                               id="defaultsUnchecked<?=$cou?>">
                                                        <span class="select-col"
                                                              style="background-color:<?=$attr->color_code?>;"></span>
                                                        <label class="custom-control-label"
                                                               for="defaultsUnchecked<?=$cou?>"><?=$attr->attr_name?>
                                                        </label>
                                                        <span class="text-right">(<?=$products[0]->child_id != 0 ? getColorcountChild($products[0]->child_id, $attr->color_code) : getColorcount($products[0]->sub_id, $attr->color_code)?>)</span>
                                                    </div>

                                                    <?php ?>

                                                    <?php
} else {

                                if ($onlyShow == $on) {
                                    ?>
                                                        <a onclick="$('.hideme').toggle()" href="javascript:void(0)">View
                                                            More</a>
                                                        <?php
}
                                ?>

                                                    <div  style="display:none" class="hideme">
                                                        <div <?=$co = $products[0]->child_id != 0 ? getColorcountChild($products[0]->child_id, $attr->color_code) : getColorcount($products[0]->sub_id, $attr->color_code)?>  <?=$co == 0 ? "style='display:none'" : ""?> class="custom-control custom-checkbox">
                                                            <input type="checkbox" <?=$arrColor != null ? (in_array($attr->color_code, $arrColor) ? "checked" : "") : ""?>
                                                                   name="<?=strtolower(str_replace(" ", "", $prop_name->pop_name))?>"
                                                                   value="<?=$attr->color_code?>"
                                                                   class="custom-control-input"
                                                                   id="defaultsUnchecked<?=$cou?>">
                                                            <span class="select-col"
                                                                  style="background-color:<?=$attr->color_code?>;"></span>
                                                            <label class="custom-control-label"
                                                                   for="defaultsUnchecked<?=$cou?>"><?=$attr->attr_name?>
                                                            </label>
                                                            <span class="text-right">(<?=$products[0]->child_id != '' ? getColorcountChild($products[0]->child_id, $attr->color_code) : getColorcount($products[0]->sub_id, $attr->color_code)?>)</span>
                                                        </div>
                                                    </div>
                                                    <?php
}
                        }
                        $cou++;
                    }
                }
            }
        }
        ?>
                        </div>

                    </div>
                <?php }?>

                <div class="product-show-right">

                    <div class="row no-gutters">
                        <?php
$diff = 0;
    $subscription_day = 10;
    foreach ($products as $pro) {
    
        $sub_name = cleanUrl($pro->sub_name);
        $pro_name = cleanUrl($pro->pro_name);
        $data_attr = getDataElement($pro->ID);

        $specifications = getSpecifications($pro->ID);

        $date1 = date("d-m-Y");
        $date2 = $pro->visible_from_date;
        $now = strtotime($date1);
        $your_date = strtotime($date2);
        $datediff = $now - $your_date;
        $diff = round($datediff / (60 * 60 * 24));

        if ($subscription != null) {
            $subscription_day = $subscription->subscription_validity_days;
            $diff = $subscription->subscription_validity_days;
        } else {
            $subscription_day = 10;
        }

        if ($diff >= 0) {
            ?>
                                <div class=" col-md-4 col-lg-3 col-xs-6 mob-col-pad" onclick="firstCart.viewSimilarProd(this)" data-latest="<?= encode($this->encryption->encrypt($pro->ID)) ?>"
                                     data-price="<?=$pro->dis_price?>" <?=$data_attr?> <?=$specifications?>>
                                    <div class="show-product-small-bx ">
                                        <?php
if ($pro->type == 1) {
                ?>
                                            <div class="view-sale">
                                                <span class="sale-tb">Sale</span>
                                            </div>
                                        <?php }?>
                                        <?php
if ($pro->type == 3) {
                ?>
                                            <div class="view-sale">
                                                <span class="tren-tb">Trending</span>
                                            </div>
                                        <?php }?>
                                        <?php
if ($pro->type == 2) {
                ?>
                                            <div class="view-sale">
                                                <span class="top-tb">Top Seller</span>
                                            </div>
                                        <?php }?>
                                        <?php
if ($pro->type == 4) {
                ?>
                                            <div class="view-sale">
                                                <span class="new-tb">New Arrival</span>
                                            </div>
                                        <?php }?>
                                        <?php
$getSubscription = load_subscription();
            $primeDiscount = floatval($pro->dis_price) * floatval($getSubscription->subscription_cal) / 100; // prime member
            $subs_price = round(floatval($pro->dis_price) - floatval($primeDiscount));
            ?>

                                        <div class="view-rlt">
                                            
                                            <a href="#" class="sim_prd" data-toggle="modal" data-target="#myModal2"
                                               data-prod="<?= $pro->ID ?>">  
                                               <!-- encode($this->encryption->encrypt($pro->ID)) -->
                                                <img src="<?= base_url()?>/bootstrap/images/similer.png">
                                                View Similar
                                            </a>

                                        </div>
                                        <a href="<?=base_url("product/$sub_name/$pro_name/" . encode($this->encryption->encrypt($pro->ID)));?>"
                                           class="block-active">
                                        </a>

                                        <div class="img-top-set">
                                            <div class="img-top-set-in">
                                                <img class="lazy"
                                                     data-src="<?=base_url('uploads/resized/')?>resized_<?=load_images($pro->ID)?>"
                                                     alt="<?=$pro->pro_name?>" title="<?=$pro->pro_name?>" />
                                            </div>
 <button onclick="window.location.href='<?=base_url("product/$sub_name/$pro_name/" . encode($this->encryption->encrypt($pro->ID)));?>'">SHOP NOW</button>
                                        </div>
 <span>
                                                <button class="right-wish"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
                                            </span>

                                        <div class="add-top-size" data-pro="<?=encode($this->encryption->encrypt($pro->ID))?>"> <!-- encode($this->encryption->encrypt( ))-->
                                            <?php
if (isset(json_decode($pro->product_attr)->response)) {
                ?>
                                                <h4> Select a size <i class="fa fa-times-circle  pull-right"
                                                                      onclick="closeEffect(this);"> </i></h4>
                                                <ul>
                                                    <?php
foreach (json_decode($pro->product_attr)->response as $key => $attr) {
                    foreach ($attr->attribute as $a) {
                        $k = (key((array) $a));
                        $str = strtoupper((string) $a->$k);
                        if ((int) $attr->qty < 1) {
                            ?>
                                                                <li data-prop="<?=strtolower((string) $k)?>"
                                                                    data-qty="<?=$attr->qty?>"
                                                                    data-attr="<?=strtoupper((string) $a->$k)?>">
                                                                    <a href=" javascript:void(0)" class="off-no">
                                                                        <?=$str?>
                                                                        <!-- <img src="<?=base_url()?>bootstrap/images/ban.png" alt="" /> -->
                                                                    </a>
                                                                </li>
                                                                <?php
} else {
                            ?>
                                                                <li data-prop="<?=strtolower((string) $k)?>"
                                                                    data-qty="<?=$attr->qty?>"
                                                                    data-attr="<?=strtoupper((string) $a->$k)?>">
                                                                    <a href="javascript:void(0)"
                                                                       class="<?=((int) $attr->qty < 1) ? 'off-no' : ''?>"><?=$str?></a>
                                                                    <?php
if ((int) $attr->qty < 5) {
                                ?>
                                                                        <span class="left-stock"><?=$attr->qty?>
                                                                            left</span>
                                                                        <?php
}
                            ?>
                                                                </li>

                                                                <?php
}
                    }
                    ?>
                                                        <?php
}
                ?>
                                                </ul>
                                            <?php }?>
                                        </div>

                                        <div class="detail-cover"
                                             onclick="window.location.href = '<?=base_url("product/$sub_name/$pro_name/" . encode($this->encryption->encrypt($pro->ID)));?>'">

                                            <!-- <div class="whs"></div> -->
                                            <div class="whs2"></div>
                                            <div class="detail-text">
                                                <h3><?=strlen($pro->pro_name) > 40 ? substr($pro->pro_name, 0, 40) . "..." : $pro->pro_name?>
                                                </h3>
                                                <p class="discrip">
                                                    <?=strlen($pro->product_sname) > 40 ? substr($pro->product_sname, 0, 40) . "..." : $pro->product_sname?>
                                                </p>
                                                <?php
if (isset(json_decode($pro->product_attr)->response)) {
                ?>
                                                    <p class="size-pl">
                                                        Size
                                                        <?php
foreach (json_decode($pro->product_attr)->response as $key => $attr) {
                    foreach ($attr->attribute as $a) {
                        $k = (key((array) $a));
                        $str = strtoupper((string) $a->$k);
                        ?>
                                                                <span><?=$str?></span>
                                                                <?php
}
                }
                ?>
                                                    </p>
                                                <?php } else {?>
                                                    <p class="size-pl">
                                                        <span>One Size</span>
                                                    </p>
                                                <?php }?>
                                            </div>

                                            <div class="detail-price">
                                                <?php
if ($this->session->userdata('myaccount') != null || $this->session->userdata('app_id') != null) {
                $prod_price = 0;
                $userID = getUserIdByEmail();
                if (@count($userID) > 0) {
                    $userDetail = $this->user->get_profile_id($userID);
                    if ($userDetail->is_prime == 1) {
                        $getSubscription = load_subscription();
                        $primeDiscount = floatval($pro->dis_price) * floatval($getSubscription->subscription_cal) / 100; // prime member
                        $prod_price_pri = (floatval($pro->dis_price) - floatval($primeDiscount));
                        $prod_price = $pro->dis_price;
                    } else {
                        $prod_price = $pro->dis_price;
                    }
                }
            } else {

                $prod_price = $pro->dis_price;
            }
            ?>
                                                <span class="rs">Rs. <?=round($prod_price)?></span>
                                                <span class="cut"><?=($pro->act_price == $pro->dis_price) ? "" : 'Rs.' . round($pro->act_price)?></span>
                                                <?php
if (isset($userDetail)) {

                if ($userDetail->is_prime == 1) {
                    $decrease = floatval($pro->act_price) - floatval($prod_price);
                } else {
                    $decrease = floatval($pro->act_price) - floatval($prod_price);
                }
            } else {
                $decrease = floatval($pro->act_price) - floatval($prod_price);
            }

            $percentage = $decrease / floatval($pro->act_price) * 100;
            ?>
                                                <span class="off"><?=($pro->act_price == $pro->dis_price) ? "" : (round($percentage) . '% off')?></span>
                                                <!-- <div class="specialPrice"><span class="">  Price for prime : <?=number_format($subs_price, 2, '.', '')?></span></div> -->
                                            </div>

                                        </div>

                                        <!-- <div class="add-wish-prod">
                                            <span>
                                                <button data-id="<?=encode($this->encryption->encrypt($pro->ID))?>"
                                                        class="left-add add-cart">ADD TO BAG</button>
                                            </span>
                                            <span>
                                                <button class="right-wish"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
                                            </span>
                                        </div> -->


                                    </div>
                                </div>

                                <?php
}
    }
    ?>

                    </div>
                    <div class="row">
                        <?=$link?>
                    </div>
                </div>

            </div>
        </div>

        <div class="load">
            <img src="<?=base_url()?>bootstrap/images/svg-icons/generator.svg" class="header-icon1" alt="ICON">
        </div>
    </section>


    <?php
} else {
    ?>
    <section class="bgwhite p-t-55 p-b-65">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 p-b-50">
                    <div class="leftbar p-r-20 p-r-0-sm">
                        <h4>
                            <center>! Currently There Is No Product Here !</center>
                        </h4>
                    </div>

                </div>

            </div>

        </div>
    </section>
<?php }
?>

<div class="container demo">

    <!-- Modal -->

    <div class="view-similar modal right fade" id="myModal2" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel2">SIMILAR PRODUCTS</h4>
                </div>

                <div class="modal-body">

                    <div class="simProd"></div>

                </div>

            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->


    <div class="view-similar1 modal right1 fade" id="myModal200" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel2">To add in wishlist goto login!!!</h4>
                </div>

                <div class="modal-body">

                    <div class="simProd"></div>

                </div>

            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->




    <div class="mob-filter">
        <button data-toggle="modal" data-target="#myModal3"><i class="fa fa-exchange" aria-hidden="true"></i> Sort
            by
        </button>
        <button data-toggle="modal" data-target="#myModal4"><i class="fa fa-filter" aria-hidden="true"></i>
            Filter
        </button>

        <div class=" short-by modal  fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel2">SORT BY</h4>
                    </div>

                    <div class="modal-body">

                        <ul>

                            <!-- <li>
                                <a id="latest" href="#"><i class="fa fa-star-o" aria-hidden="true"></i> Latest</a>
                            </li> -->
                            <li>
                                <a id="hightoLow" href="#"><i class="fa fa-inr" aria-hidden="true"></i><i
                                            class="fa fa-long-arrow-down" aria-hidden="true"></i> Price High to Low</a>
                            </li>
                            <li>
                                <a id="lowtoHigh" href="#"><i class="fa fa-inr" aria-hidden="true"></i><i
                                            class="fa fa-long-arrow-up" aria-hidden="true"></i> Price Low to High</a>
                            </li>
                            <li>
                                <a id="new2old" href="#"><i class="fa fa-inr" aria-hidden="true"></i><i
                                            class="fa fa-long-arrow-up" aria-hidden="true"></i> New to Old</a>
                            </li>
                            <li>
                                <a id="old2new" href="#"><i class="fa fa-inr" aria-hidden="true"></i><i
                                            class="fa fa-long-arrow-up" aria-hidden="true"></i> Old to New</a>
                            </li>
                        </ul>


                    </div>

                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div>
        <div class=" filter-by modal  fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <button id="applyMobileFilter" type="button" data-dismiss="modal" aria-label="Close">Apply</button>
                        <h4 class="modal-title" id="myModalLabel2">Filter</h4>
                    </div>
                    <?php
if (isMobile()) {
    $arrayPrice = $this->input->get("price") != null ? $this->input->get("price") : null;

    $arrayPrice = explode(":", $arrayPrice);

    if ($propertyName != null) {
        ?>
                    <div class="modal-body myfilterMobile">


                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#price">Price </a></li>
                            <?php
foreach ($propertyName as $prop_name) {
            if ($prop_name->id != 2) {
                ?>
                                    <li><a data-toggle="tab"
                                           href="#<?=strtolower(str_replace(" ", "", $prop_name->pop_name))?>"><?=$prop_name->pop_name?></a>
                                    </li>
                                    <?php
}
        }
        ?>

                        </ul>

                        <div class="tab-content">

                            <div id="price" class="tab-pane fade in active">
                                <div class="color-flt">
                                    <ul>
                                        
                                        <li class="active">
                                            <div <?php $priceCount = $products[0]->child_id != 0 ? getPriceCountChild($products[0]->child_id, 500, 2500) : getPriceCount($products[0]->sub_id, 500, 2500);?> <?=$priceCount == 0 ? "style='display:none'" : ""?> class="custom-control custom-checkbox">
                                                <input <?=in_array("500|2500", $arrayPrice) ? "checked" : ""?> type="checkbox" data-from="500" value="500|2500" name="price" data-to="2500" class="custom-control-input" id="defaultUnchecked">
                                                <label class="custom-control-label" for="defaultUnchecked"> Rs. 500 to Rs. 2500 </label>
                                                <span class="text-right">(<?=$priceCount?>)</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div <?php $priceCount = $products[0]->child_id != 0 ? getPriceCountChild($products[0]->child_id, 2501, 5000) : getPriceCount($products[0]->sub_id, 2501, 5000);?> <?=$priceCount == 0 ? "style='display:none'" : ""?>  class="custom-control custom-checkbox">
                                                <input <?=in_array("2501|5000", $arrayPrice) ? "checked" : ""?> type="checkbox" data-from="2501" value="2501|5000" name="price"
                                                       data-to="5000" class="custom-control-input"
                                                       id="defaultUnchecked1">
                                                <label class="custom-control-label" for="defaultUnchecked1">
                                                    Rs. 2501 Rs.
                                                    5000</label>
                                                <span class="text-right">(<?=$priceCount?>)</span>
                                            </div>
                                        </li>

                                        <li>
                                            <div <?php $priceCount = $products[0]->child_id != 0 ? getPriceCountChild($products[0]->child_id, 5001, 7500) : getPriceCount($products[0]->sub_id, 5001, 7500);?>   class="custom-control custom-checkbox" <?=$priceCount == 0 ? "style='display:none'" : ""?> >
                                                <input  <?=in_array("5001|7500", $arrayPrice) ? "checked" : ""?> type="checkbox" data-from="5001" value="5001|7500" name="price"
                                                       data-to="7500" class="custom-control-input"
                                                       id="defaultUnchecked2">
                                                <label class="custom-control-label" for="defaultUnchecked2">
                                                    Rs. 5001 Rs.
                                                    7500</label>
                                                <span class="text-right">(<?=$priceCount?>)</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div   <?php $priceCount = $products[0]->child_id != 0 ? getPriceCountChild($products[0]->child_id, 7501, 10000) : getPriceCount($products[0]->sub_id, 7501, 10000);?> class="custom-control custom-checkbox" <?=$priceCount == 0 ? "style='display:none'" : ""?> >
                                                <input <?=in_array("7501|10000", $arrayPrice) ? "checked" : ""?> type="checkbox" data-from="7501" value="7501|10000" name="price"
                                                       data-to="10000" class="custom-control-input"
                                                       id="defaultUnchecked4">
                                                <label class="custom-control-label" for="defaultUnchecked4">
                                                    Rs. 7501 Rs.
                                                    10000</label>
                                                <span class="text-right">(<?=$priceCount?>)</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div <?php $priceCount = $products[0]->child_id != 0 ? getPriceCountChild($products[0]->child_id, 10001, 20000) : getPriceCount($products[0]->sub_id, 10001, 20000);?>  <?=$priceCount == 0 ? "style='display:none'" : ""?> class="custom-control custom-checkbox">
                                                <input <?=in_array("10001|20000", $arrayPrice) ? "checked" : ""?>  type="checkbox" data-from="10001" value="10001|20000" name="price"
                                                       data-to="20000" class="custom-control-input"
                                                       id="defaultUnchecked5">
                                                <label class="custom-control-label" for="defaultUnchecked5">
                                                    Rs. 10001 Rs.
                                                    20000</label>
                                                <span class="text-right">(<?=$priceCount?>)</span>
                                            </div>
                                        </li>
                                    </ul>

                                </div>


                            </div>

                            <?php
$cou = 1;

        foreach ($propertyName as $prop_name) {

            if ($prop_name->id != 2) {
                $attribute = getAttributes($prop_name->id);

                if (isset($attribute) && $attribute != null) {
                    ?>
                                        <div id="<?=strtolower(str_replace(" ", "", $prop_name->pop_name))?>"
                                             class="tab-pane fade">
                                            <div class="color-flt">
                                                <ul>
                                                    <?php
$c = 1;
                    foreach ($attribute as $attr) {
                        if ($prop_name->catalog_type == 1) {
                            $attArr = null;
                            if ($this->input->get(strtolower(str_replace(" ", "", $prop_name->pop_name)))) {
                                $attArr = explode(":", $this->input->get(strtolower(str_replace(" ", "", $prop_name->pop_name))));
                            }
                            ?>

                                                            <li class="active">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" <?=$attArr != null ? (in_array(strtolower(str_replace(" ", "", $attr->attr_name)), $attArr) == 1 ? "checked" : "") : ""?>
                                                                           name="<?=strtolower(str_replace(" ", "", $prop_name->pop_name))?>"
                                                                           value="<?=strtolower(str_replace(" ", "", $attr->attr_name));?>"
                                                                           class="custom-control-input"
                                                                           id="defaultcUnchecked<?=$cou?>_<?=$c?>">
                                                                    <label class="custom-control-label"
                                                                           for="defaultcUnchecked<?=$cou?>_<?=$c?>">
                                                                    </label>
                                                                    <?=$attr->attr_name?>
                                                                    <span class="text-right">(0)</span>
                                                                </div>

                                                            </li>
                                                        <?php } else {
                            $arrColor1 = $this->input->get("color") ? explode(":", $this->input->get("color")) : [];
                            $arrColor = [];
                            foreach ($arrColor1 as $co) {
                                $arrColor[] = "#" . $co;
                            }

                            ?>
                                                            <li <?=$proCount = $products[0]->child_id != 0 ? getColorcountChild($products[0]->child_id, $attr->color_code) : getColorcount($products[0]->sub_id, $attr->color_code)?> <?=$proCount == 0 ? "style='display:none'" : ""?>>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" <?=$arrColor != null ? (in_array($attr->color_code, $arrColor) ? "checked" : "") : ""?>
                                                                           name="<?=strtolower(str_replace(" ", "", $prop_name->pop_name))?>"
                                                                           value="<?=$attr->color_code?>"
                                                                           class="custom-control-input"
                                                                           id="defaultsUnchecked<?=$cou?>_<?=$c?>">
                                                                    <span class="select-col"
                                                                          style="background-color:<?=$attr->color_code?>;"></span>
                                                                    <label class="custom-control-label"
                                                                           for="defaultsUnchecked<?=$cou?>_<?=$c?>">
                                                                    </label>
                                                                    <?=$attr->attr_name?>
                                                                    <span class="text-right">(<?=$products[0]->child_id != 0 ? getColorcountChild($products[0]->child_id, $attr->color_code) : getColorcount($products[0]->sub_id, $attr->color_code)?>)</span>
                                                                </div>

                                                            </li>
                                                            <?php
}
                        $c++;
                    }
                    ?>

                                                </ul>

                                            </div>
                                        </div>
                                        <?php
}
            }
            $cou++;
        }
        ?>

                        </div>

                        <div class="modal-header">
                            <button type="button" style="position: relative;
                                            margin-top: -60px;
                                            font-size: 12px;
                                            color: red;
                                            float: right;
                                            padding: 0px 0px 0px 74px;
                                            cursor: pointer;" data-dismiss="modal" aria-label="Close">Close
                            </button>
                            <span onclick="window.location.href='<?=current_url()?>'" class="mob-clearBtn" style="cursor: pointer;
                                          font-size: 12px;
                                          color: deeppink;
                                          /* float: right; */
                                          position: relative;
                                          top: -61px;">CLEAR ALL</span>
                        </div>
                        <?php
}
}
?>

