<?php
require('../includes/connect.php');
require('../includes/header.php');
require_once __DIR__ . "/config.php";
$star->id = "index_page";

$sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            categories";
 
$result = mysqli_query($connection,$sql);
 
if(!$result)
{
    echo 'The categories could not be displayed, please try again later.';
}
else
{
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
                                <div class="pull-right">
                                    <span >
                                        <?php
                                            
                                            if(!isset($_SESSION['user_id']))
                                            {
                                                echo $star->getRating("size-3");
                                            }
                                            else{
                                                echo $star->getRating("userChoose size-3");
                                            }
                                            if(isset($_POST['id']) && isset($_POST['rating']) && $_POST['id'] == "index_page"){
                                             $star->id = $_POST['id'];
                                             $star->addRating($_SESSION['user_name'], $_POST['rating'],$_POST['top']);
                                            }
                                        ?>
                                    </span>
                                    <script>var id_topic=<?php echo json_encode($row['topic_id'])?></script>
                                    
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
}
 
require('../includes/footer.php');
?>