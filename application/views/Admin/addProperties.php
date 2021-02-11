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
                    <?= form_open('Admin/SadminLogin/addProperty') ?>
                    <div class="row">
                        <div class=" col-sm-3">
                            <label for="">Prop. Name</label>
                            <select name="prop_name" class="form-control" id="prop_name">
                                <option value="">Select Name</option>
                                <?php
                                foreach ($properties as $property) {
                                    ?>
                                    <option value="<?= $property->id ?>"><?= $property->pop_name ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class=" col-sm-3">
                            <label for="">Prop. Category</label>

                            <select name="prop_cat" onchange="getProp(this)" id="prop_cat" class="form-control">
                                <option value="">Select Category</option>
                                <?php
                                foreach ($categories as $category) {
                                    ?>
                                    <option value="<?= $category->id ?>"><?= $category->cat_name ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class=" col-sm-3">
                            <label for="">Sub category</label>
                            <select name="sub_cat" id="sub_cat" required="" class="form-control"> <option value="">Select Sub</option></select>
                        </div>
                        <div class=" col-sm-2">
                            <label for="">Is Mandatory</label><br>
                            <input type="checkbox" id="is_man"  name="is_man" value="1" />
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
                        <th>Category Name</th>
                        <th>Sub Category</th>
                        <th>Is Mandatory</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($allProp as $prop) {
                        ?>
                        <tr>
                            <td><a href="<?= site_url('Admin/SadminLogin/deleteProp/') ?><?= encode($this->encryption->encrypt($prop->propId)) ?>" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i> Delete</a></td>
                            <td><?= $prop->pop_name ?></td>
                            <td><?= $prop->cat_name ?></td>
                            <td><?= $prop->sub_name ?></td>
                            <td><?= $prop->is_man == 1 ? "YES" : "NO" ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</main>
