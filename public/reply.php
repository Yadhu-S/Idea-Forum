<?php
//create_cat.php
require('../includes/connect.php');
require('../includes/header.php');
 
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    
    echo 'Direct access not allowed.';
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
        $cont=mysqli_real_escape_string($connection,$_POST['reply-content']);
        //a real user posted a real reply
        $sql = "INSERT INTO 
                    posts(post_content,
                          post_date,
                          post_topic,
                          post_by) 
                VALUES ('{$cont}',NOW(),'{$pgid}','{$idus}')";
                         
        $result = mysqli_query($connection,$sql);
                         
        if(!$result)
        {
            echo 'Your reply has not been saved, please try again later.';
        }
        else
        {
            echo 'Your reply has been saved, check out <a href="topic.php?id=' . htmlentities($_GET['id']) . '">the topic</a>.';
        }
    }
}
 
require('../includes/footer.php');
?>