<?php
require('../includes/connect.php');
require('../includes/header.php');
$_SESSION['title'] = 'Home';

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
        //prepare the table
        // echo '<table border="1">
        //       <tr>
        //         <th>Category</th>
        //         <th>Last topic</th>
        //       </tr>'; 
             
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
                                <div class="rating-stars pull-right">
                                    <span class="star">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                    </span>
                                    <span class="star">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                    </span>
                                    <span class="star">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                    </span>
                                    <span class="star">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                    </span>
                                    <span class="star">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
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
            // echo '<tr>';
            //     echo '<td class="leftpart">';
            //         echo '<h3><a href="category.php?id='.$row['cat_id'].'">' . $row['cat_name'] . '</a></h3>' . $row['cat_description'];
            //     echo '</td>';
            //     echo '<td class="rightpart">';
            //                 echo '<a href="topic.php?id=">Topic subject</a> at 10-10';
            //     echo '</td>';
            // echo '</tr>';
        }
    }
}
 
require('../includes/footer.php');
?>