<?php
// echo "<pre>";
// print_r($wish);
// $prod = getwishProduct($wish[0]->pro_id);
// echo "<pre>";
// print_r($prod);
?>
<section class="wish-page">
    <div class="container">
        <div class="wish-page-in">
            <div class="wish-head">
                <h3>My Wishlist: <span><?= count($wish) ?> Items</span></h3>
            </div>

            <div class="wish-show">

                <div class="row">
                    <?php
                    foreach ($wish as $key => $data) {
                        
                        $prod = getwishProduct($data->pro_id);
                        // echo "<pre>";
                        // print_r($prod);

                        $product = getProduct($data->pro_id);                    
                        $pro_name = cleanUrl($product->pro_name);
                        $sub_name = cleanUrl($product->sub_name);
                        
                        ?>
                    <a href="<?= ($prod[0]->pro_stock == 0) ? '#' : base_url().'product/'.$sub_name.'/'.$pro_name.'/'.encode($this->encryption->encrypt($data->pro_id)) ?>">
                        <div class="col-md-3 col-xs-6" >    <!-- onclick="window.location.href='<?= base_url("product/$sub_name/$pro_name/" . encode($this->encryption->encrypt($data->pro_id))); ?>'" -->
                            <div data-id="<?= encode($this->encryption->encrypt($data->id)) ?>" data-prop="<?= $data->pro_prop ?>" data-attr="<?= $data->pro_attr ?>" class="wish-block">
                                <div class="cross-in">
                                    x
                                </div>
                                <div class="img-set">   <!-- onclick="window.location.href='<?= base_url("product/$sub_name/$pro_name/" . encode($this->encryption->encrypt($data->pro_id))); ?>'" -->
                                    <img class="lazy" data-src="<?= base_url("uploads/original/") ?><?= getProductImage($data->pro_id) ?>" alt="<?=$product->pro_name?>" title="<?=$product->pro_name?>" />
                                </div>
                                <div class="show-pro-name">
                                    <h4><?= strlen($product->pro_name) > 50 ? substr($product->pro_name, 0, 30) . "..." : $product->pro_name ?></h4>
                                    <?= ($prod[0]->pro_stock == 0) ? "<h4 style='color:red'>Currently Out of Stock</h4>" : "" ?>
                                    <div class="detail-price">
                                        <span class="rs">Rs. <?= $product->dis_price ?> </span>
                                    <?= ($product->act_price == $product->dis_price) ? "" : '<span class="cut"><i class="fa fa-inr" aria-hidden="true"></i>'.$product->act_price.'</span>' ?>
                                            
                                          
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </a>
                    
                    <?php
                    }
                    ?>


                </div>
            </div>

        </div>


    </div>

</section>