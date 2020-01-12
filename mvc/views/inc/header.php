<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo SITENAME;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="<?php echo URLROOT;?>/css/style.css" /> -->
    <link rel='stylesheet' id='compiled.css-css'  href='https://z9t4u9f6.stackpathcdn.com/wp-content/themes/mdbootstrap4/css/compiled-4.11.0.min.css?ver=4.11.0' type='text/css' media='all' />
    
</head>
<body>
<!--Navbar -->
<nav class="mb-1 navbar navbar-expand-lg navbar-dark orange lighten-1">
  <a class="navbar-brand" href="<?php echo URLROOT;?>">CAMAGRU</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-555"
    aria-controls="navbarSupportedContent-555" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent-555">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo URLROOT;?>">Home
          <span class="sr-only">(current)</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Galery</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto nav-flex-icons">
    <?php if (isset($_SESSION['user_id'])) :?>
        <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT;?>/users/logout">LOGOUT</a>
      </li>
        <li class="nav-item">
        <a class="nav-link" href="#">welcome: <?php echo strtoupper($_SESSION['user_name']); ?></a>
      </li>
    <?php else : ?>
        <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT;?>/users/login">LOGIN</a>
      </li>
        <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT;?>/users/register">EGISTER</a>
      </li>
    <?php endif;?>
      <li class="nav-item avatar">
        <a class="nav-link p-0" href="#">
          <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-5.jpg" class="rounded-circle z-depth-0"
            alt="avatar image" height="35">
        </a>
      </li>
    </ul>
  </div>
</nav>
<!--/.Navbar -->

<!-- <div class="bg"></div> -->
<div class="body">