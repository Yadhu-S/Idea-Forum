<?php
require_once ('../public/Fr.star.php');
$server = 'localhost';
$username   = 'cite_cms';
$password   = 'spassword';
$database   = 'cite_form';
$charset = 'utf8';
$connection = mysqli_connect($server,$username,$password,$database);


$star = new \Fr\Star(array(
  "db" => array(
    "host" => "localhost",
    "port" => 3306,
    "username" => "cite_cms",
    "password" => "spassword",
    "name" => "cite_form",
    "table" => "fr_star"
  )
));
 
if(mysqli_connect_errno())
        {
            
            die ("Failed to access database".mysqli_connect_errno());
            
        }


$dsn = "mysql:host=$server;dbname=$database;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $username, $password, $opt);
      
?>