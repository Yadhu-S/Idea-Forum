<?php 
require('../includes/connect.php');
require('../includes/header.php');
require('../includes/function.php');
$alert=array();
if(isset($_SESSION['user_level'])&&$_SESSION['user_level']==1){
	if(isset($_POST['newcat'])){
		$catname=$_POST['cat_name'];
		$catdesc=$_POST['cat_description'];
		if($catname==""){
			$alert['empty']='Category name cannot be blank';
		}
		if(empty($alert)){
			$sql = "INSERT INTO categories(cat_name, cat_description)
      							   VALUES('{$catname}','{$catdesc}')";
      		$result = mysqli_query($connection,$sql);
      		if($result){
      			echo'Category added';
      		}
      		else{
      			die('failed');
      		}
		}
		

	}
	?>
     <div >
        <div class= "category_create">
         <div id="p">
            
                <div class="panel-heading">
                <h3 class="panel-title">Create category</h3> </br>
                </div>
                <div>
                    <form role="form" action="create_cat.php" method="post">
                       
                            <div class="form-group <?=isset($alert['empty'])?'has-error':''?>">
                                <input class="cat_form" placeholder="Category name" name="cat_name" type="text" autofocus>
                                <?php
                                if (isset($alert['empty'])) {
                                ?>
                                <span class="help-block"><?=$alert['empty']?>.</span>
                                <?php
                                }
                                ?>
                            </div>
                          
                            <div class="form-group">
                            	
                                <textarea placeholder="Description"  class="cat_desc" name="cat_description"></textarea>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <button type="submit" class="btn btn-md btn-success" name="newcat" value="Submit">Create</button>
                            
                        
                    </form>
                </div>
          
            </div>
        </div>
    </div>

     <?php

}
require('../includes/footer.php');
?>
