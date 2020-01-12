<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
<?php flash('register_success'); ?>
        <div class="logo">
            <img src="http://www.stickpng.com/assets/thumbs/584c4c1b1fc21103bb375bab.png" alt="intragram">
        </div>
        <h1 class="title">LOGIN TO YOUR ACCOUNT</h1> 
        <form class='form-lo' action="<?php echo URLROOT;?>/users/login" method="POST" >
            <input name="username" class="<?php echo (!empty($data['username_err']) ? 'error' : '')?>" id="user" type="text" placeholder="USERNAME" value="<?php echo $data['username']; ?>">
            <small><?php echo $data['username_err']; ?></small>
            <input name="password" class="<?php echo (!empty($data['password_err']) ? 'error' : '')?>" id="passwd" type="password" placeholder="PASSWORD" value="<?php echo $data['password']; ?>">
            <small><?php echo $data['password_err']; ?></small>
            <input id="btn" type="submit" value="LOGIN">
        </form>
        <div>
            You Don't have an account?<a href="<?php echo URLROOT;?>/users/register">Sign Up Now</a> 
        </div>
    </div>
    <!-- this the new login page -->
    <!-- Material form login -->
    <?php flash('register_success'); ?>
<div class="card">

<h5 class="card-header info-color white-text text-center py-4">
  <strong>Sign in</strong>
</h5>

<!--Card content-->
<div class="card-body px-lg-5 pt-0">

  <!-- Form -->
  <form class="text-center" style="color: #757575;" action="<?php echo URLROOT;?>/users/login" method="POST">

    <!-- Email -->
    <div class="md-form">
      <input type="text" id="materialLoginFormEmail" class="form-control" value="<?php echo $data['username']; ?>"  name="username">
      <label for="materialLoginFormEmail">E-mail</label>
    </div>

    <!-- Password -->
    <div class="md-form">
      <input type="password" id="materialLoginFormPassword" class="form-control" value="<?php echo $data['password']; ?>" name="password">
      <label for="materialLoginFormPassword">Password</label>
    </div>

    <div class="d-flex justify-content-around">
      <div>
        <!-- Remember me -->
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="materialLoginFormRemember">
          <label class="form-check-label" for="materialLoginFormRemember">Remember me</label>
        </div>
      </div>
      <div>
        <!-- Forgot password -->
        <a href="">Forgot password?</a>
      </div>
    </div>

    <!-- Sign in button -->
    <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Sign in</button>

    <!-- Register -->
    <p>Not a member?
      <a href="<?php echo URLROOT;?>/users/register">Register</a>
    </p>

    <!-- Social login -->
    <p>or sign in with:</p>
    <a type="button" class="btn-floating btn-fb btn-sm">
      <i class="fab fa-facebook-f"></i>
    </a>
    <a type="button" class="btn-floating btn-tw btn-sm">
      <i class="fab fa-twitter"></i>
    </a>
    <a type="button" class="btn-floating btn-li btn-sm">
      <i class="fab fa-linkedin-in"></i>
    </a>
    <a type="button" class="btn-floating btn-git btn-sm">
      <i class="fab fa-github"></i>
    </a>

  </form>
  <!-- Form -->

</div>

</div>
<!-- Material form login -->
    <!-- login page ended  -->
<?php require APPROOT . '/views/inc/footer.php'; ?>