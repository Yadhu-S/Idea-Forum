<?php
require('../includes/connect.php');
require('../includes/header.php');
require('../includes/function.php');
 $alert=array();
 
if(isset($_SESSION['signed_in'])&&$_SESSION['signed_in']==true)
{
    echo'logout to continue';
}
else{

     if (isset($_POST["submit"])) {
        
        $username=$_POST['user_name'];
        $password=$_POST['user_pass'];
        $passchek=$_POST['pass_check'];
        $mail=$_POST['adm_no'];
        if($username==""){
            $alert['user']="Username Should contain at least 5 characters";
        }
        if(strlen($username)>30||strlen($username)<5){
            $alert['user_le']="Username must be between 5 and 30 characters";
        }
        if($password!=$passchek){
            $alert['pass']="Passwords do not match";    
        } 
        else if(strlen($password)<=6){
            $alert['pass_length']="Password should contain at least 6 characters";
            }
        if(empty($alert)){
            $user_na=mysqli_real_escape_string($connection,$username);
            $mail_e=mysqli_real_escape_string($connection,$mail);
            $pass=encrypt_password($password);
            $ver ="SELECT user_name FROM users WHERE user_name='{$username}'";
            $pastosql=mysqli_query($connection,$ver);
            if(!$pastosql){
                echo mysqli_errno();
            }
            else{
                if(mysqli_num_rows($pastosql) != 0){
                        $alert['user']='Username is already in use';
                    }
                
                else{
                        $sql = "INSERT INTO
                                    users(user_name, user_pass, user_email ,user_date,user_level)
                                 VALUES('{$user_na}','{$pass}','{$mail_e}',NOW(),0)";
                                         
                        $result = mysqli_query($connection,$sql);
                        if(!$result)
                        {
                            die("Database query failed".mysqli_error($connection));
                        }
                        else
                        {
                            $alert['change']='Registered <a href="login.php">Log in</a>';
                        }
                    }
        }
        }

    }   
    ?>
    <div ng-app="validationApp" ng-controller="mainController">   
         <div class="row">
            <div class="col-sm-9 col-md-4 col-md-offset-4 col-sm-offset-2">
              <div id="p">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Register</h3>
                    </div>
                    <div class="panel-body">
                        <form name="userForm" role="form" action="signup.php" method="post">
                            <fieldset>
                                <div ng-class="{ 'has-error' : userForm.user_name.$invalid && !userForm.user_name.$pristine }" class="form-group <?=isset($alert['user'])?'has-error':''?>">
                                    <input class="form-control" placeholder="Username" name="user_name" type="text" autofocus ng-model="user.name" required ng-minlength="5" ng-maxlength="30">
                                    <p ng-show="userForm.user_name.$error.minlength" class="help-block">Username is too short.</p>
                                    <p ng-show="userForm.user_name.$error.maxlength" class="help-block">Username is too long.</p>
                                    <?php
                                    if (isset($alert['user'])) {
                                    ?>
                                    <span class="help-block"><?=$alert['user']?>.</span>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div ng-class="{ 'has-error' : userForm.user_pass.$invalid && !userForm.user_pass.$pristine }" class="form-group <?=isset($alert['pass_length'])?'has-error':''?>">
                                    <input class="form-control" placeholder="Password" name="user_pass" type="password" value="" ng-model="user.pass" required ng-minlength="6">
                                    <p ng-show="userForm.user_pass.$error.minlength" class="help-block">Password too short.</p>
                                    <?php
                                    if (isset($alert['pass_length'])) {
                                    ?>
                                    <span class="help-block"><?=$alert['pass_length']?>.</span>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="form-group <?=isset($alert['pass'])?'has-error':''?>">
                                    <input class="form-control" placeholder="Repet Password" name="pass_check" type="password" value="">
                                    <?php
                                    if (isset($alert['pass'])) {
                                    ?>
                                    <span class="help-block"><?=$alert['pass']?>.</span>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="form-group <?=isset($alert['mail_valid'])?'has-error':''?>">
                                    <input class="form-control" placeholder="Admission No." name="adm_no" type="number" autofocus>
                                    <?php
                                    if (isset($alert['mail_valid'])) {
                                    ?>
                                    <span class="help-block"><?=$alert['mail_valid']?>.</span>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="form-group" >
                                <!-- Change this to a button or input when using this as a form -->
                                <div class="form-group <?=isset($alert['change'])?'has-success':''?>">
                                    <button type="submit" class="btn btn-lg btn-primary btn-block" name="submit">Register</button>
                                    <?php
                                    if (isset($alert['change'])) {
                                    ?>
                                    <span class="help-block"><i class="fa fa-check-circle" aria-hidden="true"></i>

                                     <?=$alert['change']?>.</span>
                                    <?php
                                    }
                                    ?>
                                </div>
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