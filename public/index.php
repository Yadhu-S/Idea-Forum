<?php
require('../includes/connect.php');
require('../includes/header.php');
require("../includes/function.php");
$star->id = "index_page";

$sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            categories";
 
$result = mysqli_query($connection,$sql);

$numrow = mysqli_query($connection,"SELECT * FROM `topics`");
$topic_number=mysqli_num_rows($numrow);
$sql2="SELECT state FROM control ";
        $resu=mysqli_query($connection,$sql2);
        while($row = mysqli_fetch_assoc($resu)){
            $statec=$row['state'];
        }
?>
    <script>var num_topic=<?php echo json_encode($topic_number)?></script>


<?php
 
if(!$result)
{
    echo 'The categories could not be displayed, please try again later.';
}
else
{
    $chkval="";
    if (isset($_POST["submit"])) {
        if(isset($_POST["check"])){
           $chkval=TRUE;
        }
        else{
            $chkval=FALSE;
        }
        if($chkval==TRUE){
            $passql="UPDATE control SET state ='1'";
        }
        else{
            $passql="UPDATE control SET state ='0'";
        }
        mysqli_query($connection,$passql);
    }
    if (isset($_SESSION['user_level']) && $_SESSION['user_level']>=1) {
        if(mysqli_num_rows($result) == 0)
        {
            echo 'No categories defined yet.';
        }
        else
        {
            while($row = mysqli_fetch_assoc($result))
            { 
            $sql_topic = "SELECT   topic_id,topic_subject,topic_date,topic_cat
                    FROM topics
                    WHERE topic_cat = " . $row['cat_id'];
             
            $result_topic = mysqli_query($connection,$sql_topic);

            ?>
            <div class="main-items">
                 <h4><?=$row['cat_name']?></h4>
                
                <ol class="sub-items">
                    <li class="sub-item">
                    <?php if($result_topic){
                            if(mysqli_num_rows($result) != 0){
                            while($row = mysqli_fetch_assoc($result_topic)){
                    ?>
                                <h5><?php 
                                    echo '<a id="hey" href="topic.php?id=' . $row['topic_id'] . '" style="text-decoration: none;"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp' .$row['topic_subject'].'</a>'; 
                                    ?>
                                    <div class="pull-right rating-stars">
                                        <span data-topic-id="<?=$row['topic_id']?>">
                                            <?php

                                                
                                                if(!isset($_SESSION['user_id']))
                                                {
                                                    echo $star->getRating("size-3", "html", $row['topic_id']);
                                                }
                                                else{
                                                    echo $star->getRating("userChoose size-3", "html", $row['topic_id']);
                                                }
                                                if(isset($_POST['id']) && isset($_POST['rating']) && $_POST['id'] == "index_page"){
                                                 $star->id = $_POST['id'];
                                                 $star->addRating($_SESSION['user_name'], $_POST['rating'],$_POST['top']);
                                                }
                                            ?>
                                        </span>
                                    </div>                                    
                                </h5>
                        <?php
                            }

                            
                            } 
                        }
                    ?>
                    </li>
                    
                </ol>
            </div>
            <?php
            }
            
        }
        if (isset($_SESSION['user_level']) && $_SESSION['user_level']==2) {
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
                    <div class="alert alert-info"> <strong><i class="fa fa-wrench fa-2x" aria-hidden="true"></i> Competition control</strong> </div>
                        
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
    }
    else{
        if($statec==1)
        redirect_to("create_topic.php");
        else{
            echo '
            <div class="ce">

                <div class="alert alert-info vertical-center-row" > 
                 <i class="fa fa-exclamation-circle fa-5x" aria-hidden="true"></i></br>
                <strong >Competition closed.</strong>
                </div>
            </div>';
        }
    }
}
 
require('../includes/footer.php');
?>