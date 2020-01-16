<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container ">
    <!-- this the new login page -->
    <div class="card">

        <h5 class="card-header orange lighten-1 white-text text-center py-4">
            <strong>Enter Your Email To Recover Your Password</strong>
        </h5>

        <!--Card content-->
        <div class="card-body px-lg-5 pt-0">
            <?php if ($data['error'] != ''): ?>
            <div class="alert alert-danger text-center m-2" role="alert">
                <?php echo $data['error']?>
            </div>
            <?php endif;?>
            <!-- Form -->
            <form class="text-center" style="color: #757575;" action="<?php echo URLROOT;?>/users/recover"
                method="POST">
                <!-- User Name -->
                <div class="md-form">
                    <input type="text" id="email" class="form-control" value="<?php echo $data['email']; ?>"
                        name="email">
                    <label for="email" class>Email</label>
                </div>
                <!-- Sign in button -->
                <button class="btn btn-outline-orange btn-rounded btn-block my-4 waves-effect z-depth-0"
                    type="submit">Recover</button>
            </form>
            <!-- Form -->
        </div>
    </div>
    <!-- login page ended  -->
</div>
<script type="text/javascript">
try {

    var input_email = document.getElementById('email');




    var lable_email = input_email.nextElementSibling;
    if (input_email.value)
        lable_email.classList.add('active');

    input_email.addEventListener('focus', function() {
        lable_email.classList.add('active');
    });
    input_email.addEventListener('focusout', function() {
        if (!input_email.value)
            lable_email.classList.remove('active');
    });
} catch (error) {

}
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>