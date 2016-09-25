<?php
//create_cat.php
require('../includes/connect.php');
require('../includes/header.php');
$alert=array(); 

if(isset($_SESSION['signed_in'])){
     $alert=array();
    if($_SESSION['signed_in'] == false)
    {
        //the user is not signed in
        echo 'Sorry, you have to be <a href="/forum/signin.php">signed in</a> to create a topic.';
    }
    else
    {
        if(isset($_POST["submit"]))
        {
            
            $query  = "BEGIN WORK;";
            $result = mysqli_query($connection,$query);
             
            if(!$result)
            {
                echo 'An error occured while creating your topic. Please try again later.';
            }
            else
            {
                $sub=mysqli_real_escape_string($connection,$_POST['topic_subject']);
                $pr=mysqli_real_escape_string($connection,$_POST['topic_cat']);
                if($pr=="-- Select --"){
                    echo '<div class="top_cont alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 
                    You should select a valid category</div>';
                }
                $usr=$_SESSION['user_id'];
                if($sub==""){
                    echo '<div class="top_cont alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 
                    Topic name cannot be blank </dvi>';
                }
                else if($_POST['post_content']==""){
                    echo '<div class="top_cont alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 
                    Content cannot be blank </div>';
                }
                else{
                    //the form has been posted, so save it
                    //insert the topic into the topics table first, then we'll save the post into the posts table
                    $sql = "INSERT INTO 
                                topics(topic_subject,
                                       topic_date,
                                       topic_cat,
                                       topic_by)
                            VALUES('{$sub}',NOW(),'{$pr}','{$usr}')";
                              
                    $result = mysqli_query($connection,$sql);
                    if(!$result)
                    {
                        //something went wrong, display the error
                        echo 'An error occured while inserting your data. Please try again later.' . mysqli_error($connection);
                        $sql = "ROLLBACK;";
                        $result = mysqli_query($connection,$sql);
                    }
                    else
                    {
                        //the first query worked, now start the second, posts query
                        //retrieve the id of the freshly created topic for usage in the posts query
                        $topicid = mysqli_insert_id($connection);
                        $cont= mysqli_real_escape_string($connection,$_POST['post_content']);
                        $user_id =$_SESSION['user_id'];
                        $sql = "INSERT INTO posts(post_content,post_date,post_topic,post_by)
                                VALUES      ('{$cont}',NOW(),'{$topicid}','{$user_id}')";
                        $result = mysqli_query($connection,$sql);
                         
                        if(!$result)
                        {
                            //something went wrong, display the error
                            echo 'An error occured while inserting your post. Please try again later.' . mysqli_error($connection);
                            $sql = "ROLLBACK;";
                            $result = mysqli_query($connection,$sql);
                        }
                        else
                        {
                            $sql = "COMMIT;";
                            $result = mysqli_query($connection,$sql);
                             
                            //after a lot of work, the query succeeded!
                            echo 'You have successfully created <a href="topic.php?id='. $topicid . '">your new topic</a>.';
                        }
                    }
                }
            }
        }
        //retrieve the categories from the database for use in the dropdown
        $sql = "SELECT
                    cat_id,
                    cat_name,
                    cat_description
                FROM
                    categories";
         
        $result = mysqli_query($connection,$sql);
         
        if(!$result)
        {
            //the query failed, uh-oh :-(
            echo 'Error while selecting from database. Please try again later.';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                if($_SESSION['user_level'] == 1)
                {
                    echo 'You have not created categories yet.';
                }
                else
                {
                    echo 'Before you can post a topic, you must wait for an admin to create some categories.';
                }
            }
            else
            {?>
        <div class="category_create">
            <div class="form-group">
           </br><h3 class="panel-title">Create a new post</h3></br>
                <form method="post" action="">
                    <input class="cat_form" placeholder="Subject" name="topic_subject" type="text" autofocus/>
                    <label for="sel1">Select category (select one):</label> </br>
                    <select name="topic_cat" class="form-control" id="sel1">
                        <option>-- Select --</option>
                        <?php
                            while($row = mysqli_fetch_assoc($result))
                            {
                                ?><option value="<?php echo $row['cat_id']?>"> <?php echo $row['cat_name'] ?></option>
                            <?php
                            }
                        ?>
                    </select> </br>
                    <textarea placeholder="Description of your question/idea"  class="cat_desc" name="post_content" /></textarea>
                    </br>
                    <input class="btn btn-md btn-primary" type="submit" value="Create topic" name="submit" />
                 </form>
            </div>
        </div>
                <?php
            }
        }
    }
}
else{
    echo '
            <div class="ce">

                <div class="alert alert-info vertical-center-row" > 
                 <i class="fa fa-exclamation-circle fa-5x" aria-hidden="true"></i></br>
                <strong >Please log in.</strong>
                </div>
            </div>';
}
 
require('../includes/footer.php');
?>