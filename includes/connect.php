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
$host = 'localhost';
$db   = 'cite_form';
$user = 'cite_cms';
$pass = 'spassword';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);
      
?>