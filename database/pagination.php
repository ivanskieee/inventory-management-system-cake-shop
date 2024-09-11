<?php
require_once('config.php');

if(isset($_GET['page']))
{
    $page = $_GET['page'];
}
else
{
    $page = 1;
}

$num_per_page = 04;
$start_from = ($page-1)*04;


$query = "select * from products limit $start_from,$num_per_page";
$result = mysqli_query($con,$query);




?>