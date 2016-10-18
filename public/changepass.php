<?php 
	require('../includes/connect.php');
	require('../includes/header.php');
	require("../includes/function.php");
	$alert=array();
	if(isset($_SESSION['signed_in'])&&$_SESSION['signed_in']==true)
	{
		if(isset($_POST['submit'])){
			
			$password=$_POST['current_pass'];
			$newpassword=$_POST['newpass'];
        	$newpasschek=$_POST['newpass_verify'];
			
			if($password==""){
				$alert['current_passw']="This field cannot be left blank.";
			}
			if(strlen($newpassword)<=6){
            $alert['pass_length']="Password should contain at least 6 characters";
            }
        	if($newpassword==""|| $newpasschek==""){
        		$alert['password']="Both fields are required.";
        	}
        	else if($newpassword!=$newpasschek){
            	$alert['password']="Passwords do not match.";    
        	} 
        	if(empty($alert)){
        		$usn=$_SESSION['user_id'];
				$sql="SELECT user_pass FROM users WHERE user_id='{$usn}'";
				$result = mysqli_query($connection,$sql);
				if(!$result){
					echo "DB error.";
				}
				else{
					$existing_hash="";
					$newpassword="";
                    while($row = mysqli_fetch_assoc($result)){
                        $existing_hash= $row['user_pass']; 
                    }   
                    $ver_hash=password_verify($password,$existing_hash);
                    if($ver_hash==TRUE)
                        { 	
                        	
                        	$changesql="UPDATE users SET `user_pass`='".encrypt_password($newpasschek)."' WHERE user_id='{$usn}'";
                        	$resu=mysqli_query($connection,$changesql);
                        	if(!$resu){
                        		$alert['password']="Database Error";
                        	}
                        	else{
                        		$alert['change']="Password changed";
                        		
                        	}
                        }
                        else{
                        	$alert['current_passw']= "Incorrect password";
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
	                    <h3 class="panel-title">Change password</h3>
	                </div>
	                <div class="panel-body">
	                    <form role="form" name="userForm" action="changepass.php" method="post" ng-submit="submitForm(userForm.$valid)" novalidate>
	                        <fieldset>
	                            <div class="form-group <?=isset($alert['current_passw'])?'has-error':''?>" >
	                                <input class="form-control" placeholder="Current password" name="current_pass" type="password" autofocus >
	                                <?php
	                                if (isset($alert['current_passw'])) {
	                                ?>
	                                <span class="help-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?=$alert['current_passw']?>.</span>
	                                <?php
	                                }
	                                ?>
	                            </div>
	                            <div class="form-group <?=isset($alert['password'])?'has-error':''?> ">
	                                <input class="form-control" placeholder="New password" name="newpass" type="password" value="">
	                            </div>
	                            <div class="form-group <?=isset($alert['password'])?'has-error':''?> form-group <?=isset($alert['pass_length'])?'has-error':''?>">
	                                <input class="form-control" placeholder="Verify password" name="newpass_verify" type="password" value="">
	                                <?php
	                                if (isset($alert['password'])) {
	                                ?>
	                                <span class="help-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?=$alert['password']?>.</span>
	                                <?php
	                                }
	                                ?>
	                                <?php
	                                if (isset($alert['pass_length'])) {
	                                ?>
	                                <span class="help-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?=$alert['pass_length']?>.</span>
	                                <?php
	                                }
	                                ?>
	                            </div>
	                            <div class="form-group <?=isset($alert['change'])?'has-success':''?>">
	                            <!-- Change this to a button or input when using this as a form -->
	                                <button type="submit" class="btn btn-lg btn-primary btn-block" name="submit">Change</button>
	                                <?php
                                    if (isset($alert['change'])) {
                                    ?>
                                    <span class="help-block"><i class="fa fa-check-circle" aria-hidden="true"></i>

                                     <?=$alert['change']?>.</span>
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
   	else{
   		echo '
            <div class="ce">

                <div class="alert alert-info vertical-center-row" > 
                 <i class="fa fa-exclamation-circle fa-5x" aria-hidden="true"></i></br>
                <strong >Forbidden.</strong>
                </div>
            </div>';
   	}
    require('../includes/footer.php');

?>