<?php
require_once __DIR__ . "/Fr.star.php";

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
