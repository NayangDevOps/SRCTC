<main id="main" class="main">
    <div class="pagetitle">
      <h1>Add User</h1>
    </div>
    <section class="section">
      <div class="row">
        <div class="col-lg-15">
          <div class="card">
            <div class="card-body">
            <?php if (session()->getFlashdata('error')):?>
                <div class="alert alert-danger">
                        <?php foreach (session('error') as $error) : ?>
                            <div><?= $error ?></div>
                        <?php endforeach ?>
                        </div>
                    <?php endif; ?>
              <h5 class="card-title"></h5>
              <form class="profile-form" action="<?php echo site_url('add_user_reg'); ?>" method="post" enctype="multipart/form-data" id="add_user">
                <div class="row mb-3">
                  <label for="first_name" class="col-sm-2 col-form-label">First Name</label>
                  <div class="col-sm-3">
                    <input type="text" name="first_name" id="first_name" class="form-control">
                  </div>
                  <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                  <div class="col-sm-3">
                    <input type="text" name="last_name" id="last_name" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="display_name" class="col-sm-2 col-form-label">Display Name</label>
                  <div class="col-sm-3">
                    <input type="text" name="display_name" id="display_name" class="form-control">
                  </div>
                  <legend class="col-form-label col-sm-2 pt-0">Gender</legend>
                  <div class="col-sm-3">
                    <input class="form-check-input" type="radio" name="gender" id="gridRadios1" value="0" <?php echo ($user_data['gender'] == 0) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="gridRadios1">Male</label>
                    <input class="form-check-input" type="radio" name="gender" id="gridRadios2" value="1" <?php echo ($user_data['gender'] == 1) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="gridRadios2">Female</label>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="user_type" class="col-sm-2 col-form-label">User Type</label>
                  <div class="col-sm-8">
                    <?php 
                     $session = session();
                     $id = $session->get('user_id');
                     $user = user_data($id);
                    ?>
                    <select class="form-select" id="user_type" name="user_type" <?php echo ($user['user_type'] != 10) ? 'disabled' : ''; ?>>
                      <option value="" selected>Select User Type</option>
                      <option value="10">Super Admin</option>
                      <option value="20">Admin</option>
                      <option value="30">Loco Pilot</option>
                      <option value="1">Normal User</option>
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="profile_picture" class="col-sm-2 col-form-label">Profile Picture</label>
                  <div class="col-sm-8">
                    <input class="form-control" type="file" name="profile_picture" id="profile_picture">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="email" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-3">
                    <input type="text" name="email" id="email" class="form-control">
                  </div>
                  <label for="mobile_no" class="col-sm-2 col-form-label">Mobile No.</label>
                  <div class="col-sm-3">
                    <input type="text" name="mobile_no" id="mobile_no" minlength="10" maxlength="10" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="password" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-3">
                    <input type="password" name="password" id="password" class="form-control">
                  </div>
                  <label for="cpassword" class="col-sm-2 col-form-label">Confirm Password</label>
                  <div class="col-sm-3">
                    <input type="password" name="cpassword" id="cpassword" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-sm-11">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>  
                </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>