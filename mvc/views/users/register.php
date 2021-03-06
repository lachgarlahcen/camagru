<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
    <!-- Material form register -->
    <div class="card">

        <h5 class="card-header orange lighten-1 white-text text-center py-4">
            <strong>Sign up</strong>
        </h5>

        <!--Card content-->
        <div class="card-body px-lg-5 pt-0">

            <!-- Form -->
            <form class="text-center" style="color: #757575;" action="<?php echo URLROOT;?>/users/register"
                method="POST">

                <div class="form-row">
                    <div class="col">
                        <!-- First name -->
                        <div class="md-form">
                            <input name="username" type="text" id="username" class="form-control"
                                value="<?php echo $data['username']; ?>">
                            <label for="username">User name <small class="text-danger">
                                    <?php echo $data['username_err']; ?> </small></label>
                        </div>
                    </div>
                </div>
                <!-- E-mail -->
                <div class="md-form mt-0">
                    <input name="email" type="email" id="email" class="form-control"
                        value="<?php echo $data['email']; ?>">
                    <label for="email">E-mail <small class="text-danger">
                            <?php echo $data['email_err']; ?> </small></label>
                </div>

                <!-- Password -->
                <div class="md-form">
                    <input name="password" type="password" id="password" class="form-control"
                        value="<?php echo $data['password']; ?>">
                    <label for="password">Password <small class="text-danger ">
                            <?php echo $data['password_err'] ;?>
                        </small></label>
                </div>

                <!-- Confirm Password -->
                <div class="md-form">
                    <input name="confirm_password" type="password" id="passwordConfirm" class="form-control"
                        value="<?php echo $data['confirm_password']; ?>">
                    <label for="passwordConfirm">Password Confirm <small class="text-danger">
                            <?php echo $data['confirm_password_err'] ;?>
                        </small></label>
                </div>


                <!-- Sign up button -->
                <button class="btn btn-outline-orange lighten-1 btn-rounded btn-block my-4 waves-effect z-depth-0"
                    type="submit">Sign in</button>
                <div class="d-flex justify-content-around">
                    <div>
                        <!-- Register -->
                        <p>Already a Member?
                            <a href="<?php echo URLROOT;?>/users/login">Sign In</a>
                        </p>
                    </div>
                </div>
            </form>
            <!-- Form -->

        </div>

    </div>
    <!-- Material form register -->
</div>
<script type="text/javascript">
try {
    var input_user = document.getElementById('username');
    var input_pass = document.getElementById('password');
    var input_email = document.getElementById('email');
    var input_passconf = document.getElementById('passwordConfirm');
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
    var lable_email = input_email.nextElementSibling;
    var lable_passconf = input_passconf.nextElementSibling;
    if (input_email.value)
        lable_email.classList.add('active');
    if (input_passconf.value)
        lable_passconf.classList.add('active');
    input_email.addEventListener('focus', function() {
        lable_email.classList.add('active');
    });
    input_email.addEventListener('focusout', function() {
        if (!input_email.value)
            lable_email.classList.remove('active');
    });

    input_passconf.addEventListener('focus', function() {

        lable_passconf.classList.add('active');
    });
    input_passconf.addEventListener('focusout', function() {
        if (!input_passconf.value)
            lable_passconf.classList.remove('active');
    });
} catch (error) {

}
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>