<div class="login-vector-css">
	</div>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form class="sign_up_form" id="form_signup" action="<?php echo site_url('register'); ?>" method="post">
        <h3>Register</h3>        
        <?php if (session()->has('errors')) : ?>
            <div class="signup">
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session('errors') as $error) : ?>
                            <li><?= $error ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        <?php endif ?>
        <div  class="mad-mark">
            <label>First Name</label>
            <input type="text" name="first_name" placeholder="First name" id="first_name">
        </div>
        <div  class="mad-mark">
            <label>Last Name</label>
            <input type="text" name="last_name" placeholder="Last name" id="last_name">
        </div>
        <div  class="mad-mark">
            <label>Email</label>
            <input type="email" name="email" placeholder="Email" id="email">
        </div>
        <div  class="mad-mark">
            <label>Mobile No.</label>
            <input type="text" name="mobile_no" placeholder="Mobile No." id="mobile_no" minlength="10" maxlength="10">
        </div>
        <div  class="mad-mark">
            <label>Password</label>
            <input type="password" name="password" placeholder="Password" id="password">
        </div>
        <div  class="mad-mark">
            <label>Confirm Password</label>
            <input type="password" name="cpassword" placeholder="Confirm Password" id="cpassword">
        </div>
        <button class="submit-link" type="submit">Sign Up</button>
        <a class="button-link" href="<?php echo site_url('/'); ?>">Back To Sign In</a>
    </form>