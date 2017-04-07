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
        echo '<div class="alert alert-danger main-items">Sorry, you have to be <a href="/forum/signin.php">signed in</a> to create a topic.</div>';
    }
    else
    {
        if(isset($_POST["submit"]))
        {
            
            $query  = "BEGIN WORK;";
            $result = mysqli_query($connection,$query);
             
            if(!$result)
            {
                echo '<div class="alert alert-danger main-items">An error occured while creating your topic. Please try again later.</div>';
            }
            else
            {
                $sub=$_POST['topic_subject'];
                $newFileName="";
                $ver ="SELECT topic_subject FROM topics WHERE topic_subject='{$sub}'";
                $tosql=mysqli_query($connection,$ver);
                if(mysqli_num_rows($tosql)!=0){
                    $alert['Subject']="Subject name already exists";
                }
                else{

                    $sub=mysqli_real_escape_string($connection,$_POST['topic_subject']);
                    $pr=mysqli_real_escape_string($connection,$_POST['topic_cat']);
                    $cont= mysqli_real_escape_string($connection,$_POST['post_content']);
                    if($pr=="-- Select --"){
                        $alert["cat"]='You should select a valid category';
                    }
                    $usr=$_SESSION['user_id'];
                    if($sub==""){
                        $alert['Subject']='Subject name cannot be blank';
                    }
                    if(strlen($cont)<30){
                        
                        $alert['cont']='Content should contain at least 30 charaters';
                    }
                    if(empty($alert)){
                        if($_FILES['fileToUpload']['name']!=""){
                            $target_dir = "uploads/";
                            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                            $newFileName = uniqid('up-', true). '.' . strtolower(pathinfo($_FILES['fileToUpload']['name'],PATHINFO_EXTENSION));
                            //echo $newFileName;
                            $uploadOk = 1;
                            $FileType = pathinfo($target_file,PATHINFO_EXTENSION);
                            $imageFileType=strtolower($FileType);
                            //echo $imageFileType;
                            // Check file size
                            //echo $_FILES['fileToUpload']['error'];
                            //echo $_FILES['fileToUpload']['size'] ;
                            if ($_FILES["fileToUpload"]["size"] > 2*1024*1024) {
                                $alert['img'] ="Sorry, your file is too large.";
                                
                                $uploadOk = 0;
                            }
                            // Allow certain file formats
                            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                            && $imageFileType != "gif" && $imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "docx" ) {
                                $alert['img'] = '"<strong>.'.$imageFileType.'</strong>" extension is not supported' ;
                                $uploadOk = 0;
                            }
                            // Check if $uploadOk is set to 0 by an error
                             if($uploadOk) {
                                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], 'uploads/' . $newFileName)) {
                                    $alert['img_suc'] = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

                                } else {
                                    $alert['img'] = "Sorry, there was an error uploading your file.";
                                }
                            }
                        }
                        //the form has been posted, so save it
                        //insert the topic into the topics table first, then we'll save the post into the posts table
                        $tm=date("Y-m-d H:i");
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
                            
                            $user_id =$_SESSION['user_id'];
                            $sql = "INSERT INTO posts(post_content,post_date,post_topic,post_by,img_id)
                                    VALUES      ('{$cont}',NOW(),'{$topicid}','{$user_id}','{$newFileName}')";
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
                                echo '<div class="alert alert-success main-items">
                                        You have successfully posted your idea Please <a href="topic.php?id='. $topicid . '">track</a> the status of your idea.
                                        </div>';
                            }
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
                    echo '<div class="alert alert-danger main-items">You have not created categories yet.</div>';
                }
                else
                {
                    echo '<div class="alert alert-danger main-items">Before you can post a topic, you must wait for an admin to create some categories.</div>';
                }
            }
            else
            {?>
        <div class="category_create">
            <div class="form-group">
           </br><h3 class="panel-title"><i class="fa fa-lightbulb-o" aria-hidden="true"></i> Post your idea. </h3></br>
                <form method="post" action="create_topic.php" enctype="multipart/form-data">
                    <div class="form-group <?=isset($alert['Subject'])?'has-error':''?>">
                        <input class="cat_form form-control" placeholder="Subject" name="topic_subject" type="text" autofocus/>
                        <?php
                        if (isset($alert['Subject'])) {
                        ?>
                        <span class="help-block"><?=$alert['Subject']?>.</span>
                        <?php
                        }
                        ?>
                    </div>
                    <label for="sel1">Select category (select one):</label> </br>
                    <div class="form-group <?=isset($alert['cat'])?'has-error':''?>">
                        <select name="topic_cat" class="form-control" id="sel1">
                            <option>-- Select --</option>
                            <?php
                                while($row = mysqli_fetch_assoc($result))
                                {
                                    ?><option value="<?php echo $row['cat_id']?>"> <?php echo $row['cat_name'] ?></option>
                                <?php
                                }
                            ?>
                        </select>
                        <?php
                        if (isset($alert['cat'])) {
                        ?>
                        <span class="help-block"><?=$alert['cat']?>.</span>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group <?=isset($alert['cont'])?'has-error':''?>">
                    <textarea placeholder="Description of your idea" style="height: 150px;" class="form-control cat_desc " name="post_content" /></textarea>
                    <?php
                        if (isset($alert['cont'])) {
                        ?>
                        <span class="help-block"><?=$alert['cont']?>.</span>
                        <?php
                        }
                    ?>
                    </div>
                    <div class="form-group <?=isset($alert['img'])?'has-error':''?> <?=isset($alert['img_suc'])?'has-success':''?>">
                        <label for="fileToUpload">Select file to upload  (optional) </label>
                        <input type="file" name="fileToUpload" ></br>
                         <?php
                        if (isset($alert['img'])) {
                        ?>
                        <span class="help-block"><?=$alert['img']?>.</span>
                        <?php
                        }
                        ?>
                        <?php
                        if (isset($alert['img_suc'])) {
                        ?>
                        <span class="help-block"><i class="fa fa-check-circle" aria-hidden="true"></i>

                         <?=$alert['img_suc']?>.</span>
                        <?php
                        }
                        ?>
                        <div class="alert alert-info">
                          Only <strong>pdf,doc,docx,jpg,jpeg,gif,png</strong> files formats are supported and size should be less than 2Mb.
                        </div>
                    </div>
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
    ?>
     <div ng-app="validationApp" ng-controller="mainController">
    <div class="row">
        <div class="col-sm-9 col-md-4 col-md-offset-4 col-sm-offset-2">
         <div id="p">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Log in/Register</h3>
                </div>
                <div class="panel-body">
                    <form role="form" name="userForm" action="login.php" method="post" ng-submit="submitForm(userForm.$valid)" novalidate>
                        <fieldset>
                                <a class="btn btn-lg btn-primary btn-block" href="login.php">Log in</a>
                                </br>
                                <a  class="btn btn-lg btn-primary btn-block" href="signup.php">Register</a>
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
 
require('../includes/footer.php');
?>