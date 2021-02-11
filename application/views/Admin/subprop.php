<main class="main-container">
    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#">Vendor Products </a>
                        </li>
                        <li class="active"><span>All Images</span></li>
                    </ol>
                    <div class="page-header">
                        <h2 class="page-subtitle">
                            <?= $this->session->flashdata('msg'); ?>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div  class="panel panel-white">
        <div  class="panel-body  pb">
            <div class="card">
                <div class="card-body">
                    <?= form_open('Admin/SadminLogin/addAttr') ?>
                    <div class="row">
                        <div class=" col-sm-3">

                            <label for="">Prop. Name</label>
                            <select name="prop_id" class="form-control" required id="prop_id" onchange="choose_prop()">
                                <option value="">Select Name</option>
                                <?php
                               
                                foreach ($properties as $property) {
                                    ?>
                                    <option value="<?= $property->id ?>_<?= $property->catalog_type ?>"><?= $property->pop_name ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-1 my-color" style="display:none;">
                             <label>COLOR </label> <br>
                             <input type="color" name="color" aria-invalid="false">
                        </div>

                        <div class=" col-sm-2">
                            <label for=""> Attribute</label><br>
                            <input type="text" class="form-control" required id="attr_name"  name="attr_name"  />
                        </div>
                        <div class=" col-sm-1">
                            <label for=""></label><br>
                            <button type="submit" class="btn btn-success btn-xs">Add</button>
                        </div>
                    </div>

                    <?= form_close(); ?>

                </div>

            </div>

        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-nowrap no-mb">


                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Prop Name</th>
                        <th>Attr Name</th>
                       
                         
                    </tr>
                </thead>
                <tbody>
                    <?php
                
                    foreach ($attr as $at) {
                        ?>
                        <tr>
                           <td><a href="<?= site_url('Admin/SadminLogin/deleteAttr/') ?><?= encode($this->encryption->encrypt($at->attr_id)) ?>" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i> Delete</a></td>
                           <td><?=$at->pop_name?></td>
                           <td><?=$at->attr_name?></td>
                           
                        </tr>
                        <?php
                    }
                    ?>

                </tbody>
            </table>
        </div>

    </div>
</main>
