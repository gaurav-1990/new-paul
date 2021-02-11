<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<main class="main-container">


     <?=$this->session->flashdata('msg');?>
     <?=$this->session->flashdata('insert');?>



     <div class="panel panel-white">
         <?=form_open_multipart('Admin/SadminLogin/addWidget', array('class' => 'form-horizontal', 'autocomplete' => 'off', 'name' => 'sform2', 'id' => 'sform2', 'method' => 'POST'));?>



         <div  class="panel-body  ">
         <div class="panel-body  pb">
                <div class="row">
                <?=validation_errors()?>

                </div>
         </div>
            </div>
            <div  class="panel-body  ">
            <div class="panel-body  pb">
                <div class="row">

                     <div class="col-sm-3">
                         <label>Block Title</label>
                         <input type="text" class="form-control" name="bt" placeholder="Block Title"/>
                     </div>
                     <div class="col-sm-3">
                         <label>No. of products in slider</label>
                         <input type="text" class="form-control" name="Number" placeholder="Number"/>
                     </div>
                     <div class="col-sm-3">
                         <br>
                         <button type="submit" class="btn btn-success">Add</button>
                     </div>
                </div>
            </div>
             </div>
             <div  class="panel-body">
               <div class="panel-body  pb">
                 <div class="row">
                 <table class="table table-bordered table-striped table-nowrap no-mb" id="example">
                                    <thead>
                                        <tr>
                                            <th>Action </th>
                                            <th>SKU</th>
                                            <th>Product Name</th>
                                            <th>In Stock</th>
                                            <th>Total Stock</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

foreach ($product as $pr) {
    $totqty = 0;
    $getQty = getQuantity($pr->ID); //

    foreach ($getQty as $qty) {
        $totqty += $qty->pro_qty;
    }

    ?>
                                            <tr>

                                                <td >

                                                <input type="checkbox" value="<?=$pr->ID?>" name="products[]" id="">


                                                </td>
                                                <td>
                                                    <?=$pr->sku?>
                                                </td>
                                                <td><?=$pr->pro_name?></td>
                                                <td><?=$pr->in_stock == 1 ? "Yes" : "No"?></td>
                                                <td><?=$totqty + $pr->pro_stock?></td>

                                            </tr>
                                        <?php }?>

                                    </tbody>
                                </table>
                 </div>
               </div>
             </div>




         <?=form_close();?>
     </div>
 </main>