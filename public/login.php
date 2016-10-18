<?php 
require('../includes/connect.php');
require('../includes/header.php');
require("../includes/function.php");
$alert=array();
// $title = 'Login';
if(isset($_SESSION['signed_in'])&&$_SESSION['signed_in']==true)
{
    echo '
            <div class="ce">

                <div class="alert alert-danger vertical-center-row" > 
                 <i class="fa fa-exclamation-triangle fa-5x" aria-hidden="true"></i></br>
                <strong >Please log out.</strong>
                </div>
            </div>';
}
else{
    if(isset($_POST['login'])){
        $username=$_POST['user_name'];
        $password=$_POST['user_pass'];

        if($username == "") {
            $alert['username'] = "Username cannot be empty";
            
        }
        if($password == ""){
            $alert['password'] = "Password cannot be empty";
        }

        if(empty($alert)){
            $user_id=mysqli_real_escape_string($connection,$username);
            $sql = "SELECT user_id,user_name,user_level,user_pass
                    FROM   users
                    WHERE BINARY user_name = '{$user_id}'";
            $result = mysqli_query($connection,$sql);
            if(!$result) {
                $alert['user'] = 'Something went wrong while signing in. Please try again later.';
                // echo 'Something went wrong while signing in. Please try again later.';
            } else {
                    $existing_hash="";
                    while($row = mysqli_fetch_assoc($result)){
                        $existing_hash= $row['user_pass'];
                        $us_id=$row['user_id'];
                        $usr=$row['user_name'];
                        $us_lev=$row['user_level'];
                    }
                    $hash=password_verify ($password,$existing_hash);
                    if(mysqli_num_rows($result) == 0 || $hash!=TRUE) {
                        $alert['user'] = 'Username/Password is incorrect';
                    }
                    else{
                        $_SESSION['signed_in'] = true;
                        $_SESSION['user_id']    = $us_id;
                        $_SESSION['user_name']  = $usr;
                        $_SESSION['user_level'] = $us_lev;    
                        redirect_to("index.php");
                    }
            }
        }
        else {
            $alert['user'] = "Username/Password cannot be left empty";
            // echo "Username/Password cannot be left empty";
        }
    }
    ?>
   
   <div ng-app="validationApp" ng-controller="mainController">
    <div class="row">
        <div class="col-sm-9 col-md-4 col-md-offset-4 col-sm-offset-2">
         <div id="p">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Log In</h3>
                </div>
                <div class="panel-body">
                    <form role="form" name="userForm" action="login.php" method="post" ng-submit="submitForm(userForm.$valid)" novalidate>
                        <fieldset>
                            <div  ng-class="{ 'has-error' : userForm.user_name.$invalid && !userForm.user_name.$pristine }" class="form-group <?=isset($alert['username'])?'has-error':''?>" >
                                <input class="form-control" placeholder="Username" name="user_name" type="text" autofocus ng-model="user.name" required ng-minlength="5" ng-maxlength="30">
                                <p ng-show="userForm.user_name.$error.minlength" class="help-block">Invalid username.</p>
                                <p ng-show="userForm.user_name.$error.maxlength" class="help-block">Invalid username.</p>
                                <?php
                                if (isset($alert['username'])) {
                                ?>
                                <span class="help-block"><?=$alert['username']?>.</span>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="form-group <?=isset($alert['password'])?'has-error':''?>">
                                <input class="form-control" placeholder="Password" name="user_pass" type="password" value="">
                                <?php
                                if (isset($alert['password'])) {
                                ?>
                                <span class="help-block"><?=$alert['password']?>.</span>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                </label>
                            </div>
                            <div class="form-group <?=isset($alert['user'])?'has-error':''?>">
                            <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-primary btn-block" name="login">Log in</button>
                                <?php
                                if (isset($alert['user'])) {
                                ?>
                                <span class="help-block"><?=$alert['user']?>.</span>
                                <?php
                                }
                                ?>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
    </div>
    
    <?php
}
require('../includes/footer.php');
?>
