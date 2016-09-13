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
		else{
			echo'Category name cannot be blank';
		}

	}
	?>
	<form action="create_cat.php" method="post">
        Category name: <input type='text' name='cat_name' /></br>
        Description: <textarea name='cat_description' /></textarea></br>
        <input type ="submit" name="newcat" value="Submit"/>
     </form>
     <?php

}
require('../includes/footer.php');
?>
