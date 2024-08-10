<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $companyData = company_data(); 
    if(!empty($companyData[0]['company_welcome_page_image'])) {
        $welcomePageImage = base_url() . 'uploads/company/' . $companyData[0]['company_welcome_page_image'];
    } else {
        $welcomePageImage = base_url() . 'public/img/Vector1.png';
    }
    ?>
    <title><?php echo isset($head_title) ? $head_title : 'SRCTC Dashboard'; ?> | <?php echo $companyData[0]['company_name']; ?></title>
    <link rel="icon" type="img/jpg" sizes="40x40" href="<?php echo base_url() . 'uploads/company/' . $companyData[0]['company_header_logo']; ?>">
    <meta content="" name="description">
    <meta content="" name="keywords">    
    <link href="<?php echo base_url(); ?>public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>public/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>public/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>public/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>public/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>public/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>public/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>public/lib/select2/css/select2.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>public/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>public/css/common.css" rel="stylesheet">
    <script src="<?php echo base_url() ?>public/vendor/bootstrap/js/bootstrap.js"></script> 
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery-2.1.4.min.js"></script> 
    <script src="<?php echo base_url(); ?>public/js/jquery.validate.js"></script>
	  <script src="<?php echo base_url(); ?>public/js/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>public/js/additional-methods.js"></script>
    <script src="<?php echo base_url(); ?>public/js/additional-methods.min.js"></script>
    <script src="<?php echo base_url(); ?>public/js/moment.min.js"></script> 
    <script src="<?php echo base_url(); ?>public/js/dashboard.js"></script> 
    <script src="<?php echo base_url(); ?>public/lib/select2/js/select2.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript">
		var BaseUrl = '<?php echo base_url(); ?>';
    var SiteURL = '<?php echo site_url(); ?>';    
	</script>           
</head>
    <?php 
    if(!empty($header_scripts)){ 
        foreach($header_scripts as $script_names)
        {	
            $checkjscss = explode('.',$script_names);
            $status = end($checkjscss);
            if($status == 'js')
            {
            echo '<script src="'.base_url().$script_names.'"></script>';
            }
            if($status == 'css')
            {
            echo '<link rel="stylesheet" href="'.base_url().$script_names.'" > ';
            }
        }
    }
    if ($head_title != 'Login Page' && $head_title != 'Sign Up Page') {
      $session = session();
      $id = $session->get('user_id');
      $user = user_data($id);
    ?>
 <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="<?php echo site_url('dashboard'); ?>" class="logo d-flex align-items-center">
        <?php
        if(!empty($companyData[0]['company_banner'])){ ?>
        <img src="<?php echo base_url() . 'uploads/company/' . $companyData[0]['company_banner']; ?>" alt="Logo" class="logo-img">
       <?php }else{ ?>
        <img src="<?= base_url("public/img/main_logo.jpeg") ?>" alt="Logo" class="logo-img">
       <?php } ?>            
        </a>
        <div class="logo d-flex align-items-center">
          <?php 
          if($user['profile_pic'] == ' ' || $user['profile_pic'] == null){ ?>
            <img src="<?= base_url("public/img/user_default.jfif") ?>" id="profileImage" class="profile-img"> 
          <?php }else { ?>
            <img src="<?= base_url("uploads/".$user['profile_pic']) ?>" id="profileImage" class="profile-img">
         <?php } ?>
            <label class="user_name"> Hi, <?php echo $user['first_name']; ?></label>
            <div class="profile-menu" id="profileMenu">
              <ul>
                <li class="bi bi-person"><a href="<?php echo site_url('user_profile/'.$id); ?>">Profile</a></li>
                <li class="bi bi-box-arrow-right"><a href="<?php echo site_url('sign_out'); ?>">Sign Out</a></li>
              </ul>
            </div>
        </div>
    </div>
</header>
<body> 
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link " href="<?php echo site_url('dashboard'); ?>">
          <i class="bi bi-speedometer2"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <?php if($user['user_type'] == 10){ ?>
        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#table-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-person-fill"></i><span>Users Management </span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="table-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
              <a href="<?php echo site_url('add_user'); ?>">
                <i class="bi bi-pencil-fill"></i><span>Add User</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url('user_list'); ?>"> 
                <i class="bi bi-table"></i><span>View Users</span>
              </a>
            </li>
          </ul>
        </li>
        <?php }  ?>
      <?php
      if($user['user_type'] == 10 || $user['user_type'] == 20){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#station-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-signpost-split-fill"></i><span>Station Management</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="station-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo site_url('stations'); ?>">
              <i class="bi bi-table"></i><span>View Station</span>
            </a>
          </li>
        </ul>
      </li>
      <?php
      if($user['user_type'] == 10){ ?>
        <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-train-front-fill"></i><span>Train Management</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo site_url('add_train'); ?>">
              <i class="bi bi-pencil-fill"></i><span>Add Train</span>
            </a>
          </li>
          <li>
            <a href="<?php echo site_url('train_list'); ?>">
              <i class="bi bi-table"></i><span>View Train</span>
            </a>
          </li>
        </ul>
      </li>
      <?php } ?>
        <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#route-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-geo-alt-fill"></i><span>Route Management</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="route-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo site_url('add_route'); ?>">
              <i class="bi bi-pencil-fill"></i><span>Add Route</span>
            </a>
          </li>
          <li>
            <a href="<?php echo site_url('route_list'); ?>">
              <i class="bi bi-table"></i><span>View Route</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#tariff-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-currency-rupee"></i><span>Tariff Management</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="tariff-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="<?php echo site_url('add_tariff'); ?>">
                <i class="bi bi-pencil-fill"></i><span>Add Tariff</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url('tariffs'); ?>">
                <i class="bi bi-table"></i><span>View Tariffs</span>
              </a>
            </li>
          </ul>
        </li>
      <?php } ?>     
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#formss-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-ticket-detailed-fill"></i><span>Ticket Management</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="formss-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo site_url('book_ticket'); ?>">
              <i class="bi bi-pencil-fill"></i><span>Book Ticket</span>
            </a>
          </li>
          <li>
            <a href="<?php echo site_url('getTickets'); ?>">
              <i class="bi bi-table"></i><span>View Ticket</span>
            </a>
          </li>
        </ul>
      </li>
      <?php if($user['user_type'] == 10){ ?>
      <li class="nav-item">
          <a class="nav-link collapsed" href="<?php echo site_url('setting'); ?>">
          <i class="bi bi-gear-fill"></i><span>Company Management</span>
          </a>
        </li>
      <?php }  ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo site_url('contact_us'); ?>">
          <i class="bi bi-telephone-fill"></i>
          <span>Contact Us</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo site_url('about_us'); ?>">
          <i class="bi bi-building-fill"></i>
          <span>About Us</span>
        </a>
      </li>
    </ul>
  </aside>
<?php }else { ?>
    <body class="login login_background"> 
<style>
    .login_background {
        background-image: url(<?php echo $welcomePageImage; ?>);
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        width: 100%;
        height: 100vh;
    }
</style>
<?php } ?>