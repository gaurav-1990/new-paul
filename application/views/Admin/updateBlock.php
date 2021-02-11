<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

     <main class="main-container">


     <?= $this->session->flashdata('msg'); ?>
     <?= $this->session->flashdata('insert'); ?>

     <h3> UPDATE BLOCK  </h3>
     
     <div class="panel panel-white">
         <?php $url = base_url()."Admin/SadminLogin/update_block/".encode($this->encryption->encrypt($user->id)); ?>
         <?= form_open($url, array('class' => 'form-horizontal', 'autocomplete' => 'off', 'name' => 'sform2', 'id' => 'sform2', 'method' => 'POST')); ?>
         
         <div class="product_details_class">
             
             <div class="panel-body  ">
                <div class="row">
                     <div class="col-sm-2">
                         <label>
                             Enable Block <br>
                             <input type="checkbox"  value="1" <?= $user->block_status=='1' ? 'checked': '' ?> name="enableBlock">
                         </label>
                    </div>

                    <div class="col-sm-3">
                        <label>Sort Order</label>
                        <input type="text" value="<?=$user->sort_order?>" class="form-control" name="sortorder" placeholder="Sort Order">
                    </div>
                </div>
            </div>        


             <div class="panel-body  ">
                <div class="row">
                     <div class="col-sm-3">
                         <label>Block Title</label>
                         <input type="text" class="form-control" value="<?= $user->block_title?>" name="bt" placeholder="Block Title"/>
                     </div>
                     <div class="col-sm-3">
                         <label>Identifier</label>
                         <input type="text" class="form-control" value="<?= $user->block_identifier?>" name="identifier" placeholder="Identifier"/>
                     </div>
                     <div class="col-sm-3">
                         <label>Valid From</label>
                         <input type="text" id="offer_validity_from" value="<?= $user->valid_from?>" class="form-control" name="valid_from" placeholder="Valid From"/>
                     </div>
                     <div class="col-sm-3">
                         <label>Valid Upto</label>
                         <input type="text" id="offer_validity_to" value="<?= $user->valid_upto?>" class="form-control" name="valid_upto" placeholder="Valid Upto"/>
                     </div>
                </div>
             </div>

             <div class="panel-body  ">
                 <div class="row">
                     <div class="col-sm-12">
                         <label>Content:</label>
                         <textarea id="pro_desc" name="editor" rows="10" class="form-control"><?= $user->block_data?></textarea>
                         <?= display_ckeditor($ckeditor); ?>
                         <div><?php  echo form_error('editor'); ?></div>
                     </div>
                 </div>
             </div>
         </div>
         
            <div class="panel-body">
                <div class="row">
                    <div class=" col-sm-4">
                        <label for="">&nbsp;</label>
                        <button type="submit" class="btn btn-default">UPDATE BLOCK</button>
                    </div>
                </div>
            </div>
       
         

         <?= form_close(); ?>
     </div>
 </main>