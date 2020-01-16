<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container ">
    <!-- this the new login page -->
    <?php flash('register_success'); ?>
    <div class="card">

        <h5 class="card-header orange lighten-1 white-text text-center py-4">
            <strong>Sign in</strong>
        </h5>

        <!--Card content-->
        <div class="card-body px-lg-5 pt-0">
            <?php if ($data['error'] != ''): ?>
            <div class="alert alert-danger text-center m-2" role="alert">
                <?php echo $data['error']?>
            </div>
            <?php endif;?>
            <!-- Form -->
            <form class="text-center" style="color: #757575;" action="<?php echo URLROOT;?>/users/login" method="POST">

                <!-- User Name -->
                <div class="md-form">
                    <input type="text" id="username" class="form-control" value="<?php echo $data['username']; ?>"
                        name="username">
                    <label for="username" class>User Name <small
                            class="text-danger"><?php echo $data['username_err']; ?></small></label>
                </div>

                <!-- Password -->
                <div class="md-form">
                    <input type="password" id="password" class="form-control" value="<?php echo $data['password']; ?>"
                        name="password">
                    <label for="password">Password <small
                            class="text-danger"><?php echo $data['password_err']; ?></small></label>
                </div>

                <!-- Sign in button -->
                <button class="btn btn-outline-orange btn-rounded btn-block my-4 waves-effect z-depth-0"
                    type="submit">Sign in</button>

                <div class="d-flex justify-content-around">
                    <div>
                        <!-- Forgot password -->
                        <a href="<?php echo URLROOT;?>/users/recover">Forgot password?</a>
                    </div>
                    <div>
                        <!-- Register -->
                        <p>Not a member?
                            <a href="<?php echo URLROOT;?>/users/register">Register</a>
                        </p>
                    </div>
                </div>
            </form>
            <!-- Form -->
        </div>
    </div>
    <!-- login page ended  -->
</div>
<script type="text/javascript">
/*
 ** LOGIN FORM STYLING
 */
try {
    var input_user = document.getElementById('username');
    var input_pass = document.getElementById('password');
    var lable_user = input_user.nextElementSibling;
    var lable_pass = input_pass.nextElementSibling;


    if (input_user.value)
        lable_user.classList.add('active');
    if (input_pass.value)
        lable_pass.classList.add('active');


    input_user.addEventListener('focus', function() {
        lable_user.classList.add('active');
    });
    input_user.addEventListener('focusout', function() {
        if (!input_user.value)
            lable_user.classList.remove('active');
    });

    input_pass.addEventListener('focus', function() {

        lable_pass.classList.add('active');
    });
    input_pass.addEventListener('focusout', function() {
        if (!input_pass.value)
            lable_pass.classList.remove('active');
    });
} catch (error) {

}

/*
 ** LOGIN FORM STYLING ENDED
 */
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>