<?php
//create_cat.php
require('../includes/connect.php');
require('../includes/header.php');
if(isset($_GET['id'])){
	$topi=mysqli_real_escape_string($connection,$_GET['id']);

	$flag=1;
	$sql = "SELECT topic_id,topic_subject
			FROM topics
			WHERE topics.topic_id = '{$topi}'";
				
	$result = mysqli_query($connection,$sql);

	if(!$result)
	{
		
		echo 'The topic could not be displayed, please try again later.';
	}
	else
	{
		if(mysqli_num_rows($result) == 0)
		{
			echo 'This topic doesn&prime;t exist.';
		}
		else
		{
			while($row = mysqli_fetch_assoc($result))
			{
				//display post data
				echo  '<div class ="top_cont"><h4>'.$row['topic_subject'].'</h4></div>';
			
				//fetch the posts from the database
				$id2=mysqli_real_escape_string($connection,$_GET['id']);
				$posts_sql = "SELECT posts.post_topic,posts.post_content,
							posts.post_date,
							posts.post_by,
							users.user_id,
							users.user_name,
							users.user_email,
							users.user_level
						FROM
							posts
						LEFT JOIN
							users
						ON
							posts.post_by = users.user_id
						WHERE
							posts.post_topic = '{$id2}'";
							
				$posts_result = mysqli_query($connection,$posts_sql);
				
				if(!$posts_result)
				{
					echo 'The posts could not be displayed, please try again later.';
				}
				else
				{
			
					while($posts_row = mysqli_fetch_assoc($posts_result))
					{

						if($flag==1){?>
							<div class="bubble">
								<?php
								$flag=0;  
								if($posts_row['user_level']==0){
								?>  
								<div class="impr">
									<div class="usnam">
										<h4>
											<?php echo $posts_row['user_name'];?>
										</h4>
										<h6>Reg.No:<?php echo $posts_row['user_email'];?></h6>
									</div>
								</div>
									
								<?php
								}
								else{
									?>  <h4><div class="imp"><?php echo $posts_row['user_name'];?>  </br> 
										</div>
										</h4> 
									<?php
								}?>
								<div class="cntnt ">
									<?php echo htmlentities(stripslashes($posts_row['post_content'])); ?>
								</div>
							</div>
						 <?php
						}
						else{?>
							<div class="nbubble">
								<?php 
								if($posts_row['user_level']==0){
								?>  
								<div class="impr">
									<div class="usnam">
										<h4>
											<?php echo $posts_row['user_name'];?>
										</h4>
										<h6>Reg.No:<?php echo $posts_row['user_email'];?></h6>
									</div>
								</div>
									
								<?php
								}
								else{
									?>  <h4>
											<div class="imp">
												<div class="usnam">
													<?php echo $posts_row['user_name'];?>  </br> 
												</div>
											</div>
										</h4> 
									<?php
								}?>
								<div class="cntnt">
									<?php echo htmlentities(stripslashes($posts_row['post_content'])); ?>
								</div>
							</div>
						 <?php
						}
					}
				}
			}
				
			if(!isset($_SESSION['signed_in']))
			{
				echo '<div class="top_cont alert alert-info"><i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i> You must be logged in to reply.';
			}
			else
			{
				?>
				
					<div class="top_cont">
						</br><label>Post your reply: <i class="fa fa-reply" aria-hidden="true"></i>
								</label>
							<form name="reForum" method="post" action="reply.php?id=<?php echo $row['topic_id'] ?>">
							<textarea placeholder="Reply" class="cat_desc" name="reply_content" required></textarea><br />
							<input class="btn btn-md btn-primary" type="submit" value="Submit reply" />
						</form>
					</div>;
				<?php			
			}			
		}
	}
}
else{
	echo '
			<div class="ce">

				<div class="alert alert-danger vertical-center-row" >
				<i class="fa fa-exclamation-triangle fa-5x" aria-hidden="true"></i></br>
				<strong >Forbidden.</strong>
			  	</div>
			</div>';
}
mysqli_close($connection);
require('../includes/footer.php');
?>