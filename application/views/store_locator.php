<div class="container">
    <div class="condition">
        <div class="col-lg-12 col-md-12">
            <h1 class="content-title">Store Locator</h1>
            <div class="text-block">

                <div class="store-locator-set">
                    <div class="store-locator-set-in">

                        <div class="search-area">
                            <div class="form-group">
                                <label for="locator">Search by pin code</label>
                                <input type="text" class="form-control" placeholder="Search by pin code" id="locator">
                                <button>Search</button>
                            </div>
                        </div>
                        <div class="locator-div">

                            <?php

                            foreach ($data as $key => $value) {
                                if ($key % 2 != 0) {
                                    echo '<div class="row">';
                                }
                                ?>

                                <div data-text="<?= $value->city ?>" class="col-md-6 stor-loc">
                                    <div class="location-show">
                                        <iframe src="<?= $value->url ?>" width="100%" height="200" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                                        <div class="loc-dtl">
                                            <b>Store : <?= $value->store_name ?></b>
                                            <p> <?= $value->address ?>, <?= $value->address_1 ?>, <?= $value->city ?> </p>
                                            <p> <b> <?= $value->gst ?> </b></p>
                                            <p> <b> <?= $value->contact ?> </b></p>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($key % 2 != 0) { ?>
                        </div>
                <?php }
                } ?>
                    </div>
                    <p id="no-store" style="color:red;font-size: 16px;"></p>
                </div>

            </div>


        </div>


    </div>


</div>

</div>
</div>