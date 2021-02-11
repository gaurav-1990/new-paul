
<!-- /Header -->

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Main container -->
<main class="main-container">


    <!-- Page heading -->
    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">

                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#">Home</a>
                        </li>
                        <li><a href="#">Dashboard</a></li>
                        <li class="active"><span>Main page</span></li>
                    </ol>
                    <?php $userProfile = getUserProfile($this->session->userdata('signupSession')['id']); ?>
                </div>
            </div>
        </div> 
    </header>

    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?=$get?></h3>

              <p>Total Successful Orders</p>
            </div>
           
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>₹ <?=$glt?></h3>

              <p>Total Order Value</p>
            </div>
              </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
        
           
          </div>
    
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?=$gtu?></h3>

              <p>Registered Users</p>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?=$gtp?></h3>

              <p>Total Products</p>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
      </div>
      
    </section>

    <div class="col-lg-12">
        <h3>Recent Orders</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-nowrap no-mb mytable">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <!--<th>Product Quantity</th>-->
                        <th>Payment Date & Time</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody id="userOrderModule">
                <?php foreach ($getord as $res) {
                  $oid = encode($this->encryption->encrypt($res->id));
                  
                ?>
                    <tr>
                        <td><?= "10000".$res->id?></td>
                        <!--<td><?php // echo $res->pro_qty?></td>-->
                        <td><?= $res->pay_date?></td>
                        <td><?= $res->total_order_price?></td>
                    </tr>
                <?php }?>                      
                </tbody>
            </table>
        </div>
    </div>
 
    </div>
</main>