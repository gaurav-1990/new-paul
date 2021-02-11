<?php

if ($products !== null) {
    ?>
    <section class="inner-slider-set"
             style="background-image: url(<?= base_url() ?>bootstrap/images/slider/home1.jpg);">

        <h2 class="l-text2 t-center">

            <?= $products[0]->cat_desc != '' ? $products[0]->cat_name : "" ?>
        </h2>
        <p class="m-text13 t-center">
            <?= $products[0]->cat_desc ?>
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
                <a href="<?= base_url(); ?>"> Home /</a>
                <a href="<?= $cat_url ?>"><?= $products[0]->cat_name ?> <?= ($products[0]->cat_name != NULL) ? '/' : '' ?> </a>
                <a href="<?= $sub_url ?>"><?= $products[0]->sub_name ?> <?= (isset($getChild)) ? '/' : '' ?></a>
                <!-- <a href="<?= (isset($child_url)) ? $child_url : '#' ?>">
                <?= (isset($getChild) && $getChild->sub_name != NULL) ? $getChild->sub_name : '' ?> </a> -->
                <span> <?= (isset($getChild) && $getChild->sub_name != NULL) ? $getChild->sub_name : '' ?></span>
            </div>
            <div class="top-item-show">
                <h2><i class="fa fa-arrow-left" aria-hidden="true"></i>
                    <?= isset($products[0]->sub_name) ? $products[0]->sub_name : '' ?><span> <?= ($totalC) ?> items
                </span></h2>
            </div>
            <?php

            ?>
            <div class="filter-head">
                <div class="row">
                    <div class="col-md-2 col-xs-12">
                        <h2>Filters</h2>
                    </div>
                    <div class="col-md-7 col-xs-12">
                        <div class="product-short">
                            <ul>
                                <?php
                                $sid = $this->uri->segment(5);

                                if ($sid == '') {
                                    $sid = $this->uri->segment(4);

                                    $res = getSpecification($sid);


                                } else {
                                    $res = getChildSpecif($sid);
                                }


                                $response = array_unique($res);
                                $counters = 1;
                                $counters2 = 1;
                                foreach ($response as $fil) { ?>
                                    <li data-val="<?= $fil ?>" id="prop_<?= $counters ?>"
                                        onclick=" $('.open-drop').hide(); $('.open-drop<?= $counters ?>').show();">

                                        <a href="javascript:void(0);">
                                            <?= $fil ?>
                                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                                        </a>
                                    </li>


                                    <?php $counters++;
                                } ?>
                            </ul>
                            <?php
                            foreach ($response as $fil2) { ?>

                                <div class="open-drop<?= $counters2 ?> open-drop myfilter" style="display:none">
                                    <?php dynFilter($fil2, $counters2); ?>
                                </div>
                                <?php
                                $counters2++;
                            } ?>
                        </div>
                    </div>


                    <div class="col-sm-3 col-xs-6 col-md-3 col-lg-2 pull-right">
                        <div class=" default-sort">
                            <select class="selection-2" name="sorting" id="test22">
                                <option value="def">Default Sorting</option>
                                <option value="l2h">Price: low to high</option>
                                <option value="h2l">Price: high to low</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="product-show-bottom">
            <div class="row">
                <div class="product-show-filter myfilter">

                    <?php
                    $arrayPrice = $this->input->get("price") != null ? $this->input->get("price") : null;
                    $arrayPrice = explode(":", $arrayPrice);

                    ?>
                    <div>
                        <h3>Price </h3>
                        <div class="custom-control custom-checkbox">
                            <input <?= in_array("199|500", $arrayPrice) ? "checked" : "" ?> type="checkbox"
                                                                                            data-from="199"
                                                                                            value="199|500" name="price"
                                                                                            data-to="499"
                                                                                            class="custom-control-input"
                                                                                            id="defaultUnchecked">
                            <label class="custom-control-label" for="defaultUnchecked">Rs. 199 to Rs.
                                499 </label>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox"
                                   data-from="500" <?= in_array("500|1000", $arrayPrice) ? "checked" : "" ?>
                                   value="500|1000" name="price" data-to="999" class="custom-control-input"
                                   id="defaultUnchecked1">
                            <label class="custom-control-label" for="defaultUnchecked1">Rs. 500 Rs.
                                999</label>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" data-from="1000"
                                   value="1000|1500" <?= in_array("1000|1500", $arrayPrice) ? "checked" : "" ?>
                                   name="price" data-to="1500" class="custom-control-input" id="defaultUnchecked2">
                            <label class="custom-control-label" for="defaultUnchecked2">Rs. 1000 Rs.
                                1499</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" data-from="1500" value="1500|2000" name="price"
                                   data-to="1999" <?= in_array("1500|2000", $arrayPrice) ? "checked" : "" ?>
                                   class="custom-control-input" id="defaultUnchecked3">
                            <label class="custom-control-label" for="defaultUnchecked3">Rs. 1500 Rs.
                                1999</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" data-from="2000" value="2000|2600" name="price"
                                   data-to="2599" <?= in_array("2000|2600", $arrayPrice) ? "checked" : "" ?>
                                   class="custom-control-input" id="defaultUnchecked4">
                            <label class="custom-control-label" for="defaultUnchecked4">Rs. 2000 Rs.
                                2599</label>
                        </div>

                    </div>
                    <div>
                        <?php if ($propertyName != null) {
                            $cou = 1;
                            foreach ($propertyName as $prop_name) {

                                if ($prop_name->id != 2) {
                                    $attribute = getAttributes($prop_name->id);

                                    ?>
                                    <h3><?= $prop_name->pop_name ?></h3>
                                    <?php
                                }

                                if (isset($attribute) && $attribute != null) {

                                    foreach ($attribute as $attr) {

                                        if ($prop_name->catalog_type == 1) {
                                            $attArr = null;
                                            if ($this->input->get(strtolower(str_replace(" ", "", $prop_name->pop_name)))) {
                                                $attArr = explode(":", $this->input->get(strtolower(str_replace(" ", "", $prop_name->pop_name))));
                                            }
                                            ?>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" <?= $attArr != null ? (in_array(strtolower(str_replace(" ", "", $attr->attr_name)), $attArr) == 1 ? "checked" : "") : "" ?>
                                                       name="<?= strtolower(str_replace(" ", "", $prop_name->pop_name)) ?>"
                                                       value="<?= strtolower(str_replace(" ", "", $attr->attr_name)); ?>"
                                                       class="custom-control-input" id="defaultcUnchecked<?= $cou ?>">
                                                <label class="custom-control-label"
                                                       for="defaultcUnchecked<?= $cou ?>"><?= $attr->attr_name ?>
                                                </label>
                                            </div>

                                            <?php

                                        } else {
                                            $arrColor1 = $this->input->get("color") ? explode(":", $this->input->get("color")) : [];
                                            $arrColor = [];
                                            foreach ($arrColor1 as $co) {
                                                $arrColor[] = "#" . $co;
                                            }

                                            ?>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"
                                                       name="<?= strtolower(str_replace(" ", "", $prop_name->pop_name)) ?>" <?= $arrColor != null ? (in_array($attr->color_code, $arrColor) ? "checked" : "") : "" ?>
                                                       value="<?= $attr->color_code ?>" class="custom-control-input"
                                                       id="defaultsUnchecked<?= $cou ?>">
                                                <span class="select-col"
                                                      style="background-color:<?= $attr->color_code ?>;"></span>
                                                <label class="custom-control-label"
                                                       for="defaultsUnchecked<?= $cou ?>"><?= $attr->attr_name ?>
                                                </label>
                                            </div>

                                            <?php

                                        }
                                        $cou++;
                                    }
                                }
                            }
                        } ?>
                    </div>

                </div>


                <div class="product-show-right">

                    <div class="row">
                        <?php
                        foreach ($products as $pro) {
                            $sub_name = cleanUrl($pro->sub_name);
                            $pro_name = cleanUrl($pro->pro_name);
                            $data_attr = getDataElement($pro->ID);
                            $specifications = getSpecifications($pro->ID);

                            ?>
                            <div class=" col-md-4 col-lg-3 col-xs-6 mob-col-pad"
                                 data-price="<?= $pro->dis_price ?>" <?= $data_attr ?> <?= $specifications ?>>
                                <div class="show-product-small-bx ">
                                    <?php
                                    if ($pro->type == 1) {
                                        ?>
                                        <div class="view-sale">
                                            <span class="sale-tb">Sale</span>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    if ($pro->type == 3) {
                                        ?>
                                        <div class="view-sale">
                                            <span class="tren-tb">Trending</span>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    if ($pro->type == 2) {
                                        ?>
                                        <div class="view-sale">
                                            <span class="top-tb">Top Seller</span>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    if ($pro->type == 4) {
                                        ?>
                                        <div class="view-sale">
                                            <span class="new-tb">New Arrival</span>
                                        </div>
                                    <?php } ?>
                                    <div class="view-rlt">
                                        <a href="#" data-toggle="modal" data-target="#myModal2"
                                           data-prod="<?= encode($this->encryption->encrypt($pro->ID)) ?>">
                                            <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                            View Similar
                                        </a>

                                    </div>
                                    <div onclick="window.location.href='<?= base_url("product/$sub_name/$pro_name/" . encode($this->encryption->encrypt($pro->ID))); ?>'"
                                         class="block-active">
                                    </div>

                                    <div class="img-top-set">
                                        <div class="img-top-set-in">
                                            <img class="lazy"
                                                 data-src="<?= base_url('uploads/resized/') ?>resized_<?= load_images($pro->ID) ?>"
                                                 alt="<?= $pro->pro_name ?>"/>
                                        </div>
                                    </div>
                                    <div class="add-top-size" data-pro="<?= encode($this->encryption->encrypt($pro->ID)); ?>">
                                        <?php
                                        if (isset(json_decode($pro->product_attr)->response)) {
                                            ?>
                                            <h4> Select a size <i class="fa fa-times-circle  pull-right"
                                                                  onclick="closeEffect(this);"> </i></h4>
                                            <ul>
                                                <?php
                                                foreach (json_decode($pro->product_attr)->response as $key => $attr) {
                                                    foreach ($attr->attribute as $a) {
                                                        $k = (key((array)$a));
                                                        $str = strtoupper((string)$a->$k);
                                                        if ((int)$attr->qty < 1) {
                                                            ?>
                                                            <li data-prop="<?= strtolower((string)$k) ?>"
                                                                data-qty="<?= $attr->qty ?>"
                                                                data-attr="<?= strtoupper((string)$a->$k) ?>">
                                                                <a href=" javascript:void(0)" class="off-no">
                                                                    <?= $str ?>
                                                                    <!-- <img src="<?= base_url() ?>bootstrap/images/ban.png" alt="" /> -->
                                                                </a>
                                                            </li>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <li data-prop="<?= strtolower((string)$k) ?>"
                                                                data-qty="<?= $attr->qty ?>"
                                                                data-attr="<?= strtoupper((string)$a->$k) ?>">
                                                                <a href="javascript:void(0)"
                                                                   class="<?= ((int)$attr->qty < 1) ? 'off-no' : '' ?>"><?= $str ?></a>
                                                                <?php
                                                                if ((int)$attr->qty < 5) {
                                                                    ?>
                                                                    <span class="left-stock"><?= $attr->qty ?>
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
                                        <?php } ?>
                                    </div>

                                    <div class="add-wish-prod">
                                <span>
                                    <button data-id="<?= encode($this->encryption->encrypt($pro->ID)) ?>" class="left-add add-cart">ADD TO BAG</button>
                                </span>
                                        <span>
                                    <button class="right-wish">WISHLIST</button>
                                </span>
                                    </div>

                                    <div class="detail-cover"
                                         onclick="window.location.href='<?= base_url("product/$sub_name/$pro_name/" . encode($this->encryption->encrypt($pro->ID))); ?>'">

                                        <div class="whs"></div>
                                        <div class="whs2"></div>
                                        <div class="detail-text">
                                            <h3><?= strlen($pro->pro_name) > 40 ? substr($pro->pro_name, 0, 40) . "..." : $pro->pro_name ?>
                                            </h3>
                                            <p class="discrip">
                                                <?= strlen($pro->product_sname) > 40 ? substr($pro->product_sname, 0, 40) . "..." : $pro->product_sname ?>
                                            </p>
                                            <?php
                                            if (isset(json_decode($pro->product_attr)->response)) {
                                                ?>
                                                <p class="size-pl">
                                                    Size
                                                    <?php
                                                    foreach (json_decode($pro->product_attr)->response as $key => $attr) {
                                                        foreach ($attr->attribute as $a) {
                                                            $k = (key((array)$a));
                                                            $str = strtoupper((string)$a->$k);
                                                            ?>
                                                            <span><?= $str ?></span>
                                                        <?php }
                                                    } ?>
                                                </p>
                                            <?php } else { ?>
                                                <p class="size-pl">
                                                    <span>One Size</span>
                                                </p>
                                            <?php } ?>
                                        </div>

                                        <div class="detail-price">
                                            <span class="rs">Rs. <?= $pro->dis_price ?></span>
                                            <span class="cut"><?= ($pro->act_price == $pro->dis_price)? "" : 'Rs.'. round($pro->act_price) ?></span>
                                            <?php
                                            $decrease = floatval($pro->act_price) - floatval($pro->dis_price);
                                            $percentage = $decrease / floatval($pro->act_price) * 100;
                                            ?>
                                            <span class="off"><?= ($pro->act_price == $pro->dis_price)? "" :( round($percentage). '% off') ?></span>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        <?php } ?>
                    </div>
                </div>

            </div>
            <div class="row">
                <?= $link ?>
            </div>
        </div>
        <div class="load">
            <img src="<?= base_url() ?>bootstrap/images/svg-icons/generator.svg" class="header-icon1" alt="ICON">
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
    <?php
} ?>

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
                            <li>
                                <a href="#"><i class="fa fa-fire" aria-hidden="true"></i>&nbsp &nbsp Popularity</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp &nbsp Latest</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-percent" aria-hidden="true"></i>&nbsp &nbsp Discount</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-inr" aria-hidden="true"></i><i class="fa fa-long-arrow-down"
                                                                                           aria-hidden="true"></i>&nbsp
                                    &nbsp Price High to Low</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-inr" aria-hidden="true"></i><i class="fa fa-long-arrow-up"
                                                                                           aria-hidden="true"></i>&nbsp
                                    &nbsp Price Low to High</a>
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
                        <button type="button" data-dismiss="modal" aria-label="Close">Clear All</button>
                        <h4 class="modal-title" id="myModalLabel2">Filter</h4>
                    </div>

                    <div class="modal-body">


                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home">Color</a></li>
                            <li><a data-toggle="tab" href="#menu1">Size</a></li>
                            <li><a data-toggle="tab" href="#menu2">Categories</a></li>
                            <li><a data-toggle="tab" href="#menu3">Price</a></li>
                            <li><a data-toggle="tab" href="#menu4">Discount Range</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <div class="color-flt">
                                    <ul>

                                        <li class="active">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" data-from="199" value="199|499" name="price"
                                                       data-to="499" class="custom-control-input" id="defaultUnchecked">
                                                <label class="custom-control-label" for="defaultUnchecked">
                                                    Rs. 199 to Rs.
                                                    499 </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" data-from="500" value="500|999" name="price"
                                                       data-to="999" class="custom-control-input"
                                                       id="defaultUnchecked1">
                                                <label class="custom-control-label" for="defaultUnchecked1">
                                                    Rs. 500 Rs.
                                                    999</label>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" data-from="1000" value="1000|1499" name="price"
                                                       data-to="1499" class="custom-control-input"
                                                       id="defaultUnchecked2">
                                                <label class="custom-control-label" for="defaultUnchecked2">
                                                    Rs. 1000 Rs.
                                                    1499</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" data-from="1500" value="1500|1999" name="price"
                                                       data-to="1999" class="custom-control-input"
                                                       id="defaultUnchecked4">
                                                <label class="custom-control-label" for="defaultUnchecked4">
                                                    Rs. 1500 Rs.
                                                    1999</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" data-from="2000" value="2000|2599" name="price"
                                                       data-to="2599" class="custom-control-input"
                                                       id="defaultUnchecked5">
                                                <label class="custom-control-label" for="defaultUnchecked5">
                                                    Rs. 2000 Rs.
                                                    2599</label>
                                            </div>
                                        </li>
                                    </ul>

                                </div>


                            </div>
                            <div id="menu1" class="tab-pane fade">
                                <div class="color-flt">
                                    <ul>

                                        <li>
                                            <div class="search-tap">
                                                <input type="text" placeholder="Search size">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </div>
                                        </li>
                                        <li class="active">
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">3XL</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">L</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">M</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">S</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">XL</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">L</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">M</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">S</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">XL</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">L</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">M</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">S</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">XL</div>

                                            <div class="col-item">126</div>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <div id="menu2" class="tab-pane fade">
                                <div class="color-flt">
                                    <ul>
                                        <li>
                                            <div class="search-tap">
                                                <input type="text" placeholder="Search Color">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </div>
                                        </li>
                                        <li class="active">
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">Rs.199 to Rs.2258</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">Rs.199 to Rs.2258</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">Rs.199 to Rs.2258</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">Rs.199 to Rs.2258</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">Rs.199 to Rs.2258</div>

                                            <div class="col-item">126</div>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <div id="menu3" class="tab-pane fade">
                                <div class="color-flt">
                                    <ul>
                                        <li class="active">
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">Rs.199 to Rs.2258</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">Rs.199 to Rs.2258</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">Rs.199 to Rs.2258</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">Rs.199 to Rs.2258</div>

                                            <div class="col-item">126</div>
                                        </li>
                                        <li>
                                            <div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="col-block">Rs.199 to Rs.2258</div>

                                            <div class="col-item">126</div>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="closer" data-dismiss="modal">Cancel</button>

                            <button type="button" class="apply">Apply</button>
                        </div>
                    </div>

                </div><!-- modal-content -->
            </div><!-- modal-dialog -->


        </div>
    </div>


</div><!-- container -->