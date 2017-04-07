<?php
	require('../includes/connect.php');
	require('../includes/header.php');
	require("../includes/function.php");



        if (isset($_SESSION['user_level']) && $_SESSION['user_level']==2) {
        	$numrow = mysqli_query($connection,"SELECT * FROM `topics`");
			$topic_number=mysqli_num_rows($numrow);
			$numuser= mysqli_query($connection,"SELECT * FROM `users`");
			$user_num=mysqli_num_rows($numuser);
            $sql2="SELECT state FROM control ";
            $resu=mysqli_query($connection,$sql2);
            while($row = mysqli_fetch_assoc($resu)){
                $statec=$row['state'];
            }
            ?>

            <div class="main-items">
            <div class="col-sm-9 col-md-4 col-md-offset-4 col-sm-offset-2">
                <form action="index.php" method="post">
                    <p class="pull-right alert alert-info"><i class="fa fa-lightbulb-o fa-2x" aria-hidden="true"></i> Total Posts :
                            <?php
                            echo $topic_number;
                            ?>
                    </p>
                    <p class="pull-right alert alert-info"><i class="fa fa-lightbulb-o fa-2x" aria-hidden="true"></i> Total Users :
                            <?php
                            echo $user_num;
                            ?>
                    </p>
                      <div class="alert alert-info"> <strong><i class="fa fa-wrench fa-2x" aria-hidden="true"></i>Control</strong> </div>           
                        <label class="switch">
                            <?php
                            if($statec==1){
                                ?>
                                <input type="checkbox" name="check" value="Yes" checked />
                                <?php
                            }
                            else{
                                ?>
                                <input type="checkbox" name="check" value="Yes" /> 
                                <?php
                            }
                            ?>
                            <div class="slider round">
                            </div>
                        </label>
                        </br><button type="submit" class="btn btn-lg btn-primary" name="submit"><i class="fa fa-check-circle" aria-hidden="true"></i></button>
                    </div>
                </form>
            </div>
            </div>
            <?php
        }
	require('../includes/footer.php');
?>