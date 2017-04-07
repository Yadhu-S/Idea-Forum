<?php
//create_cat.php
require('../includes/connect.php');
require('../includes/header.php');
$result=0;
 
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    
    echo '<div class="ce">

                <div class="alert alert-danger vertical-center-row" >
                <i class="fa fa-exclamation-triangle fa-5x" aria-hidden="true"></i></br>
                <strong >Forbidden</strong>
                </div>
            </div>';
}
else
{
    //check for sign in status
    if(!$_SESSION['signed_in'])
    {
        echo 'You must be signed in to post a reply.';
    }
    else
    {   
        $pgid=mysqli_real_escape_string($connection,$_GET['id']);
        $idus=mysqli_real_escape_string($connection,$_SESSION['user_id']);
        $cont=mysqli_real_escape_string($connection,$_POST['reply_content']);

        if($cont!=""){
        $sql = "INSERT INTO 
                    posts(post_content,
                          post_date,
                          post_topic,
                          post_by) 
                VALUES ('{$cont}',NOW(),'{$pgid}','{$idus}')";
                         
        $result = mysqli_query($connection,$sql);
        }
        else{
            echo 'Reply cannot be empty.';
        }
                         
        if(!$result)
        {
            echo '</br>Your reply has not been saved.';  
           
        }
        else
        {
            echo 'Your reply has been saved, check out <a href="topic.php?id=' . htmlentities($_GET['id']) . '">the topic</a>.';
        }
    }
}
 
require('../includes/footer.php');
?>