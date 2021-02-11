<body class="sidebar-expanded">

    <!-- Preloader -->
    <div class="preloader loader"></div>

    <header class="header">

        <div class="top-line">

            <a href="#" class="brand">

                <div class="brand-big">
                    <!--                    <span class="strong"><img src="<?=base_url('bootstrap/images/shp.png')?>" style="width: 70%" alt="" /></span>-->
                    <span class="strong">PAULSONS</span>
                </div>

                <div class="brand-small">
                    PS
                </div>
            </a>

            <div class="menu-button">
                <a href="#" class="sidebar-toggle menu-toggle open">
                    <div class="menu-icon">
                        <span></span><span></span><span></span>
                        <span></span><span></span><span></span>
                    </div>
                </a>
            </div>
            <!-- /Menu button -->

            <!-- Navigation -->
            <div class="navigation-top">


                <ul class="navbar-top navbar-top-right">


                    <li class="dropdown">
                        <?php $userProfile = getUserProfile($this->session->userdata('signupSession')['id']);

?>
                        <!-- Profile avatar -->
                        <a href="#" class="dropdown-toggle nav-profile" data-toggle="dropdown">
                            <span class="profile-name"><?=@$userProfile->fname?> <?=@$userProfile->lname?> </span>
                            <span class="caret"></span>
                            <div class="profile-avatar">
                                <div class="profile-avatar-image">
                                    <img src="<?=base_url()?>allmedia/images/avatar-f-05.png" alt="">
                                </div>
                            </div>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="<?=site_url('Admin/SadminLogin/editProfile');?>"><i class="icon icon-inline fa fa-address-card-o"></i> Profile</a></li>

                            <li><a href="<?=site_url('Admin/SadminLogin/logout');?>"><i class="icon icon-inline fa fa-sign-out"></i> Sign out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="sidebar custom-scrollbar">
            <div class="sidebar-content">
                <ul class="sidebar-navigation sb-nav">
                    <li class="sb-dropdown">
                        <a href="<?=base_url()?>Admin/SadminLogin/dashboard" class="sb-nav-item sb-nav-item <?=$active == 'dashboard' ? "active" : ""?>">
                            <i class="icon fa fa-home"></i>
                            <span>Dashboard</span>
                        </a>

                    </li>
                    <div class="sidebar-title">System </div>
                    <li class="sb-dropdown">
                        <a href="<?=base_url()?>Admin/SadminLogin/delete_cache_site" class="sb-nav-item sb-nav-item">
                            <i class="icon fa fa-trash-o"></i>
                            <span>Delete Cache</span>
                        </a>

                    </li>
                    <?php if ($this->session->userdata('signupSession')['role'] == 1) {?>

                        <div class="sidebar-title">Catalog</div>
                        <li>
                            <a href="<?=site_url('Admin/SadminLogin/categories');?>" class="sb-nav-item <?=$active == 'categories' ? "active" : ""?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span>View Categories</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=site_url('Admin/SadminLogin/addsub');?>" class="sb-nav-item <?=$active == 'addsubcategories' ? "active" : ""?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span>Add Sub Categories</span>
                            </a>
                        </li>
                        <!-- <li>
                            <a href="<?=site_url('Admin/SadminLogin/childsub');?>" class="sb-nav-item <?=$active == 'addchildsubcategories' ? "active" : ""?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span>Add Child Sub Categories</span>
                            </a>
                        </li> -->
                        <li>
                            <a href="<?=site_url('Admin/SadminLogin/propName');?>" class="sb-nav-item <?=$active == 'propname' ? "active" : ""?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span> Properties Name (1)</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=site_url('Admin/SadminLogin/addSubProp');?>" class="sb-nav-item <?=$active == 'attrname' ? "active" : ""?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span>Attribute Name (2)</span>
                            </a>
                        </li>
                        <!-- <li>
                            <a href="<?=site_url('Admin/SadminLogin/add_block');?>" class="sb-nav-item <?=$active == 'cmsblock' ? "active" : ""?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span>CMS Block</span>
                            </a>
                        </li> -->


                        <div class="sidebar-title">Product</div>

                        <li class="sb-dropdown">
                            <a href="#" class="sb-nav-item sb-dropdown-toggle <?=$active == 'addproducts' ? "active" : ""?>">
                                <i class="icon fa fa-leaf"></i>
                                <span> Products</span>

                            </a>

                            <ul class="collapse">
                                <li>
                                    <a href="<?=site_url('Admin/Vendor/vendor_products')?>" class="sb-nav-item  <?=$action == 'profilesview' ? "active" : ""?>">
                                        <i class="icon fa fa-circle-o"></i> <span>View Products</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?=site_url('Admin/Vendor/addProducts');?>" class="sb-nav-item <?=$action == 'addproducts' ? "active" : ""?>">
                                        <i class="icon fa fa-circle-o"></i> <span>Add Products</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?=site_url('Admin/Vendor/nil_products');?>" class="sb-nav-item <?=$action == 'addproducts' ? "active" : ""?>">
                                        <i class="icon fa fa-circle-o"></i> <span>NIL Inventory</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?=site_url('Admin/Vendor/disabled_products');?>" class="sb-nav-item <?=$action == 'addproducts' ? "active" : ""?>">
                                        <i class="icon fa fa-circle-o"></i> <span>Disabled Products</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sb-dropdown">
                            <!-- <a href="#" class="sb-nav-item sb-dropdown-toggle <?=$active == 'shipping' ? "active" : ""?>">
        <i class="icon fa fa-car"></i>
        <span> Shipping Area</span>

    </a> -->

                            <ul class="collapse">

                                <li>
                                    <a href="<?=base_url()?>Admin/Vendor/shipping" class="sb-nav-item <?=$active == 'shipping' ? "active" : ""?>">
                                        <span>Add</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?=site_url('Admin/Vendor/ViewShipping');?>" class="sb-nav-item <?=$action == 'addproducts' ? "active" : ""?>">
                                        <i class="icon fa fa-circle-o"></i> <span>View</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- <div class="sidebar-title">Widget Area </div>
                        <li>
                        <a href="<?=site_url('Admin/SadminLogin/Widget');?>" class="sb-nav-item <?=$active == 'Widget' ? "active" : ""?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span> Widgets</span>
                            </a>
                            <a href="<?=site_url('Admin/SadminLogin/addWidget');?>" class="sb-nav-item <?=$active == 'addWidget' ? "active" : ""?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span>Create Widget</span>
                            </a>

                        </li> -->
                        <!-- <li class="sb-dropdown">
                            <a href="#" class="sb-nav-item sb-dropdown-toggle <?=$active == 'add_page' ? "active" : ""?>">
                                <i class="icon fa fa-leaf"></i>
                                <span> Pages</span>

                            </a>

                            <ul class="collapse">
                                <li>
                                    <a href="<?=site_url('Admin/SadminLogin/add_page')?>" class="sb-nav-item  <?=$action == 'add_page' ? "active" : ""?>">
                                        <i class="icon fa fa-circle-o"></i> <span>Add Page</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?=site_url('Admin/SadminLogin/view_page')?>" class="sb-nav-item  <?=$action == 'view_page' ? "active" : ""?>">
                                        <i class="icon fa fa-circle-o"></i> <span>View</span>
                                    </a>
                                </li>
                            </ul>
                        </li> -->
                        <!-- <li class="sb-dropdown">
                            <a href="#" class="sb-nav-item sb-dropdown-toggle <?=$active == 'cmsblock' ? "active" : ""?>">
                                <i class="icon fa fa-leaf"></i>
                                <span> CMS Block</span>

                            </a>

                            <ul class="collapse">
                                <li>
                                    <a href="<?=site_url('Admin/SadminLogin/add_block')?>" class="sb-nav-item  <?=$action == 'cmsblock' ? "active" : ""?>">
                                        <i class="icon fa fa-circle-o"></i> <span>Add Block</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?=site_url('Admin/SadminLogin/view_block')?>" class="sb-nav-item  <?=$action == 'view_block' ? "active" : ""?>">
                                        <i class="icon fa fa-circle-o"></i> <span>View</span>
                                    </a>
                                </li>
                            </ul>
                        </li> -->
                        <!-- <li>
                            <a href="<?=site_url('Admin/SadminLogin/addProp');?>" class="sb-nav-item <?=$active == 'addproperties' ? "active" : ""?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span>Properties (3)</span>
                            </a>

                        </li> -->
                        <div class="sidebar-title">Offer / Users area </div>
                        <li>
                            <a href="<?=site_url('Admin/SadminLogin/viewUser');?>" class="sb-nav-item <?=$active == 'viewuser' ? "active" : ""?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span>View Users</span>
                            </a>

                        </li>
                        <li>
                            <a href="<?=site_url('Admin/SadminLogin/createGroup');?>" class="sb-nav-item <?=$active == 'createGroup' ? "active" : ""?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span>Create Customer Group</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=site_url('Admin/SadminLogin/customerGroup');?>" class="sb-nav-item <?=$active == 'customerGroup' ? "active" : ""?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span>Assign Customer in Group</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=site_url('Admin/SadminLogin/offercode');?>" class="sb-nav-item <?=$active == 'offercode' ? "active" : ""?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span>Create Offer Code</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=site_url('Admin/SadminLogin/viewOffer');?>" class="sb-nav-item <?=$active == 'viewOffer' ? "active" : ""?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span>View Offers</span>
                            </a>

                        </li>
                        <!-- <li>
                            <a href="<?=site_url('Admin/SadminLogin/prime_member');?>" class="sb-nav-item <?=$active == 'prime_member' ? "active" : ""?>">
                                <i class="icon fa fa-list-alt"></i>
                                <span>Create prime Membership</span>
                            </a>
                        </li> -->
                        <div class="sidebar-title">Bulk Upload</div>
                    <li>
                        <a href="<?=base_url('Admin/Vendor/BulkUpload')?>" class="sb-nav-item  <?=$active == 'BulkUpload' ? "active" : ""?>">
                            <i class="icon fa fa-table"></i>
                            <span>Bulk Product Upload</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url('Admin/Vendor/BulkUpdate')?>" class="sb-nav-item  <?=$active == 'BulkUpdate' ? "active" : ""?>">
                            <i class="icon fa fa-table"></i>
                            <span>Bulk Stock Update</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url('Admin/Vendor/CrossUpload')?>" class="sb-nav-item  <?=$active == 'CrossUpload' ? "active" : ""?>">
                            <i class="icon fa fa-table"></i>
                            <span>Cross & Similar Product Upload</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url('Admin/Vendor/ColorUpload')?>" class="sb-nav-item  <?=$active == 'ColorUpload' ? "active" : ""?>">
                            <i class="icon fa fa-table"></i>
                            <span>Color Upload</span>
                        </a>
                    </li>

                    <?php }?>









                    <?php
$da = getUserProfile($this->session->userdata('signupSession')['id']);
//if (($this->session->userdata('signupSession')['role'] == 1) || ($da->allow_product == 1 && $this->session->userdata('signupSession')['role'] == 0)) {
if (($this->session->userdata('signupSession')['role'] == 2) || ($this->session->userdata('signupSession')['role'] == 1)) {
    ?>
                        <div class="sidebar-title">Report</div>
                        <li>
                            <a href="<?=base_url('Admin/Vendor/userOrder')?>" class="sb-nav-item  <?=$active == 'orders' ? "active" : ""?>">
                                <i class="icon fa fa-table"></i>
                                <span>Pending order</span>
                            </a>
                        </li>
                         <li>
                            <a href="<?=base_url('Admin/Vendor/dispatchOrder')?>" class="sb-nav-item  <?=$active == 'orders' ? "active" : ""?>">
                                <i class="icon fa fa-table"></i>
                                <span>Dispatch order</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=base_url('Admin/Vendor/faildOrder')?>" class="sb-nav-item  <?=$active == 'orders' ? "active" : ""?>">
                                <i class="icon fa fa-table"></i>
                                <span>Failed order</span>
                            </a>
                        </li>

                        <!-- <li>
                            <a href="<?=base_url('Admin/Vendor/return_view')?>" class="sb-nav-item  <?=$active == 'return_view' ? "active" : ""?>">
                                <i class="icon fa fa-table"></i>
                                <span>Product Return</span>
                            </a>
                        </li> -->
                        <!-- <li>
                            <a href="<?=base_url('Admin/Vendor/exchange_view')?>" class="sb-nav-item  <?=$active == 'exchange_view' ? "active" : ""?>">
                                <i class="icon fa fa-table"></i>
                                <span>Product Exchange</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=base_url('Admin/Vendor/review')?>" class="sb-nav-item  <?=$active == 'review' ? "active" : ""?>">
                                <i class="icon fa fa-table"></i>
                                <span>Product Review</span>
                            </a>
                        </li> -->
                        <li>
                            <a href="<?=base_url('Admin/Vendor/userReviews')?>" class="sb-nav-item  <?=$active == 'review' ? "active" : ""?>">
                                <i class="icon fa fa-table"></i>
                                <span>Products reviews</span>
                            </a>
                        </li>
                    <?php }?>
                </ul>



            </div>
        </div>
        <!-- /Sidebar -->


    </header>