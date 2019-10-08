<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
        <div class="logo">
            <img src="http://www.stickpng.com/assets/thumbs/584c4c1b1fc21103bb375bab.png" alt="intragram">
        </div>
        <h1 class="title">SIGN UP FOR YOUR ACCOUNT</h1> 
        <form class='form-lo' action="<?php echo URLROOT;?>/users/register" method="POST" >
            <input name="username" class="<?php echo (!empty($data['username_err']) ? 'error' : '')?>" id="user" type="text" placeholder="USERNAME" value="<?php echo $data['username']; ?>">
            <small><?php echo $data['username_err']; ?></small>
            <input name="email" class="<?php echo (!empty($data['email_err']) ? 'error' : '')?>" id="email" type="email" placeholder="EMAIL" value="<?php echo $data['email']; ?>">
            <small><?php echo $data['email_err']; ?></small>
            <input name="password" class="<?php echo (!empty($data['password_err']) ? 'error' : '')?>" id="passwd" type="password" placeholder="PASSWORD" value="<?php echo $data['password']; ?>">
            <small><?php echo $data['password_err']; ?></small>
            <input name="confirm_password" class="<?php echo (!empty($data['confirm_password_err']) ? 'error' : '')?>" id="conf_passwd" type="password" placeholder="CONFIRM PASSWORD" value="<?php echo $data['confirm_password']; ?>">
            <small><?php echo $data['confirm_password_err'] ;?></small>
            <input  id="btn" type="submit" value="LOGIN">
        </form>
        <div>
            You Alredy have an account?<a href="<?php echo URLROOT;?>/users/login">Sign In Now</a> 
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>