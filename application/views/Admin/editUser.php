                <?php
                    $date1 = $user->bir_year."-".$user->bir_month."-".$user->bir_day;
                    $date2 = $user->ann_year."-".$user->ann_month."-".$user->ann_day;
                ?>
<main class="main-container">
<header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#">View User </a>
                        </li>
                        <li class="active"><span> Edit User</span></li>
                    </ol>
                    <div class="page-header">
                        <h2 class="page-subtitle">
                            Properties Name
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="panel panel-white">
        <div class="panel-body pb">
             <?php $userid = encode($this->encryption->encrypt($user->id)) ?>
             <?= form_open('Admin/SadminLogin/update_user/'.$userid); ?>
            <div class="row">               
                <div class="col-md-3 col-md-offset-2">
                    <label for=""> Email</label>
                    <input type="text" class="form-control" name="user_email" value="<?= $user->user_email ?>" readonly/>
                    <?= form_error('user_email', '<div class="text-danger">', '</div>'); ?>
                </div>
                <!-- <div class="col-md-4 col-md-offset-2">
                    <label for="">Old Password </label>
                    <input type="password" class="form-control" name="user_pass" value="<?= $user->user_password ?>" readonly/>
                    <?= form_error('user_pass', '<div class="text-danger">', '</div>'); ?>
                </div> -->
                <!-- <div class="col-md-4 col-md-offset-2">
                    <label for="">New Password </label>
                    <input type="text" class="form-control" name="new_pass" placeholder="New Password"/>
                    <?= form_error('new_pass', '<div class="text-danger">', '</div>'); ?>
                </div> -->

                <div class="col-md-3 col-md-offset-2">
                    <label for=""> First Name</label>
                    <input type="text" class="form-control" name="user_name" value="<?= $user->user_name ?>" />
                    <?= form_error('user_name', '<div class="text-danger">', '</div>'); ?>
                </div>

                <div class="col-md-3 col-md-offset-2">
                    <label for=""> Last Name</label>
                    <input type="text" class="form-control" name="lastname" value="<?= $user->lastname ?>" />
                    <?= form_error('lastname', '<div class="text-danger">', '</div>'); ?>
                </div>

                <div class="col-md-3 col-md-offset-2">
                    <label for=""> Mobile</label>
                    <input type="text" class="form-control" name="user_contact" value="<?= $user->user_contact ?>" />
                    <?= form_error('user_contact', '<div class="text-danger">', '</div>'); ?>
                </div>

                <div class="col-md-4 col-md-offset-2">
                                        <div class="form-group ">
                                            <label for=""   >
                                                Date of birth
                                            </label>
                                            <select class="form-control" name="bir_day">
                                            <option value="<?=(isset($user->bir_day) && $user->bir_day != NULL)?$user->bir_day :"" ?>"><?=(isset($user->bir_day) && $user->bir_day != NULL)?$user->bir_day :"Enter Day" ?></option><?php
                                                        for ($i = 1;$i <= 31;$i++)
                                                        {
                                                            echo "<option value='$i'>$i</option>";
                                                        }
                                                  ?>
                                            </select>

                                        </div>
                                    </div>

                <div class="col-md-4 col-md-offset-2">
                                        <div class="form-group ">
                                            <label for=""   >
                                                &nbsp
                                            </label>
                                            <select class="form-control"  name="bir_month"><option value="<?=(isset($user->bir_month) && $user->bir_month != NULL)?$user->bir_month :"" ?>"><?=(isset($user->bir_month) && $user->bir_month != NULL)?date("F", strtotime($date1)) :"Enter Month" ?></option><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>

                                        </div>
                                    </div>

                <div class="col-md-4 col-md-offset-2">
                                        <div class="form-group ">
                                            <label for=""   >
                                                &nbsp
                                            </label>
                                            <select class="form-control"  name="bir_year"><option value="<?=(isset($user->bir_year) && $user->bir_year != NULL)?$user->bir_year :"" ?>"><?=(isset($user->bir_year) && $user->bir_year != NULL)?$user->bir_year :"Enter Year" ?></option><?php
                                                        for ($i = 2019;$i >= 1901;$i--)
                                                        {
                                                            echo "<option value='$i'>$i</option>";
                                                        }
                                                  ?></select>

                                        </div>
                                    </div>

                                    <div class="col-md-4 col-md-offset-2">
                                        <div class="form-group ">
                                            <label for=""   >
                                                Date of Anniversary
                                            </label>
                                            <select class="form-control" name="ann_day" ><option value="<?=(isset($user->ann_day) && $user->ann_day != NULL)?$user->ann_day :"" ?>"><?=(isset($user->ann_day) && $user->ann_day != NULL)?$user->ann_day :"Enter Day" ?></option><?php
                                                        for ($i = 1;$i <= 31;$i++)
                                                        {
                                                            echo "<option value='$i'>$i</option>";
                                                        }
                                                  ?>
                                                  <option value="">None</option>
                                            </select>

                                        </div>
                                    </div>

                <div class="col-md-4 col-md-offset-2">
                                        <div class="form-group ">
                                            <label for=""   >
                                                &nbsp
                                            </label>
                                            <select class="form-control"  name="ann_month"><option value="<?=(isset($user->ann_month) && $user->ann_month != NULL)?$user->ann_month :"" ?>"><?=(isset($user->ann_month) && $user->ann_month != NULL)?date("F", strtotime($date2)) :"Enter Month" ?></option><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option><option value="">None</option></select>

                                        </div>
                                    </div>

                <div class="col-md-4 col-md-offset-2">
                                        <div class="form-group ">
                                            <label for=""   >
                                                &nbsp
                                            </label>
                                            <select class="form-control"  name="ann_year"><option value="<?=(isset($user->ann_year) && $user->ann_year != NULL)?$user->ann_year :"" ?>"><?=(isset($user->ann_year) && $user->ann_year != NULL)?$user->ann_year :"Enter Year" ?></option><?php
                                                        for ($i = 2019;$i >= 1901;$i--)
                                                        {
                                                            echo "<option value='$i'>$i</option>";
                                                        }
                                                  ?>
                                                  <option value="">None</option>
                                            </select>

                                        </div>
                                    </div>

                <div class="col-md-6 form-group">
                    <label for=""> Location</label>
                    <textarea name="location" class="form-control"><?= $user->location?></textarea>
                    <?= form_error('location', '<div class="text-danger">', '</div>'); ?>
                </div>

                <div class="col-md-6 form-group">
                    <label for=""> Bio</label>
                    <textarea cols="54" name="bio" class="form-control"><?= $user->bio?></textarea>
                    <?= form_error('bio', '<div class="text-danger">', '</div>'); ?>
                </div>

                <!-- <div class="col-md-4 col-md-offset-2">
                    <label for=""> Mobile</label>
                    <input type="text" class="form-control" name="user_contact" value="<?= $user->user_contact ?>" />
                    <?= form_error('user_contact', '<div class="text-danger">', '</div>'); ?>
                </div> -->
            </div>
            <div class="row">
                <div class="col-md-1 col-xs-4">
                    <div class="form-group ">
                        <div class="custom-control">
                            <input type="radio" class="custom-control-input" value="Male" <?= (isset($user->gender) && $user->gender == 'Male')?'checked' : '' ?> id="defaultChecked28" name="gender" >Male
                            <!-- <label class="custom-control-label" for="defaultChecked28">Male</label> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-1 col-xs-4">
                    <div class="form-group ">
                        <div class="custom-control">
                          <input type="radio" class="custom-control-input" value="Female"<?= (isset($user->gender) && $user->gender == 'Female')?'checked' : '' ?>  name="gender" > Female  
                           <!--  <label class="custom-control-label" for="defaultChecked29">Female</label> -->
                        </div>
                    </div>
                </div>
            </div>

                <div class="col-md-3">
                    <br />
                    <button class="btn btn-sm btn-success">UPDATE</button>
                </div>
            
           
            </div>
          <?= form_close(); ?>
    </div>
</main>