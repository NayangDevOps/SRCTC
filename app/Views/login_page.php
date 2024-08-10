    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form id="form_signin" class="form_signin" action="<?php echo site_url('sign_in'); ?>" method="post">
        <h3>Login</h3>
        <?php if (!empty(session()->getFlashdata('success'))): ?>
        <div class="signup">
            <div class="alert alert-success">
                <?php echo session()->getFlashdata('success'); ?>
            </div>
        </div>            
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="signup">
                <div class="alert alert-danger">
                    <ul>                    
                        <li><?php echo $error; ?></li>
                    </ul>
                </div>
            </div>            
        <?php endif; ?>
        <div  class="mad-mark">
            <label for="username">Username</label>
            <input class="signin" type="text" placeholder="Email" name="username" id="username">
        </div>
        <div  class="mad-mark">
            <label for="password">Password</label>
            <input class="signin" type="password" placeholder="Password" name="password" id="password">
        </div>
        <button class="submit-link" type="submit">Log In</button>
        <a href="<?php echo site_url('sign_up'); ?>" class="button-link">Sign Up</a>
    </form>
