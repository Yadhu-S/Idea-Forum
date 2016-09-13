<?php
$server = 'localhost';
$username   = 'cite_cms';
$password   = 'spassword';
$database   = 'cite_form';
$connection = mysqli_connect($server,$username,$password,$database);
 
if(mysqli_connect_errno())
        {
            
            die ("Failed to access database".mysqli_connect_errno());
            
        }
      
?>