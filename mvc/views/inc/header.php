<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo SITENAME;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo URLROOT;?>/css/style.css" />
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    
</head>
<body>
<!-- <div class="bg"></div> -->
<div class="header">
<img class="nav-bar-logo" src="http://www.stickpng.com/assets/thumbs/584c4c1b1fc21103bb375bab.png" alt="intragram">
    <ul class="menu">
    <?php if (isset($_SESSION['user_id'])) :?>
        <li class="menu-item"><a class="nav-bar-link" href="<?php echo URLROOT;?>/users/logout">LOGOUT</a></li>
        <li class="menu-item"><a class="nav-bar-link" href="">welcome: <?php echo strtoupper($_SESSION['user_name']); ?></a></li>
    <?php else : ?>
        <li class="menu-item"><a class="nav-bar-link" href="<?php echo URLROOT;?>/users/login">LOGIN</a></li>
        <li class="menu-item"><a class="nav-bar-link" href="<?php echo URLROOT;?>/users/register">REGISTER</a></li>
    <?php endif;?>
        <li class="menu-item"><a class="nav-bar-link" href="">GALARY</a></li>
        <!-- <li class="menu-item"><a class="nav-bar-link" href="">HOME</a></li> -->
    </ul>
</div>
<div class="body">