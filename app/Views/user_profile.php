<main id="main" class="main">
    <div class="pagetitle">
      <h1>User Profile</h1>
    </div>
    <section class="section">
      <div class="row">
        <div class="col-lg-15">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                <?php 
                if(!empty($user_data['display_name'])){
                    echo $user_data['display_name'];
                }else{
                    echo $user_data['first_name'] . ' ' . $user_data['last_name'];
                }
                ?> 
                </h5>
              <form class="profile-form" action="<?php echo site_url('profile_update/'.$user_data['id']); ?>" method="post" enctype="multipart/form-data" id="profile-form">
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">First Name</label>
                  <div class="col-sm-3">
                    <input type="text" name="first_name" value="<?php echo $user_data['first_name']; ?>" class="form-control">
                  </div>
                  <label for="inputText" class="col-sm-2 col-form-label">Last Name</label>
                  <div class="col-sm-3">
                    <input type="text" name="last_name" value="<?php echo $user_data['last_name']; ?>" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Display Name</label>
                  <div class="col-sm-3">
                    <input type="text" name="display_name" value="<?php echo $user_data['display_name']; ?>" class="form-control">
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
                      <option value="" disabled>Select User Type</option>
                      <option value="10" <?php echo ($user_data['user_type'] == 10) ? 'selected' : ''; ?>>Super Admin</option>
                      <option value="20" <?php echo ($user_data['user_type'] == 20) ? 'selected' : ''; ?>>Admin</option>
                      <option value="30" <?php echo ($user_data['user_type'] == 30) ? 'selected' : ''; ?>>Loco Pilot</option>
                      <option value="1" <?php echo ($user_data['user_type'] == 1) ? 'selected' : ''; ?>>Normal User</option>
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputNumber" class="col-sm-2 col-form-label">Profile Picture</label>
                  <div class="col-sm-8">
                    <input class="form-control" type="file" name="profile_picture" id="profile_picture">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-3">
                    <input type="text" name="email"  value="<?php echo $user_data['email']; ?>" class="form-control">
                  </div>
                  <label for="inputText" class="col-sm-2 col-form-label">Mobile No.</label>
                  <div class="col-sm-3">
                    <input type="text" name="mobile_no"  value="<?php echo $user_data['mobile_no']; ?>" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-sm-11">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Update</button>
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