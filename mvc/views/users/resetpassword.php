<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container ">
    <!-- this the new login page -->
    <div class="card">

        <h5 class="card-header orange lighten-1 white-text text-center py-4">
            <strong>Enter Your New Password</strong>
        </h5>

        <!--Card content-->
        <div class="card-body px-lg-5 pt-0">
            <!-- Form -->
            <form class="text-center" style="color: #757575;" action="<?php echo URLROOT;?>/users/resetpassword"
                method="POST">

                <!-- Password -->
                <div class="md-form">
                    <input type="password" id="password" class="form-control" value="<?php echo $data['password']; ?>"
                        name="password">
                    <label for="password">Password <small
                            class="text-danger"><?php echo $data['password_err']; ?></small></label>
                </div>
                <!-- Password Verifie -->
                <div class="md-form">
                    <input type="password" id="password2" class="form-control" value="<?php echo $data['password2']; ?>"
                        name="password2">
                    <label for="password2">Confirm Password<small
                            class="text-danger"><?php echo $data['password2_err']; ?></small></label>
                </div>
                <!-- Sign in button -->
                <button class="btn btn-outline-orange btn-rounded btn-block my-4 waves-effect z-depth-0"
                    type="submit">Reset</button>
            </form>
            <!-- Form -->
        </div>
    </div>
    <!-- login page ended  -->
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>