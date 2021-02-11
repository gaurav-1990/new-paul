<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

     <main class="main-container">


     <?= $this->session->flashdata('msg'); ?>
     <?= $this->session->flashdata('insert'); ?>

     <h3> UPDATE PAGE  </h3>

     <div class="panel panel-white">
         <?php $url = base_url()."Admin/SadminLogin/update_page/".encode($this->encryption->encrypt($user->id)); ?>
         <?= form_open($url, array('class' => 'form-horizontal', 'autocomplete' => 'off', 'name' => 'sform2', 'id' => 'sform2', 'method' => 'POST')); ?>
         
         <div class="product_details_class">
             
            <div class="panel-body  ">
                <div class="row">
                    <div class="col-sm-1">
                        <label>Enable Page <br>
                            <input type="checkbox" value="1"<?= $user->page_status=='1' ? 'checked': '' ?> name="enablePage">
                        </label>
                    </div>
                    <div class="col-sm-3">
                        <label>Page Title*</label>
                        <input type="text" class="form-control" value="<?= $user->page_title?>" name="page_title" placeholder="Page Title">
                    </div>
                    <div><?php  echo form_error('page_title'); ?></div>
                    <div class="col-sm-2">
                        <label>Sort Order</label>
                        <input type="text" value="<?= $user->sort_order?>" class="form-control" name="sortorder" placeholder="Sort Order">
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

             
             <u><h4>Content:</h4></u>
             <div class="panel-body  ">
                <div class="row">
                     <div class="col-sm-3">
                         <label>Content Heading</label>
                         <input type="text" value="<?= $user->cont_head?>" class="form-control" name="cont_head" placeholder="Content Heading"/>
                     </div>
                </div>
             </div>

             <div class="panel-body">
                 <div class="row">
                     <div class="col-sm-12">
                         <label>Page Content:</label>
                         <textarea id="pro_desc" name="page_cont" rows="10" class="form-control"><?= htmlspecialchars_decode(stripslashes($user->page_cont))?></textarea>
                            <?=display_ckeditor($ckeditor)?>
                         <div><?php  echo form_error('page_cont'); ?></div>
                     </div>
                 </div>
             </div>

             <u><h4>Search Engine Optimization:</h4></u>
             <div class="panel-body">
                 <div class="row">
                    <div class="col-sm-4">
                         <label>URL Key</label>
                         <input type="text" value="<?= $user->url_key?>" class="form-control" name="url_key" placeholder="URL Key"/>
                    </div>
                    <div class="col-sm-4">
                         <label>Meta Title</label>
                         <input type="text" value="<?= $user->meta_title?>" class="form-control" name="meta_title" placeholder="Meta Title"/>
                    </div>
                    <div class="col-sm-4">
                         <label>Meta Keyword</label>
                         <input type="text" class="form-control" value="<?= $user->meta_keyword?>" name="meta_keyword" placeholder="Meta Keyword"/>
                    </div>
                 </div>
             </div>   

             <div class="panel-body">
                 <div class="row">
                    <div class="col-sm-12">
                         <label>Meta Description</label>
                         <textarea id="meta_desc" value="<?= $user->meta_desc?>" name="meta_description" rows="10" class="form-control"></textarea>
                    </div>
                 </div>
             </div>     

         </div>
         
            <div class="panel-body">
                <div class="row">
                    <div class=" col-sm-4">
                        <label for="">&nbsp;</label>
                        <button type="submit" class="btn btn-default">UPDATE PAGE</button>
                    </div>
                </div>
            </div>
       
         

         <?= form_close(); ?>
     </div>
 </main>