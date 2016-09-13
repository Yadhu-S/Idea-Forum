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
                        echo 'Username is already in use';
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
                            echo'Registered <a href="login.php">Log in</a>';
                        }
                    }
        }
        }

    }   
    ?>
       
     <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <div id="p">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Register</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="signup.php" method="post">
                        <fieldset>
                            <div class="form-group <?=isset($alert['user'])?'has-error':''?>">
                                <input class="form-control" placeholder="Username" name="user_name" type="text" autofocus>
                                <?php
                                if (isset($alert['user'])) {
                                ?>
                                <span class="help-block"><?=$alert['user']?>.</span>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="form-group <?=isset($alert['pass_length'])?'has-error':''?>">
                                <input class="form-control" placeholder="Password" name="user_pass" type="password" value="">
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
                                <button type="submit" class="btn btn-lg btn-success btn-block" name="submit">Register</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
   

    <?php
}
require('../includes/footer.php');

?>