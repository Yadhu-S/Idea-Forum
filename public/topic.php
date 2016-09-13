<?php
//create_cat.php
require('../includes/connect.php');
require('../includes/header.php');
$_SESSION['title']='Forum';
$topi=mysqli_real_escape_string($connection,$_GET['id']);

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

					if($posts_row['user_level']==0){
						?>  <h4><div class="usrep"><?php echo $posts_row['user_name'];?>  </br> 
							<p id="dat">Reg.No <?php echo $posts_row['user_email'];?> </p> 
							</div>
							</h4> 
						<?php
					}
					else{
						?>  <h4><div class="imp"><?php echo $posts_row['user_name'];?>  </br> 
							</div>
							</h4> 
						<?php
					}
					echo '<div class="bubble">' . htmlentities(stripslashes($posts_row['post_content'])) . '</div>';?>
					 <?php
				}
			}
			
			if(!isset($_SESSION['signed_in']))
			{
				echo '<div class="top_cont">You must be <a href="login.php">signed in</a> to reply. You can also <a href="signup.php">sign up</a> for an account.</div>';
			}
			else
			{
				//show reply box
				echo '<div class="top_cont"><h4>Reply:</h4>
					<form method="post" action="reply.php?id=' . $row['topic_id'] . '">
						<textarea name="reply-content"></textarea><br />
						<input type="submit" value="Submit reply" />
					</form></div>';
			}
			
			//finish the table
		
			
		}
	}
}
mysqli_close($connection);
require('../includes/footer.php');
?>