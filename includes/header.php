<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="A short description." />
    <meta name="keywords" content="put, keywords, here" />
    <title>CiTE</title>
    
    <script src="../public/js/jquery.min.js"></script>
    <script src="../public/js/angular.min.js"></script>
    <script src="../public/js/angapp.js"></script>
    <link rel="stylesheet" href="../public/css/Fr.star.css" />
    <link href="../public/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/css/font-awesome.min.css" rel="stylesheet">
    <link href="../public/css/metisMenu.min.css" rel="stylesheet">
    <link href="../public/css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/styles.css" type="text/css">
</head>
<body>
<div id="wrapper">
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; margin-left:10%; margin-right:10%; border-bottom: 1px solid #BDBDBD;">
    <div class="navbar-header">
        
        <a class="navbar-brand" href="index.php"> <span class=head><i class="fa fa-home fa-lg" aria-hidden="true"></i> Post Your Ideas</span></a>
    </div>
    <ul class="nav navbar-top-links navbar-right">
        <?php
            if(isset($_SESSION['signed_in'])==false || isset($_SESSION['signed_in']) == false){
               
        ?>
        <li>
            <a href="login.php"> <i class="fa fa-sign-in" aria-hidden="true"></i> Log in</a>
        </li>
        <li>
            <a href="signup.php"> <i class="fa fa-user-plus" aria-hidden="true"></i> Register</a>
        </li>
        <?php
        } 
        else{
        ?>
        
        <li>
            <a href="create_topic.php" ><i class="fa fa-pencil-square fa-lg" aria-hidden="true"></i> Create a new post
            </a>
         </li>
          
       
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i i class="fa fa-user" aria-hidden="true"></i>
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li class=drop> <span> <?php if(isset($_SESSION['signed_in'])&&$_SESSION['signed_in']==true){
                                                                                    echo $_SESSION['user_name']; 
                                                                            }
                                                                        ?>
                </span></li>
                
                <?php
                    if (isset($_SESSION['user_level']) && $_SESSION['user_level']==1) {
                ?>
                    <li>
                        <a href="create_cat.php" ><i class="fa fa-plus-circle" aria-hidden="true"></i> Create Category</a>
                    </li>
                <?php
                // echo '<a class="item" href="login.php">Log in</a> or <a class="item" href="signup.php">create an account</a>.';
                }
                ?>
                <li><a class="fa fa-key" aria-hidden="true" href="changepass.php"> Change password</a></li>
                <li ><a class="fa fa-sign-out" aria-hidden="true" href="signout.php"> Log out</a></li>
            </ul>
        </li>
        <?php
            }
        ?>
    </ul>
    
</nav>
    <!-- <h1>Post Your Ideas</h1> -->
    <div id="wrapper">
        <div id="menu">
            <div id="userbar">
            </div>
        </div>
        <div id="content">