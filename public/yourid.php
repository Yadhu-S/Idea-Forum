<?php
	require('../includes/connect.php');
	require('../includes/header.php');
	require("../includes/function.php");
	$usid=$_SESSION['user_id'];
	$star->id = "index_page";
	$sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            categories";
    ?>
      <img src="bg.png" style="width:100%;height:10%;padding-bottom: 20px">
    <div class="well well-sm" >
    <?php
 
$result = mysqli_query($connection,$sql);
	if(mysqli_num_rows($result) == 0)
        {
            echo 'No categories defined yet.';
        }
        else
        {
            while($row = mysqli_fetch_assoc($result)){ 
                $sql_topic = "SELECT users.user_name,topic_id,topic_subject,topic_date,topic_cat,topic_by
                        FROM topics
                        LEFT JOIN users ON topics.topic_by=users.user_id
                        WHERE topic_cat = " . $row['cat_id'] ." AND topic_by = '{$usid}'";

                 
                $result_topic = mysqli_query($connection,$sql_topic);

                ?>

                <div class="main-items">
                     <h4><?=$row['cat_name']?></h4>
                    
                    <ol class="sub-items">
                        <li class="sub-item">
                        <table class="table table-bordered table-hover ptable">
                            <thead style="background-color: #9E9E9E;">
                            <tr>
                                <th>Post</th>
                                <th>Post date</th>
                                <th >Rating</th>
                            </tr>
                            </thead>
                                <?php   
                                    if($result_topic){
                                        if(mysqli_num_rows($result) != 0){
                                            while($row = mysqli_fetch_assoc($result_topic)){
                                            ?>      
                                                    
                                                <tbody >
                                                    <tr >
                                                        <td><?php 
                                                            echo '<a id="hey" href="topic.php?id=' . $row['topic_id'] . '" style="text-decoration: none;"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp' .$row['topic_subject'].'</a>'; 
                                                            ?>
                                                        </td>
                                                        <td><?php echo $row['topic_date'];?></td>
                                                        <td class="rating-stars">
                                                            
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
                                                           
                                                        </td> 
                                                    </tr>  
                                                </tbody>                                 
                                                       
                                            <?php
                                            }                       
                                        }

                                    }
                                ?>
                        </table>            
                        </li>   
                    </ol>
                </div>
                <?php
            } 
        }
        ?>
        </div>
        <?php
	require('../includes/footer.php');
?>