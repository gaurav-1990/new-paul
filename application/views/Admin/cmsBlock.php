<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

     <main class="main-container">


     <?= $this->session->flashdata('msg'); ?>
     <?= $this->session->flashdata('insert'); ?>

     <h3> ADD BLOCK  </h3>

     <div class="panel panel-white">
         <?= form_open_multipart('Admin/SadminLogin/add_block', array('class' => 'form-horizontal', 'autocomplete' => 'off', 'name' => 'sform2', 'id' => 'sform2', 'method' => 'POST')); ?>
         
         <div class="product_details_class">
             
            <div class="panel-body  ">
                <div class="row">
                    <div class="col-sm-2">
                        <label>Enable Block <br>
                            <input type="checkbox" name="enableBlock" value="1">
                        </label>
                    </div>
                    <div class="col-sm-3">
                        <label>Sort Order</label>
                        <input type="text" class="form-control" name="sortorder" placeholder="Sort Order">
                    </div>
                </div>
            </div>        

             <div class="panel-body  ">
                <div class="row">
                     
                     <div class="col-sm-3">
                         <label>Block Title</label>
                         <input type="text" class="form-control" name="bt" placeholder="Block Title"/>
                     </div>
                     <div class="col-sm-3">
                         <label>Identifier</label>
                         <input type="text" class="form-control" name="identifier" placeholder="Identifier"/>
                     </div>
                     <div class="col-sm-3">
                         <label>Valid From</label>
                         <input type="text" id="offer_validity_from" class="form-control" name="valid_from" placeholder="Valid From"/>
                     </div>
                     <div class="col-sm-3">
                         <label>Valid Upto</label>
                         <input type="text" id="offer_validity_to" class="form-control" name="valid_upto" placeholder="Valid Upto"/>
                     </div>
                </div>
             </div>

             <div class="panel-body  ">
                 <div class="row">
                     <div class="col-sm-12">
                         <label>Content:</label>
                         <textarea id="pro_desc" name="editor" rows="10" class="form-control"></textarea>
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
                        <button type="submit" class="btn btn-default">ADD BLOCK</button>
                    </div>
                </div>
            </div>
       
         

         <?= form_close(); ?>
     </div>
 </main>